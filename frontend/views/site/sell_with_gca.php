<?php

use yii\helpers\Url;

$this->title = Yii::t('app', 'sale_with_gca');
?>
<style>
    .partner-in-store .slider-item-partner .item-partner {
        max-width: 130px;
    }
</style>
<div id="main">
    <div class="banner-inpage-gca">
        <?=
            frontend\widgets\banner\BannerWidget::widget([
                'group_id' => 4,
                'view' => 'sell_with_gca',
                'limit' => 1
            ])
        ?>
        <div class="ctn-banner-inpage">
            <div class="vertical">
                <div class="middle">
                    <div class="container">
                        <h2>
                            <?= Yii::t('app', 'sell_with_gca_1') ?>
                        </h2>
                        <p>
                            <?= Yii::t('app', 'sell_with_gca_2') ?>
                        </p>
                        <?php if (Yii::$app->user->id > 0) { ?>
                            <a href="<?= Url::to(['/management/shop/create']) ?>" class="register-now">
                                <?= Yii::t('app', 'sell_with_gca_10') ?>
                            </a>
                        <?php } else { ?>
                            <a href="<?= Url::to(['/login/login/signup-shop']) ?>" class="register-now">
                                <?= Yii::t('app', 'sell_with_gca_10') ?>
                            </a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?=
        \frontend\widgets\menu\MenuWidget::widget([
            'group_id' => 6,
            'view' => 'sell_with_gca'
        ])
    ?>
    <div class="step-create-store">
        <div class="bg-img" style="background-image: url(<?= Yii::$app->homeUrl ?>images/bg-nen.jpg);"></div>
        <div class="left-bottom-img">
            <img src="<?= Yii::$app->homeUrl ?>images/hoa-left.png" alt="">
        </div>
        <div class="right-bottom-img">
            <img src="<?= Yii::$app->homeUrl ?>images/hoa-right.png" alt="">
        </div>
        <div class="ctn-step-store">
            <div class="container">
                <div class="btn-join-store">
                    <a><?= Yii::t('app', 'sell_with_gca_4') ?></a>
                </div>
                <h2>
                    <?= Yii::t('app', 'sell_with_gca_5') ?>
                </h2>
                <div style="text-align: center; margin-bottom: 80px;">
                    <img alt="4-buoc-ban-hang-ocopmart.org" src="<?= Yii::$app->homeUrl ?>images/4buoc1.png">
                </div>
            </div>
        </div>
        <style>
            @media (max-width:1500px) {
                html {
                    font-size: 10px !important;
                }
            }

            @media (max-width:767px) {
                html {
                    font-size: 8px !important;
                }
            }

            @media (max-width:600px) {
                html {
                    font-size: 7px !important;
                }
            }

            @media (max-width:480px) {
                html {
                    font-size: 5px !important;
                }
            }
        </style>
    </div>
    <div class="create-store-now">
        <div class="bg-img">
            <img src="<?= Yii::$app->homeUrl ?>images/banner-dua.jpg" alt="">
        </div>
        <div class="ctn-create-store-now">
            <h2><?= Yii::t('app', 'sell_with_gca_9') ?></h2>
            <?php if (Yii::$app->user->id > 0) { ?>
                <a href="<?= Url::to(['/management/shop/create']) ?>"><?= Yii::t('app', 'sell_with_gca_10') ?></a>
            <?php } else { ?>
                <a href="<?= Url::to(['/login/login/signup-shop']) ?>" class="register-now">
                    <?= Yii::t('app', 'sell_with_gca_10') ?>
                </a>
            <?php } ?>
        </div>
    </div>
    <?=
        frontend\widgets\banner\BannerWidget::widget([
            'group_id' => 5,
            'view' => 'sell_dt',
            'limit' => 20
        ])
    ?>
</div>