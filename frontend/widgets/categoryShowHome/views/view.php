<?php

use common\components\ClaHost;
use yii\helpers\Url;

if (isset($data) && $data) {
?>
    <style type="text/css">
        .item-cate-menu h3 {
            font-size: 14px;
            line-height: 18px !important;
        }

        .charity-sin {
            position: relative;
            display: inline-block;
            padding-left: 90px;
        }

        .charity-sin img {
            position: absolute;
            left: 0px;
            top: 0px;
        }

        .charity-sin .top {
            display: block;
            color: #dbbf6d;
            line-height: 15px;
        }

        .charity-sin .bottom {
            color: #262261;
        }

        .title-standard h2 {
            margin-top: 8px;
        }

        body .xuhuong-timkiem .title-standard {
            padding-bottom: 10px;
            padding-top: 15px;
        }

        .product-inhome {
            clear: both;
        }
    </style>
    <div class="xuhuong-timkiem cate-menu-inhome">
        <div class="container">
            <div class="title-standard">
                <h2>
                    <a><?= Yii::t('app', 'menu') ?></a>
                </h2>
                <div class="right">
                    <a class="charity-sin" href="<?= \yii\helpers\Url::to(['/site/charity']) ?>">
                        <img src="<?= Yii::$app->homeUrl ?>images/charity.png" alt="">
                        <div class="blf">
                            <span class="top">OCOP CHARITY</span>
                            <span class="bottom"><?= formatMoney(\common\models\gcacoin\Gcacoin::getMoneyToCoin(\common\models\order\OrderItem::getAllCharity(['status' => \common\models\order\Order::ORDER_DELIVERING, 'sum' => 1]))) ?> <?= Yii::t('app', 'currency') ?></span>
                        </div>
                    </a>
                </div>
            </div>
            <div class="relative">
                <div class="list-cate-menu owl-carousel owl-theme ">
                    <!-- hidden-loading-content -->
                    <?php
                    foreach ($data as $item) {
                        $link = Url::to(['/product/product/category/', 'id' => $item['id'], 'alias' => $item['alias']]);
                        $src = ClaHost::getImageHost() . $item['avatar_path'] . 's80_80/' . $item['avatar_name'];
                    ?>
                        <div class="item-cate-menu" data-merge="1">
                            <a href="<?= $link ?>" title="<?= $item['name'] ?>">
                                <div class="img" <?= $item['avatar_name'] ? 'style="background-image: url(' . $src . '"' : '' ?> alt="<?= $item['name'] ?>"></div>
                                <h3>
                                    <?= $item['name'] ?>
                                </h3>
                            </a>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>