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
class CompanyController extends RestController
{

    public function actionIndex()
    {
        $request = Yii::$app->getRequest()->getBodyParams();
        $limit = isset($request['limit']) && $request['limit'] ? $request['limit'] : 20;
        $page = isset($request['page']) && $request['page'] ? $request['page'] : 1;
        $s = isset($request['s']) && $request['s'] ? $request['s'] : '';
        $user_id = isset($request['user_id']) && $request['user_id'] ? $request['user_id'] : '';
        $province_id = isset($request['province_id']) && $request['province_id'] ? $request['province_id'] : '';
        $id_price = isset($request['id_price']) && $request['id_price'] ? $request['id_price'] : '';
        $response = [];

        $shops = User::getS([
            'limit' => $limit,
            'page' => $page,
            's' => $s,
            'province_id' => $province_id,
            'id_price' => $id_price,
        ]);
        if (isset($shops['data']) && $shops['data']) {
            $shop_wish = UserWish::find()->where(['user_id_from' => $user_id])->asArray()->all();
            $shop_wish = array_column($shop_wish, 'user_id', 'id');
            foreach ($shops['data'] as $value) {
                if (in_array($value['user_id'], $shop_wish)) {
                    $value['is_wish'] = true;
                } else {
                    $value['is_wish'] = false;
                }
                $response[] = $value;
            }
        }


        return $this->responseData([
            'success' => true,
            'data' => $response
        ]);
    }

    public function actionLike()
    {
        $request = Yii::$app->getRequest()->getBodyParams();
        $user_id = isset($request['user_id']) && $request['user_id'] ? $request['user_id'] : '';
        $auth_key = isset($request['auth_key']) && $request['auth_key'] ? $request['auth_key'] : '';
        $shop_id = isset($request['shop_id']) && $request['shop_id'] ? $request['shop_id'] : '';
        $message = '';
        $errors = [];

        $user = User::findOne($user_id);
        if ($user && $user->auth_key == $auth_key) {
            $user_wish = UserWish::find()->where(['user_id_from' => $user_id, 'user_id' => $shop_id])->one();
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
                $user_wish->user_id = $shop_id;
                $user_wish->type = User::TYPE_DOANH_NGHIEP;
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