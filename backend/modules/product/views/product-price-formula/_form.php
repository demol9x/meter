<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\product\ProductPriceFormula */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-price-formula-form">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <?php
            $form = ActiveForm::begin([
                        'id' => 'product-form',
                        'options' => [
                            'class' => 'form-horizontal'
                        ],
            ]);
            ?>
            <div class="x_panel">
                <div class="x_title">
                    <h2><i class="fa fa-bars"></i> <?= Html::encode($this->title) ?> </h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <?= $this->render('partial/description'); ?>

                    <div class="col-xs-6">
                        <?=
                        $form->field($model, 'code_app', [
                            'template' => '{label}<div class="col-md-7 col-sm-7 col-xs-12">{input}{error}{hint}</div>'
                        ])->textInput([
                            'class' => 'form-control',
                        ])->label($model->getAttributeLabel('code_app'), [
                            'class' => 'control-label col-md-5 col-sm-5 col-xs-12'
                        ])
                        ?>
                        <?=
                        $form->field($model, 'name', [
                            'template' => '{label}<div class="col-md-7 col-sm-7 col-xs-12">{input}{error}{hint}</div>'
                        ])->textInput([
                            'class' => 'form-control',
                        ])->label($model->getAttributeLabel('name'), [
                            'class' => 'control-label col-md-5 col-sm-5 col-xs-12'
                        ])
                        ?>
                        <?=
                        $form->field($model, 'formula_product', [
                            'template' => '{label}<div class="col-md-7 col-sm-7 col-xs-12">{input}{error}{hint}</div>'
                        ])->textInput([
                            'class' => 'form-control',
                        ])->label($model->getAttributeLabel('formula_product'), [
                            'class' => 'control-label col-md-5 col-sm-5 col-xs-12'
                        ])
                        ?>
                        <?=
                        $form->field($model, 'formula_gold', [
                            'template' => '{label}<div class="col-md-7 col-sm-7 col-xs-12">{input}{error}{hint}</div>'
                        ])->textInput([
                            'class' => 'form-control',
                        ])->label($model->getAttributeLabel('formula_gold'), [
                            'class' => 'control-label col-md-5 col-sm-5 col-xs-12'
                        ])
                        ?>
                        <?=
                        $form->field($model, 'formula_fee', [
                            'template' => '{label}<div class="col-md-7 col-sm-7 col-xs-12">{input}{error}{hint}</div>'
                        ])->textInput([
                            'class' => 'form-control',
                        ])->label($model->getAttributeLabel('formula_fee'), [
                            'class' => 'control-label col-md-5 col-sm-5 col-xs-12'
                        ])
                        ?>
                        <?=
                        $form->field($model, 'formula_stone', [
                            'template' => '{label}<div class="col-md-7 col-sm-7 col-xs-12">{input}{error}{hint}</div>'
                        ])->textInput([
                            'class' => 'form-control',
                        ])->label($model->getAttributeLabel('formula_stone'), [
                            'class' => 'control-label col-md-5 col-sm-5 col-xs-12'
                        ])
                        ?>
                    </div>

                    <div class="col-xs-6">
                        <?=
                        $form->field($model, 'code_gold_parent', [
                            'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
                        ])->dropDownList(\common\models\product\ProductCurrency::optionsCurrency(), [
                            'class' => 'form-control',
                        ])->label($model->getAttributeLabel('code_gold_parent'), [
                            'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
                        ])
                        ?>
                        <?=
                        $form->field($model, 'status', [
                            'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
                        ])->dropDownList(common\components\ClaLid::optionsStatus(), [
                            'class' => 'form-control',
                        ])->label($model->getAttributeLabel('status'), [
                            'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
                        ])
                        ?>
                        <?=
                        $form->field($model, 'description', [
                            'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
                        ])->textArea([
                            'class' => 'form-control',
                            'rows' => 4
                        ])->label($model->getAttributeLabel('description'), [
                            'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
                        ])
                        ?>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-xs-3">
                        <?=
                        $form->field($model, 'coefficient1', [
                            'template' => '{label}<div class="col-md-7 col-sm-7 col-xs-12">{input}{error}{hint}</div>'
                        ])->textInput([
                            'class' => 'form-control',
                        ])->label($model->getAttributeLabel('coefficient1'), [
                            'class' => 'control-label col-md-5 col-sm-5 col-xs-12'
                        ])
                        ?>
                        <?=
                        $form->field($model, 'coefficient2', [
                            'template' => '{label}<div class="col-md-7 col-sm-7 col-xs-12">{input}{error}{hint}</div>'
                        ])->textInput([
                            'class' => 'form-control',
                        ])->label($model->getAttributeLabel('coefficient2'), [
                            'class' => 'control-label col-md-5 col-sm-5 col-xs-12'
                        ])
                        ?>
                        <?=
                        $form->field($model, 'coefficient3', [
                            'template' => '{label}<div class="col-md-7 col-sm-7 col-xs-12">{input}{error}{hint}</div>'
                        ])->textInput([
                            'class' => 'form-control',
                        ])->label($model->getAttributeLabel('coefficient3'), [
                            'class' => 'control-label col-md-5 col-sm-5 col-xs-12'
                        ])
                        ?>
                    </div>
                    <div class="col-xs-3">
                        <?=
                        $form->field($model, 'coefficient4', [
                            'template' => '{label}<div class="col-md-7 col-sm-7 col-xs-12">{input}{error}{hint}</div>'
                        ])->textInput([
                            'class' => 'form-control',
                        ])->label($model->getAttributeLabel('coefficient4'), [
                            'class' => 'control-label col-md-5 col-sm-5 col-xs-12'
                        ])
                        ?>
                        <?=
                        $form->field($model, 'coefficient5', [
                            'template' => '{label}<div class="col-md-7 col-sm-7 col-xs-12">{input}{error}{hint}</div>'
                        ])->textInput([
                            'class' => 'form-control',
                        ])->label($model->getAttributeLabel('coefficient5'), [
                            'class' => 'control-label col-md-5 col-sm-5 col-xs-12'
                        ])
                        ?>
                        <?=
                        $form->field($model, 'coefficient6', [
                            'template' => '{label}<div class="col-md-7 col-sm-7 col-xs-12">{input}{error}{hint}</div>'
                        ])->textInput([
                            'class' => 'form-control',
                        ])->label($model->getAttributeLabel('coefficient6'), [
                            'class' => 'control-label col-md-5 col-sm-5 col-xs-12'
                        ])
                        ?>
                    </div>
                    <div class="col-xs-3">
                        <?=
                        $form->field($model, 'coefficient7', [
                            'template' => '{label}<div class="col-md-7 col-sm-7 col-xs-12">{input}{error}{hint}</div>'
                        ])->textInput([
                            'class' => 'form-control',
                        ])->label($model->getAttributeLabel('coefficient7'), [
                            'class' => 'control-label col-md-5 col-sm-5 col-xs-12'
                        ])
                        ?>
                        <?=
                        $form->field($model, 'coefficient8', [
                            'template' => '{label}<div class="col-md-7 col-sm-7 col-xs-12">{input}{error}{hint}</div>'
                        ])->textInput([
                            'class' => 'form-control',
                        ])->label($model->getAttributeLabel('coefficient8'), [
                            'class' => 'control-label col-md-5 col-sm-5 col-xs-12'
                        ])
                        ?>
                        <?=
                        $form->field($model, 'coefficient9', [
                            'template' => '{label}<div class="col-md-7 col-sm-7 col-xs-12">{input}{error}{hint}</div>'
                        ])->textInput([
                            'class' => 'form-control',
                        ])->label($model->getAttributeLabel('coefficient9'), [
                            'class' => 'control-label col-md-5 col-sm-5 col-xs-12'
                        ])
                        ?>
                    </div>
                    <div class="col-xs-3">
                        <?=
                        $form->field($model, 'coefficientm', [
                            'template' => '{label}<div class="col-md-7 col-sm-7 col-xs-12">{input}{error}{hint}</div>'
                        ])->textInput([
                            'class' => 'form-control',
                        ])->label($model->getAttributeLabel('coefficientm'), [
                            'class' => 'control-label col-md-5 col-sm-5 col-xs-12'
                        ])
                        ?>
                        <?=
                        $form->field($model, 'coefficientx', [
                            'template' => '{label}<div class="col-md-7 col-sm-7 col-xs-12">{input}{error}{hint}</div>'
                        ])->textInput([
                            'class' => 'form-control',
                        ])->label($model->getAttributeLabel('coefficientx'), [
                            'class' => 'control-label col-md-5 col-sm-5 col-xs-12'
                        ])
                        ?>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group">
                        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                    </div>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
