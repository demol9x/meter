<?php $this->beginContent('@frontend/views/layouts/main.php'); ?>
    <link rel="stylesheet" type="text/css" href="<?= yii::$app->homeUrl ?>css/list_packages.css">
<?php //Menu main
echo frontend\widgets\banner\BannerWidget::widget([
    'view' => 'banner-main-in',
    'group_id' => 5,
])
?>
<?= $content; ?>


<?php $this->endContent(); ?>