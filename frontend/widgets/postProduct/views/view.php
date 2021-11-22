<link rel="stylesheet" href="<?php echo Yii::$app->homeUrl ?>css/style-news.css"/>
<div class="container product_submission">
    <form action="<?php \yii\helpers\Url::to(['/']) ?>" method="POST" enctype="multipart/form-data">
        <div class="post-bg-title">
            <h1 class="bluecolor">Đăng tin rao bán, cho thuê nhà đất</h1>
            <div class="graycolor">
                (Quý vị nhập thông tin nhà đất cần bán hoặc cho thuê vào các mục dưới đây)
            </div>
        </div>
        <?= $this->render('partials/basic_info', ['data' => $data, 'provinces' => $provinces, 'huong_nha' => $huong_nha]); ?>
        <?= $this->render('partials/description', ['data' => $data, 'provinces' => $provinces, 'huong_nha' => $huong_nha]); ?>
        <?= $this->render('partials/other_info', ['data' => $data, 'provinces' => $provinces, 'huong_nha' => $huong_nha]); ?>
        <?= $this->render('partials/media', ['data' => $data, 'provinces' => $provinces, 'huong_nha' => $huong_nha]); ?>
        <?= $this->render('partials/map', ['data' => $data, 'provinces' => $provinces, 'huong_nha' => $huong_nha]); ?>
        <?= $this->render('partials/contact', ['data' => $data, 'provinces' => $provinces, 'huong_nha' => $huong_nha]); ?>
        <?= $this->render('partials/schedule', ['data' => $data, 'provinces' => $provinces, 'huong_nha' => $huong_nha]); ?>
        <button type="submit">Đăng tin không cần tài khoản</button>
    </form>
    <script>

    </script>
</div>