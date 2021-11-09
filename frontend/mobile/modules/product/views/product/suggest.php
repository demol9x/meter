<?php
use common\components\ClaHost;
use yii\helpers\Url;
use common\components\ClaLid;
?>
<div id="main">
    <?= \frontend\widgets\breadcrumbs\BreadcrumbsWidget::widget() ?>
    <div class="categories-product-page">
        <div class="section-product">
            <div class="container">
                <div class="page-goi-y">
                    <div class="title center">
                        <h2><?= Yii::t('app', 'suggest_to_day') ?></h2>
                    </div>
                    <?php 
                        if($data) {
                            echo frontend\widgets\html\HtmlWidget::widget([
                                                'input' => [
                                                    'products' => $data
                                                ],
                                                'view' => 'view_product_1'
                                            ]);
                        }
                    ?>
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
    </div>
</div>