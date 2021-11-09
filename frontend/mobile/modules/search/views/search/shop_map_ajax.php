<?php
$listMap = $data;
?>
<?=
    \frontend\widgets\html\HtmlWidget::widget([
        'view' => 'map-search-shop-ajax',
        'input' => [
            'zoom' => 12,
            'center' => $center,
            'listMap' => $listMap,
            'get_range' => $get_range,
        ]
    ])
?>
<div class="btn-show-all-address">
    <i class="fa fa-angle-up"></i>
    <p>
        Danh sách sản phẩm
        <span><?= $totalitem ?> địa điểm</span>
    </p>
</div>
<div class="col-list-address">
    <div class="ds-addres ds-addres-shop" id="box-list-item-search">
        <p id="view-all-search" class="click center"><?= Yii::t('app', 'view_all') ?></p>
        <?php if ($data) {
            echo frontend\widgets\html\HtmlWidget::widget([
                'input' => [
                    'shops' => $data,
                ],
                'view' => 'view_shop_search'
            ]); ?>
            <div class="paginate" id="load-page-search">
                <?=
                    yii\widgets\LinkPager::widget([
                        'pagination' => new yii\data\Pagination([
                            'pageSize' => $limit,
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
        <?php } else { ?>
            <p style="padding: 15px;"><?= Yii::t('app', 'product_not_found') ?></p>
        <?php } ?>
    </div>
</div>