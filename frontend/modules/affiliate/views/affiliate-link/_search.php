<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\affiliate\search\AffiliateLinkSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="affiliate-link-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'url') ?>

    <?= $form->field($model, 'link') ?>

    <?= $form->field($model, 'link_short') ?>

    <?php // echo $form->field($model, 'campaign_source') ?>

    <?php // echo $form->field($model, 'aff_type') ?>

    <?php // echo $form->field($model, 'campaign_name') ?>

    <?php // echo $form->field($model, 'campaign_content') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'object_id') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
