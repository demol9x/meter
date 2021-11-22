<?php
/**
 * Created by PhpStorm.
 * User: trung
 * Date: 11/11/2021
 * Time: 9:35 AM
 */

use common\models\package\Package;
$package = new Package();

?>
<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'shop_id')->dropDownList(\frontend\models\User::getShop(), ['prompt' => 'Chọn nhà thầu']) ?>

<?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'province_id')->dropDownList(\common\models\Province::optionsProvince()) ?>

<?= $form->field($model, 'district_id')->dropDownList($package->getDistrict($model)) ?>

<?= $form->field($model, 'ward_id')->dropDownList($package->getWard($model)) ?>

<?= $form->field($model, 'status')->dropDownList(Package::getStatus()) ?>

<?= $form->field($model, 'isnew')->checkbox([
    'class' => 'js-switch',
    'label' => NULL
])->label('Gói HOT') ?>

<?= $form->field($model, 'ishot')->checkbox([
    'class' => 'js-switch',
    'label' => NULL
])->label('Nổi bật') ?>

<?= $form->field($model, 'ckedit_desc')->checkbox([
    'label' => NULL
])->label('Sử dụng trình soạn thảo') ?>

<?= $form->field($model, 'short_description')->textarea(['rows' => 6]) ?>

<?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

<?= $form->field($model, 'file')->textInput(['type' => 'file']) ?>

<?= $form->field($model, 'order')->textInput() ?>

<script>
    jQuery(document).ready(function () {
        $('#package-province_id').on('change', function () {
            jQuery.ajax({
                url: '<?= \yii\helpers\Url::to(['get-district']) ?>',
                type: 'GET',
                data: {
                    province_id: this.value,
                },
                success: function (result) {
                    var response = JSON.parse(result);
                    changeDistrict(response);
                }
            });
        });
    });

    function changeDistrict(data) {
        var html_district = '<option value="">Chọn quận/huyện</option>';
        $.each(data, function (key, val) {
            html_district += '<option value="' + key + '">' + val + '</option>';
        });
        jQuery('#package-district_id').empty().append(html_district);

        jQuery('#package-ward_id').empty();

        $('#package-district_id').on('change', function () {
            jQuery.ajax({
                url: '<?= \yii\helpers\Url::to(['get-ward']) ?>',
                type: 'GET',
                data: {
                    district_id: this.value,
                },
                success: function (result) {
                    var response = JSON.parse(result);
                    var html_ward = '<option value="">Chọn phường/xã</option>';
                    $.each(response, function (key, val) {
                        html_ward += '<option value="' + key + '">' + val + '</option>';
                    });
                    jQuery('#package-ward_id').empty().append(html_ward);
                }
            });
        });
    }
</script>
