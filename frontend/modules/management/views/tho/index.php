<link rel="stylesheet" href="<?= yii::$app->homeUrl ?>css/themdiachicanhan.css">
<?php
use common\models\general\ChucDanh;
use yii\widgets\ActiveForm;
use  yii\helpers\Html;
use common\models\user\Tho;

?>
<div class="item_right">
    <div class="form-create-store">
        <div class="title-form">
            <h2 class="content_15"><img src="<?= yii::$app->homeUrl ?>images/ico-bansanpham.png" alt="">
                Thông tin thợ </h2>
        </div>
        <div class="ctn-form">
            <?php
            $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']])
            ?>
            <?=
            $form->field($model, 'name', [
                'template' => '<div class="item-input-form">{label}<div class="group-input"><div class="full-input">{input}{error}</div></div></div>{hint}'
            ])->textInput([
                'placeholder' => 'Tên thợ',
            ])->label('Tên thợ', ['class' => 'content_14']);
            ?>
            <?=
            $form->field($model, 'tot_nghiep', [
                'template' => '<div class="item-input-form">{label}<div class="group-input"><div class="full-input">{input}{error}</div></div></div>{hint}'
            ])->textInput([
                'placeholder' => 'Tốt nghiệp trường',
            ])->label('Tốt nghiệp trường', ['class' => 'content_14']);
            ?>
            <?=
            $form->field($model, 'nghe_nghiep', [
                'template' => '<div class="item-input-form">{label}<div class="group-input"><div class="full-input">{input}{error}</div></div></div>{hint}'
            ])->dropDownList(ChucDanh::getJob(), ['prompt' => 'Nghề nghiệp'])->label('Chọn Nghề nghiệp', ['class' => 'content_14']);
            ?>

            <?=
            $form->field($model, 'chuyen_nganh', [
                'template' => '<div class="item-input-form">{label}<div class="group-input"><div class="full-input">{input}{error}</div></div></div>{hint}'
            ])->textInput([
                'placeholder' => 'Chuyên ngành VD : CNTT',
            ])->label('Chuyên ngành', ['class' => 'content_14']);
            ?>
            <?=
            $form->field($model, 'kinh_nghiem', [
                'template' => '<div class="item-input-form">{label}<div class="group-input"><div class="full-input">{input}{error}</div></div></div>{hint}'
            ])->dropDownList(Tho::numberKn(), ['prompt' => 'Chọn'])->label('Số năm kinh nghiệm', ['class' => 'content_14']);
            ?>
            <?=
            $form->field($model, 'kinh_nghiem_description', [
                'template' => '<div class="item-input-form">{label}<div class="group-input"><div class="full-input">{input}{error}</div></div></div>{hint}'
            ])->textInput([
                'placeholder' => 'Cụ thể kinh nghiệm làm việc VD : CNTT',
            ])->label('Mô tả kinh nghiệm làm việc', ['class' => 'content_14']);
            ?>
            <?=
            $form->field($model, 'description', [
                'template' => '<div class="item-input-form">{label}<div class="group-input"><div class="full-input">{input}{error}</div></div></div>{hint}'
            ])->textInput([
                'placeholder' => 'Mô tả bản thân ',
            ])->label('Mô tả bản thân', ['class' => 'content_14']);
            ?>
            <?= $form->field($model, 'file',[
                'template' => '<div class="item-input-form">{label}<div class="group-input"><div class="full-input">{input}{error}</div></div></div>{hint}'
            ])->textInput(['type' => 'file']) ?>
            <div class="btn-submit-form">
                <input type="submit" id="user-form" value="Thêm thông tin">
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>