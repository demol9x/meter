<?php
// const LANGUAGE_VI = 'vn';
// $lang = LANGUAGE_VI;
// if(isset($_COOKIE['lang'])) {
//     $lenss =strlen($_COOKIE['lang']);
//     $lang = $_COOKIE['lang'][$lenss -5].$_COOKIE['lang'][$lenss -4];
// }

Yii::setAlias('@root', __DIR__ . '/../..');

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'), require(__DIR__ . '/../../common/config/params-local.php'), require(__DIR__ . '/params.php'), require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'name' => 'METER',
    'language' => 'vi',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        'profile' => [
            'class' => 'frontend\modules\profile\Profile',
        ],
        'package' => [
            'class' => 'frontend\modules\package\Package',
        ],
        'user' => [
            'class' => 'frontend\modules\user\User',
        ],
        'device' => [
            'class' => 'frontend\modules\device\Device',
        ],
        'media' => [
            'class' => 'frontend\modules\media\Media',
        ],
        'shop' => [
            'class' => 'frontend\modules\shop\Shop',
        ],
        'news' => [
            'class' => 'frontend\modules\news\News',
        ],
        'qa' => [
            'class' => 'frontend\modules\qa\QA',
        ],
        'product' => [
            'class' => 'frontend\modules\product\Product',
        ],
        'search' => [
            'class' => 'frontend\modules\search\Search',
        ],
        'login' => [
            'class' => 'frontend\modules\login\Login',
        ],
        'notifications' => [
            'class' => 'frontend\modules\notifications\Notifications',
        ],
        'management' => [
            'class' => 'frontend\modules\management\Management',
            'as beforeRequest' => [
                'class' => 'yii\filters\AccessControl',
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
                'denyCallback' => function () {
                    return Yii::$app->response->redirect('/');
                },
            ],
        ],
        'comment' => [
            'class' => 'yii2mod\comments\Module',
        ],
        'affiliate' => [
            'class' => 'frontend\modules\affiliate\Affiliate',
            'as beforeRequest' => [
                'class' => 'yii\filters\AccessControl',
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
                'denyCallback' => function () {
                    return Yii::$app->response->redirect('/');
                },
            ],
        ],
    ],
    'components' => [
        'i18n' => [
            'translations' => [
                'yii2mod.comments' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@yii2mod/comments/messages',
                ],
                // ...
            ],
        ],
        'user' => [
            'identityClass' => 'frontend\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'class' => 'common\components\Request',
            'web' => '/frontend/web',
            'enableCsrfValidation' => false
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
//            'suffix' => '.html',
//            'rules' => [
//                'danh-sach-yeu-thich' => 'wish/index',
//                'gia-vang'=>'site/gold',
//                // 'tim-kiem'=>'site/search',
//                've-chung-toi' => '/site/about', //
//                'lien-he' => '/site/contact', //
//                'quen-mat-khau' => '/site/request-password-reset', //
//                'cap-nhat-mat-khau' => '/site/reset-password',
//                'dang-nhap' => '/login/login/login', //
//                'dang-ky' => '/login/login/signup', //
//                'thong-tin-ca-nhan' => '/management/profile/index', //
//                'cap-nhat-thong-tin-ca-nhan' => '/profile/profile/update-user', //
//                'don-hang-da-dat' => '/profile/profile/ordered', //
//                'thoat' => '/login/login/logout', //
//                'gio-hang' => '/product/shoppingcart/index', //
//                '<alias>-t<id:\d+>' => '/content-page/detail', //
//                '<alias>-j<id:\d+>' => '/recruitment/recruitment/detail', //
//                'tin-tuc' => '/news/news/index', //
//                '<alias>-nc<id:\d+>' => '/news/news/category', //
//                '<alias>-nd<id:\d+>' => '/news/news/detail', //
//                '<alias>-p<id:\d+>' => '/product/product/detail', //
//                'san-pham' => '/product/product/index', //
//                '<alias>-c<id:\d+>' => '/product/product/category', //
//                '<alias>-b<id:\d+>' => '/product/product/brand', //
//                '<alias>-<cat_alias>-b<id:\d+>c<cat_id:\d+>' => '/product/product/brand-category', //
//                '<controller:\w+>/<id:\d+>' => '<controller>/view',
//                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
//                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
//                'video' => '/media/video/index',
//                '<alias>-v<id:\d+>' => '/media/video/detail',
//                '<alias>-cv<id:\d+>' => '/media/video/category',
//                'tao-gian-hang' => '/management/shop/create',
//                'ho-so-gian-hang' => '/management/shop/update',
//                'anh-gian-hang' => '/management/shop/image',
//                'sua-tin' => '/management/product/update',
//                'dang-tin' => '/management/product/create',
//                '<alias>-shop<id:\d+>' => '/shop/shop/detail',
//                'quan-ly-san-pham' => '/management/product/index',
//                'goi-y-hom-nay' => '/product/product/suggest',
//                'san-pham' => '/product/product/index',
//                'dat-hang' => 'product/shoppingcart/checkout',
//                'cau-hoi-thuong-gap' => 'qa/qa/index',
//                '<alias>-qac<id:\d+>' => 'qa/qa/category',
//                '<alias>-qa<id:\d+>' => 'qa/qa/detail',
//                '<alias>-km<id:\d+>' => 'product/product-promotion/detail',
//                'khuyen-mai-ocop-lg<id:\d+>' => 'product/product-promotion/langdingpage',
//                'don-hang' => 'management/order/index',
//                'dia-chi-giao-hang' => 'product/shoppingcart/ship-address',
//                'kiem-tra-don-hang' => 'management/order/view',
//                'dat-hang-thanh-cong' => 'product/shoppingcart/success',
//                'tim-kiem' => 'search/search/index',
//                'tim-kiem-gian-hang' => 'search/search/shop',
//                'thong-bao-cua-toi' => 'management/notifications/index',
//                'dia-chi-gian-hang' => 'management/shop-address/index',
//                'them-dia-chi-gian-hang' => 'management/shop-address/create',
//                'cap-nhap-dia-chi-gian-hang-s<id:\d+>' => 'management/shop-address/update',
//                'cai-dat-van-chuyen' => 'management/shop-transport/index',
//                'danh-gia-shop' => 'management/shop/rate',
//                'dia-chi-ca-nhan' => 'management/user-address/index',
//                'them-dia-chi-ca-nhan' => 'management/user-address/create',
//                'cap-nhap-dia-chi-ca-nhan-u<id:\d+>' => 'management/user-address/update',
//                'doi-mat-khau' => 'management/profile/change-password',
//                'tai-khoan-ngan-hang' => 'management/user-bank/index',
//                'them-tai-khoan-ngan-hang' => 'management/user-bank/create',
//                'cap-nhap-tai-khoan-ngan-hang-bk<id:\d+>' => 'management/user-bank/update',
//                'vi-v' => 'management/gcacoin/index',
//                'ban-hang' => 'site/sell-with-gca',
//                'xu-khoa' => 'management/gcacoin/confinement',
//                'quan-ly-affiliate' => 'affiliate/affiliate-link/index',
//                'them-link-affiliate' => 'affiliate/affiliate-link/add',
//                'tong-quan-affiliate' => 'affiliate/affiliate/overview',
//                'thong-ke-affiliate' => 'affiliate/affiliate/report-order',
//                'ma-khuyen-mai' => 'management/discount-code/index',
//                'them-ma-khuyen-mai' => 'management/discount-code/create',
//                'xoa-ma-khuyen-mai' => 'management/discount-code/delete',
//                'xoa-nhieu-ma-khuyen-mai' => 'management/discount-code/delete-all',
//            ],
        ],
        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'jsOptions' => [ 'position' => \yii\web\View::POS_HEAD],
                    'js' => [
                        // 'jquery.min.js'
                        '../../js/jquery.min.js'
                    ]
                ],
            ],
        ],
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'facebook' => [
                    'class' => 'yii\authclient\clients\Facebook',
                    'clientId' => '746443348701430',
                    'clientSecret' => '4fb5b9b5a56093d406706150dd6d1e56',
                ],
//                'google' => [
//                    'class' => 'yii\authclient\clients\Google',
//                    'clientId' => '441640083791-shtl3af840g0g6712c6qci7ddpobv3in.apps.googleusercontent.com',
//                    'clientSecret' => 'dMXGAByrwPjfoMth9GewqaVL',
//                ],
            // etc.
            ],
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com', // e.g. smtp.mandrillapp.com or smtp.gmail.com
                // 'username' => 'nanowebvn5@gmail.com',
                // 'password' => 'nano6868',
                'username' => 'info@ocopmart.org',
                // 'password' => 'ocopvn2020',
                'password' => 'ceztdfvewamrcqfs',
                'port' => '587', // Port 25 is a very common port too
                'encryption' => 'tls', // It is often used, check your provider or mail server specs
            ],
        ],
    ],
    'params' => $params,
];
