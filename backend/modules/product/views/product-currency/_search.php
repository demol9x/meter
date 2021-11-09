<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\product\search\ProductCurrencySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-currency-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'code_app') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'price_sell') ?>

    <?= $form->field($model, 'price_buy') ?>

    <?php // echo $form->field($model, 'gold_yn') ?>

    <?php // echo $form->field($model, 'money_yn') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
