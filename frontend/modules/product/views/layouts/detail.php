<?php $this->beginContent('@frontend/views/layouts/main.php'); ?>
<link rel="stylesheet" href="<?= yii::$app->homeUrl?>css/chitietthietbicn.css">
<link rel="stylesheet" href="<?= yii::$app->homeUrl?>css/binhluan.css">
<link rel="stylesheet" href="<?= yii::$app->homeUrl?>css/popup_chitietthietbicn.css">
<?= $content; ?>
<?php $this->endContent(); ?>