<?php
//die();
const MAX_QUANTITY_PRODUCT = 1000000000000;
const __SERVER_NAME = 'http://meter.nanoweb.vn';
const __NAME = 'meter.nanoweb.vn';
const __NAME_SITE = 'meter';
const __VOUCHER = 'OV';
const __VOUCHER_RED = 'OVr';
const __VOUCHER_SALE = 'E.OV';
const __TOKEN_BLOCKCHECK = 'vzoneland-123X11@!@#2d$$';
const __API_GETPRODUCT_BLOCKCHECK = 'https://blockcheck.vn/api/products/check-all-vzoneland'; //Lấy dữ liệu sản phẩm trên blockcheck
const __API_BUSSINES_BLOCKCHECK = 'https://blockcheck.vn/api/eCommercePlatforms/submit-vzonelane'; //Lấy trạng thái đăng ký doanh nghiệp trên blockcheck

function __removeDF($string)
{
    return str_replace("'", '', $string);
}

function __setUrlBack($url = '')
{
    \Yii::$app->session->open();
    $_SESSION['back_url_login'] = $url ? $url : (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
}

function __getUrlBack($url = '')
{
    \Yii::$app->session->open();
    return isset($_SESSION['back_url_login']) && $_SESSION['back_url_login'] ? $_SESSION['back_url_login'] : '';
}

function Trans($vi, $en)
{
    if (Yii::$app->getRequest()->getCookies()->has('lang')) {
        $lang = Yii::$app->getRequest()->getCookies()->getValue('lang');
    } else {
        $lang = LANGUAGE_VI;
    }
    return $en ? $$lang : $vi;
}

$config =  [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=150.95.108.45;dbname=meter',
            'username' => 'user_meter',
            'password' => 'xXLGTMrQ5rdZMBTMuqNP',
            'charset' => 'utf8',
        ],
        'cache' => [
            'useMemcached' => false,
            'keyPrefix' => __NAME_SITE,
            'class' => 'yii\caching\MemCache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager'
        ],

        //
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                    //                    'sourceLanguage' => 'vi',
                    //                    'fileMap' => [
                    //                        'app' => 'app.php',
                    //                        'news' => 'news.php',
                    //                        'product' => 'product.php',
                    //                    ],
                ],
            ],
        ],
    ],
];
return $config;
