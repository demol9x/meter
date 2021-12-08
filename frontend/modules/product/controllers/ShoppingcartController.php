<?php

namespace frontend\modules\product\controllers;

use common\models\gcacoin\Gcacoin;
use common\models\product\ProductVariables;
use frontend\controllers\CController;
use Yii;
use frontend\components\Shoppingcart;
use yii\web\Response;
use common\models\order\Order;
use common\models\order\OrderItem;
use common\models\product\Product;
use yii\helpers\Url;
use frontend\models\User;
use common\components\ClaLid;
use common\models\shop\Shop;
use common\components\payments\ClaPayment;
use common\models\Province;
use common\models\District;
use common\models\Ward;
use frontend\components\Transport;
use common\models\notifications\Notifications;

class ShoppingcartController extends CController
{

    public function beforeAction($action)
    {
        if ($action->id == 'ipn') {
            $this->enableCsrfValidation = false;
        }
        if (!Yii::$app->user->id && !($action->id == 'ipn' || $action->id == 'login' || $action->id == 'add-cart')) {
            return $this->redirect(['/product/shoppingcart/login']);
        }
        return parent::beforeAction($action);
    }

    function actionCheckCode($shop_id)
    {
        $return = [
            'code' => 0,
            'data' => [],
            'message' => '',
        ];
        if (isset($_POST['code']) && $_POST['code']) {
            $shoppingcart = new \frontend\components\Shoppingcart();
            $data = $shoppingcart->cartstore;
            if (!$data) {
                $return['message'] = '<span class="error">Mã không có hiệu lực sử dụng.</span>';
                return json_encode($return);
            }
            $items = [];
            $ids = [];
            foreach ($data as $item) {
                if ($item['shop_id'] == $shop_id) {
                    $ids[] = $item['id'];
                    $items[] = $item;
                }
            }
            if ($model = \common\models\product\DiscountCode::checkCodeOrder($shop_id, $ids, $_POST['code'])) {
                $return['code'] = 1;
                $return['data']['code'] = $_POST['code'];
                if ($model->type_discount == \common\models\product\DiscountCode::TYPE_DISCOUNT) {
                    $return['data']['discount'] = $model->value;
                } else {
                    $products = [];
                    if ($model->all == 1) {
                        $products = $items;
                    } else {
                        $ids = explode(' ', $model->products);
                        foreach ($items as $item) {
                            if (in_array($item['id'], $ids)) {
                                $products[] = $item;
                            }
                        }
                    }
                    $total = 0;
                    if ($products) foreach ($products as $item) {
                        $total += $item['price'] * $item['quantity'];
                    }
                    $return['data']['discount'] = $total * $model->value / 100;
                }
                $return['message'] = '<span class="success">Mã còn hiệu lực sử dụng giảm: ' . formatMoney($return['data']['discount']) . ' ' . Yii::t('app', 'currency') . '</span>';
                return json_encode($return);
            }
            $return['message'] = '<span class="error">Mã không có hiệu lực sử dụng.</span>';
        }
        return json_encode($return);
    }

    function actionCheckout()
    {
        $this->layout = 'shoppingcart';
        //
        Yii::$app->view->title = Yii::t('app', 'thanh_toan');
        //
        Yii::$app->params['breadcrumbs'] = [
            Yii::t('app', 'home') => Url::home(),
            'Giỏ hàng' => Url::current(),
        ];
        $shoppingcart = new Shoppingcart();
        $data = $shoppingcart->cartstore;
        if (!$data) {
            $this->redirect(Url::to('/product/product/index'));
        }
        $ordertotal = $shoppingcart->getOrderTotal();
        $model = new Order();
        $user = (Yii::$app->user->id) ? User::findOne(Yii::$app->user->id) : new User();
        if ($model->load(Yii::$app->request->post())) {
            $model->key = \common\components\ClaGenerate::getUniqueCode();
            $model->order_total = $ordertotal;
            $model->user_id = (Yii::$app->user->id) ? Yii::$app->user->id : 0;
            $model->status = Order::ORDER_WAITING_PROCESS;
            if ($model->save()) {
                $data_change = [];
                foreach ($data as $key => $product) {
                    $price = $product['price'];
                    if (isset($product['var_id']) && $product['var_id']) { //Nếu là biến thể
                        $product_attr_varable = ProductVariables::getVarable(['id' => $product['var_id']]);
                        $price = $product_attr_varable['price'];
                    }
                    $model_item = new OrderItem();
                    $model_item->order_id = $model->id;
                    $model_item->product_id = $product['id'];
                    $model_item->code = $product['code'];
                    $model_item->price = $price;
                    $model_item->quantity = $product['quantity'];
                    $model_item->name = $product['name'];
                    $model_item->avatar_path = $product['avatar_path'];
                    $model_item->avatar_name = $product['avatar_name'];
                    $model_item->weight = $product['weight'];
                    $model_item->height = $product['height'];
                    $model_item->width = $product['width'];
                    $model_item->length = $product['length'];
                    $model_item->var_id = (isset($product['var_id']) && $product['var_id']) ? $product['var_id'] : '';
                    $data_change[$key][] = $model_item;
                    $model_item->save();


                }
            }
            $url_success = Url::to(['/product/shoppingcart/success', 'id' => $model->id, 'key' => $model->key]);
            return $this->redirect($url_success);
            Yii::$app->end();
        }

        $listDistrict = District::dataFromProvinceId(0);
        $listWard = Ward::dataFromDistrictId(0);
        $listProvince = Province::optionsProvince();
        //
        return $this->render('checkout', [
            'model' => $model,
            'data' => $data,
            'ordertotal' => $ordertotal,
            'user' => $user,
            'listProvince' => $listProvince,
            'listDistrict' => $listDistrict,
            'listWard' => $listWard
        ]);
    }

    public function actionGetOtp()
    {
        $user = User::findIdentity(Yii::$app->user->getId());
        return $this->renderAjax('partial/otp_pass2', [
            'success' => 'send',
            'total' => (new Shoppingcart())->getOrderTotalPayCoin(),
            'user' => $user
        ]);
        // if (!$user->phone) {
        //     return $this->renderAjax('partial/error', [
        //         'error' => 'phone',
        //         'message' => 'Vui lòng bổ xung số điện thoại cho tài khoản để có thể sử dụng hình thức thanh toán này',
        //     ]);
        // } else {
        //     // $kt['success'] = 1;
        //     $kt = \common\components\ClaQrCode::getOtpCheckAll($user->phone);
        //     if ($kt['success']) {
        //         return $this->renderAjax('partial/otp', [
        //             'success' => 'send',
        //             'total' => (new Shoppingcart())->getOrderTotal(),
        //             'user' => $user
        //         ]);
        //     } else {
        //         return $this->renderAjax('partial/error', [
        //             'error' => 'send',
        //             'message' => $kt['error']
        //         ]);
        //     }
        // }
    }

    public function actionCheckOtp($otp)
    {
        $user = User::findIdentity(Yii::$app->user->getId());
        // $kt['success'] = 1;
        // $kt = \common\components\ClaQrCode::checkOtpCheckAll($user['phone'], $otp);
        if ($user->checkOtp($otp)) {
            Yii::$app->session->open();
            $_SESSION['oke_otp_order'] = time();
            return $this->renderAjax('partial/otp_pass2', [
                'success' => 'check',
                'user' => $user
            ]);
        }
        return $this->renderAjax('partial/error_pass2', [
            'error' => 'check',
            'user' => $user,
        ]);
    }

    function actionLogin()
    {
        if (Yii::$app->user->id) {
            return $this->redirect(['/product/shoppingcart/index']);
        }
        $this->layout = 'shoppingcart';
        //
        $model = new \frontend\models\LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            \common\components\ClaLid::resetLocaltionDefault();
            return $this->redirect(['/product/shoppingcart/index']);
        }
        //
        return $this->render('login', [
            'model' => $model
        ]);
    }

    function actionIndex()
    {
        $this->layout = 'shoppingcart';
        //
        Yii::$app->view->title = Yii::t('app', 'shoppingcart');
        //
        Yii::$app->params['breadcrumbs'] = [
            Yii::t('app', 'home') => Url::home(),
            Yii::t('app', 'shoppingcart') => Url::current()
        ];
        //
        $shoppingcart = new Shoppingcart();
        //
        $data = $shoppingcart->cartstore;
        $dataProcess = [];

        //
        $ordertotal = $shoppingcart->getOrderTotal();
        //
        $user = User::findOne(Yii::$app->user->getId());
        //
        $model = new Order();
        if ($model->load(Yii::$app->request->post())) {
            $model->order_total = $ordertotal;
            if ($user) {
                $model->user_id = $user->id;
            }
            if ($model->save()) {
                // Cập nhật thông tin khách hàng
                if ($user) {
                    $user->phone = $model->phone;
                    $user->address = $model->address;
                    $user->facebook = $model->facebook;
                    $user->save(false);
                }
                //
                foreach ($data as $product) {
                    $model_item = new OrderItem();
                    $model_item->order_id = $model->id;
                    $model_item->product_id = $product['id'];
                    $model_item->code = $product['code'];
                    $model_item->price = $product['price'];
                    $model_item->quantity = $product['quantity'];
                    $model_item->save();
                }
                $shoppingcart->removeAll();
                $url_success = Url::to(['/product/shoppingcart/success', 'id' => $model->id, 'key' => $model->key]);
                $this->redirect($url_success);
            }
        }
        //

        if ($user) {
            $model->name = $user->username;
            $model->phone = $user->phone;
            $model->address = $user->address;
            $model->facebook = $user->facebook;
        }
        //
        return $this->render('index', [
            'data' => $data,
            'ordertotal' => $ordertotal,
            'model' => $model,
            'dataProcess' => $dataProcess
        ]);
    }

    public function actionShipAddress()
    {
        $shoppingcart = new Shoppingcart();
        $data = $shoppingcart->cartstore;
        if (!$data) {
            $this->redirect(['index']);
        }
        $this->layout = 'shoppingcart';
        //
        $model = new \common\models\user\UserAddress();
        //
        $addresses = \common\models\user\UserAddress::getAddressUserCurrent();
        //
        $listDistrict = District::dataFromProvinceId(0);
        $listWard = Ward::dataFromDistrictId(0);
        $listProvince = Province::optionsProvince();
        //
        if ($model->load(Yii::$app->request->post())) {
            $model->user_id = Yii::$app->user->id;
            $addtg = \common\models\user\UserAddress::find()->where(['isdefault' => 1, 'user_id' => Yii::$app->user->id])->one();
            if ($model->isdefault && $addtg) {
                $addtg->isdefault = 0;
                if ($model->save() && $addtg->save()) {
                    return $this->redirect(['ship-address']);
                }
            } else {
                if (!$addtg) {
                    $model->isdefault = 1;
                }
                if ($model->save()) {
                    return $this->redirect(['ship-address']);
                }
            }
        }
        //
        return $this->render('ship_address', [
            'model' => $model,
            'addresses' => $addresses,
            'listProvince' => $listProvince,
            'listDistrict' => $listDistrict,
            'listWard' => $listWard
        ]);
    }

    public function actionSuccess($key)
    {
        $shoppingcart = new Shoppingcart();
        $shoppingcart->removeAll();
        $orders = \common\models\order\Order::getOrderByKey($key);
        if ($orders) {
            $order_item = OrderItem::getOrderItem($orders->id);
            return $this->render('success', [
                'orders' => $orders,
                'order_item' => $order_item,
            ]);
        }
    }

    /**
     * Khi thanh toan tu cac cong thanh cong se redirect ve day
     */
    public function actionPaysuccess()
    {
        $id = Yii::$app->request->get('id');
        $key = Yii::$app->request->get('key');
        $orders = Order::getOrderByKey($key, $id);
        if ($orders) {
            $kt = 0;
            foreach ($orders as $order) {
                if ($order && $order['payment_status'] == ClaPayment::PAYMENT_STATUS_WAITING) {
                    $claPayment = new ClaPayment(['order' => $order]);
                    $claPayment->paySuccess();
                    $order = Order::findOne($order->id);
                    if ($order->type_payment == ClaPayment::TYPE_PAYMENT) {
                        echo "Sdsd";
                        die();
                        \Yii::$app->session->open();
                        if (isset($_SESSION['redirect_pay_success']) && $_SESSION['redirect_pay_success']) {
                            if ($_SESSION['redirect_pay_success'] == '/product/shoppingcart/checkout') {
                                unset($_SESSION['redirect_pay_success']);
                                $_SESSION['pay_success_responce'] = $order->id;
                                $url_success = Url::to(['/product/shoppingcart/checkout']);
                            }
                            return $this->redirect($url_success);
                            Yii::$app->end();
                        }
                        $coin = Gcacoin::getCoinToMoney((float)$order->order_total);
                        $string = 'Nap tiền thành công ' . formatMoney($coin) . ' V vào tài khoản';
                        \Yii::$app->getSession()->setFlash('success', $string);
                        $url_success = Url::to(['/management/gcacoin/recharge']);
                        return $this->redirect($url_success);
                        Yii::$app->end();
                    } else {
                        $kt = 1;
                        $url_success = Url::to(['/product/shoppingcart/success', 'id' => $order->id, 'key' => $order->key]);
                    }
                }
            }
            if ($kt) {
                return $this->redirect($url_success);
                Yii::$app->end();
            }
        }
        return $this->redirect(Url::home());
    }

    public function actionPaycancel()
    {
        $shoppingcart = new Shoppingcart();
        $shoppingcart->removeAll();
        return $this->redirect(Url::home());
    }

    /**
     * action de ben VNPay updte trạng thái thanh toán của đơn hàng
     */
    public function actionIpn()
    {
        $claPayment = new ClaPayment(['method' => ClaPayment::PAYMENT_METHOD_VNPay]);
        $vnPay = $claPayment->getPayment();
        $inputData = array();
        $returnData = array();
        $data = $_REQUEST;
        //
        foreach ($data as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }
        //
        $vnp_SecureHash = $inputData['vnp_SecureHash'];
        unset($inputData['vnp_SecureHashType']);
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . $key . "=" . $value;
            } else {
                $hashData = $hashData . $key . "=" . $value;
                $i = 1;
            }
        }
        //
        // $vnpTranId = $inputData['vnp_TransactionNo']; //Mã giao dịch tại VNPAY
        // $vnp_BankCode = $inputData['vnp_BankCode']; //Ngân hàng thanh toán
        $secureHash = md5($vnPay->configs->vnp_HashSecret . $hashData);
        $orderId = $inputData['vnp_TxnRef'];
        try {
            //Check Orderid
            //Kiểm tra checksum của dữ liệu
            if ($secureHash == $vnp_SecureHash) {
                //Lấy thông tin đơn hàng lưu trong Database và kiểm tra trạng thái của đơn hàng, mã đơn hàng là: $orderId
                //Việc kiểm tra trạng thái của đơn hàng giúp hệ thống không xử lý trùng lặp, xử lý nhiều lần một giao dịch
                //Giả sử: $order = mysqli_fetch_assoc($result);
                $order = Order::findOne($orderId);
                if (!$order) {
                    $order = NULL;
                }
                if ($order != NULL) {
                    $claPayment = new ClaPayment(['method' => ClaPayment::PAYMENT_METHOD_VNPay]);

                    $log = \common\components\payments\gates\vnpay\models\LogVnPay::getModel($orderId);
                    if ($_GET['vnp_ResponseCode'] == '00') {
                        if (!$log->correct) {
                            if ($log->status && $order->payment_status == ClaPayment::PAYMENT_STATUS_WAITING) {
                                $order->payment_status = ClaPayment::PAYMENT_STATUS_SUCCESS;
                                $order->save();
                            }
                            if ($order->type_payment == ClaPayment::TYPE_PAYMENT) {
                                Gcacoin::addCoinByVpn($order);
                            }
                            $log->correct = 1;
                            $log->save();
                            $returnData['RspCode'] = '00';
                            $returnData['Message'] = 'Confirm Success';
                        } else {
                            if ($log->status && $order->payment_status == ClaPayment::PAYMENT_STATUS_WAITING) {
                                $order->payment_status = ClaPayment::PAYMENT_STATUS_SUCCESS;
                                $order->save();
                            }
                            $returnData['RspCode'] = '02';
                            $returnData['Message'] = 'Order already confirmed';
                        }
                    } else {
                        if (!$log->correct && $log->status && $order->payment_status == ClaPayment::PAYMENT_STATUS_SUCCESS) {
                            $order->payment_status = ClaPayment::PAYMENT_STATUS_WAITING;
                            $order->save();
                        }
                        $returnData['RspCode'] = '0' . $_GET['vnp_ResponseCode'];
                        $returnData['Message'] = 'vnp_ResponseCode ' . $_GET['vnp_ResponseCode'];
                    }
                } else {
                    $returnData['RspCode'] = '01';
                    $returnData['Message'] = 'Order not found';
                }
            } else {
                $returnData['RspCode'] = '97';
                $returnData['Message'] = 'Invalid signature';
            }
        } catch (Exception $e) {
            $returnData['RspCode'] = '99';
            $returnData['Message'] = 'Unknow error';
        }
        echo json_encode($returnData);
        Yii::$app->end();
        exit(0);
    }

    public function actionCheckLog($order_id)
    {
        $log = \common\components\payments\gates\vnpay\models\LogVnPay::getModel($order_id);
        if ($log->correct) {
            echo '<script type="text/javascript"> $(document).ready(function () { location.reload(); }); </script>';
        }
        return;
    }

    public function actionAddAddressReceive()
    {
        if (\Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $address_id = \Yii::$app->request->get('address_id', 0);
            if ($address_id) {
                Yii::$app->db->createCommand()->update('user_address', ['isdefault' => ClaLid::STATUS_DEACTIVED], 'user_id=' . Yii::$app->user->id)->execute();
                $userAddress = \common\models\user\UserAddress::findOne($address_id);
                $userAddress->isdefault = ClaLid::STATUS_ACTIVED;
                $userAddress->save();
                return [
                    'message' => 'success'
                ];
            }
        }
    }

    public function actionAddCart($id, $quantity = 1, $ajax = 0, $var_id = 0)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        //
        $shoppingcart = new Shoppingcart();
        $model = Product::findOne($id);
        $price = $model->price * $quantity;
        if (isset($var_id) && $var_id) {
            $product_attr_varable = ProductVariables::getVarable(['id' => $var_id]);
            $price = $product_attr_varable['price'] * $quantity;
        }
        $data = [
            'id' => $model->id,
            'brand' => $model->brand,
            'name' => $model->name,
            'category_id' => $model->category_id,
            'code' => $model->code . $model->id,
            'price' => $price,
            'price_market' => $model->price_market,
            'avatar_path' => $model->avatar_path,
            'avatar_name' => $model->avatar_name,
            'avatar_id' => $model->avatar_id,
            'weight' => $model->weight,
            'height' => $model->height,
            'width' => $model->width,
            'length' => $model->length,
            'var_id' => $var_id,
        ];
        $shoppingcart->add($data, [
            'quantity' => $model->getQuatityOrder($quantity)
        ]);
        if ($ajax) {
            $products = $shoppingcart->cartstore;
            $quantity = count($products);
            $link = \yii\helpers\Url::to(['/product/shoppingcart/checkout']);
            $ordertotal = $shoppingcart->getOrderTotal();
            return $this->renderAjax('ajax', [
                'products' => $products,
                'quantity' => $quantity,
                'link' => $link,
                'ordertotal' => $ordertotal
            ]);
        }
        return $this->redirect(['index']);
        //
    }

    public function actionRemove($key)
    {
        $shoppingcart = new Shoppingcart();
        // $model = Video::findOne($id);
        $shoppingcart->remove($key);
        if (Yii::$app->request->isAjax) {
            return true;
        }
        return $this->redirect(['index']);
    }

    public function actionDeleteAll()
    {
        $shoppingcart = new Shoppingcart();
        $shoppingcart->removeAll();
        return $this->redirect(['/site/index']);
    }

    public function actionUpdate($id, $quantity = 1)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        //
        $shoppingcart = new Shoppingcart();
        $model = Product::findOne($id);
        // echo $quantity;; die();
        //
        $quantity = $model->getQuatityOrder($quantity);
        $price = $model->getPrice($quantity);
        $data = [
            'id' => $model->id,
            'brand' => $model->brand,
            'name' => $model->name,
            'category_id' => $model->category_id,
            'code' => $model->code . $model->id,
            'price' => $price,
            'price_market' => $model->price_market,
            'avatar_path' => $model->avatar_path,
            'avatar_name' => $model->avatar_name,
            'avatar_id' => $model->avatar_id,
            'order' => $price * $quantity,
            'quantity' => $quantity,
            'weight' => $model->weight,
            'height' => $model->height,
            'width' => $model->width,
            'length' => $model->length,
            // 'sale_buy_shop_coin' => $model->saleCoinBuyCoin($quantity),
            // 'sale_buy_shop_money' => $model->addCoinBuyMoney($quantity),
            // 'sale_before_shop' => $model->addCoinBeforeShop($quantity),
            // 'sale_before_product' => $model->addCoinBeforeProduct($quantity),
            // 'sale' => $model->moneySale($quantity),
            // 'user_before_product' => $model->userBeforeProduct(),
            // 'user_before_shop' => $model->userBeforeShop(),
        ];
        $shoppingcart->add($data, [
            'quantity' => $model->getQuatityOrder($quantity)
        ]);

        $data['ordertotal'] = $shoppingcart->getOrderTotal();

        return json_encode($data);
        //
    }
}
