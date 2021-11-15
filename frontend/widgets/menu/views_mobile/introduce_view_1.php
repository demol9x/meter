<?php if (isset($data) && $data) { ?>
<div class="tienich" style="background-image:url('<?= yii::$app->homeUrl?>images/mask-gt.png')">
    <div class="container_fix">
        <div class="tienich__row">
            <?php
            $i=3;
                foreach ($data as $menu){
                    $i+2;
            ?>
            <div class="tienich__row--item wow bounceIn" data-wow-delay="0.<?= $i?>s">
                <div class="item--img">
                    <img src="<?= common\components\ClaHost::getImageHost(), $menu['avatar_path'], $menu['avatar_name'] ?>" alt="<?= $menu['name']?>">
                </div>
                <p class="content_16"><?= $menu['name']?></p>
            </div>
            <?php }?>
        </div>
    </div>
</div>
<?php } ?>