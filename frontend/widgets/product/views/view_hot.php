<?php

use yii\helpers\Url;
use common\components\ClaHost;

if (isset($products) && $products) {
    ?>
    <div class="product-inhome">
        <div class="container">
            <div class="title-standard">
                <h2>
                    <a href="">Sản phẩm nổi bật</a>
                </h2>
                <a href="" class="view-more">Xem tất cả <i class="fa fa-angle-right"></i><i class="fa fa-angle-right"></i></a>
            </div>
            <div class="list-product-inhome slider-product-index">
                <?php
                foreach ($products as $product) {
                    $url = \yii\helpers\Url::to(['/product/product/detail', 'id' => $product['id'], 'alias' => $product['alias']]);
                    ?>
                    <div class="item-product-inhome">
                        <div class="img">
                            <a href="<?= $url ?>" title="<?= $product['name'] ?>">
                                <img src="<?= ClaHost::getImageHost(), $product['avatar_path'], $product['avatar_name'] ?>" alt="<?= $product['name'] ?>" />
                            </a>
                            <span class="sale-label">50%</span>
                        </div>
                        <h3>
                            <a href="<?= $url ?>" title="<?= $product['name'] ?>"><?= $product['name'] ?></a>
                        </h3>
                        <p class="price">
                            <del><?= number_format($product['price_market'], 0, ',', '.') ?>đ</del><?= number_format($product['price'], 0, ',', '.') ?>đ
                        </p>
                        <div class="review">
                            <div class="star">
                                <i class="fa fa-star yellow"></i>
                                <i class="fa fa-star yellow"></i>
                                <i class="fa fa-star yellow"></i>
                                <i class="fa fa-star yellow"></i>
                                <i class="fa fa-star yellow"></i>
                                <span>(50)</span>
                            </div>
                            <div class="wishlist">
                                <a href=""><i class="fa fa-heart-o"></i></a>
                            </div>
                            <div class="car-ship">
                                <i class="fa fa-truck"></i>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>

