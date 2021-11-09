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
        'css/vensdor/bootstrap.css?v='.self::version,
        'css/vensdor/all_plugin.css?v='.self::version,
        'css/vensdor/animate.css?v='.self::version,
        'css/vensdor/owl.carousel.min.css',
        'css/vensdor/owl.theme.default.min.css',
        'css/vensdor/magnific-popup.css',
        'css/style.css?v='.self::version,
        'css/fix.css?v='.self::version,
        'css/style-mobile.css?v='.self::version,
        'css/fix_ipad.css?v='.self::version,

    ];
    public $js = [
        'js/owl.carousel.min.js',
        'js/jquery.lazy.min.js',
        'js/echo.js',
        'js/bootstrap.min.js',
        'js/wow.min.js',
        'js/jquery.nice-select.js',
        'js/jquery.magnific-popup.min.js',
        'js/countdown-timer.js',
        'js/fancybox/jquery.fancybox.min.js',
        'js/theia-sticky-sidebar.js',
        'js/bootstrap.bundle.min.js',
        'js/jquery.easing.min.js',
        'js/scrolling-nav.js',
        'js/add.js?v='.self::version,
        'js/main.js?v='.self::version,
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}