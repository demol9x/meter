<?php

use yii\helpers\Url;
use common\components\ClaHost;

if (isset($products) && $products) {
    ?>
    <div class="pro_similar">
        <div class="pro_package">
            <div class="pro_content">
                <div class="content_text">
                    <h3><?= $title ?></h3>
                </div>
            </div>
            <?php
            if (isset($products) && count($products)) {
                echo frontend\widgets\html\HtmlWidget::widget([
                    'input' => [
                        'products' => $products,
                        'slide' => 'item-list-sp'
                    ],
                    'view' => 'view_product_1'
                ]);
            }
            ?>
        </div>
    </div>
<?php } ?>