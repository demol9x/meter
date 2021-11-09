<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Yêu cầu thiết lập lại mật khẩu';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-contact">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="ctn-contact">
                    <div class="box box-lg">
                        <div class="site-request-password-reset">
                            <hr/>
                            <h2><?= Html::encode($this->title) ?></h2>

                            <p>Xin vui lòng điền email của bạn. Một liên kết để thiết lập lại mật khẩu sẽ được gửi đến đó.</p>

                            <div class="row">
                                <div class="col-lg-5">
                                    <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>

                                    <?= $form->field($model, 'email')->textInput() ?>

                                    <div class="form-group">
                                        <?= Html::submitButton('Gửi', ['class' => 'btn btn-primary']) ?>
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
