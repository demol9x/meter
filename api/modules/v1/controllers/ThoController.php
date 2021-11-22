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
use frontend\models\User;
use Yii;
use api\components\RestController;


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
        ]);
        $users = $users['data'];
        if ($users) {
            $us_wish = UserWish::find()->where(['user_id_from' => $user_id,'type' => User::TYPE_THO])->asArray()->all();
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
                        'message' => 'Bỏ yêu thích thành công'
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
                        'message' => 'Thêm vào danh sách yêu thích thành công'
                    ]);
                } else {
                    $errors = $user_wish->getErrors();
                }
            }
        } else {
            $message = 'Bạn phải đăng nhập để thực hiện hành động này.';
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