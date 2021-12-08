<?php

namespace api\modules\app\controllers;

use common\components\ClaUrl;
use common\models\gcacoin\Gcacoin;
use common\models\gcacoin\GcaCoinHistory;

class CoinController extends LoginedController
{
    public function actionPaymentQr()
    {
        $this->setTimeLoadOnce(10);
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        if (isset($post['token']) && isset($post['otp']) && $post['token'] && $post['otp']) {
            if (!$this->user->checkOtp($post['otp'])) {
                $resonse['error'] = "Mật khẩu cấp 2 không hợp lệ";
                return $this->responseData($resonse);
            }
            $qr = \common\models\qrcode\PayQrcode::findOne(['token' => $post['token']]);
            if ($qr) {
                switch ($qr->type) {
                    case 'user':
                        if (isset($post['money']) && $post['money']) {
                            $json = json_decode($qr->data, true);
                            $data = [
                                'shop_id' => $json['user_id'],
                                'money' => $post['money'],
                            ];
                            return $this->responseData($this->sendCoinShop($data));
                        }
                        break;
                    case 'user_service':
                        if (isset($post['money']) && $post['money']) {
                            $json = json_decode($qr->data, true);
                            $data = [
                                'shop_id' => $json['user_id'],
                                'money' => $post['money'],
                            ];
                            return $this->responseData($this->sendCoinShopService($data));
                        }
                        break;
                    case 'order':
                        return $this->responseData($this->paymentOrder($qr));
                }
            }
        }
        $resonse['error'] = "Lỗi dữ liệu.";
        return $this->responseData($resonse);
    }

    public function sendCoinShop($post)
    {
        $resonse = $this->getResponse();
        if ($post['shop_id'] && $post['money'] > 0) {
            $money = $post['money'];
            $shop = \common\models\shop\Shop::findOne($post['shop_id']);
            if ($shop) {
                $u_coin = Gcacoin::getModel($this->user->id);
                $u_first_coin = $u_coin->getCoin();
                $coin = Gcacoin::getCoinToMoney($money);
                $siteif = \common\models\gcacoin\Config::getConfig();
                $coin_tr = $siteif->getCoinTransferFee($coin);
                $coin_fee =  $coin_tr - $coin;
                $money_tr = Gcacoin::getMoneyToCoin($coin_tr);
                if ($u_coin->addMoney(-$money_tr)) {
                    $s_coin = Gcacoin::getModel($post['shop_id']);
                    $s_first_coin = $s_coin->getCoin();
                    // $coin_rv = $shop->changeAffilliateService($coin);
                    $coin_rv = $coin;
                    if ($s_coin->addCoin($coin_rv) && $s_coin->save(false)) {
                        $history = new GcaCoinHistory();
                        $history->user_id = $u_coin->user_id;
                        $history->type = 'SEND_COIN_APPQR';
                        $history->data = 'Chuyển thành công ' . __VOUCHER . ' tới Doanh nghiệp:' . $shop->name;
                        $history->gca_coin = -$coin_tr;
                        $history->first_coin = $u_first_coin;
                        $history->last_coin = $u_coin->getCoin();
                        $history->save(false);
                        $resonse['data'] = ['coin' => $history->last_coin, 'coin_text' => formatCoin($history->last_coin) . ' ' . __VOUCHER];
                        if ($coin_fee > 0) {
                            $text = 'Nhận thành công ' . __VOUCHER . ' từ giao dịch chuyển tiền ID' . $history->id;
                            \common\models\gcacoin\Gcacoin::addCoinFeeTran($coin_fee, ['note' => $text, 'type' => 'TRANV_AFFILIATE']);
                        }
                        //
                        $history = new GcaCoinHistory();
                        $history->user_id = $s_coin->user_id;
                        $history->type = 'SEND_COIN_APPQR';
                        $history->data = 'Nhận thành công ' . __VOUCHER . ' từ khách hàng:' . $this->user->username;
                        $history->gca_coin = $coin_rv;
                        $history->first_coin = $s_first_coin;
                        $history->last_coin = $s_coin->getCoin();
                        $history->save(false);
                        //sen mail
                        $content =  'Số dư thay đổi <b style="color: green"> ' . formatCoin($history->gca_coin) . '</b> ' . __VOUCHER . '.  Số dư hiện tại: <b style="color: green">' . formatCoin($history->last_coin) . '</b>  ' . __VOUCHER;
                        if ($shop->email) {
                            \common\models\mail\SendEmail::sendMail([
                                'email' => $shop->email,
                                'title' => $history->data,
                                'content' => $content
                            ]);
                        }
                        $noti = new \common\models\notifications\Notifications();
                        $noti->title = $history->data;
                        $noti->description = $content;
                        $noti->link = \common\components\ClaUrl::to(['/management/gcacoin/index']);
                        $noti->type = 3;
                        $noti->recipient_id = $s_coin->user_id;
                        $noti->unread = \common\components\ClaLid::STATUS_ACTIVED;
                        $noti->save();
                        $resonse['code'] = 1;
                        $resonse['message'] = "Chuyển tiền thành công";
                        // $shop->affilliateService($coin);
                        return $resonse;
                    } else {
                        if ($u_coin->addMoney($money_tr)) {
                            $resonse['error'] = "Lỗi cộng tiền tài khoản nhận.";
                            return $resonse;
                        } else {
                            $history = new GcaCoinHistory();
                            $history->user_id = $u_coin->user_id;
                            $history->type = 'SEND_COIN_APPQR';
                            $history->data = 'Chuyển thành công ' . __VOUCHER . ' tới Doanh nghiệp:' . $shop->name;
                            $history->gca_coin = -$coin_tr;
                            $history->first_coin = $u_first_coin;
                            $history->last_coin = $u_coin->getCoin();
                            $history->save(false);
                            $resonse['error'] = "Lỗi cộng tiền tài khoản nhận. Và hoàn tiền. Hãy liện hệ BQT để được hoàn tiền";
                            return $resonse;
                        }
                    }
                } else {
                    $resonse['error'] = "Lỗi trừ tiền tài khoản chuyển.Vui lòng kiểm tra lại số dư tài khoản";
                    return $resonse;
                }
            } else {
                $resonse['error'] = "Lỗi không tìm được tài khoản nhận";
                return $resonse;
            }
        }
        $resonse['error'] = "Lỗi dữ liệu.";
        return $resonse;
    }

    public function sendCoinShopService($post)
    {
        $resonse = $this->getResponse();
        if ($post['shop_id'] && $post['money'] > 0) {
            $money = $post['money'];
            $shop = \common\models\shop\Shop::findOne($post['shop_id']);
            if ($shop) {
                $u_coin = Gcacoin::getModel($this->user->id);
                $u_first_coin = $u_coin->getCoin();
                $coin = Gcacoin::getCoinToMoney($money);
                $coin_tr = $shop->changeAffilliateServiceUser($coin);
                $money_tr = Gcacoin::getMoneyToCoin($coin_tr);
                if ($u_coin->addMoney(-$money_tr)) {
                    $s_coin = Gcacoin::getModel($post['shop_id']);
                    $s_first_coin = $s_coin->getCoinRed();
                    // $coin_rv = $shop->changeAffilliateService($coin);
                    $coin_rv = $coin;
                    if ($s_coin->addCoinRed($coin_rv) && $s_coin->save(false)) {
                        $history = new GcaCoinHistory();
                        $history->user_id = $u_coin->user_id;
                        $history->type = 'SEND_COIN_APPQR';
                        $history->data = 'Thanh toán QR dịch vụ doanh nghiệp:' . $shop->name . ' thành công.';
                        $history->gca_coin = -$coin_tr;
                        $history->first_coin = $u_first_coin;
                        $history->last_coin = $u_coin->getCoin();
                        $history->save(false);
                        $resonse['data'] = ['coin' => $history->last_coin, 'coin_text' => formatCoin($history->last_coin) . ' ' . __VOUCHER];
                        //
                        $history = new GcaCoinHistory();
                        $history->user_id = $s_coin->user_id;
                        $history->type = 'SEND_COIN_APPQR';
                        $history->data = 'Nhận thành công ' . __VOUCHER . ' từ khách hàng:' . $this->user->username;
                        $history->gca_coin = $coin_rv;
                        $history->first_coin = $s_first_coin;
                        $history->type_coin = GcaCoinHistory::TYPE_V_RED;
                        $history->last_coin = $s_coin->getCoinRed();
                        $history->save(false);
                        //sen mail
                        $content =  'Số dư thay đổi <b style="color: green"> ' . formatCoin($history->gca_coin) . '</b> ' . __VOUCHER . '.  Số dư hiện tại: <b style="color: green">' . formatCoin($history->last_coin) . '</b>  ' . __VOUCHER;
                        if ($shop->email) {
                            \common\models\mail\SendEmail::sendMail([
                                'email' => $shop->email,
                                'title' => $history->data,
                                'content' => $content
                            ]);
                        }
                        $noti = new \common\models\notifications\Notifications();
                        $noti->title = $history->data;
                        $noti->description = $content;
                        $noti->link = \common\components\ClaUrl::to(['/management/gcacoin/index']);
                        $noti->type = 3;
                        $noti->recipient_id = $s_coin->user_id;
                        $noti->unread = \common\components\ClaLid::STATUS_ACTIVED;
                        $noti->save();
                        $resonse['code'] = 1;
                        $resonse['message'] = "Thanh toán QR dịch vụ thành công";
                        $shop->affilliateService($coin, $this->user);
                        return $resonse;
                    } else {
                        if ($u_coin->addMoney($money_tr)) {
                            $resonse['error'] = "Lỗi cộng tiền tài khoản nhận.";
                            return $resonse;
                        } else {
                            $history = new GcaCoinHistory();
                            $history->user_id = $u_coin->user_id;
                            $history->type = 'SEND_COIN_APPQR';
                            $history->data = 'Thanh toán QR dịch vụ thành công ' . __VOUCHER . ' tới Doanh nghiệp:' . $shop->name;
                            $history->gca_coin = -$coin_tr;
                            $history->first_coin = $u_first_coin;
                            $history->last_coin = $u_coin->getCoin();
                            $history->save(false);
                            $resonse['error'] = date('d-m: H:i', time()) . ": Lỗi cộng tiền tài khoản nhận và hoàn tiền. Vui lòng chụp dư ảnh và liện hệ BQT để được hoàn tiền.";
                            return $resonse;
                        }
                    }
                } else {
                    $resonse['error'] = "Lỗi trừ tiền tài khoản nhận. Vui lòng kiểm tra lại số dư tài khoản";
                    return $resonse;
                }
            } else {
                $resonse['error'] = "Lỗi không tìm được tài khoản nhận";
                return $resonse;
            }
        }
        $resonse['error'] = "Lỗi dữ liệu.";
        return $resonse;
    }

    public function paymentOrder($qr)
    {
        $resonse = $this->getResponse();
        $post = json_decode($qr->data, true);
        if (isset($post['order_id']) && $post['order_id']) {
            $orders = \common\models\order\Order::getOrderByKey($post['order_id']);
            if ($orders) {
                $money = 0;
                foreach ($orders as $order) {
                    if ($order->payment_status != \common\components\payments\ClaPayment::PAYMENT_STATUS_SUCCESS) {
                        $money += $order->order_total;
                    }
                }
                if ($qr->price != $money) {
                    $resonse['error'] = "Lỗi thanh toán bằng mã QR. Quý khách vui lòng thanh toán bằng hình thức khác.";
                    return $resonse;
                }
                $u_coin = Gcacoin::getModel($this->user->id);
                $coin = Gcacoin::getCoinToMoney($money);
                if ($u_coin->addCoin(-$coin)) {
                    $kt = [];
                    foreach ($orders as $order) {
                        $user_old = $order->user_id;
                        $order->user_id = $this->user->id;
                        if ($order->paymentV()) {
                            $order->payment_status = \common\components\payments\ClaPayment::PAYMENT_STATUS_SUCCESS;
                            $order->user_id = $user_old;
                            $order->save(false);
                            $kt[] = $order->getOrderLabelId();
                            $resonse['data']['success'][] = $order;
                        } else {
                            $resonse['data']['error'][] = $order;
                        }
                    }
                    if ($kt) {
                        $kt = implode(', ', $kt);
                        $resonse['message'] = "Thanh toán thành công đơn hàng: " . $kt;
                        $resonse['code'] = 1;
                        return $resonse;
                    } else {
                        $resonse['error'] = "Có lỗi xảy ra trong quá trình thanh toán. Quý khách vui lòng kiểm tra lại thông tin số dư.";
                        return $resonse;
                    }
                } else {
                    $resonse['error'] = "Tài khoản không đủ số dư để thanh toán mã này";
                    return $resonse;
                }
            } else {
                $resonse['error'] = "Lỗi không tìm được đơn hàng cần thanh toán.";
                return $resonse;
            }
        }
        $resonse['error'] = "Lỗi dữ liệu.";
        return $resonse;
    }

    public function actionGetInfoVoucher()
    {
        $resonse = $this->getResponse();
        $coin = Gcacoin::getModel($this->user->id);
        $data['coin'] = $coin->getCoin();
        $data['text_coin'] = formatCoin($data['coin']) . ' ' . __VOUCHER;
        $data['coin_sale'] = $coin->getCoinSale();
        $data['text_coin_sale'] = formatCoin($data['coin_sale']) . ' ' . __VOUCHER_SALE;
        $data['coin_red'] = $coin->getCoinRed();
        $data['coin_red_lock'] = $coin->getCoinRedLock();
        $data['text_coin_red'] = formatCoin($data['coin_red']) . ' ' . __VOUCHER_RED;
        $data['text_coin_red_lock'] = formatCoin($data['coin_red_lock']) . ' ' . __VOUCHER_RED;
        $data['coin_red_waiting'] = \common\models\gcacoin\CoinConfinement::getCoinConfinement($this->user->id);
        $data['text_coin_red_waiting'] = formatCoin($data['coin_red_waiting']) . ' ' . __VOUCHER_RED;
        $resonse['code'] = 1;
        $resonse['data'] = $data;
        $resonse['message'] = "Lấy thông tin thành công.";
        return $this->responseData($resonse);
    }

    public function actionAddVoucher()
    {
        $this->setTimeLoadOnce(10);
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        if (isset($post['Order']['payment_method']) && in_array($post['Order']['payment_method'],  array_keys(\common\components\payments\ClaPayment::optionOrderPayment()))) {
            $post = $this->getDataPost()['Order'];
            $user_id = $this->user->id;
            $user = $this->user;
            $errors = [];
            if ($post['payment_method'] == \common\components\payments\ClaPayment::PAYMENT_METHOD_CK) {
                if (isset($_FILES['image1'])) {
                    $data = $this->uploadImage('image1');
                    if ($data['code'] == 1) {
                        $post['path1'] = $data['data']['path'];
                        $post['name1'] = $data['data']['name'];
                    } else {
                        $resonse['data']['image1'][] = 'Ảnh giao dịch chuyển khoản không được bỏ trống.';
                        $resonse['error'] = 'Lỗi dữ liệu.';
                        return $this->responseData($resonse);
                    }
                } else {
                    $resonse['data']['image1'][] = 'Ảnh giao dịch chuyển khoản không được bỏ trống.';
                    $resonse['error'] = 'Lỗi dữ liệu.';
                    return $this->responseData($resonse);
                }
                if (isset($_FILES['image2'])) {
                    $data = $this->uploadImage('image2');
                    if ($data['code'] == 1) {
                        $post['path2'] = $data['data']['path'];
                        $post['name2'] = $data['data']['name'];
                    } else {
                        $resonse['data']['image1'][] = 'Ảnh tin nhắn thông báo chuyển khoản thành công không được bỏ trống.';
                        $resonse['error'] = 'Lỗi dữ liệu.';
                        return $this->responseData($resonse);
                    }
                } else {
                    $resonse['data']['image1'][] = 'Ảnh tin nhắn thông báo chuyển khoản thành công không được bỏ trống.';
                    $resonse['error'] = 'Lỗi dữ liệu.';
                    return $this->responseData($resonse);
                }
                $checks = ['money', 'path1', 'path2', 'name1', 'name2'];
            } else {
                $checks = ['money'];
            }
            foreach ($checks as $key) {
                if (!(isset($post[$key]) && $post[$key])) {
                    $errors[$key][] = $key . ' không được bỏ trống';
                }
            }
            if ($errors) {
                $resonse['data'] = $errors;
                $resonse['error'] = 'Lỗi dữ liệu.';
                return $this->responseData($resonse);
            }
            $order = new \common\models\order\Order();
            $order->payment_method = $post['payment_method'];
            $order->payment_method_child = isset($post['payment_method_child']) ? $post['payment_method_child'] : 'CHUYENKHOAN';
            $order->order_total = $post['money'];
            $order->user_id = $user_id;
            $order->email = $user->email;
            $order->name = $user->username;
            $order->phone = $user->phone;
            $order->address = 'Thêm Voucher';
            $order->key = strtoupper(md5(time()));
            $order->type_payment = \common\components\payments\ClaPayment::TYPE_PAYMENT;
            $sale = \common\models\SaleV::getNow();
            if ($sale) {
                $order->to_sale = 1;
                $order->percent_sale = $sale->percent;
                $order->address = 'Thêm Voucher khuyễn mãi';
            } else {
                $order->address = 'Thêm Voucher';
            }
            if ($order->save()) {
                if ($post['payment_method'] == \common\components\payments\ClaPayment::PAYMENT_METHOD_CK) {
                    $wdimg = new \common\models\order\OrderImages();
                    $wdimg->order_id = $order->id;
                    $wdimg->name = $post['name1'];
                    $wdimg->path = $post['path1'];
                    $wdimg->save();
                    $wdimg = new \common\models\order\OrderImages();
                    $wdimg->order_id = $order->id;
                    $wdimg->name = $post['name2'];
                    $wdimg->path = $post['path2'];
                    $wdimg->save();
                }
                $resonse['data'] = $order;
                $resonse['message'] = "Lưu thông tin thành công.";
                $resonse['code'] = 1;
                return $this->responseData($resonse);
            }
            $resonse['data'] = $order->getErrors();
            $resonse['error'] = "Lỗi lưu.";
            return $this->responseData($resonse);
        }
        $resonse['error'] = 'Lỗi dữ liệu';
        return $this->responseData($resonse);
    }

    public function actionGetListCoinWaiting()
    {
        $resonse = $this->getResponse();
        $data = [];
        $tg = \common\models\gcacoin\CoinConfinement::getUseByShop($this->user->id);
        if ($tg) foreach ($tg as $item) {
            $item['created_at'] = date('d-m-Y H:i:s', $item['created_at']);
            $item['text_coin'] = formatCoin($item['coin']) . ' ' .  __VOUCHER_RED;
            $time = $item['hour'];
            if ($item['order_status'] != 4) {
                $time = $time / (60 * 60);
                $item['waiting_time_text'] =  'Hơn ' . (($time / 24 > 1) ? CEIL($time / 24) . ' ngày' : CEIL($time ? $time : 1) . ' giờ');
            } else {
                $time = ($item['order_updated_at'] + $time) - time();
                $time = $time > 0 ? $time / (60 * 60) : 0;
                if ($time) {
                    $item['waiting_time_text'] =  'Gần ' . (($time / 24 > 1) ? CEIL($time / 24) . ' ngày' : CEIL($time) . ' giờ');
                } else {
                    $item['waiting_time_text'] = 'Gần 5 phút';
                }
            }
            $data[] = $item;
        }
        $resonse['data'] = $data;
        $resonse['message'] = 'Lấy danh sách tạm giữ thành công.';
        $resonse['code'] = 1;
        return $this->responseData($resonse);
    }

    public function actionGetVoucherHistory()
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        $post['attr'] = $post;
        $post['attr']['status'] = 1;
        if (isset($post['count']) && $post['count']) {
            $resonse['data']['total'] = (new \common\models\gcacoin\GcaCoinHistory())->getByAttr($post);
            $resonse['message'] = 'Lấy số lượng lịch sử coin thành công.';
            $resonse['code'] = 1;
            return $this->responseData($resonse);
        }
        $data = [];
        $model = new \common\models\gcacoin\GcaCoinHistory();
        $tg = $model->getByAttr($post);
        if ($tg) foreach ($tg as $item) {
            $model->setAttributeShow($item);
            $item['text_gca_coin'] = $model->getTextCoin($item['gca_coin']);
            $item['text_first_coin'] = $model->getTextCoin($item['first_coin']);
            $item['text_last_coin'] = $model->getTextCoin($item['last_coin']);
            $data[] = $item;
        }
        $resonse['data'] = $data;
        $resonse['message'] = 'Lấy lịch sử coin thành công.';
        $resonse['code'] = 1;
        return $this->responseData($resonse);
    }

    public function actionVoucherConvert()
    {
        $this->setTimeLoadOnce(10);
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        if (isset($post['bank_id']) && isset($post['otp']) && isset($post['coin']) && $post['bank_id'] && $post['otp'] && $post['coin']) {
            if (!$this->user->checkOtp($post['otp'])) {
                $resonse['error'] = "Mật khẩu cấp 2 không hợp lệ";
                return $this->responseData($resonse);
            }
            $model = new \common\models\gcacoin\WithDraw();
            $gcoin = Gcacoin::getModel($this->user->id);
            $coin = $post['coin'];
            if ($gcoin->addCoinRed(-$coin)) {
                $model->user_id = $this->user->id;
                $model->value = $coin;
                $model->bank_id = $post['bank_id'];
                if ($model->save(false)) {
                    $resonse['data'] = $model;
                    $resonse['success'] = "Tạo yêu cầu thành công.";
                    $resonse['code'] = 1;
                    return $this->responseData($resonse);
                } else {
                    $resonse['data'] = $model->errors;
                    $resonse['error'] = "Lưu lỗi.";
                    return $this->responseData($resonse);
                }
            } else {
                $resonse['data'] = $model->errors;
                $resonse['error'] = "Số dư tài khoản không đủ. Vui lòng kiểm tra lại.";
                return $this->responseData($resonse);
            }
        }
        $resonse['error'] = "Lỗi dữ liệu.";
        return $this->responseData($resonse);
    }

    public function actionGetHistoryConvert()
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        $post['attr'] = $post;
        $model = new \common\models\gcacoin\WithDraw();
        if (isset($post['count']) && $post['count']) {
            $resonse['data']['total'] = $model->getByAttr($post);
            $resonse['message'] = 'Lấy số lần rút tiền thành công.';
            $resonse['code'] = 1;
            return $this->responseData($resonse);
        }
        $data = [];
        $tg = $model->getByAttr($post);
        if ($tg) foreach ($tg as $item) {
            $item['text_value'] = $item['value'] . ' ' . __VOUCHER_RED;
            $data[] = $item;
        }
        $resonse['data'] = $data;
        $resonse['message'] = 'Lấy danh sách lịch sử rút tiền thành công.';
        $resonse['code'] = 1;
        return $this->responseData($resonse);
    }

    public function actionCancerConvert()
    {
        $this->setTimeLoadOnce(10);
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        if (isset($post['id']) && isset($post['otp']) && $post['id'] && $post['otp']) {
            if (!$this->user->checkOtp($post['otp'])) {
                $resonse['error'] = "Mật khẩu cấp 2 không hợp lệ";
                return $this->responseData($resonse);
            }
            $model = \common\models\gcacoin\WithDraw::find()->where(['id' => $post, 'status' => 0, 'user_id' => $this->user->id])->one();
            if ($model && $model->delete()) {
                $resonse['data'] = $model;
                $resonse['success'] = "Hủy yêu cầu rút tiền thành công.";
                $resonse['code'] = 1;
                return $this->responseData($resonse);
            } else {
                $resonse['error'] = "Không tìm thấy yêu cầu rút tiền có thể hủy.";
                return $this->responseData($resonse);
            }
        }
        $resonse['error'] = "Lỗi dữ liệu.";
        return $this->responseData($resonse);
    }

    public function actionGetUser()
    {
        $this->setTimeLoadOnce(10);
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        if (isset($post['keyword']) && $post['keyword']) {
            $keyword = $post['keyword'];
            if (is_numeric($keyword)) {
                $user = \frontend\models\User::findOne($keyword);
                if ($user) {
                    $shop = \common\models\shop\Shop::findOne($user->id);
                }
            } else {
                $user = \frontend\models\User::find()->where(['username' => $keyword])->orWhere(['email' => $keyword])->one();
                if (!$user) {
                    $shop = \common\models\shop\Shop::find()->where(['name' => $keyword])->one();
                    if ($shop) {
                        $user = \frontend\models\User::findOne($shop->id);
                    }
                } else {
                    $shop = \common\models\shop\Shop::findOne($user->id);
                }
            }
            if ($user) {
                $resonse['message'] = "Lấy thông tin thành công.";
                $data['id'] = $user->id;
                $data['user_name'] = $user->username;
                $data['email'] = $user->email;
                $data['shop_name'] = $shop ? $shop->name : '';
                $resonse['data'] = $data;
                $resonse['code'] = 1;
                return $this->responseData($resonse);
            }
            $resonse['error'] = "Không tìm thấy tài khoản nhận.";
            return $this->responseData($resonse);
        }
        $resonse['error'] = "Lỗi dữ liệu.";
        return $this->responseData($resonse);
    }

    public function actionVoucherTransfer()
    {
        $this->setTimeLoadOnce(10);
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        if (isset($post['otp']) && $post['otp'] && isset($post['user_recive_id']) && isset($post['coin']) && $post['user_recive_id'] && $post['coin'] > 0) {
            if (!$this->user->checkOtp($post['otp'])) {
                $resonse['error'] = "Mật khẩu cấp 2 không hợp lệ";
                return $this->responseData($resonse);
            }
            $coin = $post['coin'];
            $shop = \frontend\models\User::findOne($post['user_recive_id']);
            if ($shop) {
                if ($this->user->transferV($post['user_recive_id'], $coin)) {
                    $resonse['code'] = 1;
                    $resonse['message'] = "Chuyển tiền thành công";
                    $last_coin = Gcacoin::getModel($this->user->id)->getCoin();
                    $resonse['data'] = ['coin' => $last_coin, 'coin_text' => formatCoin($last_coin) . ' ' . __VOUCHER];
                    return $this->responseData($resonse);
                } else {
                    $resonse['error'] = $this->user->_error_opt;
                    return $this->responseData($resonse);
                }
            } else {
                $resonse['error'] = "Lỗi không tìm được tài khoản nhận";
                return $this->responseData($resonse);
            }
        }
        $resonse['error'] = "Lỗi dữ liệu.";
        return $this->responseData($resonse);
    }

    public function actionVoucherTransfervrtov()
    {
        $this->setTimeLoadOnce(10);
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        if (isset($post['otp']) && $post['otp'] && isset($post['coin']) && $post['coin'] > 0) {
            if (!$this->user->checkOtp($post['otp'])) {
                $resonse['error'] = "Mật khẩu cấp 2 không hợp lệ";
                return $this->responseData($resonse);
            }
            $coin = $post['coin'];
            if ($this->user->transferVr($coin)) {
                $resonse['code'] = 1;
                $resonse['message'] = 'Chuyển tiền ' . __VOUCHER_RED . ' thành ' . __VOUCHER . ' thành công.';
                $last_coin = Gcacoin::getModel($this->user->id)->getCoin();
                $resonse['data'] = ['coin' => $last_coin, 'coin_text' => formatCoin($last_coin) . ' ' . __VOUCHER];
                return $this->responseData($resonse);
            } else {
                $resonse['error'] = $this->user->_error_opt;
                return $this->responseData($resonse);
            }
        }
        $resonse['error'] = "Lỗi dữ liệu.";
        return $this->responseData($resonse);
    }

    public function actionAddAffilliateApp()
    {
        $this->setTimeLoadOnce(10);
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        $coin = $this->user->addAffilliateApp();
        if ($coin !== false) {
            $resonse['code'] = 1;
            $resonse['message'] = $coin > 0 ? 'Quý khác được tặng ' . $coin . ' ' . __VOUCHER . ' cho lần đăng nhập App '.__NAME_SITE.' lần đầu tiên.' : 'Chào mừng ' . $this->user->username . ' đã đăng nhập App '.__NAME_SITE.'.';
            $resonse['data'] = [];
            return $this->responseData($resonse);
        } else {
            $resonse['error'] = $this->user->_error_opt;
            return $this->responseData($resonse);
        }
        $resonse['error'] = "Lỗi dữ liệu.";
        return $this->responseData($resonse);
    }
}
