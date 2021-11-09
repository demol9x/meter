<?php
use yii\helpers\Url;

if (isset($data) && count($data)) { ?>
    <div class="cate-product-trangsuc">
        <?php foreach ($data as $cat) if(count($data[$cat['id']]['products'])) { 
            ?>
                <div class="container">
                    <div class="title-cate-product">
                        <h2>
                            <a href="<?= Url::to(['/product/product/category', 'id' => $cat['id'], 'alias' => $cat['alias']]) ?>">
                                <?= Trans($cat['name'], $cat['name_en']) ?>
                            </a>
                        </h2>
                        <p><?= Trans($cat['description'], $cat['description_en']) ?></p>
                    </div>
                    <div class="owl-product-trangsuc">
                        <?php foreach ($data[$cat['id']]['products'] as $product) {
                            $product_link = Url::to(['/product/product/detail', 'id' => $product['id'], 'alias' => $product['alias']]);
                            $product['name'] = Trans($product['name'], $product['name_en']);
                            ?>
                            <div class="item-product-trangsuc">
                                <div class="img-product-trangsuc fix-height-auto">
                                    <a href="<?php echo $product_link; ?>"
                                       title="<?php echo $product['name']; ?>">
                                        <img src="<?= \common\components\ClaHost::getImageHost(), $product['avatar_path'], 's400_400/', $product['avatar_name'] ?>"

                                             alt="<?php echo $product['name'] ?>">
                                    </a>
                                </div>
                                <div class="title-product-trangsuc">
                                    <h3>
                                        <a href="<?php echo $product_link; ?>"
                                           title="<?= $product['name'] ?>">
                                            <?= $product['name'] ?>
                                        </a>
                                    </h3>
                                    <p>
                                        <?= Trans($product['short_description'], $product['short_description_en']) ?>
                                    </p>
                                    <a href="<?php echo $product_link; ?>" class="btn-view-detail hvr-float-shadow">
                                        <?= Yii::t('app', 'detail') ?>
                                    </a>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="more-ajax">
                        <a class="hvr-float-shadow"
                           href="<?= Url::to(['/product/product/category', 'id' => $cat['id'], 'alias' => $cat['alias']]) ?>"><?= Yii::t('app', 'detail') ?></a>
                    </div>
                </div>
        <?php } ?>
    </div>
<?php } ?>