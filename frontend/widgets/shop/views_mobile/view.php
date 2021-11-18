<?php

use yii\helpers\Url;
use common\components\ClaHost;

if (isset($products) && $products) {
    ?>
        <div class="product-inhome">
            <div class="container">
                <div class="title-standard">
                    <h2>
                        <a href="javascript:void(0)"><?= Yii::t('app', 'suggest_to_day') ?></a>
                    </h2>
                    <a href="<?= $other['link_all'] ?>" class="view-more"><?= Yii::t('app', 'view_all') ?> <i class="fa fa-angle-right"></i><i class="fa fa-angle-right"></i></a>
                </div>
                <div class="list-product-inhome">
                    <div class="row-5 multi-columns-row">
                        <?= frontend\widgets\html\HtmlWidget::widget([
                                'input' => [
                                    'products' => $products,
                                    'div_col' => '<div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">'
                                ],
                                'view' => 'view_product_1'
                            ]);
                        ?>
                    </div>
                </div>
                <div class="full-width center">
                    <a href="<?= $other['link_all'] ?>" class="btn-style-1"><?= Yii::t('app', 'view_more') ?></a>
                </div>
            </div>
        </div>
<?php } ?>
