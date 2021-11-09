<?php

namespace frontend\modules\affiliate\controllers;

use common\components\ClaGenerate;
use common\models\user\UserMoney;
use common\models\user\UserMoneyLog;
use Yii;
use yii\web\Controller;
use common\models\product\Product;
use common\components\ClaLid;
use yii\web\Response;
use common\models\affiliate\AffiliateLink;
use common\components\ClaDateTime;
use common\models\affiliate\AffiliateClick;
// use common\models\affiliate\AffiliateOrder;
// use common\models\affiliate\AffiliateOrderItems;
use common\models\order\OrderItem;
use common\models\order\OrderShop;
use common\models\order\Order;
use common\models\affiliate\AffiliatePaymentInfo;
use common\models\affiliate\AffiliateTransferMoney;

/**
 */
class AffiliateController extends Controller
{

    public function actionOverview()
    {
        $this->layout = 'main';
        Yii::$app->view->title = 'Tổng quan tiếp thị liên kết của bạn';

        //
        $options = [];
        $start_date = Yii::$app->request->get('start_date');
        $end_date = Yii::$app->request->get('end_date');
        //
        if ($start_date === NULL) {
            $start_date = date('d-m-Y', strtotime('-30 days'));
        }
        $options['start_date'] = $start_date;
        //
        if ($end_date === NULL) {
            $end_date = date('d-m-Y');
        }
        $options['end_date'] = $end_date;
        // get date ranges
        list($sd, $sm, $sy) = explode('-', $start_date);
        list($ed, $em, $ey) = explode('-', $end_date);
        $stemp = implode('-', [$sy, $sm, $sd]);
        $etemp = implode('-', [$ey, $em, $ed]);
        $dateRanges = ClaDateTime::date_range($stemp, $etemp, '+1 day', 'd-m-Y');
        //
        $user_id = Yii::$app->user->id;
        // Số click
        $clickCount = AffiliateClick::countClick($user_id, $options);
        // Đơn hàng chờ
        $orderWaitingCount = Order::countOrder([1,2,3], $user_id, $options);
        // Đơn hàng hoàn thành
        $orderCompleteCount = Order::countOrder([Order::ORDER_DELIVERING], $user_id, $options);
        // Tỷ lệ đơn hàng / click
        if (($orderWaitingCount + $orderCompleteCount) >= 1 && $clickCount) {
            $rate = ($orderWaitingCount + $orderCompleteCount) / ($clickCount / 100);
        } else {
            $rate = 0;
        }
        // Data for chart
        $data = [];
        foreach ($dateRanges as $date) {
            $data[$date]['click'] = 0;
            $data[$date]['order'] = 0;
        }
        //
        $dataClick = AffiliateClick::getClick($user_id, $options);
        foreach ($dataClick as $click) {
            $day = date('d-m-Y', $click['created_at']);
            $data[$day]['click']++;
        }
        $dataOrder = Order::getAllOrder($user_id, $options);
        // echo "<pre>";
        // print_r($dataOrder);
        // echo "</pre>";
        foreach ($dataOrder as $order) {
            $day = date('d-m-Y', $order['created_at']);
            $data[$day]['order']++;
        }
        
        // Get commission order success
        $order_items = OrderItem::getAllOrderItem($user_id, $options);
        $commission = OrderItem::calculatorCommission($order_items);

        return $this->render('overview', [
            'start_date' => $start_date,
            'end_date' => $end_date,
            'clickCount' => $clickCount,
            'orderWaitingCount' => $orderWaitingCount,
            'orderCompleteCount' => $orderCompleteCount,
            'rate' => $rate,
            'data' => $data,
            'commission' => $commission
        ]);
    }

    public function actionCreateLink()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $url = Yii::$app->request->get('url');
            $object_id = Yii::$app->request->get('object_id');
            $type = Yii::$app->request->get('type');
            if (isset($url) && $url) {
                $model = new AffiliateLink();
                $model->user_id = \Yii::$app->user->id;
                $model->url = $url;
                $model->type = $type;
                $model->object_id = $object_id;
                //
                $modelProduct = Product::findOne($object_id);
                if (isset($modelProduct->designer_id) && $modelProduct->designer_id) {
                    $model->is_design = ClaLid::STATUS_ACTIVED;
                    $model->designer_id = $modelProduct->designer_id;
                }
                //
                if ($model->save()) {
                    $link = $model->url . '?affiliate_id=' . $model->id;
                    $model->link = $link;
                   // $short_link = Yii::$app->google->shortUrl($link);
                    if ($model->save()) {
                        return [
                            'message' => 'success'
                        ];
                    } else {
                        echo '<pre>';
                        print_r($model->getErrors());
                        echo '</pre>';
                        die();
                    }
                } else {
                    echo '<pre>';
                    print_r($model->getErrors());
                    echo '</pre>';
                    die();
                }
            }
        }
    }

    public function actionListLink()
    {
        $this->layout = 'main';
        //
        $data = AffiliateLink::getAllLink();
        //
        return $this->render('list', [
            'data' => $data
        ]);
    }

    public function actionReportOrder()
    {
        $this->layout = 'main';
        $user_id = Yii::$app->user->id;
        //
        $options = [];
        $start_date = Yii::$app->request->get('start_date');
        $end_date = Yii::$app->request->get('end_date');
        //
        if ($start_date === NULL) {
            $start_date = date('d-m-Y', strtotime('-30 days'));
        }
        $options['start_date'] = $start_date;
        //
        if ($end_date === NULL) {
            $end_date = date('d-m-Y');
        }
        $options['end_date'] = $end_date;
        //
        $clickCount = AffiliateClick::countClick($user_id, $options);
        // Đơn hàng chờ
        $orderWaitingCount = Order::countOrder([1,2,3], $user_id, $options);
        // Đơn hàng hoàn thành
        $orderCompleteCount = Order::countOrder([Order::ORDER_DELIVERING], $user_id, $options);
        // Thưởng đơn hàng hoàn thành
        // Đơn hàng hủy
        $orderDestroyCount = Order::countOrder([Order::ORDER_CANCEL], $user_id, $options);
        //
        if (($orderWaitingCount + $orderCompleteCount) >= 1 && $clickCount) {
            $rate = ($orderWaitingCount + $orderCompleteCount) / ($clickCount / 100);
        } else {
            $rate = 0;
        }
        // Get commission order success
        $orderItems = OrderItem::getAllOrderItem($user_id, $options);
        $commission = OrderItem::calculatorCommission($orderItems);
        //
        // Get orders items
        return $this->render('report_order', [
            'clickCount' => $clickCount,
            'orderWaitingCount' => $orderWaitingCount,
            'orderCompleteCount' => $orderCompleteCount,
            'orderDestroyCount' => $orderDestroyCount,
            'rate' => $rate,
            'orderItems' => $orderItems,
            'commission' => $commission,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ]);
    }

    public function actionReportOrderShop()
    {
        $this->layout = 'main';
        $user_id = Yii::$app->user->id;
        //
        $options = [];
        $start_date = Yii::$app->request->get('start_date');
        $end_date = Yii::$app->request->get('end_date');
        //
        if ($start_date === NULL) {
            $start_date = date('d-m-Y', strtotime('-30 days'));
        }
        $options['start_date'] = $start_date;
        //
        if ($end_date === NULL) {
            $end_date = date('d-m-Y');
        }
        $options['end_date'] = $end_date;
        
        // Get commission order success
        $orderItems = OrderItem::getAllOrderItemIsShop($user_id, $options);
        $commission = OrderItem::calculatorCommissionIsShop($orderItems);
        //
        // Get orders items
        return $this->render('report_order_shop', [
            'orderItems' => $orderItems,
            'commission' => $commission,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ]);
    }

    public function actionListShop()
    {
        $this->layout = 'main';
        $user_id = Yii::$app->user->id;
        $shops = \common\models\shop\Shop::getAfterAffiliate($user_id);
        $affiliate = \common\models\affiliate\Affiliate::find()->one();
        // Get orders items
        return $this->render('list_shop', [
            'shops' => $shops,
            'affiliate' => $affiliate
        ]);
    }

    public function actionOrderTransferMoney()
    {
        $user_id = Yii::$app->user->id;
        $userMoney = UserMoney::getUserMoney($user_id);
        $moneyBefore = $userMoney->money_total;
        //
        $config = \common\models\affiliate\AffiliateConfig::findOne(ClaLid::ROOT_SITE_ID);
        // Get commission order success
        $order_items = AffiliateOrderItems::getAllOrderItem($user_id);
        $commission = AffiliateOrderItems::calculatorCommission($order_items);
        //
        $totalMoneyComplete = $userMoney['money'] + $userMoney['money_aff'];
        $moneyTransfered = AffiliateTransferMoney::getTotalMoneyKeep(AffiliateTransferMoney::STATUS_TRANSFERED);
        $moneyWaiting = AffiliateTransferMoney::getTotalMoneyKeep(AffiliateTransferMoney::STATUS_WAITING);
        //
        $model = new AffiliateTransferMoney();
        if (isset($_POST['AffiliateTransferMoney']) && $_POST['AffiliateTransferMoney']) {
            $model->attributes = $_POST['AffiliateTransferMoney'];
            $model->user_id = $user_id;
            if ($model->money < $config['min_price']) {
                $model->addError('money', 'Số tiền phải lớn hơn ' . $config['min_price']);
            }
            $money_real = $totalMoneyComplete - ($moneyTransfered + $moneyWaiting);
            if ($model->money > $money_real) {
                $model->addError('money', 'Số tiền phải nhỏ hơn ' . $money_real);
            }
            if (!$model->getErrors()) {
                if ($model->save()) {
                    $moneyChange = $model->money;
                    $log = new UserMoneyLog();
                    $log->user_id = $user_id;
                    $log->money_before = $moneyBefore;
                    $log->money_change = $moneyChange;
                    $log->money_after = $moneyBefore - $moneyChange;
                    $log->money_total_before = $moneyBefore;
                    $log->money_total_after = $moneyBefore - $moneyChange;
                    $log->order_id = $model->id;
                    $log->type = UserMoneyLog::TYPE_DEDUCT;
                    $log->reason = 'Yêu cầu rút tiền từ user';
                    $log->status = UserMoneyLog::STATUS_WAITING;
                    $log->user_id_execute = $user_id;
                    $log->save();
                    //
                    $userMoney->money_total = $userMoney->money_total - $moneyChange;
                    $userMoney->money_total_hash = ClaGenerate::encrypt($userMoney->money_total);
                    $userMoney->save();
                    //
                    return $this->redirect(['list-transfer-money']);
                }
            }
        }
        return $this->render('transfer_money', [
            'config' => $config,
            'commission' => $commission,
            'model' => $model,
            'moneyTransfered' => $moneyTransfered,
            'moneyWaiting' => $moneyWaiting,
            'userMoney' => $userMoney
        ]);
    }

    public function actionListTransferMoney()
    {
        $user_id = Yii::$app->user->id;
        $data = AffiliateTransferMoney::getAllDataByUserId($user_id);
        //
        return $this->render('list_transfer_money', [
            'data' => $data
        ]);
    }

    public function actionPaymentInfo()
    {
        $model = AffiliatePaymentInfo::findOne(Yii::$app->user->id);
        if ($model === NULL) {
            $model = new AffiliatePaymentInfo();
            $model->user_id = Yii::$app->user->id;
        }
        //
        if (isset($_POST['AffiliatePaymentInfo'])) {
            //
            $model->attributes = $_POST['AffiliatePaymentInfo'];
            //
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Cập nhật thành công');
            }
        }
        //
        return $this->render('payment_info', [
            'model' => $model
        ]);
    }

}
