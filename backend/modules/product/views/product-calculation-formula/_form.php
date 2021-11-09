<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$siteinfo = \common\components\ClaLid::getSiteinfo();
/* @var $this yii\web\View */
/* @var $model common\models\product\ProductCalculationFormula */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-calculation-formula-form">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <div class="x_panel">
                <div class="x_title">
                    <h2>
                        <i class="fa fa-bars"></i>
                        <?= Html::encode($this->title) ?>
                    </h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?php $form = ActiveForm::begin([
                        'options' => [
                            'class' => 'form-horizontal'
                        ],
                        'fieldClass' => 'common\components\MyActiveField'
                    ]);
                    echo 'Giá 1 chỉ vàng 9999: ' . $siteinfo->gold_price;
                    ?>
                    <p></p>
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'description')->textArea(['maxlength' => true]) ?>

                    <?= $form->field($model, 'percent')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'const_price')->textInput(['maxlength' => true]) ?>

                    <?=
                    $form->field($model, 'status', [])->dropDownList(common\components\ClaLid::optionsStatus(), [
                        'class' => 'form-control',
                    ])
                    ?>

                    <div class="form-group">
                        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>
