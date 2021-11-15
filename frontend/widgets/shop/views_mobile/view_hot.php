

<?php

use yii\helpers\Url;
use common\components\ClaHost;

if (isset($products) && $products) {?>
    <div class="pro_package">
        <div class="pro_content">
            <div class="content_text"><h3>gói thầu</h3></div>
            <a class="content_viewall" href=""><span>Xem tất cả</span><i class="far fa-chevron-right"></i></a>
        </div>
        <div class="pro_flex">
            <?php
            foreach ($products as $product) {
                $url = \yii\helpers\Url::to(['/product/product/detail', 'id' => $product['id'], 'alias' => $product['alias']]);
                ?>
                <div class="pro_card wow fadeIn"  data-wow-delay="0.3s">
                    <a href="<?= $url ?>">
                        <div class="card_img">
                            <img src="<?= ClaHost::getImageHost(), $product['avatar_path'], $product['avatar_name'] ?>" alt="<?= $product['name'] ?>">
                        </div>
                        <div class="card_text">
                            <div class="title"><?= $product['name'] ?></div>
                            <div class="adress"><span>Hà Nội</span><span>60km</span></div>
                            <div class="date_time"><img src="<?= Yii::$app->homeUrl ?>images/time_pro.png" alt=""><span><?= date('d',$product['created_at'])?></span>-<span><?= date('m',$product['created_at'])?></span>-<span><?= date('Y',$product['created_at'])?></span></div>
                        </div>
                    </a>
                    <div class="heart">
                        <a href="" class="add_tim active"><img class="img_add_tim" src="<?= Yii::$app->homeUrl ?>images/tim.png" alt=""></a>
                        <a href="" class="add_tim_1"><i class="fas fa-heart"></i></a>
                    </div>
                    <div class="hot_product"><img src="<?= Yii::$app->homeUrl ?>images/hot_product.png" alt=""></div>
                </div>
            <?php }?>
        </div>
    </div>
<?php } ?>