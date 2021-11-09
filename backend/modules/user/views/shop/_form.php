<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\User */
/* @var $form yii\widgets\ActiveForm */
?>
<style type="text/css">
    .right {
        float: right;
    }
    .x_title h2 {
        width: 100%;
    }
</style>
<div class="user-form"> 

    <div class="col-md-12 col-sm-12 col-xs-12">

        <div class="row">
            <?php
            $form = ActiveForm::begin([
                        'id' => 'otp-form',
                        'options' => [
                            'class' => 'form-horizontal',
                            'enctype' => 'multipart/form-data'
                        ]
            ]);
            ?>
            <div class="x_panel">
                <div class="x_title">
                    <h2><i class="fa fa-bars"></i> <?= Html::encode($this->title) ?> 
                        <a href="<?= \yii\helpers\Url::to(['/user/user/update', 'id' => $model->id]) ?>" class="btn btn-primary right" ><?= Yii::t('app', 'to_user_manager') ?> >></a>
                    </h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#tab_content1" id="one-tab" role="tab" data-toggle="tab" aria-expanded="true">
                                    <?= Yii::t('app', 'basic_info') ?>
                                </a>
                            </li>
                            <li role="presentation">
                                <a href="#tab_content2" id="two-tab" role="tab" data-toggle="tab" aria-expanded="true">
                                    <?= Yii::t('app', 'transport') ?>
                                </a>
                            </li>
                            <li role="presentation">
                                <a href="#tab_content4" id="four-tab" role="tab" data-toggle="tab" aria-expanded="true">
                                    Ảnh xác thực
                                </a>
                            </li>
                            <li role="presentation">
                                <a href="#tab_content3" id="three-tab" role="tab" data-toggle="tab" aria-expanded="true">
                                    <?= Yii::t('app', 'image') ?>
                                </a>
                            </li>
                        </ul>
                        <div id="myTabContent" class="tab-content">
                            <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="one-tab">
                                <?= $this->render('partial/tabbasicinfo', ['form' => $form, 'model' => $model]); ?>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="two-tab">
                                <?= $this->render('partial/tabtransport', ['form' => $form, 'model' => $model, 'transports' => $transports, 'shop_transports' => $shop_transports]); ?>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="tab_content4" aria-labelledby="four-tab">
                                <?= $this->render('partial/image_auth', ['form' => $form, 'model' => $model, 'images' => $image_auths]); ?>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="thre-tab">
                                <?= $this->render('partial/image', ['form' => $form, 'model' => $model, 'images' => $images]); ?>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'id' => 'submit-form']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
