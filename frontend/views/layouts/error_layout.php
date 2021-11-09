
<?php $this->beginContent('@frontend/views/layouts/main.php'); ?>
<div id="main">
    <div class="page-404">
        <div class="container">
            <div class="img-404">
                <img src="<?= Yii::$app->homeUrl ?>images/404.png" alt="">
            </div>
            <h1>
                Trang mà bạn truy cập không còn tồn tại hoặc đã được chuyển sang địa chỉ khác
            </h1>
            <a href="<?= Yii::$app->homeUrl ?>" class="come-back-home">Trở về trang chủ</a>
        </div>
    </div>
</div>
<?php $this->endContent(); ?>
