<?php

namespace frontend\assets;

use frontend\assets\FrontendAsset;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends FrontendAsset
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/style.css',
        'css/animate.css',
        'css/header.css?v='.self::version,
        'css/footer.css?v='.self::version,
        'css/index.css?v='.self::version,
        'css/reset.css?v='.self::version,
        'css/slick/slick.css',
        'css/slick/slick-theme.css',
        'css/pwsTab/jquery.pwstabs.css',
        'css/fancybox/jquery.fancybox.css',
        'css/view.css?v='.self::version,
        'css/font-awesome/css/fontawesome.pro.min.css',
        'css/fix.css',
    ];
    public $js = [
        'js/slick.min.js',
        'js/main.js?v='.self::version,
        'js/wow.min.js',
        'js/jquery.pwstabs.js',
        'js/jquery.fancybox.js',
        'js/backend_js.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}