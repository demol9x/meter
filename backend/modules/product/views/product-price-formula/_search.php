<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\product\search\ProductPriceFormulaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-price-formula-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'code_app') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'formula_product') ?>

    <?= $form->field($model, 'formula_gold') ?>

    <?php // echo $form->field($model, 'formula_fee') ?>

    <?php // echo $form->field($model, 'formula_stone') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'coefficient1') ?>

    <?php // echo $form->field($model, 'coefficient2') ?>

    <?php // echo $form->field($model, 'coefficient3') ?>

    <?php // echo $form->field($model, 'coefficient4') ?>

    <?php // echo $form->field($model, 'coefficient5') ?>

    <?php // echo $form->field($model, 'coefficient6') ?>

    <?php // echo $form->field($model, 'coefficient7') ?>

    <?php // echo $form->field($model, 'coefficient8') ?>

    <?php // echo $form->field($model, 'coefficient9') ?>

    <?php // echo $form->field($model, 'coefficientm') ?>

    <?php // echo $form->field($model, 'coefficientx') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
