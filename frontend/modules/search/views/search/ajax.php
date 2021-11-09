<?php
    if ($data) {
        echo frontend\widgets\html\HtmlWidget::widget([
                'input' => [
                    'products' => $data,
                    'div_col' => '<div class="col-lg-5-12-item">'
                ],
                'view' => 'view_product_2'
            ]);
    } else {
        echo "<p>".Yii::t('app', 'havent_product_for_keyword')."</p>";
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
        $('.open-popup-link').magnificPopup({
            type:'inline',
            midClick: true
        });
    });
</script>