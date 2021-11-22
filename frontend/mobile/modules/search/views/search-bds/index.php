<?php
/**
 * Created by PhpStorm.
 * User: trung
 * Date: 7/1/2021
 * Time: 11:54 AM
 */
?>

<div id="main">
    <div class="breadcrumb">
        <div class="container">
            <a href="/" title="Trang chủ">Trang chủ</a> <span><i class="fa fa-angle-right"></i></span>
            <a href="#" title="Bán đất mặt tiền">Tìm kiếm</a>
        </div>
    </div>
    <div class="categories-product-page">
        <div class="section-product">
            <div class="container">
                <div class="product-in-store">
                    <div class="row-5-flex multi-columns-row">
                        <?php if ($products): ?>
                            <?php foreach ($products as $product): ?>
                                <?php
                                $url = \yii\helpers\Url::to(['/product/product/detail', 'id' => $product['id'], 'alias' => $product['alias']]);
                                $gia = 'Thỏa thuận';
                                if (isset($product['price_type']) && $product['price_type']) {
                                    if ($product['price_type'] != 1) {
                                        $gia = $product['price'] . ' ' . \common\components\ClaBds::getBoDonVi($product['bo_donvi_tiente'])[$product['price_type']];
                                    }
                                };
                                ?>
                                <div class="col-md-12-item">
                                    <div class="home-product">
                                        <div class="product-thumb ">
                                            <a title="<?= $product['name'] ?>"
                                               href="<?= $url ?>">
                                                <img alt="<?= $product['name'] ?>"
                                                     src="<?= \common\components\ClaHost::getLinkImage($product['avatar_path'], $product['avatar_name'], 's300_300/') ?>">
                                            </a>
                                        </div>
                                        <div class="home-product-bound">
                                            <div class="p-title textTitle">
                                                <a class="pr-title" href="<?= $url ?>"
                                                   title="<?= $product['name'] ?>"><?= $product['name'] ?></a>
                                            </div>
                                            <div class="product-price"><?= $gia ?></div>
                                            <span class="ic_dot">·</span>
                                            <div class="pro-m2"><?= $product['dien_tich'] ?> m²</div>
                                            <div class="product-address">
                                                <span><?= $product['province_name'] ?></span>
                                            </div>
                                            <div class="review">
                                                <div class="star">
                                                    <?php for ($i = 1; $i < 6; $i++) { ?>
                                                        <span class="fa fa-star<?= ($product['rate'] >= $i) ? '' : '-o' ?> yellow"></span>
                                                    <?php } ?>
                                                    <span><?= $product['rate_count'] ? '(' . $product['rate_count'] . ')' : '' ?></span>
                                                </div>
                                                <div class="wishlist">
                                                    <?php if (Yii::$app->user->id) {
                                                        $prd = \common\models\product\Product::findOne($product['id']); ?>
                                                        <?php if ($prd->inWish()) { ?>
                                                            <a class="click active"
                                                               title="<?= Yii::t('app', 'remove_like') ?>"
                                                               onclick="removeLike(<?= $product['id'] ?>, $(this));"><i
                                                                        class="fa fa-heart"></i></a>
                                                        <?php } else { ?>
                                                            <a class="click" title="<?= Yii::t('app', 'add_like') ?>"
                                                               onclick="addLike(<?= $product['id'] ?>, $(this));"><i
                                                                        class="fa fa-heart"></i></a>
                                                        <?php } ?>
                                                    <?php } else { ?>
                                                        <a class="click" title="<?= Yii::t('app', 'add_like') ?>"
                                                           onclick="loginLike($(this));"><i
                                                                    class="fa fa-heart"></i></a>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <div class="paginate" id="load-page-search">
                        <?=
                        yii\widgets\LinkPager::widget([
                            'pagination' => new yii\data\Pagination([
                                'defaultPageSize' => $limit,
                                'totalCount' => $totalCount
                            ])
                        ]);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
