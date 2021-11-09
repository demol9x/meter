<?php

use yii\helpers\Url;
use common\components\ClaHost;

if (isset($products) && $products) {
    ?>
    <div class="cate-product-trangsuc" style="background: #fff; border-top: 1px solid #d7d7d7;">
        <div class="collection-name">
            <h3>
                <a>
                     <img src="images/icon-logo.png" alt=""><?= $title ?>
                </a>
            </h3>
        </div>
        <div class="owl-product-trangsuc">
            <?php
            foreach ($products as $product) {
                $url = Url::to(['/product/product/detail', 'id' => $product['id'], 'alias' => $product['alias']]);
                $product['name'] = Trans($product['name'], $product['name_en']);
                $product['short_description'] = Trans($product['short_description'], $product['short_description_en']);
                ?>
                <div class="item-product-trangsuc">
                    <div class="img-product-trangsuc fix-height-auto">
                        <a href="<?= $url ?>" title="<?= $product['name'] ?>">
                            <img class="img-load-1" src="<?= ClaHost::getImageHost(), $product['avatar_path'], $product['avatar_name'] ?>" />
                            <img class="img-load-2" src="<?= ClaHost::getImageHost(), $product['avatar2_path'], $product['avatar2_name'] ?>" />
                        </a>  
                    </div>
                    <div class="title-product-trangsuc">
                        <h3>
                            <a href="<?= $url ?>" title="<?= $product['name'] ?>"><?= $product['name'] ?></a>
                        </h3>
                        <p>
                            <?= nl2br($product['short_description']) ?>
                        </p>
                        <a href="<?= $url ?>" class="btn-view-detail hvr-float-shadow"><?= Yii::t('app', 'detail') ?></a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>