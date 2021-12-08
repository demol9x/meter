<?php

use yii\widgets\ActiveForm;

?>

<link rel="stylesheet" href="<?= yii::$app->homeUrl ?>css/themdiachicanhan.css">

<div class="item_right">
    <div class="form-create-store">
        <div class="title-form">
            <h2 class="content_15"><img src="<?= yii::$app->homeUrl ?>images/ico-bansanpham.png" alt=""> Thông tin cá
                nhân</h2>
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
            $form->field($model, 'username', [
                'template' => '<div class="item-input-form">{label}<div class="group-input"><div class="full-input">{input}{error}</div></div></div>{hint}'
            ])->textInput([
                'class' => '',
                'placeholder' => 'Tên người dùng',
            ])->label('Tên người dùng', ['class' => 'content_14']);
            ?>
            <?=
            $form->field($model, 'phone', [
                'template' => '<div class="item-input-form">{label}<div class="group-input"><div class="full-input">{input}{error}</div></div></div>{hint}'
            ])->textInput([
                'class' => 'content_14',
                'placeholder' => 'Điện thoại',
            ])->label('Điện thoại', ['class' => 'content_14']);
            ?>
            <?=
            $form->field($model, 'email', [
                'template' => '<div class="item-input-form">{label}<div class="group-input"><div class="full-input">{input}{error}</div></div></div>{hint}'
            ])->textInput([
                'class' => 'content_14',
                'placeholder' => 'Nhập email',
            ])->label('Email', ['class' => 'content_14']);
            ?>
            <?=
            $form->field($model, 'birthday', [
                'template' => '<div class="item-input-form">{label}<div class="group-input"><div class="full-input">{input}{error}</div></div></div>{hint}'
            ])->textInput([
                'type'=>'date',
                'class' => 'content_14',
               'value'=>  $model['birthday'] ? date('Y-m-d H:i:s',$model['birthday']) : '' ,
            ])->label('Ngày sinh', ['class' => 'content_14']);
            ?>
            <div class="btn-submit-form">
                <input type="submit" id="user-form" value="Sửa thông tin">
            </div>
            <?php
            ActiveForm::end();
            ?>
        </div>
    </div>
</div>
