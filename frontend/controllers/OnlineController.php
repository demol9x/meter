<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\rating\Rating;
use common\models\rating\RateResponse;
use common\models\product\Product;
use yii\web\Response;
use common\models\User;
use yii\helpers\Url;
/**
 * Site controller
 */
class OnlineController extends CController {

    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionOnline($id) {
        $user = User::findOne($id);
        if($user && $user->isOnline()) {
            return '<span class="online">'.Yii::t('app', 'onlines').'</span>';
        }
        return '<span class="offline">'.Yii::t('app', 'offlines').'</span>';
    }

    public function actionRequestOnline() {
        if(Yii::$app->user->id) { 
            $user = \frontend\models\User::findIdentity(Yii::$app->user->id);
            $user->last_request_time = time();
            $user->save();
        }
    }
}