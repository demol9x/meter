<?php

use yii\helpers\Url;
use common\components\ClaHost;

if (isset($products) && $products) { ?>
    <div class="title-standard">
        <h2>
            <a><?= Yii::t('app' ,'top_product_hot') ?></a>
        </h2>
        <a href="#" class="view-more"><?= Yii::t('app' ,'view_all') ?> <i class="fa fa-angle-right"></i><i class="fa fa-angle-right"></i></a>
    </div>
    <div class="list-product-inhome slider-product-index">
        <?php 
            foreach ($products as $product) {
            $url = Url::to(['/product/product/detail', 'id' => $product['id'], 'alias' => $product['alias']]);
            echo frontend\widgets\html\HtmlWidget::widget([
                                'input' => [
                                    'product' => $product
                                ],
                                'view' => 'view_product_2'
                            ]);
            }
        ?>
    </div>
<?php } ?>