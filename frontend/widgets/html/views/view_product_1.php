<?php

use common\components\ClaHost;
use common\models\product\Product; ?>
<div class="pro_flex <?=(isset($slide) && $slide) ? $slide : ''?>" id="wrapper">
    <?php
    $i = 1;
    foreach ($products as $product) {
        $price_market = $product['price_market'];
        $text_price_market = Product::getTextByPriceCustom($product['price_market']);
        $price = $product['price'];
        $text_price = Product::getTextByPriceCustom($product['price']);
        $i + 2;
        $link = \yii\helpers\Url::to(['/product/product/detail', 'id' => $product['id'], 'alias' => $product['alias']]);
        ?>
        <div class="pro_card wow fadeIn" data-wow-delay="0.<?= $i ?>s">
            <a href="<?php echo $link ?>">
                <div class="card_img">
                    <img src="<?= ClaHost::getImageHost(), $product['avatar_path'] . $product['avatar_name'] ?>"
                         alt="<?= $product['name'] ?>">
                </div>
                <div class="card_text">
                    <div class="title"><?php echo $product['name'] ?></div>
                    <div class="pro_price">
                        <span><?php echo $text_price ?></span><span><?php echo $text_price_market ?></span>
                    </div>
                    <div class="pro_exchange"><span><i class="fas fa-star"></i><?= $product['rate_count'] ?$product['rate_count'] : 0 ?>/5</span><span>Đã bán <?=$product['total_buy']?></span>
                    </div>
                </div>
            </a>
            <label class="heart wishlist">
                <?php if (isset(Yii::$app->user->id) && Yii::$app->user->id) { ?>
                    <?php if (Product::inWish2($product['id'])) { ?>
                        <div class="check">
                            <span class="iuthik2"><i class="fal fa-heart active" onclick="removeLike(<?= $product['id'] ?>, $(this));" alt="Xóa khỏi danh sách yêu thích"></i></span>
                        </div>
                    <?php } else { ?>
                        <div class="check">
                            <span class="iuthik2"><i class="fal fa-heart" onclick="addLike(<?= $product['id'] ?>, $(this));" alt="Thêm vào yêu thích"></i></span>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <div class="check">
                        <span class="iuthik2"><i class="fal fa-heart" onclick="loginLike($(this));" alt="Thêm vào yêu thích"></i></span>
                    </div>
                <?php } ?>

            </label>
            <?php if (isset($product['ishot']) && $product['ishot']==1) { ?>
                <div class="hot_product"><img src="<?= yii::$app->homeUrl ?>images/hot_product.png" alt="icon"></div>
            <?php } ?>
        </div>
    <?php } ?>
</div>
<style>
    .iuthik2 i {
        color: #289300;
        font-size: 21px;
    }
    .iuthik2 i:hover, .iuthik2 i.active {
        font-weight: 900;
    }
</style>
