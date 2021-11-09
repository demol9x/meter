<?php

use yii\helpers\Url;
use common\components\ClaHost;

if (isset($products) && $products) { ?>
    <div class="title-standard">
        <h2>
            <a><?= $title ?></a>
        </h2>
        <a href="#" class="view-more"><?= Yii::t('app' ,'view_all') ?> <i class="fa fa-angle-right"></i><i class="fa fa-angle-right"></i></a>
    </div>
    <div class="list-product-inhome slider-product-index owl-carousel owl-theme">
        <?php 
            echo frontend\widgets\html\HtmlWidget::widget([
                            'input' => [
                                'products' => $products
                            ],
                            'view' => 'view_product_2'
                        ]);
        ?>
    </div>
<?php } ?>