<?php

use yii\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Html;
use common\components\ClaHost;
use common\models\product\Product;
use yii\data\ArrayDataProvider;
use yii\widgets\Pjax;
?>

<link rel="stylesheet" href="<?= Url::home() ?>js/colorbox/style3/colorbox.css"></link>
<script src="<?= Url::home() ?>js/colorbox/jquery.colorbox-min.js"></script>
<?php if ($model->isNewRecord) { ?>
    <p>Bạn phải tạo sản phẩm xong mới tạo được mục này</p>
<?php } else { ?>
    <a id="addProduct" href="<?= Url::to(['/product/product/add-to-relation', 'pid' => $model->id]) ?>" class="btn btn-sm btn-primary">
        Thêm sản phẩm vào nhóm
    </a>
<?php } ?>
<?php
$data = common\models\product\ProductRelation::getDataRelationForProvider($model->id);
$dataProviderRelation = new ArrayDataProvider([
    'allModels' => $data,
    'sort' => [
        'attributes' => ['id'],
    ],
    'pagination' => [
        'pageSize' => 100,
    ],
        ]);
?>

<?php
$this->registerJs("
    $(document).on('ready pjax:success', function () {
        $('.ajaxDelete').on('click', function (e) {
            e.preventDefault();
            var deleteUrl = $(this).attr('delete-url');
            var pjaxContainer = $(this).attr('pjax-container');
            if (confirm('Bạn có chắc muốn xóa sản phẩm này?')) {
                $.ajax({
                    url: deleteUrl,
                    type: 'post',
                    error: function (xhr, status, error) {
                        alert('There was an error with your request.' + xhr.responseText);
                    }
                }).done(function (data) {
                    $.pjax.reload({container: '#' + $.trim(pjaxContainer)});
                });
            }
            ;
        });
    });
");
?>
<?php
Pjax::begin([
    'id' => 'pjax-list',
    'enablePushState' => false,
    'enableReplaceState' => false,
]);
?>
<?=
GridView::widget([
    'dataProvider' => $dataProviderRelation,
    'id' => 'relation-grid',
    'columns' => [
        'image' => [
            'header' => 'Ảnh',
            'content' => function($item) {
                $product = Product::findOne($item['relation_id']);
                return '<img src="' . ClaHost::getImageHost() . $product['avatar_path'] . 's100_100/' . $product['avatar_name'] . '" />';
            }
        ],
        'relation_id' => [
            'header' => 'Tên sản phẩm',
            'value' => function($item) {
                $product = Product::findOne($item['relation_id']);
                return $product->name;
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{delete}',
            'buttons' => [
                'delete' => function ($url, $item) {
                    $url = Url::to([
                                '/product/product/delete-relation',
                                'product_id' => $item['product_id'],
                                'relation_id' => $item['relation_id']
                    ]);
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', false, ['class' => 'ajaxDelete', 'delete-url' => $url, 'pjax-container' => 'pjax-list', 'title' => 'Xóa', 'style' => 'cursor: pointer']);
                }
                    ],
                ],
            ],
        ]);
        ?>
        <?php Pjax::end(); ?>
<script>
    jQuery(document).ready(function () {
        $("#addProduct").colorbox({width: "80%", maxHeight: '100%', overlayClose: false});
    });
</script>