<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\NewsCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="news-category-form">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <?php
            $form = ActiveForm::begin([
                        'id' => 'news-category-form',
                        'enableClientValidation' => false,
                        'enableAjaxValidation' => false,
                        'validateOnSubmit' => true,
                        'validateOnChange' => true,
                        'validateOnType' => true,
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
                    <div class="form-group">
                        <?= Html::activeLabel($model, 'name', ['class' => 'control-label col-md-2 col-sm-2 col-xs-12']) ?>
                        <div class="col-md-10 col-sm-10 col-xs-12">
                            <?= Html::activeTextInput($model, 'name', ['class' => 'form-control', 'placeholder' => 'Nhập tên danh mục']) ?>
                            <?= Html::error($model, 'name', ['class' => 'help-block']); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= Html::activeLabel($model, 'parent', ['class' => 'control-label col-md-2 col-sm-2 col-xs-12']) ?>
                        <div class="col-md-10 col-sm-10 col-xs-12">
                            <?= Html::activeDropDownList($model, 'parent', $model->optionsCategory(), ['class' => 'form-control']) ?>
                            <?= Html::error($model, 'parent', ['class' => 'help-block']); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= Html::activeLabel($model, 'meta_keywords', ['class' => 'control-label col-md-2 col-sm-2 col-xs-12']) ?>
                        <div class="col-md-10 col-sm-10 col-xs-12">
                            <?= Html::activeTextInput($model, 'meta_keywords', ['class' => 'form-control']) ?>
                            <?= Html::error($model, 'meta_keywords', ['class' => 'help-block']); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= Html::activeLabel($model, 'meta_description', ['class' => 'control-label col-md-2 col-sm-2 col-xs-12']) ?>
                        <div class="col-md-10 col-sm-10 col-xs-12">
                            <?= Html::activeTextInput($model, 'meta_description', ['class' => 'form-control']) ?>
                            <?= Html::error($model, 'meta_description', ['class' => 'help-block']); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= Html::activeLabel($model, 'meta_title', ['class' => 'control-label col-md-2 col-sm-2 col-xs-12']) ?>
                        <div class="col-md-10 col-sm-10 col-xs-12">
                            <?= Html::activeTextInput($model, 'meta_title', ['class' => 'form-control']) ?>
                            <?= Html::error($model, 'meta_title', ['class' => 'help-block']); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= Html::activeLabel($model, 'status', ['class' => 'control-label col-md-2 col-sm-2 col-xs-12']) ?>
                        <div class="col-md-10 col-sm-10 col-xs-12">
                            <?= Html::activeDropDownList($model, 'status', [1 => 'Hiển thị', 0 => 'Ẩn'], ['class' => 'form-control']) ?>
                            <?= Html::error($model, 'status', ['class' => 'help-block']); ?>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>
                
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
    
</div>
