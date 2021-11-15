<?php

namespace api\modules\v1\controllers;


use common\models\user\UserDevice;
use frontend\models\SignupForm;
use Yii;
use frontend\models\LoginForm;
use api\components\RestController;


class UserController extends RestController
{

    /**
     * Đăng nhập
     */
    public function actionLogin()
    {
        $model = new LoginForm();
        $params = Yii::$app->getRequest()->getBodyParams();
        if ($model->load($params, '') && $model->login()) {
            $user = Yii::$app->user->getIdentity();
            if (isset($params['device_id']) && $params['device_id']) {
                $device_type = isset($params['device_type']) ? (int)$params['device_type'] : 0;
                UserDevice::updateDevice($user->id, $params['device_id'], $device_type);
            }
            return $this->responseData([
                'success' => true,
                'data' => [
                    'id' => $user->id,
                    'phone' => $user->phone,
                    'username' => $user->username,
                ]
            ]);
        } else {
            return $this->responseData(['success' => false, 'errors' => 'Số điện thoại hoặc mật khẩu không chính xác']);
        }
    }


    /**
     * Đăng ký
     */
    public function actionSignup()
    {
        $params = Yii::$app->getRequest()->getBodyParams();
        $params['type'] = isset($params['type']) && $params['type'] ? $params['type'] : 1;
        $model = new SignupForm();
        if ($model->load($params, '')) {
            $response = $model->signupApi();
            if($response['success']){
                return $this->responseData([
                    'success' => true,
                    'data' => $response['data']
                ]);
            }
            return $this->responseData([
                'success' => false,
                'errors' => $response['errors']
            ]);
        }
        return $this->responseData([
            'success' => false,
            'errors' => [],
            'message' => 'Lỗi dữ liệu'
        ]);
    }

    /**
     *
     * @return type
     */
    protected function verbs()
    {
        return [
            'login' => ['POST'],
            'signup' => ['POST'],
            'update-device' => ['POST'],
            'get-user-info' => ['GET'],
        ];
    }

}
