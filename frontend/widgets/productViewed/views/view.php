<?php

use yii\helpers\Url;
use common\components\ClaHost;

if (isset($products) && $products) {
    ?>
    <div class="cate-product-trangsuc" style="background: #fff;">
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
                $img1 = ClaHost::getImageHost().$product['avatar_path'].'s300_300/'.$product['avatar_name'];
                $img2 = $product['avatar2_name'] ? ClaHost::getImageHost().$product['avatar2_path'].'s300_300/'.$product['avatar2_name'] : $img1;
                ?>
                <div class="item-product-trangsuc">
                    <div class="img-product-trangsuc fix-height-auto">
                        <a href="<?= $url ?>" title="<?= $product['name'] ?>">
                            <img class="img-load-1" src="<?= $img1 ?>" />
                            <img class="img-load-2" src="<?= $img2 ?>" />
                        </a>  
                    </div>
                    <div class="title-product-trangsuc">
                        <h3>
                            <a href="<?= $url ?>" title="<?= $product['name'] ?>"><?= $product['name'] ?></a>
                        </h3>
                        <p>
                            <?= nl2br($product['short_description']) ?>
                        </p>
                        <a href="<?= $url ?>" title="<?= $product['name'] ?>" class="btn-view-detail hvr-float-shadow"><?= Yii::t('app', 'detail') ?></a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>