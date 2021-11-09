<?php

use common\components\ClaHost;

$product = new \common\models\product\Product();
?>
<?php if (isset($products) && $products) {
    foreach ($products as $tg) {
        $product->setAttributeShow($tg);
        $url = $product->getLink();
        $price_market = $product->getPriceMarket(1);
        $text_price_market = $product->getPriceMarketText(1);
        $price = $product->getPrice(1);
        $text_price = $product->getPriceText(1);?>
        <div class="item-product-inhome">
            <div class="img">
                <a href="<?= $url ?>">
                    <img src="<?= ClaHost::getLinkImage($product['avatar_path'], $product['avatar_name'], 's200_200/') ?>" alt="<?= $product['name'] ?>" />
                </a>
                <?php if ($price_market > $price && $price > 0) { ?>
                    <span class="sale-label">-<?= \common\components\ClaLid::getDiscount($price_market, $price) ?>%</span>
                <?php } ?>
            </div>
            <h3>
                <a href="<?= $url ?>" title="<?= $product['name'] ?>"><?= $product['name'] ?></a>
            </h3>
            <p class="price">
                <?= $text_price; ?>
                <?php if ($price_market > $price && $price > 0) { ?>
                    <del><?= $text_price_market ?></del>
                <?php } ?>
            </p>
        </div>
    <?php } ?>
<?php } ?>