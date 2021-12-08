<?php

namespace api\modules\app\controllers;

use Yii;

class LoginedController extends AppController
{
    public $user;

    function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            $post = $this->getDataPost();
            if (isset($post['user_id']) && $post['user_id'] && $this->logined($post['user_id'])) {
                return true;
            }
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            Yii::$app->response->data = [
                'code' => 0,
                'data' => [],
                'message' => '',
                'error' => 'Vui lòng đăng nhập để có thể thực hiện hành động này.',
            ];
            \Yii::$app->end();
        }
    }

    function logined($user_id)
    {
        if ($user_id) {
            $this->user = \frontend\models\User::findIdentity($user_id);
            if ($this->user &&  $this->user->token_app == $this->_token) {
                return true;
            }
        }
        return false;
    }

    function uploadImage($name)
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        $path = ['user-avatar', date('Y_m_d', time())];
        if (isset($post['path']) && $post['path']) {
            $path = [$post['path']];
            $path[] = date('Y_m_d', time());
        }
        if (isset($_FILES[$name])) {
            $file = $_FILES[$name];
            $up = new \common\components\UploadLib($file);
            $up->setPath($path);
            $up->uploadImage();
            $responseimg = $up->getResponse(true);
            if ($up->getStatus() == '200') {
                $resonse['data']['path'] = $responseimg['baseUrl'];
                $resonse['data']['name'] = $responseimg['name'];
                $resonse['code'] = 1;
                $resonse['message'] = 'Up ảnh thành công.';
                return $resonse;
            }
        }
        $resonse['error'] = 'Up ảnh lỗi.';
        return $resonse;
    }
}
