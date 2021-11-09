<?php

use yii\helpers\Url;
use common\components\ClaHost;
$province = \common\models\Province::optionsProvince();
$promotion_all = \common\models\promotion\Promotions::getPromotionNowAll();
?>
<?php if(isset($products) && $products) {
    $dv = Yii::t('app', 'm');
    $dvkm = Yii::t('app', 'km');
    foreach ($products as $product) {
        $url = \yii\helpers\Url::to(['/product/product/detail', 'id' => $product['id'], 'alias' => $product['alias']]);
        $text_price = $product['price'] ? number_format($product['price'], 0, ',', '.').' ' . Yii::t('app', 'currency') : Yii::t('app', 'contact');
        $text_star = '';
        if ($product['price_range']) {
            $price_range = explode(',', $product['price_range']);
            $price_max = number_format($price_range[0], 0, ',', '.');
            $price_min = number_format($price_range[count($price_range) - 1], 0, ',', '.');
            $text_price = $price_max != $price_min ? $price_min . ' - ' . $price_max : $price_min;
            $text_price .= ' ' . Yii::t('app', 'currency');
        }
        if(isset($promotion_all[$product['id']]) && $promotion_all[$product['id']]) {
            $promotion_item = $promotion_all[$product['id']];
            $price = intval($promotion_item['price']);
            $text_price = number_format($promotion_item['price'], 0, ',', '.').' ' . Yii::t('app', 'currency');
        }
        for ($i = 1; $i < 6; $i++) { 
            $text_star .= '<span class="fa fa-star'. (($product['rate'] >= $i) ? '' : '-o').' yellow"></span>';
        } 
        ?>
            <div class="item-address move-position-<?= $product['shop_id'] ?>" id="open-item-<?= $product['id'] ?>">
                <div class="img">
                    <a href="<?= $url ?>">
                        <img src="<?= ClaHost::getImageHost(), $product['avatar_path'],'s100_100/', $product['avatar_name'] ?>" alt="<?= $product['name'] ?>" />
                    </a>
                </div>
                <div class="title">
                    <h2>
                        <a href="<?= $url ?>" title="<?= $product['name'] ?>"><?= $product['name'] ?></a>
                    </h2>
                    <div class="review">
                        <span class="price">
                           <?= $text_price ?>
                        </span>
                        <div class="star">
                            <?= $text_star ?>
                            <span><?= $product['rate_count'] ? '(' . $product['rate_count'] . ')' : '' ?></span>
                        </div>
                    </div>
                    <div class="location">
                        <i class="fa fa-map-marker"></i> 
                        <?= $province[$product['province_id']] ?>
                    </div>
                </div>
                <?php if(isset($product['distance'])) { ?>
                    <button class="btn-distance"  id="chiduong-<?= $product['id'] ?>">
                        <img src="<?= Yii::$app->homeUrl ?>images/map-marker-icon.png" alt="">
                        <span>
                            <?php if($product['distance'] > 1000) { ?>
                                <?= number_format($product['distance']/1000, 1, ',', '.').$dvkm ?>
                            <?php } else { ?>
                                <?= number_format($product['distance'], 0, ',', '.').$dv ?>
                            <?php } ?> 
                        </span>
                    </button>
                <?php } ?>
            </div>
    <?php } ?>
<?php } ?>