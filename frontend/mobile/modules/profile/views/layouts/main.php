<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAssetProfile;
use common\widgets\Alert;

AppAssetProfile::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i&subset=latin-ext,vietnamese" rel="stylesheet">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body class="home">
        <?php $this->beginBody() ?>
        <div class="add-fix visible-xs visible-sm hidden-lg">
            <div class="menu-wrap">
                <nav class="menu">
                    <div class="icon-list">
                        <a href="#"><span>Tất cả việc làm</span></a>
                        <a href="#"><span>Giới thiệu</span></a>
                        <a href="#"><span>Phúc lợi</span></a>
                        <a href="#"><span>Liên hệ</span></a>
                    </div>
                </nav>
                <button class="close-button" id="close-button">Close Menu</button>
                <div class="morph-shape" id="morph-shape" data-morph-open="M-7.312,0H15c0,0,66,113.339,66,399.5C81,664.006,15,800,15,800H-7.312V0z;M-7.312,0H100c0,0,0,113.839,0,400c0,264.506,0,400,0,400H-7.312V0z">
                    <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 100 800" preserveAspectRatio="none">
                    <path d="M-7.312,0H0c0,0,0,113.839,0,400c0,264.506,0,400,0,400h-7.312V0z"/>
                    </svg>
                </div>
            </div>
            <div class="container rev-styl">
                <button class="menu-button" id="open-button">Open Menu</button>
            </div>
        </div>
        <div class="content-wrap">
            <div class="content">
                <?= $this->render('@frontend/views/layouts/partial/header_not_filter'); ?>
                <?= $content ?>
                <?= $this->render('@frontend/views/layouts/partial/footer'); ?>
            </div>
        </div>

        <?php $this->endBody() ?>
    </body>
    <script type="text/javascript">
        new WOW().init();
    </script>
</html>
<?php $this->endPage() ?>











