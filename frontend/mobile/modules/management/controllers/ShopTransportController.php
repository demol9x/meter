<?php

namespace frontend\mobile\modules\management\controllers;

use Yii;
use common\models\shop\Shop;
use common\components\ClaGenerate;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\transport\Transport;
use common\models\transport\ShopTransport;

/**
 * ShopController implements the CRUD actions for Shop model.
 */
class ShopTransportController extends Controller
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

    public function actionIndex()
    {
        $transports = Transport::getAll();
        $shop_transports = ShopTransport::getByShop(Yii::$app->user->id);
        return $this->render('index', [
            'transports' => $transports,
            'shop_transports' => $shop_transports
        ]);
    }

    public function actionUpdate($status, $id)
    {
        if(!$status) {
            $transport = ShopTransport::getByShopAndTransport(Yii::$app->user->id, $id);
            return $transport->delete();
        } else {
            $transport = new ShopTransport();
            $transport->status = $status;
            $transport->transport_id = $id;
            $transport->shop_id = Yii::$app->user->id;
            $transport->default = 0;
        }
        return $transport->save();
    }

    public function actionUpdateDefault($default, $id)
    {
        $transport = ShopTransport::getByShopAndTransport(Yii::$app->user->id, $id);
        if($transport) {
            $transport->default = 1;
        } else {
            $transport = new ShopTransport();
            $transport->status = 1;
            $transport->transport_id = $id;
            $transport->shop_id = Yii::$app->user->id;
            $transport->default = 1;
        }
        ShopTransport::updateAll(
                ['default' => 0], [ 
                'shop_id' => Yii::$app->user->id
            ]);
        return $transport->save();
    }
}
