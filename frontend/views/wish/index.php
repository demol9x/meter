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
                        <h2><?= Yii::t('app', 'list_like') ?></h2>
                    </div>
                </div>
                <div class="product-in-store">
                    <div class="row-5-flex multi-columns-row">
                        <?php
                            if ($data) {
                                echo frontend\widgets\html\HtmlWidget::widget([
                                    'input' => [
                                        'products' => $data,
                                        'div_col' => '<div class="col-lg-5-12-item">'
                                    ],
                                    'view' => 'view_product_1'
                                ]);
                            }
                        ?>
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
        </div>
    </div>
</div>