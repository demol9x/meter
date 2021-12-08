<?php
use yii\widgets\ActiveForm;
?>
<link rel="stylesheet" href="<?= yii::$app->homeUrl?>css/themdiachicanhan.css">

<div class="item_right">
    <div class="form-create-store">
        <div class="title-form">
            <h2 class="content_15"><img src="<?= yii::$app->homeUrl?>images/ico-bansanpham.png" alt=""> TẠO ĐỊA CHỈ</h2>
        </div>
        <div class="ctn-form">
            <style type="text/css">
                .error,
                .help-block {
                    color: red;
                }
                .col-50 {
                    width: 50%;
                    float: left;
                }
                .img-form {
                    min-height: 200px;
                }
                .box-imgs {
                    padding-right: 91px;
                    margin-left: -15px;
                }
                .form-create-store select {
                    display: block !important;
                }
                .form-create-store .nice-select {
                    display: none !important;
                }
            </style>
            <?php
            $form = ActiveForm::begin([])
            ?>
            <?=
            $form->field($model, 'name_contact', [
                'template' => '<div class="item-input-form">{label}<div class="group-input"><div class="full-input">{input}{error}</div></div></div>{hint}'
            ])->textInput([
                'class' => '',
                'placeholder' => 'Tên người liên hệ',
            ])->label('Tên người liên hệ',['class'=>'content_14']);
            ?>
            <?=
            $form->field($model, 'phone', [
                'template' => '<div class="item-input-form">{label}<div class="group-input"><div class="full-input">{input}{error}</div></div></div>{hint}'
            ])->textInput([
                'class' => 'content_14',
                'placeholder' => 'Điện thoại',
            ])->label('Điện thoại',['class'=>'content_14']);
            ?>
            <?=
            $form->field($model, 'email', [
                'template' => '<div class="item-input-form">{label}<div class="group-input"><div class="full-input">{input}{error}</div></div></div>{hint}'
            ])->textInput([
                'class' => 'content_14',
                'placeholder' => 'Nhập email',
            ])->label('Email',['class'=>'content_14']);
            ?>
            <?=
            $form->field($model, 'province_id', [
                'template' => '<div class="item-input-form">{label}<div class="group-input"><div class="full-input">{input}{error}</div></div></div>{hint}'
            ])->dropDownList(\common\models\Province::optionsProvince(),['class'=>'select-province-id','prompt'=>'Tỉnh/Thành'])->label('Tỉnh/thành',['class'=>'content_14']);
            ?>
            <?=
            $form->field($model, 'district_id', [
                'template' => '<div class="item-input-form">{label}<div class="group-input"><div class="full-input">{input}{error}</div></div></div>{hint}'
            ])->dropDownList( \common\models\District::dataFromProvinceId($model->province_id),['prompt'=>'Quận/ Huyện', 'class'=>'select-district-id'])->label('Quận/ Huyện',['class'=>'content_14']);
            ?>
            <?=
            $form->field($model, 'ward_id', [
                'template' => '<div class="item-input-form">{label}<div class="group-input"><div class="full-input">{input}{error}</div></div></div>{hint}'
            ])->dropDownList( \common\models\Ward::dataFromDistrictId($model->district_id),['prompt'=>'Phường/Xã', 'class' => 'select-ward-id'])->label('Phường/Xã',['class'=>'content_14']);
            ?>
            <?=
            $form->field($model, 'address', [
                'template' => '<div class="item-input-form">{label}<div class="group-input"><div class="full-input">{input}{error}</div></div></div>{hint}'
            ])->textInput([
                'class' => 'content_14',
                'placeholder' => 'Nhập địa chỉ ',
            ])->label('Địa chỉ',['class'=>'content_14']);
            ?>
            <?=
            $form->field($model, 'isdefault', [
                'template' => '<div class="item-input-form">{label}<div class="group-input"><div class="full-input">{input}{error}</div></div></div>{hint}'
            ])->dropDownList([0 =>'Không chọn',1=>'Mặc định'],[ ])->label('Mặc định',['class'=>'content_14']);
            ?>
            <div class="btn-submit-form">
                <input type="submit" id="user-form" value="Tạo mới">
            </div>

            <?php
            ActiveForm::end();
            ?>
        </div>
    </div>
</div>
<script>
    function submit_user_form() {
        document.getElementById("user-form").submit();
        return false;
    }
</script>

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