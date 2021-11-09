<?php

namespace frontend\modules\management\controllers;

use Yii;
use common\models\product\Product;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Response;
use frontend\components\FilterHelper;
use common\models\order\Order;
use common\models\order\OrderItem;
/**
 * ProductController implements the CRUD actions for Product model.
 */
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

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        Yii::$app->view->title = Yii::t('app', 'order');
        Yii::$app->view->dynamicPlaceholders = [
            'asset' => 'AppAssetManagement'
        ];
        $products = Product::getOrderInShop(['status' => Order::ORDER_WAITING_PROCESS]);
        return $this->render('order', [
                    'products' => $products,
        ]);
    }

    public function actionView()
    {
        $this->layout = 'main_user';
        Yii::$app->view->title = Yii::t('app', 'order');
        Yii::$app->view->dynamicPlaceholders = [
            'asset' => 'AppAssetManagement'
        ];
        $products = Product::getOrderByUser(['status' => Order::ORDER_WAITING_PROCESS]);
        return $this->render('order-view', [
                    'products' => $products,
        ]);
    }

    public function actionUpdate12($id)
    {
        if( $order = OrderItem::findOne($id)) {
            if($order->status == 1) {
                $order->status = 2;
                return $order->save();
            }
            
        }
        return 0;
    }

    public function actionUpdate23($id)
    {
        if( $order = OrderItem::findOne($id)) {
            if($order->status == 2) {
                $order->status = 3;
                return $order->save();
            }
            
        }
        return 0;
    }

    public function actionUpdate34($id)
    {
        if( $order = OrderItem::findOne($id)) {
            if($order->status == 3) {
                $order->status = 4;
                return $order->save();
            }
            
        }
        return 0;
    }

   
    public function actionUpdate0($id)
    {
        if( $order = OrderItem::findOne($id)) {
            $order->status = 0;
            return $order->save();
        }
        return 0;
    }

    public function actionLoad($status)
    {
        $products = Product::getOrderInShop(['status' => $status]); //2
        $this->layout = '@frontend/views/layouts/empty.php';
        return $this->render('management/st'.$status, [
                    'products' => $products,
        ]);
    }

    public function actionLoadView($status)
    {
        $products = Product::getOrderInShop(['status' => $status]); //2
        $this->layout = '@frontend/views/layouts/empty.php';
        return $this->render('view/st', [
                    'products' => $products,
                    'status' => $status,
        ]);
    }

    public function actionDetail($id)
    {
        $this->layout = '@frontend/views/layouts/empty.php';
        $product = Product::getOrderById(['id' => $id]); //2
        return $this->render('detail', [
                    'product' => $product,
        ]);
    }
}
