<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
?>

<div class="form-create-store">
    <?php
    foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
        echo '<div style="margin-top: 20px;" class="alert alert-' . $key . '">' . $message . '</div>';
    }
    ?>
    <div class="infor-account">
        <h2>
            Cập nhật thông tin nhận tiền thưởng
        </h2>
    </div>
    <div class="widget widget-box">
        <div class="widget-body no-padding">
            <div class="widget-main">
                <div class="row">
                    <div class="col-xs-12 no-padding">
                        <?php
                        $form = ActiveForm::begin([
                                    'id' => 'user-description-form',
                                    'action' => Url::to([''])
                                ])
                        ?>
                        <?=
                        $form->field($model, 'payment_info')->textarea([
                            'class' => 'form-control',
                            'rows' => 7,
                        ])->label($model->getAttributeLabel('payment_info'), [
                            'class' => ''
                        ]);
                        ?>
                        <div class="control-group form-group buttons">
                            <?= \yii\helpers\Html::submitButton(Yii::t('app', 'update'), ['class' => 'btn-style right hvr-float-shadow']) ?>
                        </div>
                        <?php
                        ActiveForm::end();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
