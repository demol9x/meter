<?php

namespace api\modules\v1\controllers;


use common\components\ClaGenerate;
use common\models\user\Tho;
use common\models\user\UserDevice;
use common\models\user\UserImage;
use frontend\models\SignupForm;
use frontend\models\User;
use Yii;
use frontend\models\LoginForm;
use api\components\RestController;
use yii\web\UploadedFile;


class UserController extends RestController
{

    /**
     * Đăng nhập
     */
    public function actionIndex()
    {
        $params = Yii::$app->getRequest()->getBodyParams();
        $user_id = isset($params['user_id']) && $params['user_id'] ? $params['user_id'] : '';
        $auth_key = isset($params['auth_key']) && $params['auth_key'] ? $params['auth_key'] : '';
        $user = User::find()->where(['id' => $user_id])->joinWith(['tho'])->asArray()->one();
        $message = '';
        $errors = [];
        if ($user && $user['auth_key'] == $auth_key) {
            if($user['tho']){
                $images = UserImage::find()->where(['user_id' => $user_id])->asArray()->all();
                $user['tho']['images'] = $images;
            }
            return $this->responseData([
                'success' => true,
                'data' => $user,
                'errors' => $errors,
                'message' => $message
            ]);
        }else {
            $message = 'Thông tin tài khoản không hợp lệ';
        }
        return $this->responseData([
            'success' => false,
            'errors' => $errors,
            'message' => $message
        ]);
    }

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
                    'auth_key' => $user->auth_key,
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
            if ($response['success']) {
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

    public function actionActive()
    {
        $params = Yii::$app->getRequest()->getBodyParams();
        $user_id = isset($params['user_id']) && $params['user_id'] ? $params['user_id'] : '';
        $auth_key = isset($params['auth_key']) && $params['auth_key'] ? $params['auth_key'] : '';
        $user = User::findOne($user_id);
        $message = '';
        $errors = [];
        if ($user && $user->auth_key == $auth_key) {
            $user->status = User::STATUS_ACTIVE;
            $user->save();
            return $this->responseData([
                'success' => true,
                'errors' => $errors,
                'message' => $message
            ]);
        }else {
            $message = 'Thông tin tài khoản không hợp lệ';
        }
        return $this->responseData([
            'success' => false,
            'errors' => $errors,
            'message' => $message
        ]);
    }

    public function actionForgotPassword(){
        $params = Yii::$app->getRequest()->getBodyParams();
        $password = isset($params['password']) && $params['password'] ? $params['password'] : '';
        $re_password = isset($params['re_password']) && $params['re_password'] ? $params['re_password'] : '';
        $phone = isset($params['phone']) && $params['phone'] ? $params['phone'] : '';
        $user = User::find()->where(['phone' => $phone])->one();
        $message = '';
        $errors = [];
        if($password != $re_password){
            $message = 'Mật khẩu không khớp';
        }
        if ($user && $password && $password == $re_password) {
            $user->setPassword($password);
            $user->generateAuthKey();
            $user->save();
            return $this->responseData([
                'success' => true,
                'errors' => $errors,
                'message' => $message
            ]);
        }else {
            $message = 'Số điện thoại chưa đăng ký tài khoản';
        }
        return $this->responseData([
            'success' => false,
            'errors' => $errors,
            'message' => $message
        ]);
    }

    public function actionChangePassword(){
        $params = Yii::$app->getRequest()->getBodyParams();
        $password = isset($params['password']) && $params['password'] ? $params['password'] : '';
        $new_password = isset($params['new_password']) && $params['new_password'] ? $params['new_password'] : '';
        $re_password = isset($params['re_password']) && $params['re_password'] ? $params['re_password'] : '';
        $user_id = isset($params['user_id']) && $params['user_id'] ? $params['user_id'] : '';
        $auth_key = isset($params['auth_key']) && $params['auth_key'] ? $params['auth_key'] : '';

        $user = User::findOne($user_id);
        $message = '';
        $errors = [];

        if ($user && $user->auth_key == $auth_key) {
            $model = new LoginForm();
            $params = [
                'phone' => $user->phone,
                'password' => $password
            ];
            if ($model->load($params, '') && $model->login()) {
                if($new_password && $new_password == $re_password){
                    $user->setPassword($new_password);
-                    $user->save();
                    return $this->responseData([
                        'success' => true,
                        'errors' => $errors,
                        'message' => $message
                    ]);
                }else{
                    $message = 'Mật khẩu mới không khớp';
                }

            }else{
                $message = 'Mật khẩu không đúng';
            }

        }else {
            $message = 'Thông tin tài khoản không hợp lệ';
        }

        return $this->responseData([
            'success' => false,
            'errors' => $errors,
            'message' => $message
        ]);
    }

    /**
     * Đăng ký thợ
     */
    public function actionTho()
    {
        $params = Yii::$app->getRequest()->getBodyParams();
        $user_id = isset($params['user_id']) && $params['user_id'] ? $params['user_id'] : '';
        $auth_key = isset($params['auth_key']) && $params['auth_key'] ? $params['auth_key'] : '';
        $user = User::findOne($user_id);
        $message = '';
        $errors = [];
        if ($user && $user->auth_key == $auth_key) {
            if ($user->type != User::TYPE_DOANH_NGHIEP) {
                $tho = Tho::findOne($user_id);
                if (!$tho) {
                    $tho = new Tho();
                }
                if ($tho->load($params, '')) {
                    $tho->name = $user->username;
                    $uploads = UploadedFile::getInstancesByName("file");
                    if (empty($uploads)) {
                    } else {
                        $file = $uploads[0];
                        $ext = pathinfo($file, PATHINFO_EXTENSION);
                        $path = Yii::getAlias('@rootpath') . '/static/media/files/tho/' . ClaGenerate::getUniqueCode() . '.' . $ext;
                        $file->saveAs($path);
                        $tho->attachment = '/media/files/tho/' . ClaGenerate::getUniqueCode() . '.' . $ext;
                    }

                    $images = UploadedFile::getInstancesByName("images");
                    foreach ($images as $fl) {
                        $file = (array)$fl;
                        if ($file) {
                            $file['tmp_name'] = $file['tempName'];
                            unset($file['tempName']);
                            $data = $this->uploadImage($file, 'tho');
                            if ($data['code'] == 1) {
                                $nimg = new UserImage();
                                $nimg->attributes = $data['data'];
                                $nimg->user_id = $user_id;
                                $nimg->save();
                            } else {
                                print_r('<pre>');
                                print_r($data);
                                die;
                            }
                        } else {
                            break;
                        }
                    }
                    if ($tho->save()) {
                        $user->type = User::TYPE_THO;
                        $user->province_id = isset($params['province_id']) && $params['province_id'] ? $params['province_id'] : $user->province_id;
                        $user->district_id = isset($params['district_id']) && $params['district_id'] ? $params['district_id'] : $user->district_id;
                        $user->ward_id = isset($params['ward_id']) && $params['ward_id'] ? $params['ward_id'] : $user->ward_id;
                        $user->address = isset($params['address']) && $params['address'] ? $params['address'] : $user->address;
                        $user->save();
                        return $this->responseData([
                            'success' => true,
                            'errors' => [],
                            'message' => 'Đăng ký thành công'
                        ]);
                    } else {
                        $errors = $tho->getErrors();
                    }
                }
            } else {
                $message = 'Tài khoản nhà thầu không thể đăng ký thợ';
            }
        } else {
            $message = 'Thông tin tài khoản không hợp lệ';
        }
        return $this->responseData([
            'success' => false,
            'errors' => $errors,
            'message' => $message
        ]);
    }

    public function actionUpdate(){
        $params = Yii::$app->getRequest()->getBodyParams();
        $user_id = isset($params['user_id']) && $params['user_id'] ? $params['user_id'] : '';
        $auth_key = isset($params['auth_key']) && $params['auth_key'] ? $params['auth_key'] : '';
        $user = User::findOne($user_id);
        $message = '';
        $errors = [];
        if ($user && $user->auth_key == $auth_key) {
            if (isset($_FILES['avatar'])) {
                $avatar = UploadedFile::getInstancesByName("avatar");
                $file = (array)$avatar[0];
                $file['tmp_name'] = $file['tempName'];
                unset($file['tempName']);
                $data = $this->uploadImage($file,'user');
                if ($data['code'] == 1) {
                    $user->avatar_path = $data['data']['path'];
                    $user->avatar_name = $data['data']['name'];
                }
            }

            if($user->load($params,'')){
                $user->sex = isset($params['sex']) && $params['sex'] ? $params['sex'] : $user->sex;
                $user->username = isset($params['username']) && $params['username'] ? $params['username'] : $user->username;
                $user->province_id = isset($params['province_id']) && $params['province_id'] ? $params['province_id'] : $user->province_id;
                $user->district_id = isset($params['district_id']) && $params['district_id'] ? $params['district_id'] : $user->district_id;
                $user->ward_id = isset($params['ward_id']) && $params['ward_id'] ? $params['ward_id'] : $user->ward_id;
                $user->address = isset($params['address']) && $params['address'] ? $params['address'] : $user->address;
                $user->email = isset($params['email']) && $params['email'] ? $params['email'] : $user->email;
                $user->birthday = isset($params['birthday']) && $params['birthday'] ? $params['birthday'] : $user->birthday;
                if($user->save()){
                    $tho = Tho::findOne($user_id);
                    if($tho){
                        $tho->province_id = isset($params['province_id']) && $params['province_id'] ? $params['province_id'] : $tho->province_id;
                        $tho->district_id = isset($params['district_id']) && $params['district_id'] ? $params['district_id'] : $tho->district_id;
                        $tho->ward_id = isset($params['ward_id']) && $params['ward_id'] ? $params['ward_id'] : $tho->ward_id;
                        $tho->address = isset($params['address']) && $params['address'] ? $params['address'] : $tho->address;
                        $tho->save();
                    }

                    return $this->responseData([
                        'success' => true,
                        'errors' => [],
                        'data' => $user->attributes,
                        'message' => 'Cập nhật thành công'
                    ]);
                }else{
                    $errors = $user->getErrors();
                }
            }

        } else {
            $message = 'Thông tin tài khoản không hợp lệ';
        }
        return $this->responseData([
            'success' => false,
            'errors' => $errors,
            'message' => $message
        ]);
    }


    function uploadImage($file, $path = 'tho')
    {
        $path = [$path, date('Y_m_d', time())];
        if ($file) {
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
        return [
            'code' => 0,
            'data' => [],
            'message' => '',
            'error' => 'Up ảnh lỗi.'
        ];
    }

    /**
     *
     * @return type
     */
    protected function verbs()
    {
        return [
            'index' => ['POST'],
            'login' => ['POST'],
            'signup' => ['POST'],
            'tho' => ['POST'],
            'update-device' => ['POST'],
            'get-user-info' => ['GET'],
        ];
    }

}
