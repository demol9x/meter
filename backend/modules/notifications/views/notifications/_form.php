<?php

use yii\helpers\Html;
use \common\components\ActiveFormC;
use common\models\notifications\Notifications;

/* @var $this yii\web\View */
/* @var $model common\models\notifications\Notifications */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="notifications-form">

    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <div class="x_panel">
                <div class="x_title">
                    <h2><i class="fa fa-bars"></i> <?= Html::encode($this->title) ?> </h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <?php
                    $form = ActiveFormC::begin([
                        'options' => [
                            'class' => 'form-horizontal'
                        ],
                        'fieldClass' => 'common\components\MyActiveField'
                    ]);
                    ?>

                    <?= $form->field($model, 'recipient_id')->dropDownList(\common\models\notifications\Notifications::getArrNotification()) ?>
                    <p>
                        1, Chọn tài khoản: U-{ID tài khoản}<br />
                        2, Chọn nhóm tài khoản: <?= Notifications::TYPE_USER_GROUP ?>-{Tên nhóm}<br />
                        3, Chọn vùng miền: <?= Notifications::TYPE_REGION ?>-{Tên vùng miền}<br />
                        4, Chọn tỉnh thành: <?= Notifications::TYPE_PROVINCE ?>-{Tên tỉnh thành}<br />
                    </p>
                    <link rel="stylesheet" href="<?= Yii::$app->homeUrl ?>gentelella/select2/dist/css/select2.min.css">
                    <script src="<?= Yii::$app->homeUrl ?>gentelella/select2/dist/js/select2.full.min.js"></script>
                    <script>
                        jQuery(document).ready(function() {
                            jQuery("#notifications-recipient_id").select2({
                                placeholder: "Chọn người nhận",
                                allowClear: true
                            });
                        });
                    </script>

                    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

                    <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>

                    <?=
                    $form->field($model, 'type')->dropDownList(Notifications::optionsType(), [
                        'prompt' => '--- Chọn ---'
                    ])
                    ?>

                    <?= $form->fieldB($model, 'updated_at')->textDate(['format' => 'DD-MM-YYYY HH:mm'])->label() ?>

                    <div class="form-group">
                        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                    </div>

                    <?php ActiveFormC::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>