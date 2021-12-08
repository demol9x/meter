<?php

namespace frontend\modules\management\controllers;

use Yii;
use common\models\product\Product;
use yii\web\Controller;
use yii\filters\VerbFilter;
use common\models\order\Order;
use common\models\order\OrderItem;
use common\models\rating\Rating;
use common\components\shipping\ClaShipping;

class OrderController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $orders = Order::find()->where(['order.status' => 1, 'order.user_id' => Yii::$app->user->id])
            ->joinWith(['items', 'voucher'])
            ->orderBy('created_at DESC')
            ->asArray()->all();
        return $this->render('index',['orders' => $orders]);
    }

    public function actionLoad($status)
    {
        $orders = Order::find()->where(['order.status' => $status, 'order.user_id' => Yii::$app->user->id])
            ->joinWith(['items', 'voucher'])
            ->orderBy('created_at DESC')
            ->asArray()->all();
        return $this->renderPartial('load',['orders' => $orders]);

    }
}
