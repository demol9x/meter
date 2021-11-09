<?php

use yii\helpers\Url;
use common\components\ClaHost;
?>
<?php if(isset($products) && count($products)) { 
    foreach ($products as $product) {
        $url = \yii\helpers\Url::to(['/product/product/detail', 'id' => $product['id'], 'alias' => $product['alias']]);
        ?>
        <?= isset($div_col) && $div_col ? $div_col : '' ?> 
            <div class="item-product-inhome">
                <div class="img">
                    <a href="<?= $url ?>" title="<?= $product['name'] ?>">
                        <img src="<?= ClaHost::getImageHost(), $product['avatar_path'],'s200_200/', $product['avatar_name'] ?>" alt="<?= $product['name'] ?>" />
                    </a>
                    <?php if($product['price_market'] > $product['price']  && $product['price'] > 0) { ?>
                        <span class="sale-label"><?= number_format(round(100*($product['price_market'] - $product['price'])/$product['price_market'], 0), 0, ',', '.') ?>%</span>
                    <?php } ?>
                </div>
                <h3>
                    <a href="<?= $url ?>" title="<?= $product['name'] ?>"><?= $product['name'] ?></a>
                </h3>
                <p class="price">
                    <?php if (!$product['price_range']) { ?>
                        <?= ($product['price_market'] > $product['price'] && $product['price_market'] > 0) ? '<del>' . number_format($product['price_market'], 0, ',', '.') . '</del>' : '' ?>
                        <?= ($product['price'] > 0) ? number_format($product['price'], 0, ',', '.') . ' ' . Yii::t('app', 'currency') : Yii::t('app', 'contact'); ?>
                        <?php
                    } else {
                        $price_range = explode(',', $product['price_range']);
                        if(count($price_range) > 1) {
                            $price_range = explode(',', $product['price_range']);
                            $price_max = number_format($price_range[0], 0, ',', '.');
                            $price_min = number_format($price_range[count($price_range) - 1], 0, ',', '.');
                            echo $price_max != $price_min ? $price_min . ' - ' . $price_max : $price_min;
                            echo ' ' . Yii::t('app', 'currency');
                        } else {
                            echo number_format($price_range[0], 0, ',', '.');
                            echo ' ' . Yii::t('app', 'currency');
                        }
                    }
                    ?>
                </p>
                <div class="review">
                    <div class="star">
                        <?php for ($i=1; $i <6 ; $i++) { ?>
                            <span class="fa fa-star<?= ($product['rate'] >= $i) ? '' : '-o' ?> yellow"></span>
                        <?php } ?>
                        <span><?= $product['rate_count'] ? '('.$product['rate_count'].')' : '' ?></span>
                    </div>
                    <div class="wishlist">
                        <a href=""><i class="fa fa-heart-o"></i></a>
                    </div>
                    <div class="car-ship">
                        <i class="fa fa-truck"></i>
                    </div>
                </div>
                <div class="add-product-managers solid-out" data="<?= $product['id'] ?>">
                    <button>
                        <a href="<?= Url::to(['/management/product/update', 'id' => $product['id']]) ?>"><span class="solid-out-circle" data="<?= $product['id'] ?>"><?= Yii::t('app', 'update') ?></span></a>
                        <span class="solid-out-circle delete-product" data="<?= $product['id'] ?>"><?= Yii::t('app', 'delete') ?></span>
                        <span class="solid-out-circle notselectedbt"><?= Yii::t('app', 'select') ?></span>
                        <?php if($product['status_quantity']) { ?>
                            <span class="solid-out-circle do-not-product" data="<?= $product['id'] ?>"><?= Yii::t('app', 'have_product') ?></span>
                        <?php } else { ?>
                            <span class="solid-out-circle do-have-product" data="<?= $product['id'] ?>"><?= Yii::t('app', 'not_product') ?></span>
                        <?php } ?>
                    </button>
                </div>
            </div>
        <?= isset($div_col) && $div_col ? '</div>' : '' ?>
    <?php } ?>
<?php } ?>