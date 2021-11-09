<style>
    .col-lg-5-12-item .item-product-inhome {
        width: 100%;
    }

    .product-in-store {
        overflow: auto;
        height: calc(100vh - 117px);
        overflow-x: hidden;
        width: 100%;
        padding: 10px;
    }
    .gm-ui-hover-effect {
        right: 2px !important;
    }
</style>
<div class="search-width-googlemap">
    <div class="container">
        <div class="product-in-store">
            <div class="row-5-flex multi-columns-row">
                <?php if (isset($data) && $data) { ?>
                    <?= frontend\widgets\html\HtmlWidget::widget([
                        'input' => [
                            'products' => $data,
                            'div_col' => '<div class="col-lg-5-12-item">'
                        ],
                        'view' => 'view_product_1_nolazy'
                    ]);
                    ?>
                <?php } else { ?>
                    <div class="col-lg-5-12-item" style="padding: 20px;">
                        <?= Yii::t('app', 'havent_product') ?>
                    </div>
                <?php } ?>
            </div>
            <div class="paginate" id="load-page-search">
                <?=
                    yii\widgets\LinkPager::widget([
                        'pagination' => new yii\data\Pagination([
                            'defaultPageSize' => $limit,
                            'totalCount' => $totalitem
                        ])
                    ]);
                ?>
            </div>
            <script>
                $('#load-page-search li a').click(function() {
                    loadAjax($(this).attr('href'), $('#from-search-mobile').serialize(), $('#box-load-search'));
                    return false;
                });
            </script>
        </div>
    </div>
</div>