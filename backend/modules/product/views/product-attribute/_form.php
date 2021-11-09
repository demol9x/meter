<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\product\ProductAttribute */
/* @var $form yii\widgets\ActiveForm */
?>
<script src="<?php echo Yii::$app->homeUrl ?>js/upload/ajaxupload.min.js"></script>
<div class="product-attribute-form">

    <div class="row">
        <?php
        $form = ActiveForm::begin([
                    'id' => 'product-attribute-form',
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

                <div class="" role="tabpanel" data-example-id="togglable-tabs">
                    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#tab_content1" id="basicinfo-tab" role="tab" data-toggle="tab" aria-expanded="true">
                                Thông tin cơ bản
                            </a>
                        </li>
                        <li role="presentation" class="">
                            <a href="#tab_content2" id="option-value-tab" role="tab" data-toggle="tab" aria-expanded="true">
                                Giá trị lựa chọn
                            </a>
                        </li>
                    </ul>
                    <div id="myTabContent" class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                            <?= $this->render('partial/basicinfo', ['form' => $form, 'model' => $model]); ?>
                        </div>
                        <div role="tabpanel" class="tab-pane fade " id="tab_content2" aria-labelledby="home-tab">
                            <?= $this->render('partial/option_value', ['form' => $form, 'model' => $model]); ?>
                        </div>
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
