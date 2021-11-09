<?php
const MAX_QUANTITY_PRODUCT = 1000000000000;
const __SERVER_NAME = 'http://ocopmart-dev.vn';
const __VOUCHER = 'V';
const __VOUCHER_RED = 'Vr';
const __VOUCHER_SALE = 'Vs';

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
            'dsn' => 'mysql:host=127.0.0.1;dbname=meter',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],
        'cache' => [
            'useMemcached' => false,
            'keyPrefix' => 'ocmain',
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
