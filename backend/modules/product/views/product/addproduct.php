<?php

use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use yii\bootstrap\Html;
use yii\widgets\Pjax;
?>
<div class="no-border">
    <div class="widget-header">
        <h4>
            Thêm sản phẩm vào nhóm <?= $model->name ?>
        </h4>
    </div>
    <div class="col-xs-12">
        <div class="row">
            <div class="col-sm-7">
                <div class="widget-box" id="searchproduct">
                    <div class="widget-header header-color-grey">
                        <h4 class="lighter smaller">Tìm kiếm sản phẩm</h4>
                    </div>
                    <div class="widget-body">
                        <div class="widget-main padding-8">
                            <?php
                            Pjax::begin([
                                'id' => 'dataProductSearch',
                                'enablePushState' => false,
                                'enableReplaceState' => false,
                            ])
                            ?>
                            <?=
                            GridView::widget([
                                'dataProvider' => $dataProvider,
                                'filterModel' => $searchModel,
                                'columns' => [
                                    'id',
                                    'name',
                                    [
                                        'class' => 'yii\grid\ActionColumn',
                                        'template' => '{addtochoice}',
                                        'buttons' => [
                                            'addtochoice' => function ($url, $model) {
                                                $urlToFrontend = 'javascript:void(0)';
                                                return Html::a('<span class="glyphicon glyphicon-arrow-right"></span>', $urlToFrontend, [
                                                            'onclick' => 'return AddToChoice("' . $model->id . '", this)',
                                                ]);
                                            },
                                                ],
                                            ],
                                        ],
                                    ]);
                                    ?>
                                    <?php Pjax::end(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-5" id="choicedproduct">
                        <?php
                        $form = ActiveForm::begin([
                                    'id' => 'product-groups-form',
                                    'options' => [
                                        'class' => 'form-horizontal'
                                    ]
                        ]);
                        ?>
                        <div class="widget-box">
                            <div class="widget-header header-color-green2">
                                <h4 class="lighter smaller">Sàn phẩm đã chọn</h4>
                                <div class="widget-toolbar no-border">
                                    <input class="btn btn-xs btn-primary" id="btnProductSave" type="submit" name="yt1" value="Lưu sản phẩm đã chọn">
                                </div>
                            </div>
                            <div class="widget-body">
                                <div class="widget-main padding-8">
                                    <table class="table table-bordered table-hover vertical-center products">
                                        <thead>
                                            <tr>
                                                <th id="products-grid_c0">Tên sản phẩm</th>
                                                <th id="products-grid_caction">&nbsp;</th></tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <?=
                        Html::hiddenInput('rel_products', NULL, [
                            'id' => 'choicedProducts'
                        ])
                        ?>
                        <?php
                        ActiveForm::end();
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <script>
            var choicedproducts = [];
            //
            jQuery(document).ready(function () {
                jQuery('#btnProductSave').on('click', function () {
                    if (choicedproducts.length <= 0) {
                        return false;
                    }
                    jQuery('#choicedProducts').val(choicedproducts.join(','));
                    return true;
                });
        <?php if ($isAjax) { ?>
                    var formSubmit = true;
                    jQuery('#product-groups-form').on('submit', function () {
                        if (!formSubmit) {
                            return false;
                        }
                        formSubmit = false;
                        var thi = jQuery(this);
                        jQuery.ajax({
                            'type': 'POST',
                            'dataType': 'JSON',
                            'beforeSend': function () {
                            },
                            'url': thi.attr('action'),
                            'data': thi.serialize(),
                            'success': function (res) {
                                if (res.code == 200) {
                                    $.pjax.reload({container: '#pjax-list'});
                                    $.colorbox.close();
                                }
                                formSubmit = true;
                            },
                            'error': function () {
                                formSubmit = true;
                            }
                        });
                        return false;
                    });
        <?php } ?>
    });
    function AddToChoice(id, obj) {
        var obj = jQuery(obj);
        obj.addClass('hidden');
        var next = obj.next();
        if (next) {
            next.removeClass('hidden');
        }
        var tr = obj.closest('tr');
        var html = '<tr id="pro' + id + '">' + tr.html() + '</tr>';
        tr.remove();
        if (jQuery('#pro' + id).length > 0) {
            return false;
        }
        choicedproducts.push(id);
        jQuery('#choicedproduct .products').find('tbody').prepend(html);
        return false;
    }
    function RemoveChoice(id, obj) {
        choicedproducts = jQuery.grep(choicedproducts, function (a) {
            return a !== id;
        });
        var obj = jQuery(obj);
        obj.closest('tr').remove();
        return false;
    }
</script>