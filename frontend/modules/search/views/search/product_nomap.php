<div class="search-width-googlemap">
    <div class="container">
        <div class="product-in-store">
            <div class="row-5-flex multi-columns-row">
                <?php if (isset($products) && $products) { ?>
                    <?= frontend\widgets\html\HtmlWidget::widget([
                        'input' => [
                            'products' => $products,
                            'div_col' => '<div class="col-lg-5-12-item">'
                        ],
                        'view' => 'view_product_1'
                    ]);
                    ?>
                <?php } else { ?>
                    <div class="col-lg-5-12-item" style="padding: 20px;">
                        <?= Yii::t('app', 'havent_product') ?>
                    </div>
                <?php } ?>
            </div>
            <div class="paginate">
                <?=
                    yii\widgets\LinkPager::widget([
                        'pagination' => new yii\data\Pagination([
                            'defaultPageSize' => $limit,
                            'totalCount' => $totalitem
                        ])
                    ]);
                ?>
            </div>
        </div>
    </div>
</div>