<?php

namespace frontend\modules\profile\controllers;

use frontend\controllers\CController;
use Yii;
use yii\web\Controller;
use frontend\models\User;
use frontend\models\profile\UserInfo;
use frontend\models\profile\UserEducation;
use frontend\models\profile\UserFile;
use common\models\recruitment\Skill;
use yii\web\Response;
//
use common\components\ClaGenerate;
use common\components\UploadLib;
use common\components\HtmlFormat;
use common\components\ClaHost;
use common\models\user\UserAddress;

/**
 * News controller for the `login` module
 */
class ProfileController extends CController {

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {
        $this->layout = 'main';
        $user = User::findIdentity(Yii::$app->user->getId());
//        //
//        $user_info = $this->findModelInfo();
//        // Học vấn và bằng cấp
//        $user_education = new UserEducation();
//        $educations = $this->findEducations();
//        // file cv
//        $file = UserFile::find()->where('user_id=:user_id', [':user_id' => Yii::$app->user->getId()])->one();
        //

        return $this->render('index', [
                    'user' => $user,
//                    'user_info' => $user_info,
//                    'user_education' => $user_education,
//                    'educations' => $educations,
//                    'file' => $file
        ]);
    }
    public function actionBoxAddress(){
        $this->layout = 'main';
        $id=Yii::$app->user->getId();
        $model = UserAddress::find()->where(['user_id'=>$id])->all();
        return $this->render('partial/box_address',[
            'model'=>$model,
        ]);
    }
    public function actionUpdateAddress($id=0){
        $this->layout = 'main';
        if ($id){
            $model = UserAddress::findOne($id);
        }
        else
        $model = new UserAddress();
        if($model->load(\Yii::$app->request->post())){
            $model->user_id = Yii::$app->user->getId();
            if($model->save())
            {
                \Yii::$app->getSession()->setFlash('cusses', 'Cập nhật thông tin thành công');
                return $this->redirect(['/profile/profile/box-address']);
            }
        }
        return $this->render('partial/update-address',[
            'model'=>$model,
        ]);
    }
    public function actionUpdatePassword(){
        $this->layout='main';
        $id=Yii::$app->user->getId();
        $model = \common\models\User::findOne($id);
        $old_pass = $model->password_hash;
        if($model->load(\Yii::$app->request->post())){
            if(Yii::$app->security->validatePassword($model->old_password, $old_pass)){
                $model->password_hash = Yii::$app->security->generatePasswordHash($model->new_password);
                if($model->save()){
                    \Yii::$app->getSession()->setFlash('cusses', 'Thay đổi mật khẩu thành công');
                    return $this->refresh();
                }
            }
            else{
                \Yii::$app->getSession()->setFlash('cusses', 'Mật khẩu cũ không trùng khớp');
                return  $this->refresh();
            }
        }
        return $this->render('partial/update-password',[
            'model'=>$model,
        ]);
    }
    public function actionDeleteAddress($id){
        $model = UserAddress::findOne($id);
        if($model){
            if ($model->delete()){
                \Yii::$app->getSession()->setFlash('cusses', 'Xóa địa chỉ thông tin thành công');
                return $this->redirect(['/profile/profile/box-address']);
            }
        }
    }
    public  function actionUpdateDefau($id){
        $model = UserAddress::findOne($id);
        $data= UserAddress::find()->all();
        if($id) {
            $data['isdefault']=0;
            $data->save();
        }


    }
    /**
     * Cập nhật thông tin cá nhân cơ bản của user
     * @return type
     */
    public function actionUpdateInfo() {
        if (\Yii::$app->request->isAjax) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            $user = User::findIdentity(Yii::$app->user->getId());
            $model = $this->findModelInfo();
            if ($model->load(\Yii::$app->request->post())) {
                if ($model->save()) {
                    $html = $this->renderAjax('ajax/box_basic_info', [
                        'user' => $user,
                        'user_info' => $model
                    ]);
                    return [
                        'code' => 200,
                        'html' => $html
                    ];
                } else {
                    return $model->getErrors();
                }
            }
        }
    }


    public function findModelInfo() {
        $model = UserInfo::findOne(\Yii::$app->user->getId());
        if ($model === NULL) {
            $model = new UserInfo();
        }
        if ($model->isNewRecord) {
            $model->user_id = \Yii::$app->user->getId();
            $model->new_graduate = \common\components\ClaLid::STATUS_ACTIVED;
        }
        return $model;
    }

    /**
     * Khởi tạo model education
     * @return UserEducation
     */

    public function actionUploadCv() {
        if (\Yii::$app->request->isAjax) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            if (isset($_FILES['file'])) {
                $file = $_FILES['file'];

                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $file_allow = array('doc', 'docx', 'pdf');
                if (in_array($ext, $file_allow)) {
                    $user_id = \Yii::$app->user->getId();
                    $model_file = UserFile::find()->where('user_id=:user_id', [':user_id' => $user_id])->one();
                    if ($model_file === NULL) {
                        $model_file = new UserFile();
                    }
                    $model_file->file_src = 'true';
                    $model_file->size = $file['size'];
                    $model_file->id = ClaGenerate::getUniqueCode(array('prefix' => 'f'));
                    $model_file->display_name = $file['name'];
                    $up = new UploadLib($file);
                    $up->setPath(array('user-file', $user_id));
                    $up->uploadFile();
                    $response = $up->getResponse(true);
                    if ($up->getStatus() == '200') {
                        $model_file->path = $response['baseUrl'];
                        $model_file->name = $response['name'];
                        $model_file->extension = $response['ext'];
                        $model_file->file_src = 'true';
                        $model_file->user_id = $user_id;
                        if ($model_file->save()) {
                            $html = $this->renderAjax('ajax/html_file_info', [
                                'file' => $model_file
                            ]);
                            return [
                                'code' => 200,
                                'html' => $html,
                                'model' => $model_file->attributes
                            ];
                        } else {
                            return $model_file->getErrors();
                        }
                    }
                }
            }
        }
    }

    public function actionDownloadFileCv($id) {
        $file = UserFile::findOne($id);
        if ($file !== NULL) {
            $read = \Yii::$app->request->get('read', false) ? true : false;
            $up = new UploadLib();
            $up->download(array(
                'path' => $file->path,
                'name' => $file->name,
                'extension' => UserFile::getMimeType($file->extension),
                'realname' => HtmlFormat::parseToAlias($file->display_name) . '.' . $file->extension,
                'readOnline' => $read
            ));
        }
        \Yii::$app->end();
    }
    
    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
    public function actionUploadAvatar()
    {
        if (isset($_FILES['file'])) {
            $file = $_FILES['file'];
            if ($file['size'] > 1024 * 1000 * 2) {
                $this->jsonResponse('400', array(
                    'message' => Yii::t('errors', 'filesize_toolarge', array('{size}' => '2Mb')),
                ));
                Yii::app()->end();
            }
            $up = new UploadLib($file);
            $up->setPath(array('user-avatar', \Yii::$app->user->getId()));
            $up->uploadImage();
            $return = array();
            $response = $up->getResponse(true);
            $return = array('status' => $up->getStatus(), 'data' => $response, 'host' => ClaHost::getImageHost(), 'size' => '');
            if ($up->getStatus() == '200') {
                $keycode = ClaGenerate::getUniqueCode();
                $return['data']['realurl'] = ClaHost::getImageHost() . $response['baseUrl'] . 's150_150/' . $response['name'];
                $return['data']['avatar'] = $keycode;
                $user_info = User::findOne(Yii::$app->user->getId());
                if ($response) {
                    $user_info->avatar_path = $response['baseUrl'];
                    $user_info->avatar_name = $response['name'];
                    $user_info->save(false);
                }
            }
            echo json_encode($return);
            Yii::$app->end();
        }
        //
    }
    /**
     * upload file
     */
    public function actionUploadCover()
    {

        if (isset($_FILES['file'])) {
            $file = $_FILES['file'];
            if ($file['size'] > 1024 * 1000 * 2) {
                $this->jsonResponse('400', array(
                    'message' => Yii::t('errors', 'filesize_toolarge', array('{size}' => '2Mb')),
                ));
                Yii::app()->end();
            }
            $up = new UploadLib($file);

            $up->setPath(array('user-cover', \Yii::$app->user->getId()));
            $up->uploadImage();
            $return = array();
            $response = $up->getResponse(true);
            $return = array('status' => $up->getStatus(), 'data' => $response, 'host' => ClaHost::getImageHost(), 'size' => '');

            if ($up->getStatus() == '200') {
                $keycode = ClaGenerate::getUniqueCode();
                $return['data']['realurl'] = ClaHost::getImageHost() . $response['baseUrl'] . 's150_150/' . $response['name'];
                $return['data']['avatar'] = $keycode;
                $user_info = User::findOne(Yii::$app->user->getId());
                if ($response) {
                    $user_info->image_path = $response['baseUrl'];
                    $user_info->image_name = $response['name'];
                    $user_info->save(false);
                }
            }
            echo json_encode($return);
            Yii::$app->end();
        }
    }

}
