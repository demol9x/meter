<style>
    .shop-box {
        overflow: auto;
        height: calc(100vh - 100px);
        width: 100%;
    }
</style>
<div class="shop-box">
    <?php
    if ($data) {
        echo frontend\widgets\html\HtmlWidget::widget([
            'input' => [
                'shops' => $data,
            ],
            'view' => 'view_shop_search'
        ]);
    } else {
        echo '<p style="padding: 10px">Không tìm thấy gian hàng.</p>';
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