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
        $price_market = $product->getPriceMarket(1);
        $text_price_market = $product->getPriceMarketText(1);
        $price = $product->getPrice(1);
        $text_price = $product->getPriceText(1);
        $check = $product->checkInCart(); ?>
        <?= isset($div_col) && $div_col ? $div_col : '' ?>
        <div class="item-product-inhome relative">
            <div class="img">
                <div class="hidden-loading-contentn">
                    <a href="<?= $url ?>" title="<?= $product['name'] ?>">
                        <img src="<?= ClaHost::getLinkImage($product->avatar_path, $product->avatar_name, 's200_200/') ?>" alt="<?= $product['name'] ?>" />
                    </a>
                    <?php if ($price_market > $price && $price > 0) { ?>
                        <span class="sale-label">-<?= \common\components\ClaLid::getDiscount($price_market, $price) ?>%</span>
                    <?php } ?>
                </div>
            </div>
            <h3>
                <a href="<?= $url ?>" title="<?= $product->name ?>"><?= $product->name ?></a>
            </h3>
            <p class="price">
                <?= $text_price ?>
                <?php if ($price_market > $price && $price > 0) { ?>
                    <del><?= $text_price_market ?></del>
                <?php } ?>
            </p>
            <p class="price marker">
                <i class="fa fa-map-marker" aria-hidden="true"></i>
                <?= $product->show('province_id') ?>
                <?php if ($price > 0) { ?>
                    <a class="btn-style-3 click" <?= $check ? '' : 'onclick="addCart($(this), ' . $product['id'] . ')"' ?>><?= $check ? 'Đã thêm ' : 'Thêm vào ' ?> <i class="fa fa-shopping-cart"></i>
                    </a>
                <?php } ?>
            </p>
            <?php
            $shopi = $product->getShop();
            if ($shopi) {  ?>
                <p class="price shop">
                    <a href="<?= Url::to(['/shop/shop/detail', 'id' => $shopi['id'], 'alias' => $shopi['alias']]) ?>">
                        <i class="fa fa-archive"></i>
                        <?= $shopi['name'] ?>
                    </a>
                </p>
            <?php } ?>
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
                            <a class="click active" title="<?= Yii::t('app', 'remove_like') ?>" onclick="removeLike(<?= $product['id'] ?>, $(this));"><i class="fa fa-heart"></i></a>
                        <?php } else { ?>
                            <a class="click" title="<?= Yii::t('app', 'add_like') ?>" onclick="addLike(<?= $product['id'] ?>, $(this));"><i class="fa fa-heart"></i></a>
                        <?php } ?>
                    <?php } else { ?>
                        <a class="click" title="<?= Yii::t('app', 'add_like') ?>" onclick="loginLike($(this));"><i class="fa fa-heart"></i></a>
                    <?php } ?>
                </div>
                <?php if ($product['fee_ship']) { ?>
                    <div class="car-ship">
                        <i class="fa fa-truck"></i>
                        <div class="car-ship-detai">
                            <?= nl2br($product['note_fee_ship']) ?>
                        </div>
                    </div>

                <?php } ?>
            </div>
        </div>
        <?= isset($div_col) && $div_col ? '</div>' : '' ?>
    <?php } ?>
<?php } ?>