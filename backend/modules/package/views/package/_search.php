<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\package\PackageSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="package-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'shop_id') ?>

    <?= $form->field($model, 'alias') ?>

    <?= $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'avatar_path') ?>

    <?php // echo $form->field($model, 'avatar_name') ?>

    <?php // echo $form->field($model, 'avatar_id') ?>

    <?php // echo $form->field($model, 'isnew') ?>

    <?php // echo $form->field($model, 'ishot') ?>

    <?php // echo $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'ward_id') ?>

    <?php // echo $form->field($model, 'ward_name') ?>

    <?php // echo $form->field($model, 'district_id') ?>

    <?php // echo $form->field($model, 'district_name') ?>

    <?php // echo $form->field($model, 'province_id') ?>

    <?php // echo $form->field($model, 'province_name') ?>

    <?php // echo $form->field($model, 'latlng') ?>

    <?php // echo $form->field($model, 'viewed') ?>

    <?php // echo $form->field($model, 'short_description') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'ho_so') ?>

    <?php // echo $form->field($model, 'ckedit_desc') ?>

    <?php // echo $form->field($model, 'order') ?>

    <?php // echo $form->field($model, 'lat') ?>

    <?php // echo $form->field($model, 'long') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
