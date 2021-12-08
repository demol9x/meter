<?php

namespace frontend\modules\management\controllers;


use common\components\ClaGenerate;
use common\components\UploadLib;
use common\models\user\Tho;
use frontend\controllers\CController;

use Yii;
use frontend\models\User;
use yii\web\Response;
use yii\web\UploadedFile;


class ThoController extends CController
{


    public function actionIndex()
    {
        $this->layout = 'main';
        if(Yii::$app->user->getId()){
            $model= Tho::findOne(['user_id'=>Yii::$app->user->getId()]);
            $user = User::findIdentity(Yii::$app->user->getId());
            if($user->type==User::TYPE_CA_NHAN){
                $model= new Tho();
            }
        }

        if($model->load(Yii::$app->request->post())){
            $model->status = 1;
            $model->file = UploadedFile::getInstance($model,'file');
            if($model->file){
                $model->file->saveAs(Yii::getAlias('@rootpath').'/static/media/files/package/'.ClaGenerate::getUniqueCode().'.'.$model->file->extension);
                $model->attachment = '/media/files/package/'.ClaGenerate::getUniqueCode().'.'.$model->file->extension;
            }
            if($user->type==User::TYPE_CA_NHAN){
                $model->user_id= Yii::$app->user->getId();
            }
            if($model->save()){
                if($user->type==User::TYPE_CA_NHAN){
                    $user->type=User::TYPE_THO;
                    $model->user_id= Yii::$app->user->getId();
                    $user->save();
                }
                \Yii::$app->getSession()->setFlash('cusses', 'Cập nhật thành công!');
            }
            else{
                echo '<pre>';
                print_r($model->getErrors());
                echo '</pre>';
                die();
                \Yii::$app->getSession()->setFlash('cusses', 'Cập nhật không thành công!');
            }
        }

        return $this->render('index', [
            'user' => $user,
            'model' => $model,
        ]);
    }

}

