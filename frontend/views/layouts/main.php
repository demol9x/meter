<?php
/* @var $this \yii\web\View */
/* @var $content string */

use common\components\ClaLid;
use frontend\assets\AppAsset;


AppAsset::register($this);
$siteinfo = common\components\ClaLid::getSiteinfo();
?>
<?php $this->beginPage()?>
    <!DOCTYPE html>
    <html lang="<?=Yii::$app->language?>">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title><?=$this->title?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" type="image/png" href="<?=$siteinfo->favicon?>" />
        <script src="<?= yii::$app->homeUrl?>js/jquery-3.6.0.js"></script>
        <?php $this->head()?>

    </head>
    <body>
    <?php $this->beginBody()?>
    <?php if (Yii::$app->session->getFlash('success')) { ?>
        <div class="set-flash">
            <div class="flash-set-flex content_14">
                <?php echo Yii::$app->session->getFlash('success'); ?>
                <div class="flash-ok">
                    Xác nhận
                </div>
            </div>
        </div>
    <?php } ?>

    <?php echo $this->render('partial/header', ['siteinfo' => $siteinfo]) ?>
    <?=$content?>
    <?php echo $this->render('partial/footer', ['siteinfo' => $siteinfo]) ?>

    <?= $this->render('partial/add_js_all'); ?>
    <?php $this->endBody()?>
    </body>

    </html>
<?php $this->endPage()?>