<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use common\models\product\ProductCategory;
use yii\helpers\ArrayHelper;
use common\models\product\Product;
use common\models\shop\Shop;
use common\components\ClaHost;

/* @var $this yii\web\View */
/* @var $searchModel common\models\product\searchProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'product_management');
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
    select {
        width: 100%;
        height: 32px;
        background: #fff;
        padding: 0px 10px;
        min-width: 97px;
    }

    .fa-times {
        color: red;
    }

    .fa-check {
        color: green;
    }

    .updateajax {
        display: block;
        text-align: center;
        cursor: pointer;
    }

    .box-checkbox {
        position: relative;
        clear: both;
        cursor: pointer;
    }

    .box-checkbox::before {
        content: '';
        display: block;
        position: absolute;
        top: 0px;
        left: 0px;
        width: 100%;
        height: 100%;
        z-index: 1;
    }

    .box-checkbox.check .switcherys {
        background-color: rgb(38, 185, 154) !important;
        border-color: rgb(38, 185, 154);
        box-shadow: rgb(38, 185, 154) 0px 0px 0px 11px inset !important;
        transition: border 0.4s, box-shadow 0.4s, background-color 1.2s !important;
    }

    .box-checkbox.check .switcherys small {
        left: 11px !important;
        background-color: rgb(255, 255, 255) !important;
        transition: background-color 0.4s, left 0.2s !important;
    }

    .box-checkbox .switcherys {
        box-shadow: rgb(223, 223, 223) 0px 0px 0px 0px inset;
        border-color: rgb(223, 223, 223);
        background-color: rgb(255, 255, 255);
        transition: border 0.4s, box-shadow 0.4s;
    }

    .box-checkbox .switcherys small {
        left: 0px;
        transition: background-color 0.4s, left 0.2s;
    }
    
</style>
<div class="product-index">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><?= Html::encode($this->title) ?></h2>
                    <?= Html::a(Yii::t('app', 'create_product'), ['create'], ['class' => 'btn btn-success pull-right']) ?>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?php
                    $model_category = new ProductCategory();
                    ?>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            'id',
                            'images' => [
                                'header' => Yii::t('app', 'image'),
                                'content' => function ($model) {
                                    return '<img src="' . ClaHost::getImageHost() . $model['avatar_path'] . 's100_100/' . $model['avatar_name'] . '" />';
                                }
                            ],
                            'name',
                            [
                                'attribute' => 'category_id',
                                'content' => function ($model) {
                                    return $model->category->name;
                                },
                                'filter' => Html::activeDropDownList($searchModel, 'category_id', $model_category->optionsCategory(), ['class' => 'form-control'])
                            ],
                            // 'code',
                            [
                                'attribute' => 'price',
                                'value' => function ($model) {
                                    return number_format($model->price, 0, ',', '.');
                                }
                            ],
                            [
                                'attribute' => 'ishot',
                                'content' => function ($model) {
                                    if ($model->ishot) {
                                        return '<div class="box-checkbox check" check="1">
                                                    <span class="switchery switcherys updateajax"  data-link="' . Url::to(['/product/product/updatermthot', 'id' => $model->id]) . '"><small></small></span>
                                                </div>';
                                    }
                                    return '<div class="box-checkbox"  check="0">
                                                <span class="switchery switcherys updateajax" data-link="' . Url::to(['/product/product/updateaddhot', 'id' => $model->id]) . '" ><small></small></span>
                                            </div>';
                                },
                                'filter' => Html::activeDropDownList($searchModel, 'ishot', [1 => Yii::t('app', 'on'), 0 => Yii::t('app', 'off')], ['class' => 'form-control', 'prompt' => Yii::t('app', 'selects')])
                            ],
                            [
                                'attribute' => 'isnew',
                                'content' => function ($model) {
                                    if ($model->isnew) {
                                        return '<div class="box-checkbox check" check="1">
                                                    <span class="switchery switcherys updateajax"  data-link="' . Url::to(['/product/product/updatermtnew', 'id' => $model->id]) . '"><small></small></span>
                                                </div>';
                                    }
                                    return '<div class="box-checkbox"  check="0">
                                                <span class="switchery switcherys updateajax" data-link="' . Url::to(['/product/product/updateaddnew', 'id' => $model->id]) . '" ><small></small></span>
                                            </div>';
                                },
                                'filter' => Html::activeDropDownList($searchModel, 'isnew', [1 => Yii::t('app', 'on'), 0 => Yii::t('app', 'off')], ['class' => 'form-control', 'prompt' => Yii::t('app', 'selects')])
                            ],
                            [
                                'attribute' => 'status',
                                'content' => function ($model) {
                                    return $model->status == 1 ? 'Hiển thị' : 'Ẩn';
                                },
                                'filter' => Html::activeDropDownList($searchModel, 'status', [1 => 'Hiển thị', 0 => 'Ẩn'], ['class' => 'form-control', 'prompt' => Yii::t('app', 'selects')])
                            ],
                            'order',
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{update} {copy} {delete}',
                                'buttons' => [
                                    'copy' => function ($url, $model) {
                                        return \yii\helpers\Html::a('<div class="text-center"><em data-toggle="tooltip"
                                                            data-placement="top" title="Sao chép"
                                                            class="fa fa-external-link-square"></em></div>',
                                            (new yii\grid\ActionColumn())->createUrl('/product/product/create', $model, $model['id'], 1), [
                                                'title' => Yii::t('yii', 'view'),
                                                'data-method' => 'post',
                                                'data-pjax' => '0',
                                            ]);
                                    },
                                ]
                            ],
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function changeStatusProduct(_this, pid, shop_status) {
        var status = $(_this).val();
        if (shop_status == 1 || status != '1') {
            $.getJSON(
                '<?= \yii\helpers\Url::to(['/product/product/change-status']) ?>', {
                    status: status,
                    pid: pid
                },
                function (data) {
                    if (data.code == 200) {
                        alert('Cập nhật trạng thái thành công');
                        location.reload();
                    }
                }
            );
        } else {
            alert('Gian hàng chưa được xác thực. Vui lòng xác thực gian hàng trước khi xác thực sản phẩm.');
            $(_this).val(2);
        }

    }
</script>
<script type="text/javascript">
    jQuery(document).on('click', '.box-checkbox', function () {
        if (confirm("<?= Yii::t('app', 'you_sure_change') ?>")) {
            $(this).css('display', 'none');
            setTimeout(function () {
                $('.box-checkbox').css('display', 'block');
            }, 1000);
            var checkbox = $(this).find('.updateajax').first();
            changeHot(checkbox);
            var label = $(this).find('.switchery').first();
            if (!$(this).hasClass('check')) {
                $(this).addClass('check');
            } else {
                $(this).removeClass('check');
            }
        }
        return false;
    });

    function changeHot(_this) {
        var link = _this.attr('data-link');
        if (link) {
            jQuery.ajax({
                type: 'get',
                dataType: 'json',
                url: link,
                data: null,
                success: function (res) {
                    if (res.code == 200) {
                        // _this.html(res.html);
                        _this.attr('data-link', res.link);
                        // _this.attr('title',res.title);
                    } else {
                        alert('<?= Yii::t('app', 'update_fail') ?>');
                    }
                },
                error: function () {
                    alert('<?= Yii::t('app', 'update_fail') ?>');
                }
            });
        }
    }
</script>