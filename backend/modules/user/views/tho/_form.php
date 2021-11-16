<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\user\Tho */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tho-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'tot_nghiep')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nghe_nghiep')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'chuyen_nganh')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kinh_nghiem')->textInput() ?>

    <?= $form->field($model, 'kinh_nghiem_description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'attachment')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
