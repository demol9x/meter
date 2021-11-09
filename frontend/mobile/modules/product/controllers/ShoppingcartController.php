<?php

namespace frontend\mobile\modules\product\controllers;

use common\models\gcacoin\Gcacoin;
use frontend\controllers\CController;
use Yii;
use frontend\components\Shoppingcart;
use yii\web\Response;
use common\models\order\Order;
use common\models\order\OrderItem;
use common\models\order\OrderShop;
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
                    $return['data']['discount'] = $total* $model->value / 100;
                }
                $return['message'] = '<span class="success">Mã còn hiệu lực sử dụng giảm: '.formatMoney($return['data']['discount']).' '.Yii::t('app', 'currency').'</span>';
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
            Yii::t('app', 'thanh_toan') => Url::current(),
        ];
        $shoppingcart = new Shoppingcart();
        $data = $shoppingcart->cartstore;
        if (!$data) {
            $this->redirect(['index']);
        }
        $dataProcess = [];
        if ($data) {
            foreach ($data as $item) {
                $dataProcess[$item['shop_id']][] = $item;
            }
        }
        $ordertotal = $shoppingcart->getOrderTotal();
        $model = new Order();
        $address = \common\models\user\UserAddress::getDefaultAddress();
        $user = (Yii::$app->user->id) ? User::findOne(Yii::$app->user->id) : new User();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->payment_method == ClaPayment::PAYMENT_METHOD_MEMBERIN) {
                Yii::$app->session->open();
                if (isset($_SESSION['oke_otp_order']) && time() - $_SESSION['oke_otp_order'] < 30) {
                    $_SESSION['oke_otp_order'] = 0;
                } else {
                    Yii::$app->session->setFlash('error', 'Xác nhận mật khẩu cấp 2 không hợp lệ.');
                    return $this->redirect(['checkout']);
                }
            }
            $model->key = \common\components\ClaGenerate::getUniqueCode();
            $model->order_total = $ordertotal;
            $model->user_id = (Yii::$app->user->id) ? Yii::$app->user->id : 0;
            $model->email = (isset($address['email']) && $address['email']) ? trim($address['email']) : (isset(Yii::$app->user->identity->email) ? Yii::$app->user->identity->email : '');
            $model->name = $address['name_contact'];
            $model->phone = $address['phone'];
            $model->address = $address['address'] . ', ' . Ward::getNamebyId($address['ward_id']) . ', ' . District::getNamebyId($address['district_id']) . ', ' . Province::getNamebyId($address['province_id']);
            $model->province_id = $address['province_id'];
            $model->district_id = $address['district_id'];
            $model->user_address_id = $address['id'];
            $model->status = 1;
            $ship_total = 0;
            if ($model->checkCostAffilate($dataProcess)) {
                if ($model->validate()) {
                    foreach ($dataProcess as $shop_id => $items) {
                        $orderTotalShop = 0;
                        foreach ($items as $item) {
                            $orderTotalShop += $item['price'] * $item['quantity'];
                        }
                        $order = new Order();
                        $order->attributes = $model->attributes;
                        $order->payment_status = 1;
                        $shop = \common\models\shop\Shop::findOne($shop_id);
                        $order->shop_id = $shop_id;
                        $order->getShopAddressSlected();
                        $order->order_total = $order->order_total_all = $orderTotalShop;
                        //van chuyen
                        $tran = new Transport();
                        $order->transport_type = isset($tran->transports[$shop_id]['method']) ? $tran->transports[$shop_id]['method'] : 0;
                        $order->shipfee = 0;
                        $order->transport_id = 0;
                        //van chuyen
                        if ($order->save()) {
                            //them item
                            $list = [];
                            foreach ($items as $product) {
                                $model_item = new OrderItem();
                                $model_item->order_id = $order->id;
                                $model_item->shop_id = $product['shop_id'];
                                $model_item->product_id = $product['id'];
                                $model_item->code = $product['code'];
                                $model_item->price = $product['price'] ? $product['price'] : 0;
                                $model_item->quantity = $product['quantity'];
                                $model_item->status = 1;
                                $model_item->name = $product['name'];
                                $model_item->avatar_path = $product['avatar_path'];
                                $model_item->avatar_name = $product['avatar_name'];
                                $model_item->weight = $product['weight'];
                                $model_item->height = $product['height'];
                                $model_item->width = $product['width'];
                                $model_item->length = $product['length'];
                                $model_item->getAffiliate();
                                if ($model_item->save()) {
                                    $notify = [];
                                    $notify['title'] = Yii::t('app', 'have_new_order');
                                    $notify['description'] = Yii::t('app', 'order_ms_0') . $product['name'] . Yii::t('app', 'order_ms_1') . $product['quantity'];
                                    $notify['link'] = Url::to(['/management/order/index']);
                                    $notify['type'] = Notifications::ORDER;
                                    $notify['recipient_id'] = $product['shop_id'];
                                    Notifications::pushMessage($notify);
                                    $list[] = $model_item;
                                }
                            }
                            $shop = Shop::findOne($product['shop_id']);
                            $order->costAffiliate($list);
                            $order->addDiscountCode(isset($_POST['discount_code'][$product['shop_id']]) ? $_POST['discount_code'][$product['shop_id']] : '');
                            $order->getFeeTransport();
                            if ($shop['email']) {
                                \common\models\mail\SendEmail::sendMail([
                                    'email' => $shop['email'],
                                    'title' => 'Đơn hàng mới tại OCOP',
                                    'content' => $this->renderAjax('email_shop', [
                                        'orderShop' => $order
                                    ])
                                ]);
                            }
                            if ($address['email']) {
                                \common\models\mail\SendEmail::sendMail([
                                    'email' => $address['email'],
                                    'title' => 'Tạo đơn hàng thành công tại OCOP',
                                    'content' => $this->renderAjax('email_user', [
                                        'orderShop' => $order
                                    ])
                                ]);
                            }
                            $siteinfo = \common\components\ClaLid::getSiteinfo();
                            $email_manager = $siteinfo->email_rif;
                            if ($email_manager) {
                                \common\models\mail\SendEmail::sendMail([
                                    'email' => $email_manager,
                                    'title' => 'Tạo đơn hàng thành công tại OCOP',
                                    'content' => $this->renderAjax('email_manager', [
                                        'orderShop' => $order,
                                        'address' => $address,
                                        'shop' => $shop,
                                        'items' => $items
                                    ])
                                ]);
                            }
                            $dataos = [
                                'order_id' => $order->id,
                                'type' => $order->transport_type,
                                'time' => time(),
                                'status' => 1,
                                'content' => Yii::t('app', 'created_order'),
                            ];
                            \common\models\order\OrderShopHistory::saveData($dataos);
                            $tran->remove($shop_id);
                            $ship_total += $order->shipfee;
                        }
                    }
                    $shoppingcart->removeAll();
                    if ($ship_total) {
                        $model->shipfee = $ship_total > 0 ? $ship_total : 0;
                        $model->order_total += $ship_total;
                        $model->save();
                    }
                    // payment
                    $model->id = time();
                    $claPayment = new ClaPayment(['order' => $model]);
                    $claPayment->pay();
                    $url_success = Url::to(['/product/shoppingcart/success', 'id' => $model->id, 'key' => $model->key]);
                    $this->redirect($url_success);
                }
            } else {
                Yii::$app->session->setFlash('error', $model->getErrorAffiliate());
            }
        }
        $data_change = [];
        foreach ($dataProcess as $shop_id => $items) {
            foreach ($items as $product) {
                $model_item = new OrderItem();
                $model_item->order_id = $model->id;
                $model_item->order_shop_id = 0;
                $model_item->shop_id = $product['shop_id'];
                $model_item->product_id = $product['id'];
                $model_item->code = $product['code'];
                $model_item->price = $product['price'] ? $product['price'] : 0;
                $model_item->quantity = $product['quantity'];
                $model_item->name = $product['name'];
                $model_item->avatar_path = $product['avatar_path'];
                $model_item->avatar_name = $product['avatar_name'];
                $model_item->weight = $product['weight'];
                $model_item->height = $product['height'];
                $model_item->width = $product['width'];
                $model_item->length = $product['length'];
                $model_item->getAffiliate();
                $data_change[$shop_id][] = $model_item;
            }
        }
        $dataProcess = $data_change;
        //
        return $this->render('checkout', [
            'model' => $model,
            'data' => $data,
            'dataProcess' => $dataProcess,
            'ordertotal' => $ordertotal,
            'user' => $user,
            'address' => $address
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
        if ($data) {
            foreach ($data as $item) {
                $dataProcess[$item['shop_id']][] = $item;
            }
        }
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

    public function actionSuccess($id, $key)
    {
        $shoppingcart = new Shoppingcart();
        // $data = $shoppingcart->cartstore;
        $shoppingcart->removeAll();
        return $this->render('success');
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

    public function actionAddCart($id, $quantity = 1, $ajax = 0)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        //
        $shoppingcart = new Shoppingcart();
        $model = Product::findOne($id);
        if (!$model->canBuyFor(Yii::$app->user->id)) {
            if ($ajax) {
                $products = $shoppingcart->cartstore;
                $quantity = count($products);
                $link = \yii\helpers\Url::to(['/product/shoppingcart/index']);
                $ordertotal = $shoppingcart->getOrderTotal();
                return $this->renderAjax('ajax', [
                    'products' => $products,
                    'quantity' => $quantity,
                    'link' => $link,
                    'ordertotal' => $ordertotal,
                    'message' => 'Sản phẩm không thể thêm vào giỏ hàng'
                ]);
            }
            Yii::$app->session->setFlash('error', 'Bạn không được phép mua sản phẩm này. Vui lòng chọn sản phẩm khác.');
            return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
        }
        // echo $quantity;; die();
        //
        $data = [
            'id' => $model->id,
            'brand' => $model->brand,
            'name' => $model->name,
            'category_id' => $model->category_id,
            'code' => $model->code . $model->id,
            'price' => $model->getPrice($quantity),
            'price_market' => $model->price_market,
            'avatar_path' => $model->avatar_path,
            'avatar_name' => $model->avatar_name,
            'avatar_id' => $model->avatar_id,
            'shop_id' => $model->shop_id,
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
        if ($ajax) {
            $products = $shoppingcart->cartstore;
            $quantity = count($products);
            $link = \yii\helpers\Url::to(['/product/shoppingcart/index']);
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
            'shop_id' => $model->shop_id,
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
