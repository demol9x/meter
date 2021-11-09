<?php

use yii\helpers\Url;
use common\components\ClaHost;

if (isset($products) && $products) {
    ?>
    <div class="br-60"></div>
    <div class="index_col_title">
        <div class="collection-name">
            <h3>
                <a href="">
                     <img src="<?= Yii::$app->homeUrl ?>images/icon-logo.png" alt=""><?= $title ?>
                </a>
            </h3>
        </div>
        <div class="collection-link">
            <a href="<?= Url::to(['/product/product/index']); ?>"><?= Yii::t('app', 'view_all') ?></a>
        </div>
    </div>
    <div class="slick-hot-product">
        <div class="group-product  owl-carousel owl-theme">
            <?php
                $count = count($products);
                $i = 0;
                foreach ($products as $product) { $i++;
                    $url = Url::to(['/product/product/detail', 'id' => $product['id'], 'alias' => $product['alias']]);
                    $product['name'] = Trans($product['name'],$product['name_en']);
                    $product['short_description'] = Trans($product['short_description'],$product['short_description_en']);
                    ?>
                    <div class="product_single">
                        <div class="item-product-trangsuc">
                            <div class="img-product-trangsuc fix-height-auto">
                                <a href="<?= $url ?>" title="<?= $product['name'] ?>">
                                    <img class="img-load-1" src="<?= ClaHost::getImageHost(), $product['avatar_path'], 's300_300/', $product['avatar_name'] ?>" />
                                    <img class="img-load-2" src="<?= ClaHost::getImageHost(), $product['avatar2_path'], 's300_300/', $product['avatar2_name'] ?>" />
                                </a>  
                            </div>
                            <div class="title-product-trangsuc">
                                <h3>
                                     <a href="<?= $url ?>" title="<?= $product['name'] ?>" class="btn-view-detail hvr-float-shadow"><?= Yii::t('app','detai') ?></a>
                                </h3>
                                <p>
                                    <?= nl2br($product['short_description']) ?>
                                </p>
                                <a href="<?= $url ?>" title="<?= $product['name'] ?>" class="btn-view-detail hvr-float-shadow"><?= Yii::t('app','detail') ?></a>
                            </div>
                        </div>
                    </div>
                    <?php if( ($i%8 == 0) && ($count != $i) ) { ?>
                    </div>
                    <div class="group-product">
                    <?php } 
                }
            ?>
        </div>
    </div>
    <div class="br-60"></div>
<?php } ?>