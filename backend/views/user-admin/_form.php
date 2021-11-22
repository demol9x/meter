<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\notifications\Notifications;

/* @var $this yii\web\View */
/* @var $model backend\models\UserAdmin */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    .clasclrr>span {
        width: 200px;
        text-align: left;
        display: inline-block;
        position: relative;
        cursor: pointer;
        padding: 0px 5px;
    }
    .clasclrr>span:hover {
        background: #0000ff1a;
    }

    .clasclrr>span>div {
        width: 100%;
        height: 100%;
        position: absolute;
        z-index: 1;
        top: 0px;
        left: 0px;
    }
</style>
<div class="user-admin-form">

    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <?php
            $form = ActiveForm::begin([
                'id' => 'user-admin-form',
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
                    $form->field($model, 'username', [
                        'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
                    ])->textInput([
                        'class' => 'form-control',
                        'placeholder' => 'Tên đăng nhập'
                    ])->label($model->getAttributeLabel('username'), [
                        'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
                    ])
                    ?>

                    <?=
                    $form->field($model, 'email', [
                        'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
                    ])->textInput([
                        'class' => 'form-control',
                        'placeholder' => 'Email'
                    ])->label($model->getAttributeLabel('email'), [
                        'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
                    ])
                    ?>

                    <?=
                    $form->field($model, 'password', [
                        'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
                    ])->passwordInput([
                        'class' => 'form-control',
                        'placeholder' => 'Password'
                    ])->label($model->getAttributeLabel('password'), [
                        'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
                    ])
                    ?>

                    <?=
                    $form->field($model, 'password2', [
                        'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
                    ])->passwordInput([
                        'class' => 'form-control',
                        'placeholder' => 'Password2'
                    ])->label($model->getAttributeLabel('password2'), [
                        'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
                    ])
                    ?>
                    <div class="form-group">
                        <?= Html::activeLabel($model, 'status', ['class' => 'control-label col-md-2 col-sm-2 col-xs-12']) ?>
                        <div class="col-md-10 col-sm-10 col-xs-12">
                            <?= Html::activeDropDownList($model, 'status', [1 => 'Kích hoạt', 0 => 'Dừng hoạt động'], ['class' => 'form-control', 'placeholder' => 'Password']) ?>
                            <?= Html::error($model, 'status', ['class' => 'help-block']); ?>
                        </div>
                    </div>
                    <!-- <div class="form-group">
                        <?= Html::activeLabel($model, 'type', ['class' => 'control-label col-md-2 col-sm-2 col-xs-12']) ?>
                        <div class="col-md-10 col-sm-10 col-xs-12">
                            <?= Html::activeDropDownList($model, 'type', \backend\models\UserAdmin::arrayType(), ['class' => 'form-control', 'placeholder' => 'Password']) ?>
                            <?= Html::error($model, 'type', ['class' => 'help-block']); ?>
                        </div>
                    </div> -->
                    <div class="form-group">
                        <?= Html::activeLabel($model, 'rule_notifys', ['class' => 'control-label col-md-2 col-sm-2 col-xs-12']) ?>
                        <div class="col-md-10 col-sm-10 col-xs-12 clasclrr">
                            <span>
                                <div></div>
                                <input class="itall" name="rule_notifys[]" type="checkbox" value="<?= Notifications::TYPE_USER_ALL ?>" <?= $model->rule_notifys ==  json_encode([Notifications::TYPE_USER_ALL]) ? 'checked' : '' ?>>
                                <span>Tất cả tài khoản</span>
                            </span>
                            <?php
                            $lig = Notifications::getArrNotificationG();
                            $rl = $model->rule_notifys ? json_decode($model->rule_notifys, true) : [];
                            if ($lig) foreach ($lig as $key => $value) { ?>
                                <span>
                                    <div></div>
                                    <input class="itgr" name="rule_notifys[]" type="checkbox" value="<?= $key ?>" <?= in_array($key, $rl) ? 'checked' : '' ?>>
                                    <span><?= $value ?></span>
                                </span>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <?= Html::submitButton($isNewRecord ? 'Create' : 'Update', ['class' => $isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
        <script>
            $('.itall').change(function() {
                $(".itgr").prop('checked', false);
            });
            $('.itgr').change(function() {
                $(".itall").prop('checked', false);
            });
            $('.clasclrr>span').click(function() {
                $(this).find('input').click();
            });
        </script>
    </div>