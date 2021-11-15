<?php

use yii\helpers\Url;
use common\components\ClaHost;

if (isset($shop) && $shop) {?>
<div class="pro_package">
    <div class="pro_content">
        <div class="content_text"><h3>nhà thầu</h3></div>
        <a class="content_viewall" href=""><span>Xem tất cả</span><i class="far fa-chevron-right"></i></a>
    </div>
    <div class="pro_flex">
    <?php
    $i=1;
    foreach ($shop as $shopt) {
        $i+2;
        $url = \yii\helpers\Url::to(['/product/product/detail', 'id' => $shopt['id'], 'alias' => $shopt['alias']]);
        ?>
        <div class="pro_card wow fadeIn"  data-wow-delay="0.<?= $i ?>s">
            <a href="<?= $url ?>">
                <div class="card_img">
                    <img src="<?= ClaHost::getImageHost(). $shopt['avatar_path']. $shopt['avatar_name'] ?>" alt="<?= $shopt['name'] ?>">
                </div>
                <div class="card_text">
                    <div class="title"><?= $shopt['name'] ?></div>
                    <div class="adress"><span><?= $shopt['province_name'] ?></span><span><i class="fas fa-star"></i><?= $shopt['rate'] ?>/5</span></div>

                </div>
            </a>
            <div class="heart">
                <a href="" class="add_tim active"><img class="img_add_tim" src="<?= Yii::$app->homeUrl ?>images/tim.png" alt=""></a>
                <a href="" class="add_tim_1"><i class="fas fa-heart"></i></a>
            </div>
            <?php if(isset($shopt['ishot']) && $shopt['ishot']==1){?>
                <div class="hot_product"><img src="<?= Yii::$app->homeUrl ?>images/hot_product.png" alt=""></div>
            <?php }?>
        </div>
    <?php }?>
    </div>
</div>
<?php } ?>