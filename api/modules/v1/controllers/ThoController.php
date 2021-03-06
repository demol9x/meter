<?php
/**
 * Created by PhpStorm.
 * User: hungtm
 * Date: 11/17/2018
 * Time: 10:25 AM
 */

namespace api\modules\v1\controllers;

use common\components\ClaLid;
use common\components\ClaMeter;
use common\models\general\ChucDanh;
use common\models\general\UserWish;
use common\models\package\Package;
use common\models\package\PackageWish;
use common\models\sms\SmsOtp;
use common\models\sms\SmsOtpLog;
use common\models\sms\SmsOtpLogApi;
use common\models\user\Tho;
use common\models\user\UserImage;
use frontend\models\User;
use Yii;
use api\components\RestController;
use yii\db\Expression;


/**
 *
 */
class ThoController extends RestController
{

    public function actionIndex()
    {
        $request = Yii::$app->getRequest()->getBodyParams();
        $limit = isset($request['limit']) && $request['limit'] ? $request['limit'] : 20;
        $page = isset($request['page']) && $request['page'] ? $request['page'] : 1;
        $s = isset($request['s']) && $request['s'] ? $request['s'] : '';
        $user_id = isset($request['user_id']) && $request['user_id'] ? $request['user_id'] : '';
        $lat = isset($request['lat']) && $request['lat'] ? $request['lat'] : '';
        $lng = isset($request['lng']) && $request['lng'] ? $request['lng'] : '';
        $province_id = isset($request['province_id']) && $request['province_id'] ? $request['province_id'] : '';
        $job_id = isset($request['job_id']) && $request['job_id'] ? $request['job_id'] : '';
        $kn = isset($request['kn']) && $request['kn'] ? $request['kn'] : '';
        $time = isset($request['time']) && $request['time'] ? $request['time'] : 'new';
        $sort = isset($request['sort']) && $request['sort'] ? $request['sort'] : '';
        $response = [];

        $users = User::getT([
            'limit' => $limit,
            'page' => $page,
            'lat' => $lat,
            'lng' => $lng,
            's' => $s,
            'province_id' => $province_id,
            'job_id' => $job_id,
            'kn' => $kn,
            'time' => $time,
            'sort' => $sort,
        ]);
        $users = $users['data'];
        if ($users) {
            $us_wish = UserWish::find()->where(['user_id_from' => $user_id, 'type' => User::TYPE_THO])->asArray()->all();
            $us_wish = array_column($us_wish, 'user_id', 'id');
            foreach ($users as $us) {
                if (in_array($us['user_id'], $us_wish)) {
                    $us['is_wish'] = true;
                } else {
                    $us['is_wish'] = false;
                }
//                if ($lat && $lng) {
//                    $us['km'] = (int)ClaMeter::betweenTwoPoint($lat, $lng, $us['lat'], $us['long']) . 'km';
//                } else {
//                    $us['km'] = '';
//                }
                $response[] = $us;
            }
        }


        return $this->responseData([
            'success' => true,
            'package' => $response
        ]);
    }

    public function actionLike()
    {
        $request = Yii::$app->getRequest()->getBodyParams();
        $user_id = isset($request['user_id']) && $request['user_id'] ? $request['user_id'] : '';
        $auth_key = isset($request['auth_key']) && $request['auth_key'] ? $request['auth_key'] : '';
        $tho_id = isset($request['tho_id']) && $request['tho_id'] ? $request['tho_id'] : '';
        $message = '';
        $errors = [];

        $user = User::findOne($user_id);
        if ($user && $user->auth_key == $auth_key) {
            $user_wish = UserWish::find()->where(['user_id_from' => $user_id, 'user_id' => $tho_id])->one();
            if ($user_wish) {
                if ($user_wish->delete()) {
                    return $this->responseData([
                        'success' => true,
                        'errors' => $errors,
                        'message' => 'B??? y??u th??ch th??nh c??ng'
                    ]);
                } else {
                    $errors = $user_wish->getErrors();
                }
            } else {
                $user_wish = new UserWish();
                $user_wish->user_id_from = $user_id;
                $user_wish->user_id = $tho_id;
                $user_wish->type = User::TYPE_THO;
                if ($user_wish->save()) {
                    return $this->responseData([
                        'success' => true,
                        'errors' => $errors,
                        'message' => 'Th??m v??o danh s??ch y??u th??ch th??nh c??ng'
                    ]);
                } else {
                    $errors = $user_wish->getErrors();
                }
            }
        } else {
            $message = 'B???n ph???i ????ng nh???p ????? th???c hi???n h??nh ?????ng n??y.';
        }

        return $this->responseData([
            'success' => false,
            'errors' => $errors,
            'message' => $message
        ]);
    }

    public function actionDetail()
    {
        $message = '';
        $errors = [];
        $request = Yii::$app->getRequest()->getBodyParams();
        $tho_id = isset($request['tho_id']) && $request['tho_id'] ? $request['tho_id'] : '';
        $user_id = isset($request['user_id']) && $request['user_id'] ? $request['user_id'] : '';
        $tho = Tho::find()->where(['user_id' => $tho_id])->joinWith(['province', 'district', 'ward', 'user'])->asArray()->one();
        if ($tho) {
            $data = $tho;

            //???nh nh?? th???u
            $images = UserImage::getImages($tho_id);
            $data['images'] = $images;

            $related = [];
            $tho_related = Tho::find()->where(['<>','user_id',$tho_id])->joinWith(['province', 'district', 'ward', 'user'])->orderBy(new Expression('rand()'))->limit(10)->asArray()->all();
            if($tho_related){
                if($user_id){
                    $tho_wish = UserWish::find()->where(['user_id_from' => $user_id,'type' => User::TYPE_THO])->asArray()->all();
                    $tho_wish = array_column($tho_wish, 'user_id', 'id');
                }
                foreach ($tho_related as $value) {
                    $value['is_wish'] = false;
                    if (isset($tho_wish) && $tho_wish && in_array($value['user_id'], $tho_wish)) {
                        $value['is_wish'] = true;
                    }
                    $related[] = $value;
                }
            }
            $data['related'] = $related;
            return $this->responseData([
                'success' => true,
                'data' => $data,
                'errors' => $errors,
                'message' => $message
            ]);

        } else {
            $message = 'Th??? kh??ng t???n t???i';
        }


        return $this->responseData([
            'success' => false,
            'errors' => $errors,
            'message' => $message
        ]);
    }

    /**
     * @return array
     */
    protected function verbs()
    {
        return [
            'index' => ['POST'],
            'like' => ['POST'],
        ];
    }
}