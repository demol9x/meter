<?php

use yii\helpers\Url;
use common\components\ClaHost;
$province = \common\models\Province::optionsProvince();
$shop = \common\models\shop\Shop::optionsShop();
$wish = \common\models\product\ProductWish::getWishAllByUser();
?>
<?php 
    if(isset($products) && count($products)) {
        foreach ($products as $product) if($product['quantity_promotion_sale']){
            $url = Url::to(['/product/product/detail', 'id' => $product['id'], 'alias' => $product['alias']]);
            $price = $product['price'];
            $text_price = number_format($product['price'], 0, ',', '.');
            if ($product['price_range']) {
                $price_range = explode(',', $product['price_range']);
                $price_max = number_format($price_range[0], 0, ',', '.');
                $price = $price_range[0];
                $price_min = number_format($price_range[count($price_range) - 1], 0, ',', '.');
                $text_price = $price_max != $price_min ? $price_min . ' - ' . $price_max : $price_min;
            }
            ?>
            <?= isset($div_col) && $div_col ? $div_col : '' ?> 
            <div class="item-product-inhome item-product-promotion relative">
                <div class="img">
                    <div class="hidden-loading-content">
                        <a href="<?= $url ?>" title="<?= $product['name'] ?>">
                            <img class="lazy" data-src="<?= ClaHost::getImageHost(), $product['avatar_path'], 's300_300/', $product['avatar_name'] ?>" alt="<?= $product['name'] ?>" />
                        </a>
                        <span class="sale-label">-<?= \common\components\ClaLid::getDiscount(number_format($price, 0, ',', '.'), $product['price_promotion_sale']) ?>%</span>
                    </div>
                    <div class="box-thumbnail box-thumbnail-abs">
                        <br>
                        <br>
                        <div class="box-line-lg"></div>
                        <div class="box-line-sm"></div>
                    </div>
                </div>
                <h3>
                    <a href="<?= $url ?>" title="<?= $product['name'] ?>">[<?= $province[$product['province_id']] ?>] <?= $product['name'] ?></a>
                </h3>
                    <p class="price">
                        <?= number_format($product['price_promotion_sale'], 0, ',', '.'). ' ' . Yii::t('app', 'currency') ?>
                    </p>
                    <?php 
                        $shopi = isset($shop[$product['shop_id']]) ? $shop[$product['shop_id']] : 0;
                        if($shopi) {
                    ?>
                    <?php } ?>
                    <div class="review">
                        <div class="selling" style="width: 100%;">
                            <div class="seller" style="width: <?= ($product['quantity_selled_promotion_sale']/$product['quantity_promotion_sale'])*100 ?>%"></div>
                            <span>
                                <?= ($product['quantity_selled_promotion_sale'] < $product['quantity_promotion_sale']) ? 'Đã bán '.number_format($product['quantity_selled_promotion_sale'], 0, ',', '.').'/'.number_format($product['quantity_promotion_sale'], 0, ',', '.') : 'Hết hàng khuyến mãi' ?>
                            </span>
                        </div>
                    </div>
            </div>
            <?= isset($div_col) && $div_col ? '</div>' : '' ?>
        <?php } ?>
<?php } ?>