<?php
/**
 * Created by PhpStorm.
 * User: trung
 * Date: 6/29/2021
 * Time: 11:10 AM
 */

$user = Yii::$app->user->identity;
$contact_name = (isset($user->username) && $user->username) ? $user->username : '';
$contact_address = (isset($user->address) && $user->address) ? $user->address : '';
$contact_phone = (isset($user->phone) && $user->phone) ? $user->phone : '';
$contact_email = (isset($user->email) && $user->email) ? $user->email : '';
?>

<div class="ps-basic_info">
    <div class="partial-head">Thông tin Liên hệ</div>
    <div class="partial-content">
        <?=
        $form->field($model, 'contact_name', [
            'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
        ])->textInput([
            'class' => 'form-control',
            'placeholder' => $model->getAttributeLabel('contact_name'),
            'value' => $contact_name
        ])->label($model->getAttributeLabel('contact_name'), [
            'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
        ])
        ?>

        <?=
        $form->field($model, 'contact_address', [
            'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
        ])->textInput([
            'class' => 'form-control',
            'placeholder' => $model->getAttributeLabel('contact_address'),
            'value' => $contact_address
        ])->label($model->getAttributeLabel('contact_address'), [
            'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
        ])
        ?>

        <?=
        $form->field($model, 'contact_phone', [
            'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
        ])->textInput([
            'class' => 'form-control',
            'placeholder' => $model->getAttributeLabel('contact_phone'),
            'value' => $contact_phone
        ])->label($model->getAttributeLabel('contact_phone'), [
            'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
        ])
        ?>

        <?=
        $form->field($model, 'contact_mobile', [
            'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
        ])->textInput([
            'class' => 'form-control',
            'placeholder' => $model->getAttributeLabel('contact_mobile')
        ])->label($model->getAttributeLabel('contact_mobile'), [
            'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
        ])
        ?>

        <?=
        $form->field($model, 'contact_email', [
            'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
        ])->textInput([
            'class' => 'form-control',
            'placeholder' => $model->getAttributeLabel('contact_email'),
            'value' => $contact_email
        ])->label($model->getAttributeLabel('contact_email'), [
            'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
        ])
        ?>
    </div>
</div>