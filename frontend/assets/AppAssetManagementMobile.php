<?php

namespace frontend\assets;

use frontend\assets\FrontendAsset;

/**
 * Main frontend application asset bundle.
 */
class AppAssetManagementMobile extends FrontendAsset
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/vensdor/bootstrap.css?v='.self::version,
        'css/vensdor/all_plugin.css?v='.self::version,
        'css/vensdor/animate.css?v='.self::version,
        'css/vensdor/slick.css',
        'css/vensdor/magnific-popup.css',
        //crop
            // 'css/crop/cropper.css?v='.self::version,
            // 'css/crop/crop.css?v='.self::version,
        //end
        'css/style.css?v='.self::version,
        'css/fix.css?v='.self::version,
        'css/style-mobile.css?v='.self::version,
        'css/fix_ipad.css?v='.self::version,

    ];
    public $js = [
        'js/bootstrap.min.js',
        'js/wow.min.js',
        'js/slick.min.js',
        'js/jquery.nice-select.js',
        'js/jquery.magnific-popup.min.js',
        'js/owl.carousel.min.js',
        'js/countdown-timer.js',
        //crop
            // 'js/crop/bootstrap.bundle.min.js',
            // 'js/crop/cropper.js',
            // 'js/crop/crop.js',
        //end
        'js/add.js?v='.self::version,
        'js/main.js?v='.self::version,
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
