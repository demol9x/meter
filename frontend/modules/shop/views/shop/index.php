<?php
use common\components\ClaHost;
use yii\helpers\Url;
use common\components\ClaLid;
?>
 <div class="title-page-product center">
    <div class="container">
        <h2>
            <?= Yii::$app->view->title ?>
        </h2>
        <p>
            <?= $productdes ?>
        </p>
    </div>
</div>
<div class="sort-by-tool">
    <h2>Sort by:</h2>
    <div class="container">
        <div class="row">
            <div class="item-sort-by">
                <select name="" id="">
                    <option value="Material">Material</option>
                    <option value="Material">Material 1</option>
                    <option value="Material">Material 2</option>
                    <option value="Material">Material 3</option>
                    <option value="Material">Material 4</option>
                </select>
            </div>
            <div class="item-sort-by">
                <select name="" id="">
                    <option value="Collection">Collection</option>
                    <option value="Collection">Collection 1</option>
                    <option value="Collection">Collection 2</option>
                    <option value="Collection">Collection 3</option>
                    <option value="Collection">Collection 4</option>
                </select>
            </div>
            <div class="item-sort-by">
                <select name="" id="">
                    <option value="Product type">Product type</option>
                    <option value="Product type">Product type</option>
                    <option value="Product type">Product type</option>
                    <option value="Product type">Product type</option>
                    <option value="Product type">Product type</option>
                </select>
            </div>
            <div class="item-sort-by">
                <select name="" id="">
                    <option value="Theme">Theme</option>
                    <option value="Theme">Theme 1</option>
                    <option value="Theme">Theme 2</option>
                    <option value="Theme">Theme 3</option>
                    <option value="Theme">Theme 4</option>
                </select>
            </div>
            <div class="item-sort-by">
                <select name="" id="">
                    <option value="Other">Other</option>
                    <option value="Other">Other 1</option>
                    <option value="Other">Other 2</option>
                    <option value="Other">Other 3</option>
                    <option value="Other">Other 4</option>
                </select>
            </div>
        </div>
    </div>
</div>
<div class="list-product-page">
    <div class="container">
        <div class="row">
            <?php if (isset($data) && $data) { ?>
                <?php foreach ($data as $product) {
                    ?>
                    <div class="item-product-standard">
                        <div class="border-item-product">
                            <div class="img-item-product-standard">
                                <a href="<?= Url::to(['/product/product/detail', 'id' => $product['id'], 'alias' => $product['alias']]) ?>"
                                   title="<?= $product['name'] ?>">
                                    <img src="<?= ClaHost::getImageHost(), $product['avatar_path'], $product['avatar_name'] ?>"
                                         alt="<?= $product['name'] ?>">
                                </a>
                            </div>
                            <div class="title-item-product-standard">
                                <div class="img-show-standard">
                                    <a href="<?= Url::to(['/product/product/detail', 'id' => $product['id'], 'alias' => $product['alias']]) ?>"
                                   title="<?= $product['name'] ?>">
                                        <img src="<?= ClaHost::getImageHost(), $product['avatar_path'], $product['avatar_name'] ?>"
                                             alt="<?= $product['name'] ?>">
                                    </a>
                                </div>
                                <div class="box-text">
                                    <h2>
                                        <a href="<?= Url::to(['/product/product/detail', 'id' => $product['id'], 'alias' => $product['alias']]) ?>"
                                           title="<?= $product['name'] ?>">
                                            <?= ClaLid::getDataByLanguage($product['name'], $product['name_en']) ?>
                                        </a>
                                    </h2>
                                    <p>
                                        <?= ClaLid::getDataByLanguage($product['short_description'], $product['short_description_en']) ?>
                                    </p>
                                    <a href="<?= Url::to(['/product/product/detail', 'id' => $product['id'], 'alias' => $product['alias']]) ?>"
                                       class="view-detail"><?= Yii::t('app','detail') ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
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
</div>
