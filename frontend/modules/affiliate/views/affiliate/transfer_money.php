<?php

use common\models\order\Order;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
?>
<div class="form-create-store">
    <div class="infor-account">
        <h2>
            Yêu cầu chuyển khoản tiền thưởng
        </h2>
    </div>
    <p>Số tiền tối thiểu bạn có thể yêu cầu là: <b><?= number_format($config->min_price, 0, ',', '.') ?> VNĐ</b></p>
    <?php
    $max_money = ($userMoney['money'] + $userMoney['money_aff'])  - ($moneyTransfered + $moneyWaiting);
    ?>
    <p>Số tiền bạn đang có là: <b><?= number_format($max_money, 0, ',', '.') ?> VNĐ</b></p>
    <?php if ($max_money >= $config['min_price']) { ?>
        <div class="widget widget-box">
            <div class="widget-header">
                <h4>
                    Tạo yêu cầu rút tiền thưởng
                </h4>
            </div>
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
                            $form->field($model, 'money')->textInput([
                                'class' => 'form-control',
                                'rows' => 7,
                            ])->label($model->getAttributeLabel('money'), [
                                'class' => ''
                            ]);
                            ?>
                            <?=
                            $form->field($model, 'note')->textarea([
                                'class' => 'form-control',
                                'rows' => 7,
                            ])->label($model->getAttributeLabel('note'), [
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
    <?php } else { ?>
        <div>
            Bạn chưa đủ tiền thưởng để yêu cầu chuyển tiền
        </div>
    <?php } ?>
</div>
