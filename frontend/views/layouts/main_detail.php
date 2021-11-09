<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAssetDetailProduct;
use common\widgets\Alert;

AppAssetDetailProduct::register($this);
$siteinfo = common\components\ClaLid::getSiteinfo();
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" type="image/png" href="<?= $siteinfo->favicon ?>"/>
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body class="home">
        <?php $this->beginBody() ?>
        
        <?= Yii::$app->user->getId() ? '' : $this->render('partial/signup'); ?>

        <?= $this->render('partial/menu_mobile'); ?>
        

        <?= $this->render('partial/header'); ?>

        <?= $content ?>

        <?= $this->render('partial/footer'); ?>

        <?php $this->endBody() ?>
    </body>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.open-popup-link').magnificPopup({
                type: 'inline',
                midClick: true // allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source.
            });
            $(".height-fix").height($(".height-fix").width() * 0.979);
            $(".owl-product-index").owlCarousel({
                items: 4,
                lazyLoad: true,
                navigation: true,
                pagination: false,
                autoPlay: false,
                paginationSpeed: 500,
                navigationText: ["<span class='fa fa-angle-left'></span>", "</span><span class='fa fa-angle-right'></span>"],
                scrollPerPage: true,
                itemsDesktop: [1200, 4],
                itemsDesktopSmall: [992, 3],
                itemsTablet: [767, 2],
                itemsMobile: [560, 1],
            });
            $(".owl-product-trangsuc").owlCarousel({
                items: 4,
                lazyLoad: true,
                navigation: true,
                pagination: false,
                autoPlay: false,
                paginationSpeed: 500,
                navigationText: ["<span class='fa fa-angle-left'></span>", "</span><span class='fa fa-angle-right'></span>"],
                scrollPerPage: true,
                itemsDesktop: [1200, 4],
                itemsDesktopSmall: [992, 3],
                itemsTablet: [767, 2],
                itemsMobile: [560, 1],
            });
            $(".owl-single-cate").owlCarousel({
                navigation: false, // Show next and prev buttons
                pagination: true,
                slideSpeed: 300,
                paginationSpeed: 400,
                singleItem: true
            });
            $(".fix-height-auto").height($(".fix-height-auto").width());
            if ($(window).width() > 560) {
                $(".item-categories").height($(".item-categories").width() * 0.7);
            }
        });
    </script>
    <script>
        function backtotop() {
            $('html, body').animate({scrollTop: 0}, 'slow');
        }
    </script>
    <script src="<?= Yii::$app->homeUrl ?>js/main.js"></script>
</html>
<?php $this->endPage() ?>
