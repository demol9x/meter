<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\rating\Rating;
use common\models\rating\RateResponse;
use common\models\product\Product;
use yii\web\Response;
use frontend\models\User;

class RatingController extends CController {

    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionRating() {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model = new Rating();
            if ($model->load(Yii::$app->request->post())) {
                $user = User::findOne(Yii::$app->user->getId());
                $model->name = $user->username;
                $model->address = $user->address ? $user->address : '.';
                $model->email = $user->email ? $user->email : '.';
                $model->user_id = $user->id;
                if ($model->save()) {
                    Product::updateRate($model->object_id);
                    return ['code' => 200];
                } else {
                    echo "<pre>";
                    print_r($model->getErrors());
                    echo "</pre>";
                    die();
                }
            }
        }
    }

    public function actionResponse() {
        if(isset($_POST['id']) && isset($_POST['message']) && $_POST['message'] && $_POST['id']) {
            $model = new RateResponse();
            $user = User::findOne(Yii::$app->user->getId());
            $model->rating_id = $_POST['id']; 
            $model->response = $_POST['message'];
            $model->user_response_id = $user->id;
            $model->user_response_name = $user->username;
            $model->created_at = time();
            if($model->save()) {
                return '<p><b>'.$model['user_response_name'].'</b>'.Yii::t('app', 'response').':
                        <p>'.$model['response'].'</p>
                    </p>';
            }
        }
        return false;
    }

}
