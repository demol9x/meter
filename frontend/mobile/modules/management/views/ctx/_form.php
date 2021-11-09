<?php

use yii\helpers\Html;
use common\models\ActiveFormC;

/* @var $this yii\web\View */
/* @var $model common\models\shop\Shop */
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

    #add-phone {
        background: #ebebeb;
        display: inline-block;
        padding: 3px 14px;
        font-size: 24px;
        margin-top: -20px;
    }

    #remove-phone {
        background: #ebebeb;
        display: inline-block;
        padding: 3px 11px;
        font-size: 24px;
        margin-top: -20px;
        margin-left: 20px;
        color: red;
    }

    #box-add-phone {
        margin-top: -30px;
    }

    .phone_add {
        margin-top: -10px !important;
    }
</style>
<?php $form = ActiveFormC::begin(); ?>

<?= $form->fields($model, 'username')->textInput(['maxlength' => true]) ?>

<?= $form->fields($model, 'password')->textInput(['type' => 'password']) ?>

<div class="btn-submit-form">
    <input type="submit" id="shop-form" value="<?= Yii::t('app', 'save') ?>">
</div>
<?php ActiveFormC::end(); ?>