<link rel="stylesheet" href="<?= yii::$app->homeUrl ?>css/themdiachicanhan.css">
<?php

use yii\widgets\ActiveForm;
use  yii\helpers\Html;
use common\models\package\Package;

$package = new Package();

?>
<script src="<?php echo Yii::$app->homeUrl ?>js/ckeditor/ckeditor.js"></script>
<script>
    <?php if($model->ckedit_desc) { ?>
    jQuery(document).ready(function () {
        CKEDITOR.replace("package-short_description", {
            height: 200,
            language: '<?php echo Yii::$app->language ?>'
        });
        CKEDITOR.replace("package-description", {
            height: 200,
            language: '<?php echo Yii::$app->language ?>'
        });
    });
    <?php } ?>
    jQuery(document).ready(function () {
        $('#package-ckedit_desc').on("click", function () {
            if (this.checked) {
                CKEDITOR.replace("package-short_description", {
                    height: 400,
                    language: '<?php echo Yii::$app->language ?>'
                });
                CKEDITOR.replace("package-description", {
                    height: 400,
                    language: '<?php echo Yii::$app->language ?>'
                });
            } else {
                var a = CKEDITOR.instances['package-short_description'];
                if (a) {
                    a.destroy(true);
                }

                var b = CKEDITOR.instances['package-description'];
                if (b) {
                    b.destroy(true);
                }

            }
        });
    });
</script>
<div class="item_right">
    <div class="form-create-store">
        <div class="title-form">
            <h2 class="content_15"><img src="<?= yii::$app->homeUrl ?>images/ico-bansanpham.png" alt="">
                Thêm gói thầu </h2>
        </div>
        <div class="ctn-form">
            <?php
            $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']])
            ?>
            <?=
            $form->field($model, 'name', [
                'template' => '<div class="item-input-form">{label}<div class="group-input"><div class="full-input">{input}{error}</div></div></div>{hint}'
            ])->textInput([
                'placeholder' => 'Tên gói thầu',
            ])->label('Tên gói thầu', ['class' => 'content_14']);
            ?>
            <?=
            $form->field($model, 'shop_id', [
                'template' => '<div class="item-input-form">{label}<div class="group-input"><div class="full-input">{input}{error}</div></div></div>{hint}'
            ])->dropDownList(\frontend\models\User::getShop(), ['prompt' => 'Chọn nhà thầu'])->label('Chọn nhà thầu', ['class' => 'content_14']);
            ?>

            <?=
            $form->field($model, 'price', [
                'template' => '<div class="item-input-form">{label}<div class="group-input"><div class="full-input">{input}{error}</div></div></div>{hint}'
            ])->textInput([
                'placeholder' => '500000000',
            ])->label('Vốn điều lệ', ['class' => 'content_14']);
            ?>
            <?=
            $form->field($model, 'address', [
                'template' => '<div class="item-input-form">{label}<div class="group-input"><div class="full-input">{input}{error}</div></div></div>{hint}'
            ])->textInput([
                'placeholder' => 'Nhập địa chỉ',

            ])->label('Nhập đia chỉ', ['class' => 'content_14']);
            ?>
            <?=
            $form->field($model, 'province_id', [
                'template' => '<div class="item-input-form">{label}<div class="group-input"><div class="full-input">{input}{error}</div></div></div>{hint}'
            ])->dropDownList(\common\models\Province::optionsProvince(), ['prompt' => 'Chọn thành phố','class'=>'select-province-id'])->label('Thành phố', ['class' => 'content_14']);
            ?>
            <?=
            $form->field($model, 'district_id', [
                'template' => '<div class="item-input-form">{label}<div class="group-input"><div class="full-input">{input}{error}</div></div></div>{hint}'
            ])->dropDownList(\common\models\District::dataFromProvinceId($model->province_id), ['prompt' => 'Chọn quận huyện','class'=>'select-district-id'])->label('Quận huyện', ['class' => 'content_14']);
            ?>
            <?=
            $form->field($model, 'ward_id', [
                'template' => '<div class="item-input-form">{label}<div class="group-input"><div class="full-input">{input}{error}</div></div></div>{hint}'
            ])->dropDownList(\common\models\Ward::dataFromDistrictId($model->district_id), ['prompt' => 'Chọn phường xã','class' => 'select-ward-id'])->label('phường xã', ['class' => 'content_14']);
            ?>
            <?=
            $form->field($model, 'status', [
                'template' => '<div class="item-input-form">{label}<div class="group-input"><div class="full-input">{input}{error}</div></div></div>{hint}'
            ])->dropDownList(Package::getStatus(), ['prompt' => 'Chọn Trạng thái'])->label('Trạng thái', ['class' => 'content_14']);
            ?>
            <?= $form->field($model, 'ckedit_desc', ['template' => '<div class="item-input-form">{label}<div class="group-input"><div class="full-input">{input}{error}</div></div></div>{hint}'])->checkbox([
                'label' => NULL
            ])->label('Sử dụng trình soạn thảo') ?>
            <?= $form->field($model, 'short_description',
                ['template' => '<div class="item-input-form">{label}<div class="group-input"><div class="full-input">{input}{error}</div></div></div>{hint}'])
                ->textarea(['rows' => 6])
            ?>

            <?= $form->field($model, 'description', ['template' => '<div class="item-input-form">{label}<div class="group-input"><div class="full-input">{input}{error}</div></div></div>{hint}'])->textarea(['rows' => 6]) ?>

            <?= $form->field($model, 'file', ['template' => '<div class="item-input-form">{label}<div class="group-input"><div class="full-input">{input}{error}</div></div></div>{hint}'])->textInput(['type' => 'file']) ?>
            <script type="text/javascript">
                $(document).ready(function () {
                    $('.select-province-id').change(function () {
                        var province_id = $(this).val();
                        $.getJSON(
                            "<?=\yii\helpers\Url::to(['/suggest/getdistrict'])?>", {
                                province_id: province_id,
                                label: 'Quận/huyện'
                            }
                        ).done(function (data) {
                            $('.select-district-id').html(data.html);
                            $('.select-ward-id').html('<option>Phường/xã</option>');
                            $('.loading').removeClass('active');
                        }).fail(function (jqxhr, textStatus, error) {
                            var err = textStatus + ", " + error;
                            console.log("Request Failed: " + err);

                        });
                    });

                    $('.select-district-id').change(function () {
                        var district_id = $(this).val();
                        $.getJSON(
                            "<?=\yii\helpers\Url::to(['/suggest/getward'])?>", {
                                district_id: district_id,
                                label: 'Phường/xã'
                            }
                        ).done(function (data) {
                            $('.select-ward-id').html(data.html);
                        }).fail(function (jqxhr, textStatus, error) {
                            var err = textStatus + ", " + error;
                            console.log("Request Failed: " + err);
                        });
                    });
                });
            </script>

        <div class="btn-submit-form">
            <input type="submit" id="user-form" value="Thêm gói thầu">
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
</div>