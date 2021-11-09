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

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        Yii::$app->view->title = 'Quản lý đơn hàng của gian hàng';
        $orders = Order::getInShopByStatus(Yii::$app->user->id, Order::ORDER_WAITING_PROCESS);
        $products = [];
        foreach ($orders as $order) {
            $products[$order['id']] = OrderItem::getByShopOrder($order['id']);
        }
        for ($i = 0; $i < 5; $i++) {
            $count_status[$i] = Order::getInShopByStatus(Yii::$app->user->id, $i, ['count' => 1]);
        }
        return $this->render('order', [
            'products' => $products,
            'orders' => $orders,
            'count_status' => $count_status
        ]);
    }

    public function actionUpdate0($id)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $tru_product = 0;
        $order = Order::getInShopById($id);
        if ($order) {
            if ($order->transport_id) {
                $claShipping = new ClaShipping();
                $claShipping->loadVendor(['method' => $order->transport_type]);
                switch ($order->transport_type) {
                    case ClaShipping::METHOD_GHN:
                        $options['data'] = array(
                            'OrderCode' => $order->transport_id
                        );
                        break;
                    default:
                        $options['data'] = array(
                            'OrderCode' => $order->transport_id
                        );
                        break;
                }
                $data = $claShipping->cancerOrder($options);
                if (isset($data['success']) && $data['success']) {
                    $status_old = $order->status;
                    if ($order->status > 1) {
                        $tru_product = true;
                    }
                    $order->status = 0;
                    if ($order->save()) {
                        if (\common\models\gcacoin\CoinConfinement::cancerShopOrder($order)) {
                            if ($tru_product) {
                                $order->setPromotion(0);
                            }
                            $data = [
                                'order_id' => $id,
                                'time' => time(),
                                'status' => 0,
                                'type' => $order->transport_type,
                                'content' => Yii::t('app', 'update_to_shop'),
                                'created_at' => time()
                            ];
                            $kt = \common\models\order\OrderShopHistory::saveData($data);
                            $sve = \common\models\notifications\Notifications::updateStatusOrder($order);
                            return $this->renderAjax('view/response-order', [
                                'repspone' => 1,
                                'msg' => Yii::t('app', 'cancer_order_success'),
                                // 'url_back' => Url::to(['/management/order/update-order-back', 'order_id' => $order->id])
                            ]);
                        } else {
                            $order->status = $status_old;
                            $order->save(false);
                            return $this->renderAjax('view/response-order', [
                                'repspone' => 0,
                                'msg' => Yii::t('app', 'cancer_order_fail')
                            ]);
                        }
                    }
                } else {
                    return $this->renderAjax('view/response-order', [
                        'repspone' => 20,
                        'msg' => isset($data['message']) ? $data['message'] : Yii::t('app', 'cancer_order_fail')
                    ]);
                }
            } else {
                if ($order->status == 1 || $order->status == 2 || $order->status == 3) {
                    $status_old = $order->status;
                    if ($order->status > 1) {
                        $tru_product = true;
                    }
                    $order->status = 0;
                    if ($order->save()) {
                        if (\common\models\gcacoin\CoinConfinement::cancerShopOrder($order)) {
                            if ($tru_product) {
                                $order->setPromotion(0);
                            }
                            $data = [
                                'order_id' => $id,
                                'time' => time(),
                                'status' => 0,
                                'type' => $order->transport_type,
                                'content' => Yii::t('app', 'update_to_shop'),
                                'created_at' => time()
                            ];
                            $kt = \common\models\order\OrderShopHistory::saveData($data);
                            $sve = \common\models\notifications\Notifications::updateStatusOrder($order);
                            return $this->renderAjax('view/response-order', [
                                'repspone' => 1,
                                'msg' => Yii::t('app', 'cancer_order_success')
                            ]);
                        } else {
                            $order->status = $status_old;
                            $order->save(false);
                        }
                    }
                }
            }
        }
        return $this->renderAjax('view/response-order', [
            'repspone' => 0,
            'msg' => Yii::t('app', 'cancer_order_fail')
        ]);
    }

    public function actionUpdate12($id)
    {
        if ($order = Order::getInShopById($id)) {
            if ($order->status == 1) {
                $order->status = 2;
                if ($order->save()) {
                    $order->setPromotion();
                    $data = [
                        'order_id' => $id,
                        'time' => time(),
                        'status' => $order->status,
                        'type' => $order->transport_type,
                        'content' => Yii::t('app', 'update_to_shop'),
                        'created_at' => time()
                    ];
                    $kt = \common\models\order\OrderShopHistory::saveData($data);
                    $sve = \common\models\notifications\Notifications::updateStatusOrder($order);
                    return Yii::t('app', 'update_success');
                }
            }
        }
        return Yii::t('app', 'update_fail');
    }

    public function actionUpdate23($id)
    {
        if ($order = Order::getInShopById($id)) {
            if ($order->status == 2) {
                $order->status = 3;
                if ($order->save()) {
                    $data = [
                        'order_id' => $id,
                        'time' => time(),
                        'status' => $order->status,
                        'type' => $order->transport_type,
                        'content' => Yii::t('app', 'update_to_shop'),
                        'created_at' => time()
                    ];
                    $kt = \common\models\order\OrderShopHistory::saveData($data);
                    $sve = \common\models\notifications\Notifications::updateStatusOrder($order);
                    return Yii::t('app', 'update_success');
                }
            }
        }
        return Yii::t('app', 'update_fail');
    }

    public function actionLoad($status)
    {
        $orders = Order::getInShopByStatus(Yii::$app->user->id, $status);
        $products = [];
        foreach ($orders as $order) {
            $products[$order['id']] = OrderItem::getByShopOrder($order['id']);
        }
        return $this->renderAjax('management/st' . $status, [
            'products' => $products,
            'orders' => $orders,
        ]);
    }

    public function actionDetail($id)
    {
        $product = Product::getOrderById(['id' => $id]); //2
        return $this->renderAjax('detail', [
            'product' => $product,
        ]);
    }

    public function actionLoadReview($order_item_id)
    {
        $rates = Rating::getRatingsByOrder($order_item_id); //2
        $this->layout = '@frontend/views/layouts/empty.php';
        return $this->render('management/review', [
            'rates' => $rates,
        ]);
    }

    public function actionGetDetail()
    {
        $get = $_GET;
        if (isset($get['status_get']) && isset($get['id'])) {
            $view = 'management/detail' . $get['status_get'];
            $id = $get['id'];
            $data = Order::getDetail($id);
            // echo "<pre>";
            // return print_r($data);
            return $this->renderAjax($view, [
                'data' => $data,
            ]);
        }
        return Yii::t('app', 'data_empty');
    }

    //nguoi mua
    public function actionView()
    {
        $this->layout = 'main_user';
        Yii::$app->view->title = 'Quản lý đơn hàng bạn đặt mua';
        $status =  Order::ORDER_WAITING_PROCESS;
        $orders = Order::getByUserByStatus(Yii::$app->user->id, $status);
        $products = [];
        foreach ($orders as $order) {
            $products[$order['id']] = OrderItem::getByShopOrder($order['id']);
        }
        for ($i = 0; $i < 5; $i++) {
            $count_status[$i] = Order::getByUserByStatus(Yii::$app->user->id, $i, ['count' => 1]);
        }
        return $this->render('order-view', [
            'products' => $products,
            'orders' => $orders,
            'status' => $status,
            'count_status' => $count_status
        ]);
    }

    public function actionLoadView($status)
    {
        $orders = Order::getByUserByStatus(Yii::$app->user->id, $status);
        $products = [];
        foreach ($orders as $order) {
            $products[$order['id']] = OrderItem::getByShopOrder($order['id']);
        }
        $view = 'view/st' . $status;
        return $this->renderAjax($view, [
            'products' => $products,
            'orders' => $orders,
            'status' => $status,
        ]);
    }

    public function actionGetDetailView()
    {
        $get = $_GET;
        if (isset($get['status_get']) && isset($get['id'])) {
            $view = 'view/detail';
            $id = $get['id'];
            $data = Order::getDetail($id);
            return $this->renderAjax($view, [
                'data' => $data,
            ]);
        }
        return Yii::t('app', 'data_empty');
    }

    public function actionUpdatev0($id)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $order = Order::getInUserById($id);
        if ($order) {
            if ($order->transport_id) {
                $claShipping = new ClaShipping();
                $claShipping->loadVendor(['method' => $order->transport_type]);
                switch ($order->transport_type) {
                    case ClaShipping::METHOD_GHN:
                        $options['data'] = array(
                            'OrderCode' => $order->transport_id
                        );
                        break;

                    default:
                        $options['data'] = array(
                            'OrderCode' => $order->transport_id
                        );
                        break;
                }
                $data = $claShipping->cancerOrder($options);
                if (isset($data['success']) && $data['success']) {
                    $status_old = $order->status;
                    $order->status = 0;
                    if ($order->save()) {
                        if (\common\models\gcacoin\CoinConfinement::cancerShopOrder($order)) {
                            $data = [
                                'order_id' => $id,
                                'time' => time(),
                                'status' => 0,
                                'type' => $order->transport_type,
                                'content' => Yii::t('app', 'update_to_user'),
                                'created_at' => time()
                            ];
                            $kt = \common\models\order\OrderShopHistory::saveData($data);
                            $sve = \common\models\notifications\Notifications::updateStatusOrder($order);
                            return $this->renderAjax('view/response-order', [
                                'repspone' => 1,
                                'msg' => Yii::t('app', 'cancer_order_success'),
                            ]);
                        } else {
                            $order->status = $status_old;
                            $order->save(false);
                            return $this->renderAjax('view/response-order', [
                                'repspone' => 0,
                                'msg' => Yii::t('app', 'cancer_order_fail')
                            ]);
                        }
                    }
                } else {
                    return $this->renderAjax('view/response-order', [
                        'repspone' => 20,
                        'msg' => isset($data['message']) ? $data['message'] : Yii::t('app', 'cancer_order_fail')
                    ]);
                }
            } else {
                if ($order->status == 1) {
                    $status_old = $order->status;
                    $order->status = 0;
                    if ($order->save()) {
                        if (\common\models\gcacoin\CoinConfinement::cancerShopOrder($order)) {
                            $data = [
                                'order_id' => $id,
                                'time' => time(),
                                'status' => 0,
                                'type' => $order->transport_type,
                                'content' => Yii::t('app', 'update_to_user'),
                                'created_at' => time()
                            ];
                            $kt = \common\models\order\OrderShopHistory::saveData($data);
                            $sve = \common\models\notifications\Notifications::updateStatusOrder($order);
                            return $this->renderAjax('view/response-order', [
                                'repspone' => 1,
                                'msg' => Yii::t('app', 'cancer_order_success')
                            ]);
                        } else {
                            $order->status = $status_old;
                            $order->save(false);
                        }
                    }
                }
            }
        }

        return $this->renderAjax('view/response-order', [
            'repspone' => 0,
            'msg' => Yii::t('app', 'cancer_order_fail')
        ]);
    }

    // public function actionUpdatev40($id)
    // {
    //     date_default_timezone_set('Asia/Ho_Chi_Minh');
    //     $order = Order::getInUserById($id);
    //     if($order) {
    //         if(!$order->transport_id) {
    //             if($order->status == 4) {
    //                 $order->status = 0;
    //                 if($order->save()) {
    //                     $data = [
    //                         'order_id' => $id,
    //                         'time' => time(),
    //                         'status' => 7,
    //                         'type' => $order->transport_type,
    //                         'content' => Yii::t('app', 'update_to_user'),
    //                         'created_at' => time()
    //                     ];
    //                     $kt = \common\models\order\OrderShopHistory::saveData($data);
    //                     $sve = \common\models\notifications\Notifications::updateStatusOrder($order);
    //                     return $this->renderAjax('view/response-order',[
    //                             'repspone' => 1,
    //                             'msg' => Yii::t('app', 'cancer_order_success')
    //                         ]);
    //                 }
    //             }
    //         }
    //     }

    //     return $this->renderAjax('view/response-order',[
    //                     'repspone' => 0,
    //                     'msg' => Yii::t('app', 'cancer_order_fail')
    //                 ]);
    // }

    public function actionUpdate34($id)
    {
        $order = ($order = Order::getInUserById($id)) ? $order : Order::getInShopById($id);
        if ($order) {
            if ($order->status == 3) {
                $order->status = 4;
                if ($order->save()) {
                    $data = [
                        'order_id' => $id,
                        'time' => time(),
                        'status' => $order->status,
                        'type' => $order->transport_type,
                        'content' => Yii::t('app', 'update_to_user'),
                        'created_at' => time()
                    ];
                    $kt = \common\models\order\OrderShopHistory::saveData($data);
                    $sve = \common\models\notifications\Notifications::updateStatusOrder($order);
                    return Yii::t('app', 'update_success');
                }
            }
        }
        return Yii::t('app', 'update_fail');
    }

    public function actionUpdateOrderBack($order_id)
    {
        return Order::updateStatus($order_id);
    }

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionPrint()
    {
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $model = Order::findOne($id);
            $shop = \common\models\shop\Shop::findOne(Yii::$app->user->id);
            if ($model && $shop) {
                $products = OrderItem::getByShopInOrder(Yii::$app->user->id, $id);
                return $products ? $this->renderAjax('printorder', [
                    'model' => $model,
                    'products' => $products,
                    'shop' => $shop
                ])
                    : 0;
            }
        }
        return 0;
    }
}
