<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \frontend\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Yêu cầu thiết lập lại mật khẩu';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .site51_form_col10_dangnhap .main__left--login label:first-child input {
        border: 0.5px solid #289300;
    }
</style>
<div class="site51_form_col10_dangnhap">
    <div class="bg" style="background-image: url('<?= Yii::$app->homeUrl ?>images/bg_dangnhap.png')"></div>
    <div class="container_fix">
        <div class="main">
            <div class="main__left">
                <div class="title">
                    <h2 class="title_60">Lấy lại mật khẩu</h2>
                </div>
                <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>
                    <div class="main__left--login">
                        <?=
                        $form->field($model, 'email', [
                            'template' => '<label for=""><i class="fal fa-phone-alt"></i>{input}{error}</label>'
                        ])->textInput([
                            'class' => 'content_16',
                            'placeholder' => 'Nhập email của bạn'
                        ]);
                        ?>

                    </div>
                    <div class="main__left--btn">
                        <button class="btn-1 content_16 btn-animation" type="submit">Gửi yêu cầu</button>
                    </div>
                <?php ActiveForm::end(); ?>
            </div>
            <div class="main__right">
                <a href="#"><img src="<?= Yii::$app->homeUrl ?>images/imgDN.png" alt="icon"></a>
            </div>
        </div>
    </div>
</div>
