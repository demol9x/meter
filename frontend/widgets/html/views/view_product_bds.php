<?php

use yii\helpers\Url;
use common\components\ClaHost;

$product = \common\models\product\Product::loadShowAll();
?>
<?php
if (isset($products) && count($products)) {
    foreach ($products as $tg) {
        $product->setAttributeShow($tg);
        $url = $product->getLink();
        $price = $product->price_af;
        $gia = 'Thỏa thuận';
        if(isset($product->price_type) && $product->price_type){
            if($product->price_type != 1){
                $gia = $product->price . ' ' .\common\components\ClaBds::getBoDonVi($product->bo_donvi_tiente)[$product->price_type];
            }
        };
        ?>
        <?= isset($div_col) && $div_col ? $div_col : '' ?>
        <div class="home-product home-product-not-slide">
            <div class="product-thumb ">
                <a title="<?= $product->name ?>"
                   href="<?= $url ?>">
                    <img alt="<?= $product->name ?>" src="<?=  ClaHost::getLinkImage($product->avatar_path, $product->avatar_name, 's300_300/') ?>">
                </a>
            </div>
            <div class="home-product-bound">
                <div class="p-title textTitle">
                    <a class="pr-title"  href="<?= $url ?>" title="<?= $product->name ?>"><?= $product->name ?></a>
                </div>
                <div class="product-price"><?= $gia ?></div>
                <span class="ic_dot">·</span>
                <div class="pro-m2"><?= $product->dien_tich ?> m²</div>
                <div class="product-address">
                    <span ><?= $product->show('province_id') ?></span>
                </div>
                <div class="review">
                    <div class="star">
                        <?php for ($i = 1; $i < 6; $i++) { ?>
                            <span class="fa fa-star<?= ($product['rate'] >= $i) ? '' : '-o' ?> yellow"></span>
                        <?php } ?>
                        <span><?= $product['rate_count'] ? '(' . $product['rate_count'] . ')' : '' ?></span>
                    </div>
                    <div class="wishlist">
                        <?php if (Yii::$app->user->id) { ?>
                            <?php if ($product->inWish()) { ?>
                                <a class="click active" title="<?= Yii::t('app', 'remove_like') ?>"
                                   onclick="removeLike(<?= $product['id'] ?>, $(this));"><i class="fa fa-heart"></i></a>
                            <?php } else { ?>
                                <a class="click" title="<?= Yii::t('app', 'add_like') ?>"
                                   onclick="addLike(<?= $product['id'] ?>, $(this));"><i class="fa fa-heart"></i></a>
                            <?php } ?>
                        <?php } else { ?>
                            <a class="click" title="<?= Yii::t('app', 'add_like') ?>" onclick="loginLike($(this));"><i
                                        class="fa fa-heart"></i></a>
                        <?php } ?>
                    </div>
                    <div class="date"><?= date('d-m-Y',$product['created_at']) ?></div>
                </div>
            </div>
        </div>
        <?= isset($div_col) && $div_col ? '</div>' : '' ?>
    <?php } ?>
<?php } ?>

