<?php
/**
 * Created by PhpStorm.
 * User: trung
 * Date: 6/29/2021
 * Time: 11:10 AM
 */
?>
<?=
$form->field($model, 'contact_name', [
    'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
])->textInput([
    'class' => 'form-control',
    'placeholder' => $model->getAttributeLabel('contact_name')
])->label($model->getAttributeLabel('contact_name'), [
    'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
])
?>

<?=
$form->field($model, 'contact_address', [
    'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
])->textInput([
    'class' => 'form-control',
    'placeholder' => $model->getAttributeLabel('contact_address')
])->label($model->getAttributeLabel('contact_address'), [
    'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
])
?>

<?=
$form->field($model, 'contact_phone', [
    'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
])->textInput([
    'class' => 'form-control',
    'placeholder' => $model->getAttributeLabel('contact_phone')
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
    'placeholder' => $model->getAttributeLabel('contact_email')
])->label($model->getAttributeLabel('contact_email'), [
    'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
])
?>
