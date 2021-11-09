<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\product\CertificateProductItem */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="certificate-product-item-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'product_id')->textInput() ?>

    <?= $form->field($model, 'certificate_product_id')->textInput() ?>

    <?= $form->field($model, 'avatar_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'avatar_path')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
