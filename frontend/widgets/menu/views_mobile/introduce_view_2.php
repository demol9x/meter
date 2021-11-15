<?php if (isset($data) && $data) { ?>
<div class="giatri" style="background-image:url('<?= yii::$app->homeUrl?>images/bg_giatri.png')">
    <div class="container_fix">
        <div class="giatri__content">
            <h2 class="title_30"><?= $this->title ?></h2>
            <?php
                $i=3;
                foreach ($data as $menu){
                    $i+2;
                ?>
            <div class="giatri__content-item">
                <div class="giatri__content-item__icon wow bounceIn" data-wow-delay="0.<?= $i;?>s">
                    <img src="<?= common\components\ClaHost::getImageHost(), $menu['avatar_path'], $menu['avatar_name'] ?>" alt="<?= $menu['name']?>">
                </div>
                <div class="giatri__content-item__text wow slideInRight" data-wow-delay="0.<?= $i++;?>s">
                    <h4 class="title_21"><?= $menu['name']?></h4>
                    <p class="content_16"><?= $menu['description']?></p>
                </div>
            </div>
                <?php }?>
        </div>
    </div>
</div>
<?php } ?>