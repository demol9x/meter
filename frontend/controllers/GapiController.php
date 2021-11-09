<?php

namespace frontend\controllers;

class GapiController extends CController
{

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionGetNumberNotification($user_id = 0)
    {
        if (!$user_id) {
            return 0;
        }
        return \common\models\notifications\Notifications::countUnreadNotifications($user_id);
    }

    public function actionGetLinkProduct($id)
    {
        $product = \common\models\product\Product::findOne($id);
        return $product ? \yii\helpers\Url::to(['/product/product/detail', 'id' => $product->id, 'alias' => $product->alias]) : '';
    }

    public function actionGetLinkFrontend($url)
    {
        $get = $_GET;
        unset($get['url']);
        $fx = array_merge([$url], $get);
        return \yii\helpers\Url::to($fx);
    }
}
