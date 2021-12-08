<?php if (isset($data) && $data) { ?>
    <div class="site51_bann_col0_slide">
        <div class="back_ground"><img src="<?= yii::$app->homeUrl ?>images/back_gruond_color.png"></div>
        <div class="slide_home">
            <?php foreach ($data as $tg) {
                $banner->setAttributeShow($tg); ?>
                <div class="bann_img">
                    <img src="<?= $tg['src']?>" alt="<?= $tg['name']?>">
                </div>
            <?php } ?>
        </div>
        <div class="container_fix">
            <div class="bann_text">
                <?=
                    $tg['description'];
                ?>
                <div class="bann_flex">
                    <a href="<?= \yii\helpers\Url::to(['/package/package/index'])?>">XEM NGAY</a><a href="<?= \yii\helpers\Url::to(['/site/contact'])?>">LIÊN HỆ</a>
                </div>
            </div>
        </div>
    </div>
<?php } ?>