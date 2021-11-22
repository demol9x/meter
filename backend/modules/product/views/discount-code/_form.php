<?php

use yii\helpers\Html;
use common\components\ActiveFormC;

/* @var $this yii\web\View */
/* @var $model common\models\product\Brand */
/* @var $form yii\widgets\ActiveForm */

$product_ns = $model->shop_id ? \common\models\product\Product::find()->where(['shop_id' => $model->shop_id])->all() : [];
?>
<style>
    .select-products {
        display: none;
    }

    .select-products.show {
        display: block;
    }
</style>
<div class="news-category-form">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <?php
            $form = ActiveFormC::begin1([
                'options' => [
                    'class' => 'form-horizontal',
                    'enctype' => 'multipart/form-data',
                    'title_form' => $this->title,
                    'id' => 'form-load',
                ]
            ]);
            ?>

            <?= $form->fieldB($model, 'name')->textInput()->label() ?>

            <?= $form->fieldB($model, 'shop_id')->dropDownList(\common\models\shop\Shop::optionShop())->label() ?>

            <?= $form->fieldB($model, 'quantity')->textInput()->label() ?>

            <?= $form->fieldB($model, 'type_discount')->dropDownList(\common\models\product\DiscountCode::optionType())->label() ?>

            <?= $form->fieldB($model, 'value')->textInput()->label() ?>

            <?= $form->fieldB($model, 'count_limit')->textInput(['placeholder' => '1'])->label() ?>

            <?= $form->fieldB($model, 'time_start')->textDate(['format' => 'DD-MM-YYYY HH:mm'])->label() ?>

            <?= $form->fieldB($model, 'time_end')->textDate(['format' => 'DD-MM-YYYY HH:mm'])->label() ?>

            <link rel="stylesheet" href="<?= Yii::$app->homeUrl ?>gentelella/select2/dist/css/select2.min.css">
            <script src="<?= Yii::$app->homeUrl ?>gentelella/select2/dist/js/select2.full.min.js"></script>
            <script>
                jQuery(document).ready(function() {
                    jQuery("#discountshopcode-shop_id").select2({
                        placeholder: "Chọn gian hàng",
                        allowClear: true
                    });
                });
            </script>

            <?php
            //  $form->fieldB($model, 'status')->dropDownList([
            //     \common\components\ClaLid::STATUS_ACTIVED => 'Lưu và tạo mã giảm giá',
            //     \common\components\ClaLid::STATUS_DEACTIVED => 'Lưu nháp và không tạo mã giảm giá',
            // ])->label() 
            ?>

            <?= $form->fieldB($model, 'all')->dropDownList(['1' => 'Tất cả sản phẩm', '0' => 'Nhóm sản phẩm'])->label() ?>

            <div class="select-products <?= $model->all == 0 ? 'show' : '' ?>">
                <div class="form-group field-discountshopcode-all required has-success">
                    <label class="control-label col-md-2 col-sm-2 col-xs-12">Sản phẩm</label>
                    <div class="col-md-10 col-sm-10 col-xs-12">
                        <table class="table" style="margin-top: 10px;">
                            <tbody id="load-product">
                                <?php if ($product_ns) foreach ($product_ns as $product) { ?>
                                    <tr class="trupdt">
                                        <td><input type="checkbox" name="add[]" value="<?= $product->id ?>" class="checkp"></td>
                                        <td>
                                            <b><?= $product->name ?></b>
                                        </td>
                                    </tr>
                                <?php }
                                else { ?>
                                    <tr>
                                        <td colspan="5">Không có sản phẩm</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <script>
                $(document).on('change', '#discountshopcode-all', function() {
                    if ($(this).val() == '0') {
                        $('.select-products').addClass('show');
                        $('#form-load').addClass('checkproduct');
                    } else {
                        $('.select-products').removeClass('show');
                        $('#form-load').removeClass('checkproduct');
                    }
                });
                $("#form-load").submit(function() {
                    if ($(this).hasClass('checkproduct')) {
                        if ($('.checkp:checked').length == 0) {
                            alert("Vui lòng chọn ít nhất một sản phẩm.");
                            return false;
                        }
                    }
                    return true;
                });
                $('#discountshopcode-shop_id').change(function() {
                    loadAjax('<?= \yii\helpers\Url::to(['load-product']) ?>', {
                            shop_id: $(this).val()
                        },
                        $('#load-product'));
                });
            </script>
            <?php ActiveFormC::end1(['update' => $model->id]); ?>
        </div>
    </div>
</div>