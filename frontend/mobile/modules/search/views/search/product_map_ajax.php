<?php

use yii\helpers\Url;
use common\components\ClaLid;

$latlngdf = ClaLid::getLatlngDefault();
$FullTextlatlngdf = ClaLid::getFullTextLatlngDefault();
$listMap = $data;
// $listid = [];
// foreach ($products as $product) {
//     if(!in_array($product['shop_id'] , $listid)) {
//         $listMap[] = $product;
//         $listid[] = $product['shop_id'];
//     }
// }
?>
<?=
    \frontend\widgets\html\HtmlWidget::widget([
        'view' => 'map-search-ajax',
        'input' => [
            'zoom' => 12,
            'center' => $center,
            'listMap' => $listMap,
            'get_range' => $get_range
        ]
    ])
?>
<div class="btn-show-all-address active">
    <i class="fa fa-angle-up"></i>
    <p>
        Danh sách sản phẩm
        <span><?= $totalitem ?> Địa điểm</span>
    </p>
    <script>
        $(".btn-show-all-address").click(function() {
            $(this).toggleClass('active');
            $('.col-list-address').toggleClass('active');
        });
    </script>
</div>
<div class="col-list-address active">
    <div class="ds-addres" id="box-list-item-search">
        <p id="view-all-search" class="click center"><?= Yii::t('app', 'view_all') ?></p>
        <?php if ($data) {
            echo frontend\widgets\html\HtmlWidget::widget([
                'input' => [
                    'products' => $data,
                ],
                'view' => 'view_product_search'
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