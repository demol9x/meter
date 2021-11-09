<?php

use yii\helpers\Url;
use common\components\ClaHost;

if (isset($products) && $products) {
    ?>
    <div class="product-inhome">
        <div class="container">
            <div class="title-standard">
                <h2>
                    <a><?= $title ?></a>
                </h2>
                <?php if (isset($other['link_all']) && $other['link_all']) { ?>
                    <a href="<?= $other['link_all'] ?>" class="view-more"><?= Yii::t('app', 'view_all') ?> <i class="fa fa-angle-right"></i><i class="fa fa-angle-right"></i></a>
                <?php } ?>
            </div>
            <div class="list-product-inhome slider-product-index owl-carousel owl-theme">
                <?= frontend\widgets\html\HtmlWidget::widget([
                                'input' => [
                                    'products' => $products
                                ],
                                'view' => 'view_product_1'
                            ]);
                ?>
            </div>
        </div>
    </div>
<?php } ?>

