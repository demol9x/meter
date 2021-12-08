
<?php if (isset($data) && $data) {
  ?>
<?php foreach ($data as $tg) {
    $banner->setAttributeShow($tg);

?>
<div id="banner_qc_mobile" class="site51_html_col0_taiappmeter" style="background-image: url(<?= $banner->src ?>) ">
    <div class="container_fix">
        <h2 class="title-icon title_30"><?= $banner['name'] ?></h2>
        <p class="content_16"><?= $banner['description']?></p>
        <div class="link_app">
            <a href="" class="btn-app "><img src="<?= yii::$app->homeUrl?>images/button1.png" alt=""></a>
            <a href="" class="btn-app "><img src="<?= yii::$app->homeUrl?>images/button2.png" alt=""></a>
        </div>
    </div>
</div>
<?php }?>
<?php } ?>