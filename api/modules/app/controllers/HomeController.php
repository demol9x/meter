<?php

namespace api\modules\app\controllers;

//
use Yii;
// yii\web\HeaderCollection::
class HomeController extends AppController
{

    function actionStart()
    {
        $resonse = $this->getResponse();
        if ($this->checkApi()) {
            $resonse['error'] = 'Token đã được đăng ký trước đó.';
            return $this->responseData($resonse);
        } else {
            $str = $_GET['string'];
            if (sha1($str . $this->token) == $this->_token) {
                $model = new \common\models\Tokens();
                $model->token = $this->_token;
                $model->created_at = time();
                $model->save();
                Yii::$app->cache->delete(self::KEY_API_TOKEN_LIST);
                $resonse['code'] = 1;
                $resonse['data'] =  ['token' => $this->_token];
                $resonse['message'] = 'Tạo token thành công';
                return $this->responseData($resonse);
            } else {
                $resonse['error'] = 'Api không hợp lệ.';
                return $this->responseData($resonse);
            }
        }
    }

    function actionUpdateDriver()
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        if (isset($post['device_id']) && $post['device_id']) {
            $dr = \common\models\user\UserDevice::getModel(['device_id' => $post['device_id']]);
            $dr->user_id = isset($post['user_id']) ? $post['user_id'] : '';
            $dr->type = isset($post['device_type']) ? $post['device_type'] : $dr->type;
            if ($dr->save()) {
                $resonse['code'] = 1;
                $resonse['data'] =  $dr;
                $resonse['message'] = 'Cập nhật Device Id thành công.';
                return $this->responseData($resonse);
            } else {
                $resonse['data'] = $dr->errors;
                $resonse['error'] = 'Lưu lỗi.';
                return $this->responseData($resonse);
            }
        }
        $resonse['error'] = 'Lỗi dữ liệu.';
        return $this->responseData($resonse);
    }

    function actionGetConfig()
    {
        $resonse = $this->getResponse();
        $resonse['code'] = 1;
        $resonse['data'] = \common\components\ClaLid::getSiteinfo();
        return $this->responseData($resonse);
    }

    function actionGetBanner()
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        if (isset($post['group_id']) && $post['group_id']) {
            $group_id = $post['group_id'];
            $group = \common\models\banner\BannerGroup::findOne(['id' => $group_id]);
            if ($group) {
                $limit = isset($post['limit']) ? $post['limit'] : '';
                $category_id = isset($post['category_id']) ? $post['category_id'] : '';
                $data = \common\models\banner\Banner::getBannerFromGroupId($group_id, ['limit' => $limit, 'category_id' => $category_id]);
                $resonse['data'] = [];
                if ($data) {
                    foreach ($data as $item) {
                        if ($item['src'][0] == '/') {
                            $item['src'] = \common\components\ClaHost::getImageHost() . $item['src'];
                        }
                        $resonse['data'][] = $item;
                    }
                }
                $resonse['code'] = 1;
                $resonse['message'] = 'Lấy danh sách banner thàng công';
            } else {
                $resonse['error'] = "Nhóm banner không tồn tại";
            }
        } else {
            $resonse['error'] = "Thiếu giá trị tham số group_id";
        }
        return $this->responseData($resonse);
    }

    function actionGetMenu()
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        if (isset($post['group_id']) && $post['group_id']) {
            $group_id = $post['group_id'];
            $group = \common\models\menu\MenuGroup::findOne(['id' => $group_id]);
            if ($group) {
                $parent_id = isset($post['parent_id']) ? $post['parent_id'] : 0;
                $clamenu = new \common\components\ClaMenu(array(
                    'create' => true,
                    'group_id' => $group_id,
                ));
                $resonse['data'] =  $clamenu->createMenu($parent_id);
                $resonse['code'] = 1;
                $resonse['message'] = 'Lấy danh sách menu thàng công';
            } else {
                $resonse['error'] = "Nhóm menu không tồn tại";
            }
        } else {
            $resonse['error'] = "Thiếu giá trị tham số group_id";
        }
        return $this->responseData($resonse);
    }

    function actionGetProductcatShowhome()
    {
        $resonse = $this->getResponse();
        $resonse['data'] = \common\models\product\ProductCategory::getShowHome();;
        $resonse['code'] = 1;
        $resonse['message'] = 'Lấy danh danh mục sản phẩm hiện trang chủ 1 thàng công';
        return $this->responseData($resonse);
    }

    function actionGetProductcatShowhome2product()
    {
        $resonse = $this->getResponse();
        $post = $this->getDataPost();
        $tgs = \common\models\product\ProductCategory::getShowHome2();
        $cats = [];
        $limit = isset($post['limit']) && $post['limit'] > 0 ? $post['limit'] : 4;
        $product = new \common\models\product\Product();
        $user = false;
        if (isset($post['user_id']) && $post['user_id']) {
            $product->_wishs = \common\models\product\ProductWish::getWishAllByUser(['user_id' => $post['user_id']]);
            $user = true;
        }
        if ($tgs) foreach ($tgs as $cat) {
            $cat = $cat->attributes;
            $tg2s = \common\models\product\Product::getProduct([
                'category_id' => $cat['id'],
                'limit' => $limit,
                'order' => 'ishot DESC, id DESC'
            ]);
            $datasave = [];
            if ($tg2s) foreach ($tg2s as $item) {
                $product->setAttributeShow($item);
                // $item['url'] = $product->getLink();
                $item['price_market'] = $product->getPriceMarket(1);
                $item['text_price_market'] = $product->getPriceMarketText(1);
                $item['price'] = $product->getPrice(1);
                $item['text_price'] = $product->getPriceText(1);
                if ($user) {
                    $item['in_wish'] = $product->inWish();
                } else {
                    $item['in_wish'] = false;
                }
                $datasave[] = $item;
            }
            $cat['products'] = $datasave;
            $cats[] = $cat;
        }
        $resonse['data'] = $cats;
        $resonse['code'] = 1;
        $resonse['message'] = 'Lấy danh danh mục sản phẩm hiện trang chủ 2 thàng công';
        return $this->responseData($resonse);
    }

    function actionGetKeySearchProduct()
    {
        $options = $this->getDataPost();
        $resonse['message'] = 'Lấy danh sách từ khóa tìm kiếm thàng công';
        $resonse['data'] = \common\models\product\ProductTopsearch::getTopsearch($options);
        $resonse['code'] = 1;
        return $this->responseData($resonse);
    }

    function actionLogin()
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        $model = new \frontend\models\LoginForm();
        if ($model->load($post) && $model->login()) {
            $user = \Yii::$app->user->identity;
            if (!$user->token_app) {
                $user->token_app = $this->_token;
                $user->save(false);
            }
            if (isset($post['device_id']) && $post['device_id']) {
                $dr = \common\models\user\UserDevice::getModel(['device_id' => $post['device_id']]);
                if ($dr->user_id != $user->id) {
                    $dr->user_id = $user->id;
                    $dr->type = isset($post['device_type']) ? $post['device_type'] : $dr->type;
                    $dr->save();
                }
            }
            $user->addAffilliateApp();
            $resonse['data'] = $user->attributes;
            $shop = \common\models\shop\Shop::findOne($user['id']);
            $resonse['data']['_shop'] = $shop ? $shop->attributes : 0;
            $resonse['code'] = 1;
            $resonse['message'] = 'Đăng nhập thành công.';
        } else {
            $resonse['data'] = $model->getErrors();
            $resonse['error'] = 'Thông tin đăng nhập không đúng';
        }
        return $this->responseData($resonse);
    }

    function actionSignup()
    {
        $this->setTimeLoadOnce(5);
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        $model = new \frontend\models\SignupForm();
        if ($model->load($post)) {
            if ($user = $model->signup()) {
                $user->addAffilliateApp();
                if (Yii::$app->getUser()->login($user)) {
                    if (isset($post['device_id']) && $post['device_id']) {
                        $dr = \common\models\user\UserDevice::getModel(['device_id' => $post['device_id']]);
                        if ($dr->user_id != $user->id) {
                            $dr->user_id = $user->id;
                            $dr->type = isset($post['device_type']) ? $post['device_type'] : $dr->type;
                            $dr->save();
                        }
                    }
                    if ($user['email']) {
                        \common\models\mail\SendEmail::sendMail([
                            'email' => $user['email'],
                            'title' => 'Đăng ký tài khoản '.__NAME_SITE.' thành công',
                            'content' => \frontend\widgets\mail\MailWidget::widget(['view' => 'email_signup', 'input' => ['user' => $user]])
                        ]);
                    }
                    \frontend\models\User::updateAll(['token_app' => $this->_token], "id = " . \Yii::$app->user->id);
                    $resonse['data'] = $user;
                    $resonse['code'] = 1;
                    $resonse['message'] = 'Đăng ký thành công.';
                    return $this->responseData($resonse);
                }
                $resonse['error'] = 'Tài khoản không thể đang nhập.';
                return $this->responseData($resonse);
            }
        }
        $resonse['data'] = $model->getErrors();
        $resonse['error'] = $resonse['data'] ? 'Thông tin đăng ký không đúng yêu cầu' :  'Thông tin đăng ký không đúng cấu trúc';
        return $this->responseData($resonse);
    }

    function actionGetOptionWards()
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        if (isset($post['district_id']) && $post['district_id']) {
            $list = \common\models\Ward::dataFromDistrictId($post['district_id']);
        } else {
            $list = (new \common\models\Ward())->optionsCache();
        }
        $resonse['data'] = $list ? $list : [];
        $resonse['message'] = "Lấy danh sách xã/phường thành công";
        $resonse['code'] = 1;
        return $this->responseData($resonse);
    }

    function actionGetOptionDistricts()
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        if (isset($post['province_id']) && $post['province_id']) {
            $list = \common\models\District::dataFromProvinceId($post['province_id']);
        } else {
            $list = (new \common\models\District())->optionsCache();
        }
        $resonse['data'] = $list ? $list : [];
        $resonse['message'] = "Lấy danh sách quận/huyện thành công";
        $resonse['code'] = 1;
        return $this->responseData($resonse);
    }

    function actionGetOptionProvinces()
    {
        $resonse = $this->getResponse();
        $list = (new \common\models\Province())->optionsCache();
        $resonse['data'] = $list ? $list : [];
        $resonse['message'] = "Lấy danh sách tỉnh/thành phố thành công";
        $resonse['code'] = 1;
        return $this->responseData($resonse);
    }

    function actionGetNews()
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        $post['attr'] = $post;
        $post['attr']['status'] = 1;
        if (isset($post['count']) && $post['count']) {
            $resonse['data']['total'] = (new \common\models\news\News())->getByAttr($post);
            $resonse['message'] = 'Lấy số lượng tin tức thành công.';
            $resonse['code'] = 1;
            return $this->responseData($resonse);
        }
        $resonse['data'] = (new \common\models\news\News())->getByAttr($post);
        $resonse['message'] = 'Lấy tin tức thành công.';
        $resonse['code'] = 1;
        return $this->responseData($resonse);
    }

    function actionGetDetailNews()
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        if (isset($post['id']) && $post['id'] && ($news = \common\models\news\News::findOne($post['id']))) {
            if ($news->status == 1) {
                $resonse['data'] = $news;
                $resonse['message'] = 'Lấy chi tiết tin tức thành công.';
                $resonse['code'] = 1;
                return $this->responseData($resonse);
            }
            $resonse['error'] = 'Bài tin chưa qua kiểm duyệt vui lòng xem lại.';
            return $this->responseData($resonse);
        }
        $resonse['error'] = 'Không tìm thấy bài tin.';
        return $this->responseData($resonse);
    }

    function actionGetBanks()
    {
        $resonse = $this->getResponse();
        $resonse['data'] = \common\models\Bank::find()->all();
        $resonse['message'] = 'Lấy danh sách ngân hàng thành công.';
        $resonse['code'] = 1;
        return $this->responseData($resonse);
    }

    function actionGetSaleNow()
    {
        $resonse = $this->getResponse();
        $sale = \common\models\SaleV::getNow();
        if ($sale) {
            $resonse['data'] = $sale;
            $resonse['message'] = 'Lấy chương trình nạp V khuyến mãi thành công.';
            $resonse['code'] = 1;
        } else {
            $sale = \common\models\SaleV::getNear();
            $resonse['data'] = $sale ? $sale : [];
            $resonse['message'] = $sale  ? 'Lấy chương trình nạp V khuyến mãi gần nhất thành công.' : 'Hiện không có chương trình nạp V khuyến mãi.';
        }
        return $this->responseData($resonse);
    }

    function actionGetOrderQr()
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        if (isset($post['token']) && $post['token']) {
            $qr = \common\models\qrcode\PayQrcode::findOne(['token' => $post['token']]);
            $json = json_decode($qr->data, true);
            if (isset($json['order_id']) && $json['order_id']) {
                $orders = \common\models\order\Order::getOrderByKey($json['order_id']);
                if ($orders) {
                    $money = 0;
                    foreach ($orders as $order) {
                        if ($order->payment_status != \common\components\payments\ClaPayment::PAYMENT_STATUS_SUCCESS) {
                            $money += $order->order_total;
                        }
                    }
                    if ($qr->price != $money) {
                        $resonse['error'] = "Mã không còn hiệu lực thanh toán.";
                        return $this->responseData($resonse);
                    }
                    $resonse['data']['total'] = $money;
                    $resonse['data']['key'] = $json['order_id'];
                    $resonse['data']['orders'] = $orders;
                    $resonse['message'] = "Lấy danh sách đơn hàng thành công.";
                    $resonse['code'] = 1;
                    return $this->responseData($resonse);
                }
            }
            $resonse['error'] = "Mã không còn hiệu lực thanh toán.";
            return $this->responseData($resonse);
        }
        $resonse['error'] = "Lỗi dữ liệu.";
        return $this->responseData($resonse);
    }

    function actionGetInfoQr()
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        if (isset($post['token']) && $post['token']) {
            $qr = \common\models\qrcode\PayQrcode::findOne(['token' => $post['token']]);
            if ($qr) {
                $json = json_decode($qr->data, true);
                $resonse['data']['type'] = $qr->type;
                switch ($qr->type) {
                    case 'order':
                        $orders = \common\models\order\Order::getOrderByKey($json['order_id']);
                        if ($orders) {
                            $money = 0;
                            foreach ($orders as $order) {
                                if ($order->payment_status != \common\components\payments\ClaPayment::PAYMENT_STATUS_SUCCESS) {
                                    $money += $order->order_total;
                                }
                            }
                            if ($qr->price != $money) {
                                $resonse['error'] = "Mã không còn hiệu lực thanh toán.";
                                return $this->responseData($resonse);
                            }
                            $resonse['data']['total'] = $money;
                            $resonse['data']['key'] = $json['order_id'];
                            $resonse['data']['orders'] = $orders;
                            $resonse['message'] = "Lấy danh sách đơn hàng thành công.";
                            $resonse['code'] = 1;
                            return $this->responseData($resonse);
                        }
                        break;
                    case 'user':
                        $user = \frontend\models\User::findIdentity($json['user_id']);
                        if ($user) {
                            $resonse['data']['user'] = $user->attributes;
                            $resonse['data']['shop'] = \common\models\shop\Shop::findOne($user->id);
                            $siteif = \common\models\gcacoin\Config::getConfig();
                            $resonse['data']['fee_tranpost']['value'] = $siteif->transfer_fee;
                            $resonse['data']['fee_tranpost']['value_text'] = ($siteif->transfer_fee > 0) ? formatCoin($siteif->transfer_fee) . ' ' . $siteif->getUnitTransfer() : 'Miễn phí chuyển';
                            $resonse['message'] = "Lấy thông tin tài khoản thành công.";
                            $resonse['code'] = 1;
                            return $this->responseData($resonse);
                        }
                        break;
                    case 'user_service':
                        $user = \frontend\models\User::findIdentity($json['user_id']);
                        if ($user) {
                            $resonse['data']['user'] = $user->attributes;
                            $shop = \common\models\shop\Shop::findOne($user->id);
                            $resonse['data']['shop'] = $shop;
                            if ($shop && $shop->affilliate_status_service) {
                                $resonse['data']['product_service'] = \common\models\product\Product::getProductService($shop->id);
                            }
                            $resonse['message'] = "Lấy thông tin tài khoản thành công.";
                            $resonse['code'] = 1;
                            return $this->responseData($resonse);
                        }
                        break;
                }
            }
            $resonse['error'] = "Mã không còn hiệu lực.";
            return $this->responseData($resonse);
        }
        $resonse['error'] = "Lỗi dữ liệu.";
        return $this->responseData($resonse);
    }

    function actionRequestPasswordReset()
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        if (isset($post['email']) && $post['email']) {
            $model = new \frontend\models\PasswordResetRequestForm();
            $model->email = $post['email'];
            if ($model->validate()) {
                if ($model->sendEmail()) {
                    $resonse['code'] = 1;
                    $resonse['message'] = 'Kiểm tra email của bạn để được hướng dẫn thêm.';
                    return $this->responseData($resonse);
                } else {
                    $resonse['message'] = 'Sorry, we are unable to reset password for email provided.';
                    return $this->responseData($resonse);
                }
            }
            $resonse['data'] = $model->errors;
        }
        $resonse['error'] = "Lỗi dữ liệu.";
        return $this->responseData($resonse);
    }

    public function actionResetPassword()
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        if (isset($post['password']) && $post['password'] && isset($post['token']) && $post['token']) {
            $model = new \frontend\models\ResetPasswordForm($post['token']);
            if (!$model->getUser()) {
                $resonse['error'] = "Token hết thời gian hiệu lực.";
                return $this->responseData($resonse);
            }
            $model->password = $post['password'];
            if ($model->validate() && $model->resetPassword()) {
                $resonse['code'] = 1;
                $resonse['message'] = 'Đổi mật khẩu thành công.';
                return $this->responseData($resonse);
            }
            $resonse['data'] = $model->errors;
        }
        $resonse['error'] = "Lỗi dữ liệu.";
        return $this->responseData($resonse);
    }

    function actionGetGroups()
    {
        $resonse['data'] = (new  \common\models\user\UserGroup())->options();
        $resonse['code'] = 1;
        $resonse['message'] = 'Lấy danh sách nhóm người dùng thành công.';
        return $this->responseData($resonse);
    }

    function actionGetImageQrs()
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        if (isset($post['user_id']) && $post['user_id']) {
            $user = \frontend\models\User::findOne($post['user_id']);
            if ($user) {
                $resonse['data']['qr_senv'] = $user->getQrSendV();
                $resonse['data']['qr_service'] = $user->getQrSendService();
                $resonse['data']['qr_gtshop'] = $user->getQrSendBeforeShop();
                $resonse['code'] = 1;
                $resonse['message'] = 'Lấy danh sách QR-CODE thành công.';
                return $this->responseData($resonse);
            } else {
                $resonse['data'] = $post;
                $resonse['error'] = 'Tài khoản không tồn tại.';
                return $this->responseData($resonse);
            }
        }
        $resonse['data'] = $post;
        $resonse['error'] = 'Lỗi dữ liệu.';
        return $this->responseData($resonse);
    }

    function actionTotalCharity()
    {
        $resonse['data']['total'] = \common\models\gcacoin\Gcacoin::getMoneyToCoin(\common\models\order\OrderItem::getAllCharity(['status' => \common\models\order\Order::ORDER_DELIVERING, 'sum' => 1]));
        $resonse['data']['total_text'] = formatMoney($resonse['data']['total']) . ' ' . Yii::t('app', 'currency');
        $post = $this->getDataPost();
        $page = isset($post['page']) && $post['page'] > 1 ? $post['page'] : 1;
        $limit = isset($post['limit']) && $post['limit'] > 1 ? $post['limit'] : 10;
        $ors = \common\models\order\OrderItem::getAllCharity([
            'status' => \common\models\order\Order::ORDER_DELIVERING,
            'limit' => $limit,
            'page' => $page,
        ]);
        $histories = [];
        $shops = (new \common\models\shop\Shop())->optionsCache();
        if ($ors) foreach ($ors as $item) {
            $money = \common\models\gcacoin\Gcacoin::getMoneyToCoin($item['sale_charity']);
            $tg['money'] = formatMoney($money);
            $tg['user'] = $item['user_id'] . ' - ' . $item['name'];
            $tg['product'] = $item['product_name'];
            $tg['shop'] = isset($shops[$item['shop_id']]) ? $shops[$item['shop_id']] : 'Doanh nghiệp đã không có trong hệ thống';
            $sale = \common\models\gcacoin\Gcacoin::getMoneyToCoin($item['sale']);
            $tg['percent'] = formatCoin($money * 100 / ($item['price'] * $item['quantity'] + $sale)) . '%';
            $histories[] = $tg;
        }
        $resonse['data']['histories'] = $histories;
        $resonse['code'] = 1;
        $resonse['message'] = 'Lấy tổng tiển từ thiện thành công thành công.';
        return $this->responseData($resonse);
    }
}
