<?php
    if ($data) {
        echo frontend\widgets\html\HtmlWidget::widget([
                'input' => [
                    'shops' => $data,
                    'products' => $products,
                ],
                'view' => 'view_shop_0'
            ]);
    } else {
        echo "<p>".Yii::t('app', 'havent_supplier_for_keyword')."</p>";
    }
?>
<div id="li-loadjax" class="paginate">
    <?=
        yii\widgets\LinkPager::widget([
            'pagination' => new yii\data\Pagination([
                'pageSize' => $limit,
                'totalCount' => $totalitem
                    ])
        ]);
    ?>                 
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('.slide-some-product').owlCarousel({
            items: 1,
            loop: false,
            merge: true,
            dots:false,
            nav:true,
            responsive: {
                0:{
                    items: 1,
                },
                530:{
                    items: 1,
                },
                531:{
                    items: 1,
                },
                767:{
                    items: 1,
                },
                992:{
                    items: 1,
                },
                1200:{
                    items: 1,
                },
            }
        });
    });
</script>