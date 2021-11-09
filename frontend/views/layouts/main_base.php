<?php
\Yii::$app->session->open();
$_SESSION['backUrl'] = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
\Yii::$app->session->close();
/* @var $this \yii\web\View */
/* @var $content string */
// $AppAsset = 'AppAssetDetailProduct';
$AppAsset = '\frontend\assets' . '\\' . 'AppAsset';
if (isset($this->dynamicPlaceholders['asset'])) {
    $AppAsset = '\frontend\assets' . '\\' . $this->dynamicPlaceholders['asset'];
}

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

$AppAsset::register($this);
$siteinfo = common\components\ClaLid::getSiteinfo();
// echo $AppAsset;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <?php if (\common\components\ClaSite::isMobile()) { ?>
            <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1,user-scalable=0"/>
        <?php } else { ?>
            <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php } ?>
        <link rel="shortcut icon" type="image/png" href="<?= $siteinfo->favicon ?>"/>
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>

        <?= $this->render('partial/app'); ?>
        <script type="text/javascript">
            var baseUrl = '<?= Yii::$app->homeUrl ?>';
        </script>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-119180471-1"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', 'UA-119180471-1');
        </script>
        <script type="text/javascript">
            function formatMoney(a,c, d, t){
                var n = a, 
                c = isNaN(c = Math.abs(c)) ? 2 : c, 
                d = d == undefined ? "." : d, 
                t = t == undefined ? "," : t, 
                s = n < 0 ? "-" : "", 
                i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))), 
                j = (j = i.length) > 3 ? j % 3 : 0;
               return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
            };
            function initMap() {}        
        </script>
    </head>
    <body class="home">
        <h1 style="line-height: 0px;opacity: 0; filter: alpha(opacity=0); text-indent: -9999px;margin: 0px;"><?= $this->title ?></h1>

        <?= $this->render('partial/popup'); ?>

        <?= $content ?>

        <?= $this->endBody() ?>

        <?= $this->render('partial/add_js_all'); ?>

    </body>
</html>
<?php $this->endPage() ?>
