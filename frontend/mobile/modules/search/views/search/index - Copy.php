<?php

use common\components\ClaHost;
use yii\helpers\Url;
use common\components\ClaLid;
?>
<?php
if ($data)
    echo frontend\widgets\html\HtmlWidget::widget([
            'input' => [
                'products' => $data,
                // 'div_col' => '<div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">'
            ],
            'view' => 'view_product_1'
        ]);
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