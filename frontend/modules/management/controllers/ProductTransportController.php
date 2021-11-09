<?php

namespace frontend\modules\management\controllers;

use Yii;
use common\components\ClaGenerate;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\transport\Transport;
use common\models\transport\ProductTransport;

/**
 * ShopController implements the CRUD actions for Shop model.
 */
class ProductTransportController extends Controller
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

    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    // public function actionIndex()
    // {
    //     $transports = Transport::getAll();
    //     $shop_transports = ProductTransport::getByShop(Yii::$app->user->id);
    //     return $this->render('index', [
    //         'transports' => $transports,
    //         'shop_transports' => $shop_transports
    //     ]);
    // }

    public function actionUpdate($product_id, $transport_id , $status)
    {
        $product_ids = $product_id;
        $product_id = $product_id ? $product_id : Yii::$app->user->id;
        $transport = ProductTransport::getByProductAndTransport($product_id, $transport_id);
        if(!$status) {
            if($transport) {
                $transport->status = $product_ids ? 1 : 2;
            } else {
                $transport = new ProductTransport();
                $transport->status = $product_ids ? 1 : 2;
                $transport->transport_id = $transport_id;
                $transport->product_id = $product_id;
            }
            $transport->default = 0;
        } else {
            if($transport) {
                $transport->status = $product_ids ? 1 : 2;
            } else {
                $transport = new ProductTransport();
                $transport->status =  $product_ids ? 1 : 2;
                $transport->transport_id = $transport_id;
                $transport->product_id = $product_id;
            }
            $transport->default = 1;
            ProductTransport::setDefaultZero($product_id);
        }
        return $transport->save();
    }
    
}
