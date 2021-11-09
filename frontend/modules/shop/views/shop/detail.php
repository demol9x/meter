<?php

use common\components\ClaHost;

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'shop')];
$this->params['breadcrumbs'][] = $model->name;
?>
<style>
    body .banner-store {
        height: 250px;
        overflow: hidden;
        margin-bottom: 53px;
    }

    .banner-store img {
        height: 100%;
        width: auto;
        margin: auto;
        position: absolute;
        left: 0px;
        right: 0px;
    }
</style>
<div class="page-store">
    <div class="container">
        <div class="section-intro">
            <div class="left-intro">
                <?= frontend\widgets\html\HtmlWidget::widget([
                    'input' => [
                        'model' => $model,
                        'user' => $user
                    ],
                    'view' => 'view_shop_info'
                ]);
                ?>
            </div>
            <div class="right-intro">
                <div class="banner-store hidden-xs hidden-sm hidden-md visible-lg">
                    <img src="<?= $model->image_name ? ClaHost::getImageHost() . $model->image_path . $model->image_name : ClaHost::getImageHost() . '/imgs/df.png' ?>" alt="<?= $model->name ?>">
                </div>
                <div class="bottom-right-intro">
                    <?= frontend\widgets\html\HtmlWidget::widget([
                        'input' => [],
                        'view' => 'view_shop_tool'
                    ]);
                    ?>
                    <div class="menu-store">
                        <ul class="tab-menu">
                            <li class="active click"><a id="1"><?= Yii::t('app', 'product')  ?></a></li>
                            <li><a class="click" id="2"><?= Yii::t('app', 'introduce')  ?></a></li>
                            <li><a class="click" id="3"><?= Yii::t('app', 'contact')  ?></a></li>
                            <li><a class="click" id="4">QR CODE</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="section-product">
            <div class="left-filter">
                <div class="option-filter">
                    <?= \frontend\widgets\menuCategory\MenuCategoryInShopWidget::widget([
                        'view' => 'menu_product_left',
                        'shop_id' => $model->id
                    ])
                    ?>
                </div>
                <!-- <div class="option-filter">
                    <h2>Giá sản phẩm</h2>
                    <ul>
                        <li>
                            <a href="">50.000 - 100.000</a>
                        </li>
                        <li><a href="">100.000 - 500.000</a></li>
                        <li><a href="">500.000 - 1.000.000</a></li>
                        <li><a href="">1.000.000 - 5.000.000</a></li>
                    </ul>
                </div> -->
            </div>
            <div class="product-in-store tab-menu-read tab-menu-read-1" style="display: block;">
                <div class="row-5-flex multi-columns-row">
                    <?php
                    echo frontend\widgets\html\HtmlWidget::widget([
                        'input' => [
                            'products' => $products,
                            'div_col' => '<div class="col-lg-5-12-item">',
                        ],
                        'view' => 'view_product_1'
                    ]);
                    ?>
                </div>
                <div class="paginate">
                    <?=
                    yii\widgets\LinkPager::widget([
                        'pagination' => new yii\data\Pagination([
                            'pageSize' => $limit,
                            'totalCount' => $totalitem
                        ])
                    ]);
                    ?>
                </div>
            </div>
            <div class="product-in-store tab-menu-read tab-menu-read-2" style="display: none;">
                <div class="content-intro-store content-standard-ck">
                    <div class="description">
                        <h4><?= Yii::t('app', 'shop') ?>: <?= $model->name ?></h4>
                        <hr />
                        <?= nl2br($model->description)  ?>
                    </div>
                    <?php if ($img_shop) { ?>
                        <div class="img-shop clear">
                            <h4><?= Yii::t('app', 'image_shop') ?></h4>
                            <hr />
                            <div class="box-img">
                                <?php foreach ($img_shop as $img) { ?>
                                    <div class="item-img col-md-3 col-sm-4 col-xs-6">
                                        <a rel="example_group2" href="<?= ClaHost::getImageHost() . $img['path'] . $img['name'] ?>"><img src="<?= ClaHost::getImageHost() . $img['path'] . $img['name'] ?>" alt="chung-thuc"></a>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="product-in-store tab-menu-read tab-menu-read-3" style="display: none;">
                <div class="content-intro-store content-standard-ck">
                    <div class="map" style="margin-bottom: 10px;">
                        <?=
                        \frontend\widgets\html\HtmlWidget::widget([
                            'view' => 'map',
                            'input' => [
                                'center' => $model,
                                'zoom' => 10,
                                'listMap' => $shopadd ? $shopadd : [0 => $model]
                            ]
                        ])
                        ?>
                    </div>
                    <p>
                        <b><?= Yii::t('app', 'shop') ?>:</b> <?= $model->name ?>
                    </p>
                    <p>
                        <b><?= Yii::t('app', 'timing') ?>: </b> <?= (($time = date('Y', time()) - date('Y', $model->created_time)) >= 1) ? $time : Yii::t('app', 'under_1') ?> <?= Yii::t('app', 'year') ?>
                    </p>
                    <!-- <p>
                        <b><?= Yii::t('app', 'address') ?>: </b> <?= ($model->address ? $model->address . ', ' : '') . $model->ward_name . ', ' . $model->district_name . ', ' . $model->province_name ?>
                    </p> -->
                    <!-- <p>
                        <b><?= Yii::t('app', 'phone') ?>: </b> 
                        <a href="tel:<?= $model->phone  ?>"><?= formatPhone($model->phone) ?></a>
                        <?php if ($model->phone_add) {
                            $phones = explode(',', $model->phone_add);
                            foreach ($phones as $phone) {
                        ?>
                                , <a href="tel:<?= $phone  ?>"><?= formatPhone($phone) ?></a>
                            <?php }
                        } ?>
                    </p> -->
                    <!-- <p>
                        <b><?= Yii::t('app', 'email') ?>: </b> <?= $model->email ?>
                    </p> -->
                </div>
            </div>
            <div class="product-in-store tab-menu-read tab-menu-read-4" style="display: none;">
                <style>
                    .qr-shop {
                        float: left;
                        margin-right: 10px;
                    }
                </style>
                <div class="content-intro-store content-standard-ck">
                    <div class="qr-shop">
                        <img src="<?= $user->getQrSendV() ?>" style="width: 150px; height: 150px; border-radius: 0;position: relative;">
                        <?php if ($model->affilliate_status_service) { ?>
                            <p>QR chuyển tiền</p>
                        <?php } ?>
                    </div>
                    <?php if ($model->affilliate_status_service) {
                        $user->_shop =  $model;
                    ?>
                        <div class="qr-shop">
                            <style>
                                .qr-shop>p {
                                    margin: 0 0 10px;
                                    background: #fff;
                                    text-align: center;
                                }
                            </style>
                            <img src="<?= $user->getQrSendService() ?>" style="width: 150px; height: 150px; border-radius: 0;position: relative;">
                            <p>QR dịch vụ</p>
                        </div>
                    <?php } ?>
                    <div class="qr-shop">
                        <style>
                            .qr-shop>p {
                                margin: 0 0 10px;
                                background: #fff;
                                text-align: center;
                            }
                        </style>
                        <img src="<?= $user->getQrSendBeforeShop() ?>" style="width: 150px; height: 150px; border-radius: 0;position: relative;">
                        <p>QR AFFILLIATE - <?= $user->id ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>