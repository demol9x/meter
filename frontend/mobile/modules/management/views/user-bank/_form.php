<?php

use yii\helpers\Html;
use common\models\ActiveFormC;
$list_bank = \common\models\Bank::optionsBank();
/* @var $this yii\web\View */
/* @var $model common\models\user\user */
/* @var $form yii\widgets\ActiveForm */
?>
<style type="text/css">
    .error {
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
<?php $form = ActiveFormC::begin(); ?>
    
    <?= $form->fields($model, 'bank_type', ['arrSelect' => $list_bank])->textSelect(['class' => 'select-province-id']) ?>

    <?= $form->fields($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->fields($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->fields($model, 'number')->textInput(['maxlength' => true]) ?>

    <?= $form->fields($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $model->isdefault ? '' : $form->fields($model, 'isdefault', ['arrSelect' => ['0' => Yii::t('app', 'not_select'), '1' => Yii::t('app', 'default')]])->textSelect(['class' => 'select-default-id']) ?>

    <div class="btn-submit-form">
        <input type="submit" id="user-form" value="<?= ($model->isNewRecord) ?  Yii::t('app','create_user') :  Yii::t('app','update_user') ?>">
    </div>
<?php ActiveFormC::end(); ?>
