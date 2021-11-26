<?php
/**
 * Created by PhpStorm.
 * User: trung
 * Date: 11/23/2021
 * Time: 3:59 PM
 */
use yii\widgets\ActiveForm;

use common\models\package\Package;
$package = new Package();

?>
<style>
    .hidden {
        display: none !important;
    }
    .col-md-55{
        position: relative;
        min-height: 1px;
        float: left;
        padding-right: 10px;
        padding-left: 10px;
    }
    .thumbnail .caption {
        padding: 9px;
        color: #333;
    }
    .thumbnail .image {
        height: 120px;
        overflow: hidden;
    }
    .radio, .checkbox {
        position: relative;
        display: block;
        margin-top: 10px;
        margin-bottom: 10px;
    }
    .view-first .mask {
        opacity: 0;
        background-color: rgba(0,0,0,0.5);
        transition: all 0.4s ease-in-out;
    }
    .view .mask, .view .content {
        position: absolute;
        width: 100%;
        overflow: hidden;
        top: 0;
        left: 0;
    }
    .view-first .tools {
        transform: translateY(-100px);
        opacity: 0;
        transition: all 0.2s ease-in-out;
    }
    .view .tools {
        text-transform: uppercase;
        color: #fff;
        text-align: center;
        position: relative;
        font-size: 17px;
        padding: 3px;
        background: rgba(0,0,0,0.35);
        margin: 43px 0 0 0;
    }
    .thumbnail {
        margin-bottom: 0px;
    }
    .thumbnail {
        height: 190px;
        overflow: hidden;
    }
    .thumbnail {
        display: block;
        padding: 4px;
        margin-bottom: 20px;
        line-height: 1.42857143;
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 4px;
        -webkit-transition: border .2s ease-in-out;
        -o-transition: border .2s ease-in-out;
        transition: border .2s ease-in-out;
    }
    .form-control {
        display: block;
        width: 100%;
        height: 34px;
        padding: 6px 12px;
        font-size: 14px;
        line-height: 1.42857143;
        color: #555;
        background-color: #fff;
        background-image: none;
        border: 1px solid #ccc;
        border-radius: 4px;
        -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
        -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
        transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
    }
    label {
        display: inline-block;
        max-width: 100%;
        margin-bottom: 5px;
        font-weight: bold;
    }
    .profile-company textarea {
        width: 100%;
        height: 200px;
        line-height: 40px;
        padding: 0px 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    #company-form {
        margin: 15px 25px;
        line-height: 43px;
        height: 40px;
        text-transform: uppercase;
        font-weight: 500;
        background-clip: padding-box;
        border-radius: 4px;
        background-color: #289300;
        color: #fff !important;
        display: inline-block;
        padding: 0px 20px;
        white-space: nowrap;
        border: none;
        cursor: pointer;
        margin-right: 10px;
        -webkit-transition: all 0.4s ease;
        transition: all 0.4s ease;
    }
    .form-group {
        margin-bottom: 10px;
    }
    .form-group.required label:after {
        content: '(*)';
        color: red;
        margin-left: 5px;
    }
</style>
<div class="item_right">
    <div class="form-create-store">
        <div class="title-form">
            <h2 class="content_15"><img src="<?= yii::$app->homeUrl ?>images/ico-hoso.png" alt=""> Hồ sơ doanh nghiệp
            </h2>
        </div>
        <?php
        $form = ActiveForm::begin([
            'id' => '',
            'class' => '',
        ])
        ?>
        <div class="table-buyer table-shop profile-company">
            <table>
                <tbody>
                <?= $form->field($shop, 'name')->textInput(['maxlength' => true])->label('Tên công ty') ?>

                <?= $form->field($shop, 'founding')->textInput(['type' => 'date'])->label('Ngày thành lập') ?>

                <?= $form->field($shop, 'number_auth')->textInput(['maxlength' => true])->label('Mã số thuế') ?>

                <?= $form->field($shop, 'business')->textInput(['maxlength' => true])->label('Ngành nghề chính') ?>

                <?= $form->field($shop, 'phone')->textInput(['maxlength' => true])->label('Số điện thoại') ?>

                <?= $form->field($shop, 'email')->textInput(['maxlength' => true])->label('Email') ?>

                <?= $form->field($shop, 'price')->textInput(['maxlength' => true])->label('Vốn điều lệ (triệu)') ?>

                <?= $form->field($shop, 'website')->textInput(['maxlength' => true])->label('Website') ?>

                <?= $form->field($shop, 'province_id')->dropDownList(\common\models\Province::optionsProvince())->label('Tỉnh/ thành phố') ?>

                <?= $form->field($shop, 'district_id')->dropDownList($package->getDistrict($shop))->label('Quận/ huyện') ?>

                <?= $form->field($shop, 'ward_id')->dropDownList($package->getWard($shop))->label('Phường/ xã') ?>

                <?= $form->field($shop, 'address')->textInput(['maxlength' => true])->label('Địa chỉ') ?>

                <?= $form->field($shop, 'description')->textInput(['maxlength' => true])->label('Mô tả') ?>

                <?= $this->render('partial/image', ['form' => $form, 'model' => $shop, 'images' => $images]); ?>
                </tbody>
            </table>
        </div>
        <div class="btn-submit-form">
            <input type="submit" id="company-form" value="Cập nhật">
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<script>
    jQuery(document).ready(function () {
        $('#shop-province_id').on('change', function () {
            jQuery.ajax({
                url: '<?= \yii\helpers\Url::to(['/management/package/get-district']) ?>',
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
        jQuery('#shop-district_id').empty().append(html_district);

        jQuery('#shop-ward_id').empty();

        $('#shop-district_id').on('change', function () {
            jQuery.ajax({
                url: '<?= \yii\helpers\Url::to(['/management/package/get-ward']) ?>',
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
                    jQuery('#shop-ward_id').empty().append(html_ward);
                }
            });
        });
    }
</script>