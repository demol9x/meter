<?php

use yii\helpers\Url;
use common\components\ClaHost;

if (isset($products) && $products) {
    $product = $products[0];
    $url = Url::to(['/product/product/detail', 'id' => $product['id'], 'alias' => $product['alias']]);
    ?>
    <style type="text/css">
        .catbig_banner {
            background-color:#f4ebec;
            padding: 30px 0px;
            height: 360px;
        }
    </style>
    <div class="catbig_banner" >
        <div class="row">
            <div class="col-xl-7 col-lg-6 col-md-6 col-sm-7 col-xs-12 col-xl-push-5 col-lg-push-6 col-md-push-6 col-sm-push-5">
                <div class="catbig_banner_thumb">
                    <a href="<?= $url ?>" title="<?= $product['name'] ?>">
                        <img class="img-load-1" src="<?= ClaHost::getImageHost(), $product['avatar_path'], 's300_300/', $product['avatar_name'] ?>" att="" />
                    </a>  
                </div>
            </div>
            <div class="col-xl-5 col-lg-6 col-md-6 col-sm-5 col-xs-12 col-xl-pull-7 col-lg-pull-6 col-md-pull-6 col-sm-pull-7">
                <div class="catbig_banner_text">
                    <h3><span><?= Yii::t('app', 'product') ?></span></h3>
                    <h2><?= $title ?></h2>
                    <p><?= Trans($product['name'],$product['name_en']) ?></p>
                    <a class="nbtn nbtn_grey" href="<?= $url ?>"><?= Yii::t('app', 'shop_now') ?>  &nbsp;<i class="fa fa-angle-right"></i></a> </div>
            </div>
        </div>
    </div>
<?php } ?>