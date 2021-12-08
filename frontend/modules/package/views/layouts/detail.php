<?php $this->beginContent('@frontend/views/layouts/main.php'); ?>
    <link rel="stylesheet" href="<?= yii::$app->homeUrl?>css/chitietgoithau.css">
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

<?= $content; ?>
<?php $this->endContent(); ?>