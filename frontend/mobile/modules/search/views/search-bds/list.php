<link rel="stylesheet" href="<?php echo Yii::$app->homeUrl ?>css/bds-result.css"/>
<div class="search-bds-page search-bds-result">
    <div class="container" style="margin-top: 10px">
            <?php if (isset($products) && $products) {
                foreach ($products as $product) : ?>

                    <?php
                    $price = isset($product['price']) && $product['price'] ? $product['price'] : 0;
                    $price = $price . ' ' . \common\components\ClaBds::getBoDonVi($product['bo_donvi_tiente'])[$product['price_type']];
                    $url = \yii\helpers\Url::to(['/product/product/detail', 'id' => $product['id'], 'alias' => $product['alias']]);
                    ?>
                    <div class="home-product home-product-grid">
                        <div class="product-thumb ">
                            <a title="<?= $product['name'] ?>"
                               href="<?= $url ?>">
                                <img alt="<?= $product['name'] ?>"
                                     src="<?= \common\components\ClaHost::getImageHost() . $product['avatar_path'] . $product['avatar_name'] ?>">
                            </a>
                        </div>
                        <div class="home-product-bound">
                            <div class="p-title textTitle">
                                <a class="pr-title" href="<?= $url ?>"
                                   title="<?= $product['name'] ?>"><?= $product['name'] ?></a>
                            </div>
                            <div class="product-price"><?= $price ?></div>
                            <span class="ic_dot">·</span>
                            <div class="pro-m2"><?= $product['dien_tich'] ?> m²</div>
                            <div class="product-address">
                                <span><?= $product['address'] ?></span>
                            </div>
                            <div class="review">
                                <div class="star">
                                    <?php for ($i = 1; $i < 6; $i++) { ?>
                                        <span class="fa fa-star<?= ($product['rate'] >= $i) ? '' : '-o' ?> yellow"></span>
                                    <?php } ?>
                                    <span><?= $product['rate_count'] ? '(' . $product['rate_count'] . ')' : '' ?></span>
                                </div>

                            </div>
                        </div>
                    </div>
                <?php endforeach;
            } else { ?>
                <div class="col-12">
                    <div>
                        <p style="margin-left: 15px;">Không có sản phẩm nào phù hợp.</p>
                    </div>
                </div>
            <?php } ?>
    </div>
</div>