<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\product\ProductAttributeSet */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-attribute-set-form">

    <div class="row">
        <?php
        $form = ActiveForm::begin([
                    'id' => 'product-attribute-set-form',
                    'options' => [
                        'class' => 'form-horizontal'
                    ]
        ]);
        ?>
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-bars"></i> <?= Html::encode($this->title) ?> </h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?=
                $form->field($model, 'name', [
                    'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
                ])->textInput([
                    'class' => 'form-control',
                ])->label($model->getAttributeLabel('name'), [
                    'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
                ])
                ?>
                
                <?=
                $form->field($model, 'code', [
                    'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
                ])->textInput([
                    'class' => 'form-control',
                ])->label($model->getAttributeLabel('code'), [
                    'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
                ])
                ?>
                
                <?=
                $form->field($model, 'order', [
                    'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
                ])->textInput([
                    'class' => 'form-control',
                ])->label($model->getAttributeLabel('order'), [
                    'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
                ])
                ?>

            </div>
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
