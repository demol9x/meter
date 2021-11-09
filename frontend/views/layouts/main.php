<?php
$_SESSION['backUrl'] = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

$AppAsset = '\frontend\assets' . '\\' . 'AppAsset';
if (isset($this->dynamicPlaceholders['asset'])) {
    $AppAsset = '\frontend\assets' . '\\' . $this->dynamicPlaceholders['asset'];
}

use yii\helpers\Html;

$AppAsset::register($this);
$siteinfo = common\components\ClaLid::getSiteinfo();
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head itemscope itemtype="http://schema.org/WebSite">
    <meta charset="<?= Yii::$app->charset ?>">
    <?php if (\common\components\ClaSite::isMobile()) { ?>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1,user-scalable=0" />
    <?php } else { ?>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php } ?>
    <link rel="shortcut icon" type="image/png" href="<?= $siteinfo->favicon ?>" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <script type="text/javascript">
        var baseUrl = '<?= Yii::$app->homeUrl ?>';
    </script>
    <script type="text/javascript">
        function addCart(_this, id) {
            _this.attr('onclick', 'return false;');
            _this.html('Đã thêm  <i class="fa fa-shopping-cart"></i>');
            var href = '<?= \yii\helpers\Url::to(['/product/shoppingcart/add-cart']) ?>';
            loadAjax(href, {
                ajax: 1,
                id: id,
                quantity: 1
            }, $('#box-shopping-cart, .number-index-shop'));
            return false;
        };

        function formatMoney(a, c, d, t) {
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
    <style>
        .bg-pop-white>div {
            position: relative;
            z-index: 1;
        }
    </style>
</head>

<body class="home">
    <h1 style="line-height: 0px;opacity: 0; filter: alpha(opacity=0); text-indent: -9999px;margin: 0px;"><?= $this->title ?></h1>

    <?= $this->render('partial/popup'); ?>

    <?php
    if (\common\components\ClaSite::isMobile()) {
        echo $this->render('partial/box-search-mobile');
    }
    ?>

    <div class="wapper">

        <?php $this->beginBody() ?>

        <?php if (\common\components\ClaSite::isMobile() && !(Yii::$app->controller->action->id == 'index' && Yii::$app->controller->id == 'site')) {
            echo $this->render('partial/top-mobilein'); ?>
            <style type="text/css">
                body .wapper {
                    margin-top: 0px;
                }

                body .front-back-page {
                    top: 0px;
                }
            </style>
        <?php } ?>

        <?php
        if (Yii::$app->session->getAllFlashes()) {
            foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
                echo '<div class="alert alert-' . $key . '">' . $message . '<span class="close-alert">x</span></div>';
            } ?>
            <style>
                .alert-error {
                    color: red;
                    position: fixed;
                    top: 50px;
                    z-index: 999999;
                    background: #fff;
                    border: 1px solid;
                    margin: auto;
                    right: 0px;
                    left: 0px;
                    max-width: 90%;
                    width: 800px;
                }

                .close-alert {
                    color: #000;
                    position: absolute;
                    top: 0px;
                    cursor: pointer;
                    padding: 0px 10px;
                    right: 0px;
                }
            </style>
            <script>
                $('.close-alert').click(function() {
                    $(this).closest('.alert').remove();
                });
            </script>
        <?php } ?>

        <?= $this->render('partial/getLocation'); ?>

        <?php if (!\common\components\ClaSite::isActiceApp()) { ?>
            <?= $this->render('partial/header'); ?>
            <?= $this->render('partial/box-index'); ?>
        <?php }
        ?>

        <?= $content ?>

        <?php if (\common\components\ClaSite::isMobile() && !(Yii::$app->controller->action->id == 'index' && Yii::$app->controller->id == 'site')) {
            echo '<div class="not-footer"></div>';
        } else {
            echo $this->render('partial/footer');
        } ?>

        <div class="scroll-top-btn">
            <img src="<?= Yii::$app->homeUrl ?>images/btn-totop.png" alt="">
        </div>

        <?php //echo $this->render('partial/chat'); 
        ?>

        <?= Yii::$app->user->id ? '' : $this->render('partial/signup'); ?>

        <?= (\common\components\ClaSite::isMobile()) ? $this->render('partial/menu_mobile') : '' ?>

        <?php $this->endBody() ?>
    </div>

    <?= $this->render('partial/add_js_all'); ?>

</body>

</html>
<?php $this->endPage() ?>