<?php

namespace frontend\mobile\modules\management\controllers;

use common\components\ClaGenerate;
use common\components\ClaLid;
use common\components\ClaQrCode;
use common\components\payments\ClaPayment;
use common\models\gcacoin\Config;
use common\models\gcacoin\Gcacoin;
use common\models\gcacoin\GcaCoinHistory;
use common\models\gcacoin\WithDraw;
use common\models\order\Order;
use frontend\models\User;
use yii;

class GcacoinController extends \frontend\controllers\CController
{
    public $layout = 'gcacoin';
    public $domain = '<?= __SERVER_NAME ?>/';
    public $config_xu = 100;
    const TYPE_MEMBER = 'MEMBER';

    public function actionIndex()
    {
        $coin = Gcacoin::getModel(Yii::$app->user->id);
        $history = GcaCoinHistory::find()->where(['user_id' => Yii::$app->user->id])->orderBy(['id' => SORT_DESC])->limit(10)->all();
        $username = Yii::$app->user->identity->username;
        $history_warning = WithDraw::find()->where(['user_id' => Yii::$app->user->id, 'status' => 0])->all();
        $coin_waning = 0;
        if (isset($history_warning) && $history_warning) {
            foreach ($history_warning as $his) {
                $coin_waning += $his->value;
            }
        }
        return $this->render('index', ['coin' => $coin, 'history' => $history, 'username' => $username, 'coin_waning' => $coin_waning]);
    }

    public function actionConfinement()
    {
        $confinements = \common\models\gcacoin\CoinConfinement::getUseByShop();
        return $this->render('confinement', ['confinements' => $confinements]);
    }

    public function actionPaymentMethod()
    {
        $post = Yii::$app->request->post();
        $type = $post['type'];
        $money = $post['money'];
        $user_id = Yii::$app->user->id;
        $user = User::findOne($user_id);
        if ($type == ClaPayment::PAYMENT_METHOD_MEMBERIN && $money) {
            if ($user->member_privatekey && $user->member_username) {
                $data = [
                    'user_name' => $user->member_username,
                    'key' => $user->member_privatekey,
                    'money' => $money
                ];
                $result = ClaQrCode::ConnectXu($data);
                if (isset($result) && $result) {
                    if ($result->success) {
                        $session = ClaQrCode::getSession('otp-member');
                        if (isset($session) && $session) {
                            if ($session['time'] + 90 < time()) {
                                Yii::$app->session->remove('otp-member');
                                ClaQrCode::setSession('otp-member', true);
                                $get_otp = ClaQrCode::getOtp($result->phone);
                                $get_otp = json_decode($get_otp);
                                if ($get_otp->success) {
                                    $return = [
                                        'success' => true,
                                        'token' => $result->token,
                                        'phone' => $result->phone
                                    ];
                                } else {
                                    $return = [
                                        'success' => false,
                                        'errors' => $get_otp->message
                                    ];
                                }
                            } else {
                                $return = [
                                    'success' => true,
                                    'token' => $result->token,
                                    'phone' => $result->phone
                                ];
                            }
                        } else {
                            ClaQrCode::setSession('otp-member', true);
                            $get_otp = ClaQrCode::getOtp($result->phone);
                            $get_otp = json_decode($get_otp);
                            if ($get_otp->success) {
                                $return = [
                                    'success' => true,
                                    'token' => $result->token,
                                    'phone' => $result->phone
                                ];
                            } else {
                                $return = [
                                    'success' => false,
                                    'errors' => $get_otp->message
                                ];
                            }
                        }
                    } else {
                        $return = [
                            'success' => false,
                            'errors' => $result->errors
                        ];
                    }
                } else {
                    $return = [
                        'success' => false,
                        'errors' => 'Kh??ng k???t n???i ???????c server k???t n???i qui ?????i ??i???m.'
                    ];
                }
            } else {
                $return = [
                    'success' => false,
                    'errors' => 'B???n ch??a c???u h??nh t??i kho???n th??? th??nh vi??n.B???n vui l??ng v??o m???c C???u h??nh t??i kho???n th??nh vi??n ????? th??m t??i kho???n.'
                ];
            }
            return json_encode($return);
        }
    }

    public function actionCheckout()
    {
        $post = Yii::$app->request->post();
        $token = isset($post['token']) ? $post['token'] : '';
        $otp = isset($post['otp']) ? $post['otp'] : '';
        $data = [
            'token' => $token,
            'otp' => $otp
        ];
        $config = Config::find()->one();
        if ($config) {
            $return_member = ClaQrCode::GetXu($data);
            $success = json_decode($return_member);
            if ($success->success) {
                Yii::$app->session->remove('otp-member');
                $money = $success->data->money;
                $coin = (($money) / ($config->money)) * $config->gcacoin;
                $gcacoin = Gcacoin::findOne(Yii::$app->user->id);
                if ($gcacoin && $coin) {
                    $first_coin = (float)ClaGenerate::decrypt($gcacoin->gca_coin);
                    $encypt = (float)ClaGenerate::decrypt($gcacoin->gca_coin);
                    $encypt += $coin;
                    $gcacoin->gca_coin = ClaGenerate::encrypt($encypt);
                } else {
                    $gcacoin = new Gcacoin();
                    $gcacoin->user_id = Yii::$app->user->id;
                    $gcacoin->gca_coin = ClaGenerate::encrypt($coin);
                }
                if ($gcacoin->save()) {
                    $noti = new \common\models\notifications\Notifications();
                    $noti->title = 'S??? d?? t??i kho???n thay ?????i';
                    $noti->description = 'S??? d?? t??i kho???n thay ?????i <b style="color: green">+' . $coin . '</b> gcacoin.  S??? d?? hi???n t???i: <b style="color: green">' . ClaGenerate::decrypt($gcacoin->gca_coin) . '</b> gcacoin';
                    $noti->link = '#';
                    $noti->type = 3;
                    $noti->recipient_id = Yii::$app->user->id;
                    $noti->unread = ClaLid::STATUS_ACTIVED;
                    $noti->save();

                    $history = new GcaCoinHistory();
                    $history->user_id = Yii::$app->user->id;
                    $history->type = 'member';
                    $history->data = 'B???n ???? n???p th??nh c??ng ' . $coin . ' OCOP V';
                    $history->gca_coin = $coin;
                    $history->first_coin = $first_coin;
                    $history->last_coin = (float)ClaGenerate::decrypt($gcacoin->gca_coin);
                    $history->save();

                    $return = [
                        'success' => true,
                        'message' => 'B???n ???? n???p th??nh c??ng ' . $coin . ' OCOP V.'
                    ];
                }
            } else {
                $return = [
                    'success' => false,
                    'errors' => $success->errors
                ];
            }
        } else {
            $return = [
                'success' => false,
                'errors' => 'Ch??a c?? c???u h??nh t??? l??? quy ?????i. Li??n h??? v???i admin.'
            ];
        }

        return json_encode($return);
    }

    public function actionConvert()
    {
        $user_id = Yii::$app->user->id;
        $coin = Gcacoin::findOne($user_id);
        $user = User::findOne($user_id);
        $model = new WithDraw();
        $history = WithDraw::find()->where(['user_id' => $user_id])->orderBy('updated_at DESC')->limit(10)->all();
        $history_warning = WithDraw::find()->where(['user_id' => $user_id, 'status' => 0])->all();
        $coin_waning = 0;
        if (isset($history_warning) && $history_warning) {
            foreach ($history_warning as $his) {
                $coin_waning += $his->value;
            }
        }
        $post = Yii::$app->request->post();
        $xu = isset($post['value']) ? $post['value'] : '';
        $id_bank = isset($post['bank_id']) ? $post['bank_id'] : '';
        if (isset($post) && $post) {
            if ($xu <= (ClaGenerate::decrypt($coin->gca_coin_red) - $coin_waning)) {
                $model->user_id = Yii::$app->user->id;
                $model->value = $xu;
                $model->bank_id = $id_bank;
                if ($model->validate()) {
                    $return = $user->createInfoOtp($id_bank, $xu);
                } else {
                    $return = [
                        'success' => false,
                        'errors' => $model->getErrors()
                    ];
                }
            } else {
                $return = [
                    'success' => false,
                    'errors' => [
                        'tk' => 'T??i kho???n c???a b???n kh??ng ????? ti???n.'
                    ]
                ];
            }
            return json_encode($return);
        }
        return $this->render('convert', ['coin' => $coin, 'user' => $user, 'model' => $model, 'history' => $history, 'coin_waning' => $coin_waning]);
    }

    public function actionCheckotpConvert()
    {
        $user_id = Yii::$app->user->id;
        $user = User::findOne($user_id);
        $post = Yii::$app->request->post();
        $xu = isset($post['xu']) ? $post['xu'] : '';
        $bank_id = isset($post['bank_id']) ? $post['bank_id'] : '';
        $otp = isset($post['otp']) ? $post['otp'] : '';
        $model = new WithDraw();
        if (isset($post) && $post) {
            if ($user->checkOtp($otp)) {
                $model->user_id = $user_id;
                $model->value = $xu;
                $model->bank_id = $bank_id;
                if ($model->save()) {
                    $return = [
                        'success' => true,
                        'message' => 'Y??u c???u c???a b???n ???? ???????c g???i th??nh c??ng.'
                    ];
                } else {
                    $return = [
                        'success' => false,
                        'errors' => $model->getErrors()
                    ];
                }
            } else {
                $return = [
                    'success' => false,
                    'errors' => $user->_error_opt,
                ];
            }
            return json_encode($return);
        }
    }

    public function actionTransfer()
    {
        $user_id = Yii::$app->user->id;
        $user = User::findOne($user_id);
        $coin = Gcacoin::getModel($user_id);
        $model = new \common\models\gcacoin\Transfer();
        $history = GcaCoinHistory::find()->where(['user_id' => Yii::$app->user->id, 'type' => 'TRANSFER_COIN'])->orderBy(['id' => SORT_DESC])->limit(10)->all();
        return $this->render('transfer', ['coin' => $coin, 'user' => $user, 'model' => $model, 'history' => $history]);
    }

    public function actionTransferv()
    {
        $user_id = Yii::$app->user->id;
        $user = User::findOne($user_id);
        $coin = Gcacoin::getModel($user_id);
        $model = new \common\models\gcacoin\Transfer();
        $history = GcaCoinHistory::find()->where(['user_id' => Yii::$app->user->id, 'type' => 'TRANSFER_VRCOIN'])->orderBy(['id' => SORT_DESC])->limit(10)->all();
        return $this->render('transferv', ['coin' => $coin, 'user' => $user, 'model' => $model, 'history' => $history]);
    }

    public function actionSaveTransferv()
    {
        $user_id = Yii::$app->user->id;
        $user = User::findOne($user_id);
        $post = Yii::$app->request->post();
        $xu = isset($post['xu']) ? $post['xu'] : '';
        $otp = isset($post['otp']) ? $post['otp'] : '';
        if (isset($post) && $post) {
            if ($user->checkOtp($otp)) {
                if ($user->transferVr($xu)) {
                    $return = [
                        'success' => true,
                        'message' => 'Chuy???n V th??nh c??ng.'
                    ];
                } else {
                    $return = [
                        'success' => false,
                        'errors' => $user->_error_opt
                    ];
                }
            } else {
                $return = [
                    'success' => false,
                    'errors' => $user->_error_opt,
                ];
            }
            return json_encode($return);
        }
    }

    // public function actionCheckTransfer()
    // {
    //     $model = new \common\models\gcacoin\Transfer();
    //     if ($model->load(Yii::$app->request->post()) && $model->validate()) {
    //         return 'success';
    //     }
    //     return false;
    // }

    public function actionSaveTransfer()
    {
        $user_id = Yii::$app->user->id;
        $user = User::findOne($user_id);
        $post = Yii::$app->request->post();
        $xu = isset($post['xu']) ? $post['xu'] : '';
        $user_receive = isset($post['user_receive']) ? $post['user_receive'] : '';
        $otp = isset($post['otp']) ? $post['otp'] : '';
        if (isset($post) && $post) {
            if ($user->checkOtp($otp)) {
                if ($user->transferV($user_receive, $xu)) {
                    $return = [
                        'success' => true,
                        'message' => 'Chuy???n V th??nh c??ng.'
                    ];
                } else {
                    $return = [
                        'success' => false,
                        'errors' => $user->_error_opt
                    ];
                }
            } else {
                $return = [
                    'success' => false,
                    'errors' => $user->_error_opt,
                ];
            }
            return json_encode($return);
        }
    }

    public function actionInfoUser($user_id)
    {
        $shop = [];
        if (is_numeric($user_id)) {
            $user = User::findOne($user_id);
            if ($user) {
                $shop = \common\models\shop\Shop::findOne($user->id);
            }
        } else {
            $user = User::find()->where(['username' => $user_id])->one();
            if (!$user) {
                $shop = \common\models\shop\Shop::find()->where(['name' => $user_id])->orWhere(['email' => $user_id])->one();
                if ($shop) {
                    $user = User::findOne($shop->id);
                }
            } else {
                $shop = \common\models\shop\Shop::findOne($user->id);
            }
        }
        return $this->renderAjax('info-user', ['user' => $user, 'shop' => $shop]);
    }

    public function actionRecharge()
    {
        if (\common\models\SaleV::getNow()) {
            Yii::$app->session->setFlash('error', '???? h???t phi??n n???p VOUCHER - H??? th???ng ???? chuy???n qua phi??n n???p VOUCHER khuy???n m??i. Qu?? kh??ch vui l??ng ?????i phi??n n???p VOUCHER khuy???n m??i k???t th??c ????? c?? th??? ti???p t???c n???p VOUCHER.');
            return $this->redirect(['recharge-sale']);
        }
        $user_id = Yii::$app->user->id;
        $user = User::findOne($user_id);
        $post = Yii::$app->request->post();
        $key = strtoupper(md5(time()));
        if (isset($post) && $post && isset($post['Order']['key'])) {
            if ($post['Order']['payment_method'] == \common\components\payments\ClaPayment::PAYMENT_METHOD_CK) {
                if (!$post['Recharge']['avatar_1'] || !$post['Recharge']['avatar_2']) {
                    Yii::$app->session->setFlash('error', 'Vui l??ng nh???p ?????y ????? ???nh!');
                    return $this->render('recharge', ['key' => $key]);
                }
            }
            $model = $post['Order'];
            $order = new Order();
            $order->payment_method = $model['payment_method'];
            $order->payment_method_child = isset($model['payment_method_child']) ? $model['payment_method_child'] : 'CHUYENKHOAN';
            $order->order_total = \common\models\gcacoin\Gcacoin::getMoneyToCoin($post['money']);
            $order->user_id = $user_id;
            $order->email = $user->email;
            $order->name = $user->username;
            $order->phone = $user->phone;
            $order->address = 'Th??m Voucher';
            $order->key = $model['key'];
            $order->type_payment = ClaPayment::TYPE_PAYMENT;
            if ($order->save()) {
                if ($post['Order']['payment_method'] == \common\components\payments\ClaPayment::PAYMENT_METHOD_CK) {
                    $avatar = Yii::$app->session[$post['Recharge']['avatar_1']];
                    if ($avatar) {
                        $wdimg = new \common\models\order\OrderImages();
                        $wdimg->order_id = $order->id;
                        $wdimg->name = $avatar['name'];
                        $wdimg->path = $avatar['baseUrl'];
                        $wdimg->save();
                    }
                    unset(Yii::$app->session[$post['Recharge']['avatar_1']]);
                    $avatar = Yii::$app->session[$post['Recharge']['avatar_2']];
                    if ($avatar) {
                        $wdimg = new \common\models\order\OrderImages();
                        $wdimg->order_id = $order->id;
                        $wdimg->name = $avatar['name'];
                        $wdimg->path = $avatar['baseUrl'];
                        $wdimg->save();
                    }
                    unset(Yii::$app->session[$post['Recharge']['avatar_2']]);
                }
                $claPayment = new ClaPayment(['order' => $order]);
                $claPayment->pay();
                Yii::$app->session->setFlash('success', 'Y??u c???u ???? ???? ???????c g???i ?????n BQT. Qu?? kh??ch vui l??ng ch??? x??c nh???n t??? BQT');
                return $this->redirect(['/management/gcacoin/index']);
            } else {
                print_r($order->getErrors());
                die;
            }
        }
        if (isset($_GET['iframe']) && $_GET['iframe']) {
            \Yii::$app->session->open();
            $_SESSION['redirect_pay_success'] = '/product/shoppingcart/checkout';
            $this->layout = '@frontend/views/layouts/main_base';
        }
        return $this->render('recharge', ['key' => $key]);
    }

    public function actionRechargeSale()
    {
        $sale = \common\models\SaleV::getNow();
        if (!$sale) {
            Yii::$app->session->setFlash('error', '???? h???t phi??n n???p VOUCHER khuy???n m??i - H??? th???ng ???? chuy???n qua phi??n n???p VOUCHER. Qu?? kh??ch vui l??ng ?????i ?????n phi??n n???p VOUCHER khuy???n m??i ti???p theo ????? c?? th??? ti???p t???c n???p VOUCHER khuy???n m??i.');
            return $this->redirect(['recharge']);
        }
        $user_id = Yii::$app->user->id;
        $user = User::findOne($user_id);
        $post = Yii::$app->request->post();
        $key = strtoupper(md5(time()));
        if (isset($post) && $post && isset($post['Order']['key'])) {
            if ($post['Order']['payment_method'] == \common\components\payments\ClaPayment::PAYMENT_METHOD_CK) {
                if (!$post['Recharge']['avatar_1'] || !$post['Recharge']['avatar_2']) {
                    Yii::$app->session->setFlash('error', 'Vui l??ng nh???p ?????y ????? ???nh!');
                    return $this->render('recharge-sale', ['key' => $key, 'sale' => $sale]);
                }
            }
            $model = $post['Order'];
            $order = new Order();
            $order->payment_method = $model['payment_method'];
            $order->payment_method_child = isset($model['payment_method_child']) ? $model['payment_method_child'] : 'CHUYENKHOAN';
            $order->order_total = \common\models\gcacoin\Gcacoin::getMoneyToCoin($post['money']);
            $order->user_id = $user_id;
            $order->email = $user->email;
            $order->name = $user->username;
            $order->phone = $user->phone;
            $order->address = 'Th??m Voucher khuy???n m??i';
            $order->key = $model['key'];
            $order->type_payment = ClaPayment::TYPE_PAYMENT;
            $order->to_sale = 1;
            $order->percent_sale = $sale->percent;
            if ($order->save()) {
                if ($post['Order']['payment_method'] == \common\components\payments\ClaPayment::PAYMENT_METHOD_CK) {
                    $avatar = Yii::$app->session[$post['Recharge']['avatar_1']];
                    if ($avatar) {
                        $wdimg = new \common\models\order\OrderImages();
                        $wdimg->order_id = $order->id;
                        $wdimg->name = $avatar['name'];
                        $wdimg->path = $avatar['baseUrl'];
                        $wdimg->save();
                    }
                    unset(Yii::$app->session[$post['Recharge']['avatar_1']]);
                    $avatar = Yii::$app->session[$post['Recharge']['avatar_2']];
                    if ($avatar) {
                        $wdimg = new \common\models\order\OrderImages();
                        $wdimg->order_id = $order->id;
                        $wdimg->name = $avatar['name'];
                        $wdimg->path = $avatar['baseUrl'];
                        $wdimg->save();
                    }
                    unset(Yii::$app->session[$post['Recharge']['avatar_2']]);
                }
                $claPayment = new ClaPayment(['order' => $order]);
                $claPayment->pay();
                Yii::$app->session->setFlash('success', 'Y??u c???u ???? ???? ???????c g???i ?????n BQT. Qu?? kh??ch vui l??ng ch??? x??c nh???n t??? BQT');
                return $this->redirect(['/management/gcacoin/index']);
            } else {
                print_r($order->getErrors());
                die;
            }
        }
        if (isset($_GET['iframe']) && $_GET['iframe']) {
            \Yii::$app->session->open();
            $_SESSION['redirect_pay_success'] = '/product/shoppingcart/checkout';
            $this->layout = '@frontend/views/layouts/main_base';
        }
        return $this->render('recharge-sale', ['key' => $key, 'sale' => $sale]);
    }

    public function actionViewFormRecharge()
    {
        return $this->renderPartial('form-recharge');
    }

    public function actionHistory()
    {
        $history = GcaCoinHistory::find()->where(['user_id' => Yii::$app->user->id])->orderBy(['id' => SORT_DESC])->limit(20)->all();
        return $this->render('history', ['history' => $history]);
    }
}
