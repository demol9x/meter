<?php

namespace api\modules\app\controllers;

class ShoppingController extends AppController
{
    function actionGetAddressShop()
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        if (isset($post['shop_id']) && $post['shop_id']) {
            $address = \common\models\shop\ShopAddress::getByShop($post['shop_id']);
            $resonse['data'] = $address ? $address : [];
            $resonse['message'] = "Lấy danh sách địa chỉ gian hàng thành công";
            $resonse['code'] = 1;
        } else {
            $resonse['error'] = "Không có shop_id.";
        }
        return $this->responseData($resonse);
    }

    function actionGetOptionPayments()
    {
        $resonse = $this->getResponse();
        $resonse['data'] = [
            '2' => 'Thành toán bằng tiền mặt khi nhận hàng (COD)',
            'MEMBERIN' => 'Đổi '.__NAME_SITE.' Voucher'
        ];
        $resonse['message'] = "Lấy danh sách hình thức thanh toán thành công";
        $resonse['code'] = 1;
        return $this->responseData($resonse);
    }

    function actionGetTranposts()
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        if (isset($post['product_id']) && $post['product_id']) {
            $transports = \common\models\transport\ProductTransport::getByProduct($post['product_id']);
            $resonse['data'] = $transports ? $transports : [];
            $resonse['message'] = "Lấy danh sách đơn vị giao hàng theo sản phẩm thành công.";
        } else if (isset($post['shop_id']) && $post['shop_id'] && isset($post['products']) && $post['products']) {
            $transports = \common\models\transport\ShopTransport::getByShopOrder($post['shop_id'], $post['products']);
            $resonse['data'] = $transports ? $transports : [];
            $resonse['message'] = "Lấy danh sách đơn vị giao hàng theo danh sách sản phẩm của một doanh nghiệp thành công.";
        } else {
            $transports = \common\models\transport\Transport::getAll();
            $resonse['data'] = $transports ? $transports : [];
            $resonse['message'] = "Lấy danh sách đơn vị giao hàng thành công.";
        }
        $resonse['code'] = 1;
        return $this->responseData($resonse);
    }

    function actionGetCostTranpostByProduct()
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        if ($post) {
            foreach ($post as $shop_id => $add) {
                if (isset($add['f_district']) && $add['f_district']) {
                    $cost = \frontend\components\Transport::getCostTransportApi($add);
                    $resonse['data'][$shop_id] = $cost;
                } else {
                    $resonse['error'] = "Lỗi dữ liệu.";
                    return $this->responseData($resonse);
                }
            }
            $resonse['message'] = "Lấy phí vận chuyển thành công.";
            $resonse['code'] = 1;
            return $this->responseData($resonse);
        }
        $resonse['error'] = "Lỗi dữ liệu.";
        return $this->responseData($resonse);
    }

    function actionCheckDiscountCode()
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        if (isset($post['products']) && $post['products'] && isset($post['discount_code']) && $post['discount_code'] && isset($post['shop_id']) && $post['shop_id'] && $codes = \common\models\product\DiscountCode::checkCodeOrder($post['shop_id'], $post['products'], $post['discount_code'])) {
            $resonse['data'] = $codes;
            $resonse['message'] = "Mã còn hiệu lực sử dụng";
            $resonse['code'] = 1;
        } else {
            $resonse['error'] = "Mã không có hiệu lực sử dụng.";
        }
        return $this->responseData($resonse);
    }

    function actionAddOrder()
    {
        $this->setTimeLoadOnce(5);
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        if (isset($post['Order']) && isset($post['Products']) && $post['Order'] && $post['Products']) {
            $listitems = [];
            $listorders = [];
            $model = new \common\models\order\Order();
            if (isset($post['Order']['user_address_id']) && isset($post['Order']['payment_method']) && $post['Order']['payment_method'] && $post['Order']['user_address_id'] > 0) {
                $model->user_address_id = $post['Order']['user_address_id'];
                $model->payment_method = $post['Order']['payment_method'];
                $model->payment_method_child = isset($post['Order']['payment_method_child']) ? $post['Order']['payment_method_child'] : '';
                $model->payment_status = \common\components\payments\ClaPayment::PAYMENT_STATUS_WAITING;
                $address = \common\models\user\UserAddress::findOne($model->user_address_id);
                if ($address) {
                    $model->user_id = $address['user_id'];
                    $model->email = $address['email'] ? trim($address['email']) :  '';
                    $model->name = $address['name_contact'];
                    $model->phone = $address['phone'];
                    $model->address = $address['address'] . '(' . $address['ward_name'] . ', ' . $address['district_name'] . ', ' . $address['province_name'] . ')';
                    $model->province_id = $address['province_id'];
                    $model->district_id = $address['district_id'];
                    $model->status = 1;
                } else {
                    $resonse['error'] = 'Lỗi không tìm được địa chỉ người mua.';
                    $resonse['data']['type'] = 2;
                    return $this->responseData($resonse);
                }
                if ($model->payment_method != \common\components\payments\ClaPayment::PAYMENT_METHOD_NR) {
                    $user = \frontend\models\User::findIdentity($model->user_id);
                    if (!(isset($post['Order']['otp']) && $post['Order']['otp'] && $user && $user->checkOtp($post['Order']['otp']))) {
                        $resonse['error'] = 'Lỗi mật khẩu cấp 2. Vui lòng kiểm tra lại.';
                        $resonse['data']['type'] = 2;
                        return $this->responseData($resonse);
                    }
                }
            } else {
                $resonse['error'] = 'Lỗi dữ liệu đơn hàng.';
                $resonse['data']['type'] = 1;
                $resonse['data']['errors'][] = 'Cần có user_address_id và payment_method';
                return $this->responseData($resonse);
            }
            $model->key = \common\components\ClaGenerate::getUniqueCode();
            foreach ($post['Products'] as $shop_id => $products) {
                $orderTotalShop = 0;
                if ($products) {
                    foreach ($products as $product) {
                        if (isset($product['id']) && isset($product['quantity']) && $product['id'] > 0 && $product['quantity'] > 0) {
                            $model_item = new \common\models\order\OrderItem();
                            $model_item->shop_id = $shop_id;
                            $model_item->product_id = $product['id'];
                            $model_item->quantity = $product['quantity'];
                            $model_item->status = 1;
                            $listitems[$shop_id][] = $model_item;
                            if (!$model_item->getAffiliate($model->user_id)) {
                                $resonse['error'] =  $model_item->_merrors;
                                $resonse['data']['type'] = 3;
                                $resonse['data']['shop_id'] = $shop_id;
                                return $this->responseData($resonse);
                            }
                            $orderTotalShop += $model_item['price'] * $model_item['quantity'];
                        } else {
                            $resonse['error'] = 'Lỗi thông tin sản phẩm';
                            $resonse['data']['type'] = 3;
                            $resonse['data']['shop_id'] = $shop_id;
                            return $this->responseData($resonse);
                        }
                    }
                    if ($orderTotalShop > 0) {
                        $order = new \common\models\order\Order();
                        $order->attributes = $model->attributes;
                        $order->shop_id = $shop_id;
                        $order->order_total = $orderTotalShop;
                        if ($order->checkCostAffilate($post['Products'])) {
                            if ($order->validate()) {
                                $listorders[] = $order;
                            } else {
                                $resonse['error'] = 'Lỗi dữ liệu lưu đơn hàng';
                                $resonse['data']['type'] = 1;
                                $resonse['data']['errors'] = $order->getErrors();
                                return $this->responseData($resonse);
                            }
                        } else {
                            $resonse['error'] = $order->_error_affiliate ? $order->_error_affiliate : 'Lỗi thanh toán affilate';
                            $resonse['data']['type'] = 1;
                            $resonse['data']['errors'] = [];
                            return $this->responseData($resonse);
                        }
                    } else {
                        $resonse['error'] = 'Lỗi giá trị đơn hàng bằng 0';
                        $resonse['data']['type'] = 3;
                        $resonse['data']['shop_id'] = $shop_id;
                        return $this->responseData($resonse);
                    }
                } else {
                    $resonse['error'] = 'Lỗi đơn hàng không có sản phẩm';
                    $resonse['data']['type'] = 3;
                    $resonse['data']['shop_id'] = $shop_id;
                    return $this->responseData($resonse);
                }
            }
            $listordersaved = [];
            $model->shipfee = 0;
            $model->order_total = 0;
            foreach ($listorders as $order) {
                $code = '';
                if (isset($post['Shop'][$order->shop_id])) {
                    $trantg = $post['Shop'][$order->shop_id];
                    $order->shop_adress_id = isset($trantg['shop_adress_id']) && $trantg['shop_adress_id'] ? $trantg['shop_adress_id'] : (($tg = \common\models\shop\ShopAddress::getDefautByShop($order->shop_id)) ? $tg->id : 0);
                    $order->transport_type = isset($trantg['transport_type']) && $trantg['transport_type'] ? $trantg['transport_type'] : 0;
                    $order->transport_id = 0;
                    $code = isset($trantg['discount_code']) && $trantg['discount_code'] ? $trantg['discount_code'] : 0;
                }
                $order->order_total_all = $order->order_total;
                if ($order->save()) {
                    $shop_id = $order->shop_id;
                    foreach ($listitems[$shop_id] as $model_item) {
                        $model_item->order_id = $order->id;
                        if ($model_item->save()) {
                            $notify = [];
                            $notify['title'] = \Yii::t('app', 'have_new_order');
                            $notify['description'] = \Yii::t('app', 'order_ms_0') . $model_item['name'] . \Yii::t('app', 'order_ms_1') . $product['quantity'];
                            $notify['link'] = \yii\helpers\Url::to(['/management/order/index']);
                            $notify['type'] = \common\models\notifications\Notifications::ORDER;
                            $notify['recipient_id'] = $shop_id;
                            \common\models\notifications\Notifications::pushMessage($notify);
                        }
                    }
                    $order->costAffiliate($listitems[$shop_id]);
                    $order->getFeeTransport();
                    $order->addDiscountCode($code);
                    $shop = \common\models\shop\Shop::findOne($shop_id);
                    if ($shop['email']) {
                        \common\models\mail\SendEmail::sendMail([
                            'email' => $shop['email'],
                            'title' => 'Đơn hàng mới tại '.__NAME_SITE,
                            'content' => $this->renderAjax('email_shop', [
                                'orderShop' => $order
                            ])
                        ]);
                    }
                    if ($address['email']) {
                        \common\models\mail\SendEmail::sendMail([
                            'email' => $address['email'],
                            'title' => 'Tạo đơn hàng thành công tại '.__NAME_SITE,
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
                            'title' => 'Tạo đơn hàng thành công tại '.__NAME_SITE,
                            'content' => $this->renderAjax('email_manager', [
                                'orderShop' => $order,
                                'address' => $address,
                                'shop' => $shop,
                                'items' => $listitems[$shop_id]
                            ])
                        ]);
                    }
                    $dataos = [
                        'order_id' => $order->id,
                        'type' => $order->transport_type,
                        'time' => time(),
                        'status' => 1,
                        'content' => \Yii::t('app', 'created_order'),
                    ];
                    \common\models\order\OrderShopHistory::saveData($dataos);
                    $model->shipfee += $order->shipfee;
                    $model->order_total += $order->order_total;
                    $listordersaved[] = $order->attributes;
                } else {
                    $resonse['error'] = 'Lỗi dữ liệu lưu đơn hàng';
                    $resonse['data']['type'] = 1;
                    $resonse['data']['errors'] = $order->getErrors();
                    return $this->responseData($resonse);
                }
            }
            // payment
            $model->id = time();
            $model->paymentAPI();
            $resonse['mesage'] = 'Tạo đơn hàng thành công.';
            $resonse['code'] = 1;
            $resonse['data']['order_sum'] = $model;
            $resonse['data']['order_items'] = $listordersaved;
            return $this->responseData($resonse);
        } else {
            $resonse['error'] = "Không có Order Hoặc Products.";
        }
        return $this->responseData($resonse);
    }
}
