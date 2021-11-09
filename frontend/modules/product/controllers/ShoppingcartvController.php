<?php

namespace frontend\modules\product\controllers;

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
use yii\web\NotFoundHttpException;
use common\models\shop\Shop;
use common\components\payments\ClaPayment;
use common\models\Province;
use common\models\District;
use common\models\Ward;
use frontend\components\Transport;
use common\models\notifications\Notifications;

class ShoppingcartvController extends CController
{
    public function getProduct($id)
    {
        Yii::$app->session->open();
        $id = $id ? $id : (isset($_SESSION['product_sale_id']) ? $_SESSION['product_sale_id'] : null);
        if ($id) {
            $product = \common\models\product\Product::findActive($id);
            $_SESSION['product_sale_id'] = $id;
            return $product->inCatSale() ? $product : [];
        }
        return [];
    }

    public function actionIndex($id = null, $quantity = 1)
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
        Yii::$app->session->open();
        $product = $this->getProduct($id);
        if (!$product) {
            return $this->goHome();
        }
        $user = User::findOne(Yii::$app->user->getId());
        $voucher = $user ? \common\models\gcacoin\Gcacoin::getModel($user->id) : [];
        $address = \common\models\user\UserAddress::getDefaultAddress();
        if (Yii::$app->request->post('quantity') >= 1) {
            if (!$user) {
                __setUrlBack();
                return $this->redirect(\yii\helpers\Url::to(['/login/login/login']));
            }
            if (Yii::$app->request->post('password') && $user->checkOtp(Yii::$app->request->post('password'))) {
                $quantity = Yii::$app->request->post('quantity');
                $price = $product->getPrice($quantity);
                $ordertotal = $price * $quantity;
                $coin = \common\models\gcacoin\Gcacoin::getCoinToMoney($ordertotal);
                if ($voucher->addCoinSale(-$coin) > 0) {
                    $model = new Order();
                    $attrs = $product->attributes;
                    $attrs['quantity'] = $quantity;
                    $dataProcess = [$product->shop_id => [$attrs]];
                    if ($model->checkCostAffilate($dataProcess)) {
                        $shop_id = $product->shop_id;
                        $shop = \common\models\shop\Shop::findOne($shop_id);
                        $model->shop_id = $shop_id;
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
                        $model->getShopAddressSlected();
                        //thiet lap mua bangw vs
                        $model->payment_status = \common\components\payments\ClaPayment::PAYMENT_STATUS_SUCCESS;
                        $model->payment_method =  \common\components\payments\ClaPayment::PAYMENT_METHOD_MEMBERVS;
                        $model->to_sale = 1;
                        //van chuyen
                        $tran = new Transport();
                        $model->transport_type = isset($tran->transports[$shop_id]['method']) ? $tran->transports[$shop_id]['method'] : 0;
                        $model->shipfee = 0;
                        $model->transport_id = 0;
                        //
                        $list = [];
                        if ($model->save()) {
                            $model_item = new OrderItem();
                            $model_item->order_id = $model->id;
                            $model_item->shop_id = $product['shop_id'];
                            $model_item->product_id = $product['id'];
                            $model_item->code = $product['code'];
                            $model_item->price = $price;
                            $model_item->quantity = $quantity;
                            $model_item->status = 1;
                            $model_item->name = $product['name'];
                            $model_item->avatar_path = $product['avatar_path'];
                            $model_item->avatar_name = $product['avatar_name'];
                            $model_item->getAffiliate();
                            if ($model_item->save()) {
                                $notify = [];
                                $notify['title'] = Yii::t('app', 'have_new_order');
                                $notify['description'] = Yii::t('app', 'order_ms_0') . $product['name'] . Yii::t('app', 'order_ms_1') . $model_item['quantity'];
                                $notify['link'] = Url::to(['/management/order/index']);
                                $notify['type'] = Notifications::ORDER;
                                $shop = Shop::findOne($model_item['shop_id']);
                                $notify['recipient_id'] = $shop->user_id;
                                Notifications::pushMessage($notify);
                                $list[] = $model_item;
                            }
                            $model->costAffiliate($list);
                            $model->getFeeTransport();
                            if ($shop['email']) {
                                \common\models\mail\SendEmail::sendMail([
                                    'email' => $shop['email'],
                                    'title' => 'Đơn hàng mới tại OCOP',
                                    'content' => $this->renderAjax('email_shop', [
                                        'order' => $model
                                    ])
                                ]);
                            }
                            if ($address['email']) {
                                \common\models\mail\SendEmail::sendMail([
                                    'email' => $address['email'],
                                    'title' => 'Tạo đơn hàng thành công tại OCOP',
                                    'content' => $this->renderAjax('email_user', [
                                        'order' => $model
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
                                        'order' => $model,
                                        'address' => $address,
                                        'shop' => $shop,
                                        'items' => [$product]
                                    ])
                                ]);
                            }
                            $dataos = [
                                'order_id' => $model->id,
                                'type' => $model->transport_type,
                                'time' => time(),
                                'status' => 1,
                                'content' => Yii::t('app', 'created_order'),
                            ];
                            \common\models\order\OrderShopHistory::saveData($dataos);
                            $claPayment = new ClaPayment(['order' => $model]);
                            $claPayment->pay();
                            $url_success = Url::to(['/product/shoppingcart/success', 'id' => $model->id, 'key' => $model->key]);
                            return $this->redirect($url_success);
                        }
                    } else {
                        Yii::$app->session->setFlash('error', $model->getErrorAffiliate());
                    }
                }
            } else {
                Yii::$app->session->setFlash('error', 'Mật khẩu cấp 2 không chính xác vui lòng thử lại.');
            }
        }
        //
        return $this->render('index', [
            'product' => $product,
            'voucher' => $voucher,
            'address' => $address,
            'quantity' => $quantity
        ]);
    }

    public function actionSuccess($id, $key)
    {
        $order = Order::findOne($id);
        $shoppingcart = new Shoppingcart();
        $data = $shoppingcart->cartstore;
        $shoppingcart->removeAll();
        if ($order->key != $key) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $product = new Product();
        $shop = new Shop();
        if ($data) {
            foreach ($data as $product) {
                $product = Product::findOne($product['id']);
                $shop = Shop::findOne($product['shop_id']);
            }
        }
        if ($order->payment_method == ClaPayment::PAYMENT_METHOD_QR) {
            $qrcode = [
                'type' => 'order',
                'price' => $order->order_total,
                // 'user_id' => 4,
                'data' => [
                    'order_id' => $order->id,
                ]
            ];
            $src = \common\components\ClaQrCode::GenQrCode($qrcode);
            // \common\components\ClaQrCode::CheckPayment($qrcode);
        } else {
            $src = '';
        }
        Yii::$app->view->title = 'Đặt hàng thành công';
        return $this->render('success', [
            'order' => $order,
            'shop' => $shop,
            'src' => $src,
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
            //
            $model->province_name = ($tg = Province::findOne($model->province_id)) ? $tg['name'] : '';
            $model->district_name = ($tg = District::findOne($model->district_id)) ? $tg['name'] : '';
            $model->ward_name = ($tg = Ward::findOne($model->ward_id)) ? $tg['name'] : '';
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

    public function actionUpdate($quantity = 1)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = $this->getProduct(0);
        $quantity = $model->getQuatityOrder($quantity);
        $price = $model->getPrice($quantity);
        $model->_price = $price * $quantity;
        $data = [
            'price_text' => $model->getPriceText($quantity),
            'quantity' => $quantity,
            'price' => \common\models\gcacoin\Gcacoin::getCoinToMoney($model->_price)
        ];
        return json_encode($data);
        //
    }

    function actionCheckOtp($otp)
    {
        $user = User::findOne(Yii::$app->user->getId());
        if ($otp && $user && $user->checkOtp($otp)) {
            return 'success';
        }
        return "error";
    }
}
