<?php

use common\components\ClaHost;
use yii\helpers\Url;
use common\components\ClaLid;
?>
<?php if (isset($data) && $data) { ?>
    <div class="col-lg-10 col-md-10 col-sm-9 col-xs-8">
        <div class="ctn-item-product">
            <div class="row multi-columns-row">
                <?php foreach ($data as $product) { ?>
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                        <div class="item-product">
                            <?php if ($product['price_market'] > 0 && $product['price'] > 0) { ?>
                                <span class="icon-sale-list"><spam>-<?= ClaLid::getDiscount($product['price_market'], $product['price']) ?>%</spam></span>
                            <?php } ?>
                            <div class="img-item-product">
                                <a href="<?= Url::to(['/product/product/detail', 'id' => $product['id'], 'alias' => $product['alias']]) ?>" title="<?= $product['name'] ?>">
                                    <img src="<?= ClaHost::getImageHost(), $product['avatar_path'], $product['avatar_name'] ?>" alt="<?= $product['name'] ?>">
                                </a>
                            </div>
                            <div class="title-item-product">
                                <h2><a href="<?= Url::to(['/product/product/detail', 'id' => $product['id'], 'alias' => $product['alias']]) ?>" title="<?= $product['name'] ?>"><?= $product['name'] ?></a></h2>
                                <span>
                                    <?= number_format($product['price'], 0, ',', '.') ?> đ 
                                    <?php if ($product['price_market'] > 0) { ?>
                                        - <spam><?= number_format($product['price_market'], 0, ',', '.') ?> đ</spam>
                                    <?php } ?>
                                </span>
                            </div>
                        </div>
                    </div>
                <?php } ?>
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
        </div>
    </div>
<?php } ?>