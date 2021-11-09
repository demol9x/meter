<?php

namespace frontend\controllers;

use common\components\ClaLid;
use common\components\ClaQrCode;
use common\models\gcacoin\Config;
use common\models\gcacoin\Gcacoin;
use common\models\qrcode\PayQrcode;
use Yii;
use frontend\controllers\CController;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\SignupFormSocial;
use frontend\models\User;
use yii\helpers\Url;

/**
 * Site controller
 */
class SiteController extends CController
{

    public $successUrl = 'Success';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    // 'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'successCallback'],
            ],
        ];
    }

    public function actionSearch()
    {
        // $this->layout = "main_notfitter";
        $data = null;
        $get = $_GET;
        if (isset($get['tag']) && isset($get['type'])) {
            $data = \common\models\Search::getData($get);
        }
        $list_type = \common\models\Search::getTypeName();
        return $this->render('search', [
            'datas' => $data,
            'list_type' => $list_type,
        ]);
    }

    public function actionGetDistrict($pid)
    {
        $this->layout = "empty";
        $data = [];
        $data = \common\models\District::dataFromProvinceId($pid);
        return $this->render('district', [
            'data' => $data,
            'select_id' => ''
        ]);
    }

    public function successCallback($client)
    {
        \Yii::$app->session->open();
        $_SESSION['url_back_login_yes'] = time();
        $attributes = $client->getUserAttributes();
        // user login or signup comes here
        /*
          Checking facebook email registered yet?
          Maxsure your registered email when login same with facebook email
          die(print_r($attributes));
         */
        $email = '';
        $username = '';
        $type_social = 0;
        $id_social = '';
        if (isset($attributes['email']) && $attributes['email']) {
            // FACEBOOK
            $email = $attributes['email'];
            $username = $attributes['name'];
            $type_social = User::TYPE_SOCIAL_FACEBOOK;
            $id_social = $attributes['id'];
        } else if (isset($attributes['emails'][0]['value']) && $attributes['emails'][0]['value']) {
            // GOOGLE
            $email = $attributes['emails'][0]['value'];
            $username = $attributes['displayName'];
            $type_social = User::TYPE_SOCIAL_GOOGLE;
            $id_social = $attributes['id'];
        }
        if ($email) {
            $user = \frontend\models\UserSocial::find()->where(['email' => $email])->one();
            if (!empty($user)) {
                Yii::$app->user->login($user);
            } else {
                // Save session attribute user from FB
                $password = '111111111111111111111111111111111111111111111111111111111111';

                $model = new SignupFormSocial();
                $model->email = $email;
                $model->username = $username;
                $model->password = $password;
                $model->type_social = $type_social;
                $model->id_social = $id_social;
                //
                if ($user = $model->signup()) {
                    if ($user['email']) {
                        \common\models\mail\SendEmail::sendMail([
                            'email' => $user['email'],
                            'title' => 'Đăng ký tài khoản OCOP thành công',
                            'content' => \frontend\widgets\mail\MailWidget::widget(['view' => 'email_signup', 'input' => ['user' => $user]])
                        ]);
                    }
                    Yii::$app->user->login($user, Yii::$app->params['user.login.cookie.expire']);
                }
                \common\components\ClaLid::resetLocaltionDefault();
                // $session = Yii::$app->session;
                // $session['attributes_login_facebook'] = $attributes;
                // redirect to form signup, variabel global set to successUrl
                $this->successUrl = \yii\helpers\Url::to(['/site/index']);
            }
        } else {
            Yii::$app->session->setFlash('error', 'Lỗi: Không thể lấy thông tin email.');
            $this->successUrl = \yii\helpers\Url::to(['/site/index']);
        }
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {

        \Yii::$app->session->open();
        if (isset($_SESSION['url_back_login_yes']) && $_SESSION['url_back_login']) {
            unset($_SESSION['url_back_login_yes']);
            echo '
                <div style="display: flex; width: 100%; height: 100vh">
                    <img style="margin: auto;" src="' . Yii::$app->homeUrl . 'images/start_mobile.png">
                </div>
                <script type="text/javascript">
                    window.history.back();
                </script>';
            die();
        }

        $this->layout = 'main';
        $siteinfo = \common\components\ClaLid::getSiteinfo();
        // add title for view
        Yii::$app->view->title = isset($siteinfo->title) ? $siteinfo->title : 'Trang chủ';
        // add meta description
        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => $siteinfo->meta_description
        ]);
        // add meta keywords
        Yii::$app->view->registerMetaTag([
            'name' => 'keywords',
            'content' => $siteinfo->meta_keywords
        ]);
        //
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        return $this->redirect(Url::to(['login/login/login']));
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            \common\components\ClaLid::resetLocaltionDefault();
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect(Yii::$app->request->referrer);
        //        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        //
        $this->layout = '@frontend/views/layouts/content_page';
        $siteinfo = \common\components\ClaLid::getSiteinfo();
        // add meta description
        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => $siteinfo->meta_description
        ]);
        // add meta keywords
        Yii::$app->view->registerMetaTag([
            'name' => 'keywords',
            'content' => $siteinfo->meta_keywords
        ]);
        //
        $model = new \common\models\Contact();
        $model->created_at = time();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'thank_for_contact'));
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }
            return $this->refresh();
        }
        $info  = \common\models\SiteIntroduce::findOne(1);
        $infoAdd  = \common\models\Siteinfo::findOne(1);
        return $this->render('contact', [
            'model' => $model,
            'info' => $info,
            'infoAdd' => $infoAdd,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        //
        $this->layout = '@frontend/views/layouts/content_page';
        $siteinfo = \common\components\ClaLid::getSiteinfo();
        // add meta description
        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => $siteinfo->meta_description
        ]);
        // add meta keywords
        Yii::$app->view->registerMetaTag([
            'name' => 'keywords',
            'content' => $siteinfo->meta_keywords
        ]);
        //
        $model = ClaLid::getSiteIntroduce();
        return $this->render('about', [
            'model' => $model,
        ]);
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        //
        $this->layout = '@frontend/views/layouts/contact';
        //
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Kiểm tra email của bạn để được hướng dẫn thêm.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        //
        $this->layout = '@frontend/views/layouts/contact';
        //
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'Mật khẩu mới đã được lưu.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionLanguage()
    {
        if (Yii::$app->request->isAjax) {
            $lang = Yii::$app->request->post('lang');
            if (isset($lang)) {
                Yii::$app->language = $lang;
                $cookie = new \yii\web\Cookie([
                    'name' => 'lang',
                    'value' => $lang,
                ]);
                Yii::$app->language = $lang;
                Yii::$app->getResponse()->getCookies()->add($cookie);
            }
        }
    }
    /**/
    public function actionClearcache()
    {
        $cache = Yii::$app->cache;
        $cache->flush();
        echo "<pre>";
        print_r('Đã xóa cache');
        echo "</pre>";
        die();
    }

    public function beforeAction($action)
    {
        if ($action->id == 'error') {
            $this->layout = 'error_layout';
            return $this->render('error');
        }

        return parent::beforeAction($action);
    }

    public function actionEmail()
    {
        if (Yii::$app->request->isAjax) {
            $email = Yii::$app->request->get('email', 0);
            $model = new \common\models\EmailContact();
            $model->email = $email;
            $model->created_at = time();
            if ($model->validate()) {
                $model->save();
                return json_encode(['code' => 200]);
            } else {
                return json_encode(['code' => 400, 'error' => $model->errors['email'][0]]);
            }
        }
    }

    public function actionSellWithGca()
    {
        return $this->render('sell_with_gca', []);
    }

    public function actionRouterUrl($url, $id = null, $alias = null)
    {
        // $session = Yii::$app->session;
        // $session['adminbk'] = 1;
        if ($url != null) {
            if ($id != null) {
                if ($alias != null) {
                    return $this->redirect(Url::to([$url, 'id' => $id, 'alias' => $alias]));
                } else {
                    return $this->redirect(Url::to([$url, 'id' => $id]));
                }
            } else {
                return $this->redirect(Url::to([$url]));
            }
        }
        return $this->redirect(Url::to(['/']));
    }

    public function actionSetLocation($lat, $lng)
    {
        \Yii::$app->session->open();
        if ($lat && $lng) {
            $location = new \common\models\user\UserAddress();
            $location->latlng = $lat . ',' . $lng;

            $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=" . $location->latlng . "&key=" . \common\components\ClaLid::API_KEY;
            $data = @file_get_contents($url);
            $jsondata = json_decode($data, true);
            print_r($jsondata);
            die();
            if (isset($jsondata['results'][0]['formatted_address'])) {
                $string =  $jsondata['results'][0]['formatted_address'];
                $address = explode(',', $string);
                $len = count($address);
                $location->province_name = isset($address[$len - 2]) ? $address[$len - 2] : '';
                $location->district_name = isset($address[$len - 3]) ? $address[$len - 3] : '';
                $location->ward_name = isset($address[$len - 4]) ? $address[$len - 4] : '';
                $location->address = isset($address[$len - 5]) ? $address[$len - 5] : '';
                $location->user_id = Yii::$app->user->id;
                $_SESSION['got_location'] = time();
                ClaLid::setLocaltionDefault($location);
                return $location->latlng . '&' . $string;
            }
            return '&';
        } else {
            $_SESSION['got_location'] = time();
            return '&';
        }
    }

    public function actionSaveRegisterProduct()
    {
        $model = new \common\models\product\ProductRegisterInfo();
        $model->user_id = Yii::$app->user->id ? Yii::$app->user->id : 0;
        $model->created_at = time();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->session->open();
            $_SESSION['check_register_product'][$model->product_id] = time();
            return 1;
        } else {
            return Yii::t('app', 'check_info');
        }
    }

    public function actionTest()
    {
        return $this->render('test');
    }

    public function actionCheckProduct()
    {
        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();
            $token = isset($post['token']) ? $post['token'] : '';
            $model = PayQrcode::findOne(['token' => $token]);
            if ($model) {
                $return = [
                    'error_code' => 0,
                    'message' => '',
                ];
                $return = array_merge($return, $model->attributes);
            } else {
                $return = [
                    'error_code' => 1,
                    'message' => 'Không tồn tại sản phẩm',
                ];
            }
            return json_encode($return);
        } else {
            return false;
        }
    }
    public function actionPay()
    {
        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();
            $public_key = isset($post['public_key']) ? $post['public_key'] : '';
            $id = isset($post['user_id']) ? $post['user_id'] : '';
            $token = isset($post['token']) ? $post['token'] : '';
            $model = PayQrcode::findOne(['token' => $token]);
            $user = User::findOne($id);
            if ($model && $user) {
                if (md5($user->id . $user->auth_key) == $public_key) {
                    $gcacoin = Gcacoin::findOne(['user_id' => $user->id]);
                    $config = Config::find()->one();
                    $coin = (($model->price) / ($config->money)) * $config->gcacoin;
                    if ($gcacoin->gca_coin >= $coin) {
                        $gcacoin->gca_coin = $gcacoin->gca_coin - $coin;
                        if ($gcacoin->update()) {
                            $return = [
                                'error_code' => 0,
                                'message' => 'Thanh toán thành công.',
                            ];
                            // Đã thanh toán thành công.
                            $data = [
                                'type' => $model->type,
                                'price' => $model->price,
                                'user_id' => $id,
                                'data' => json_decode($model->data, true),
                            ];
                            ClaQrCode::CheckPayment($data);
                        }
                    } else {
                        $return = [
                            'error_code' => 200,
                            'message' => 'Tài khoản của bạn không đủ tiền.'
                        ];
                    }
                }
            } else {
                $return = [
                    'error_code' => 300,
                    'message' => 'Sản phẩm hoặc người dùng không tồn tại.'
                ];
            }
            return json_encode($return);
        } else {
            return false;
        }
    }

    public function actionSetMobile($screen_start_mobile)
    {
        return '';
    }


    // public function actionMoveLatlng() {
    //     $shops= \common\models\shop\Shop::find()->all();
    //     foreach ($shops as $shop) {
    //         echo $shop->latlng;
    //         die();
    //         $latlng = explode(',' , $shop['latlng']);
    //         $lat = isset($latlng[0]) ? $latlng[0] : '';
    //         $lng = isset($latlng[1]) ? $latlng[1] : '';
    //         \Yii::$app->db->createCommand()
    //         ->update('shop', ['lat' => $lat, 'lng' => $lng ], 'id = '.$shop['id'])
    //         ->execute();
    //     }
    //     return '';
    // }
    // public function actionGendb()
    // {
    //     $user = (new \yii\db\Query())->select('user.*, shop.name as name, shop.avatar_path as savatar_path, shop.avatar_name as savatar_name')->from('user')->leftJoin('shop', 'user.id = shop.id')->all();
    //     $data = [];
    //     if($user){
    //         foreach ($user as $item){
    //             $avatar = \common\components\ClaHost::getImageHost() . '/imgs/user_default.png';
    //             if ($item['savatar_name']) {
    //                 $avatar = \common\components\ClaHost::getImageHost() . $item['savatar_path'] . $item['savatar_name'];
    //             } else if ($item['avatar_name']) {
    //                 $avatar = \common\components\ClaHost::getImageHost() . $item['avatar_path'] . $item['avatar_name'];
    //             }
    //             $dt = [
    //                 'id' => $item['id'],
    //                 'name' => str_replace("'","\\'",$item['username']),
    //                 'avatar' => $avatar,
    //                 'shop_name'  => str_replace("'","\\'",$item['name']),
    //             ];
    //             $data[$item['id']] = $dt;
    //         }
    //     }
    //     return print_r(json_encode($data));
    // }

    public function actionGenSitemap()
    {
        $file = '../../sitemap.xml';
        $myfile = fopen($file, "w") or die("Unable to open file!");
        $time =  date('Y-m-d H:i:s');
        $str = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        $domain = '<?= __SERVER_NAME ?>';
        $str .= '<url>
                    <loc>' . $domain . '</loc>
                    <lastmod>' . $time . '</lastmod>
                    <priority>1.00</priority>
                </url>';
        $adds = [
            '/site/contact',
            '/site/about',
            '/login/login/login',
            '/login/login/signup',
            '/product/product/index',
            '/news/news/index',
            '/site/sell-with-gca',
        ];
        foreach ($adds as $key) {
            $str .= '<url>
                    <loc>' . $domain . \yii\helpers\Url::to([$key]) . '</loc>
                    <lastmod>' . $time . '</lastmod>
                    <priority>0.90</priority>
                </url>';
        }
        $list = ['product', 'product_category', 'news', 'news_category', 'shop', 'content_page'];
        foreach ($list as $table) {
            $items = (new \yii\db\Query())->select("id, alias")->from($table)->where("status <> 0 and id > 0")->all();
            $url = '';
            switch ($table) {
                case 'product':
                    $url = '/product/product/detail';
                    break;
                case 'product_category':
                    $url = '/product/product/category';
                    break;
                case 'news':
                    $url = '/news/news/detail';
                    break;
                case 'news_category':
                    $url = '/news/news/category';
                    break;
                case 'shop':
                    $url = '/shop/shop/detail';
                    break;
                case 'content_page':
                    $url = '/content-page/detail';
                    break;
            }
            if ($items) foreach ($items as $item) {
                $str .= '<url>
                            <loc>' . $domain . \yii\helpers\Url::to([$url, 'id' => $item['id'], 'alias' => $item['alias']]) . '</loc>
                            <lastmod>' . $time . '</lastmod>
                            <priority>0.80</priority>
                        </url>';
            }
        }
        $str .= '</urlset>';
        fwrite($myfile, $str);
        fclose($myfile);
        return $this->redirect('/sitemap.xml');
    }

    public function actionSetAdmin()
    {
        \common\components\ClaAll::setAdmin();
        return "Set Success";
    }

    public function actionCharity()
    {
        //
        $this->layout = '@frontend/views/layouts/content_page';
        $siteinfo = \common\components\ClaLid::getSiteinfo();
        Yii::$app->view->title = 'OCOP CHARITY';
        // add meta description
        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => $siteinfo->meta_description
        ]);
        // add meta keywords
        Yii::$app->view->registerMetaTag([
            'name' => 'keywords',
            'content' => $siteinfo->meta_keywords
        ]);
        //
        $page = Yii::$app->request->get('page', 1);
        $limit = 20;
        $sum = \common\models\order\OrderItem::getAllCharity(['status' => \common\models\order\Order::ORDER_DELIVERING, 'sum' => 1]);
        $orders = \common\models\order\OrderItem::getAllCharity([
            'status' => \common\models\order\Order::ORDER_DELIVERING,
            'limit' => $limit,
            'page' => $page,
            'order' => 'id DESC'
        ]);
        $totalitem = \common\models\order\OrderItem::getAllCharity([
            'status' => \common\models\order\Order::ORDER_DELIVERING,
            'count' => 1
        ]);
        return $this->render('charity', [
            'orders' => $orders,
            'limit' => $limit,
            'totalitem' => $totalitem,
            'sum' => $sum,
        ]);
    }
}
