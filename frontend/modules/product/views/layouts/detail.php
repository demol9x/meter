<?php $this->beginContent('@frontend/views/layouts/main.php'); ?>
<link rel="stylesheet" href="<?= yii::$app->homeUrl?>css/chitietgoithau.css">
<?= $content; ?>
<?php $this->endContent(); ?>