<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Đặt lại mật khẩu';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-contact">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="ctn-contact">
                    <div class="box box-lg">
                        <div class="site-reset-password">
                            <h1><?= Html::encode($this->title) ?></h1>

                            <p>Vui lòng chọn mật khẩu mới:</p>

                            <div class="row">
                                <div class="col-lg-5">
                                    <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>

                                    <?= $form->field($model, 'password')->passwordInput(['autofocus' => true]) ?>

                                    <div class="form-group">
                                        <?= Html::submitButton('Lưu', ['class' => 'btn btn-primary']) ?>
                                    </div>

                                    <?php ActiveForm::end(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
