<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */
\Yii::$app->session->open();

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\authclient\widgets\AuthChoice;
use yii\helpers\Url;

$authAuthChoice = AuthChoice::begin([
    'baseAuthUrl' => ['/site/auth']
]);
?>
<style>
    .main__left--register .nav-tab .register__enterprise label input {
        margin-bottom: 0;
    }

    .main__left--register .form-group {
        margin-bottom: 20px;
    }
    .flex-text-tab{
        display: flex;
        justify-content: start;
        align-items: center;
    }
    .flex-text-tab .tab_text{
        color: #219653;
        border-bottom: 2px solid #219653;
        -webkit-transition: all 0.3s linear;
        transition: all 0.3s linear;
        width: 50%;
        text-align: center;
        height: 30px;
    }
    .flex-text-tab a{
        background-color: #fff;
        color: #bebebe;
        border-bottom: 2px solid #EBEFF2;
        -webkit-transition: all 0.3s linear;
        transition: all 0.3s linear;
        margin-right: 0px;
        width: 50%;
        text-align: center;
        height: 30px;

    }
    .site51_form_col10_dangnhap .container_fix .main .main__left .Tab{
        display: none;
    }
    .site51_form_col10_dangnhap .container_fix .main .main__left .Tab.active{
        display: block;
    }
</style>

<div class="site51_form_col10_dangnhap">
    <div class="bg" style="background-image: url('<?= yii::$app->homeUrl ?>images/bg_dangnhap.png')"></div>
    <div class="container_fix">
        <div class="main">
            <div class="main__left">
                <div class="title">
                    <h2 class="title_60">Đăng ký</h2>
                </div>
                <p class="content_14">Chào mừng bạn đến với shoppingonline365. Vui lòng đăng nhập để có trải nghiệm mua sắm tốt hơn.</p>
                <div class="main__left--register">
                    <div class="nav-tab">
                        <div class="flex-text-tab">
                            <a href="<?= Url::to(['/login/login/signup'])?>">Cá nhân</a>
                            <div class="tab_text">Doanh nghiệp</div>
                        </div>
                        <div class="Tab active">
                            <?php
                            $form = ActiveForm::begin([
                                'id' => '',
                                'options' => [
                                    'class' => 'register__enterprise'
                                ]
                            ]);
                            ?>
                            <?=
                            $form->field($model, 'username', [
                                'template' => '<label for=""><i class="far fa-building"></i>{input}{error}{hint}</label>'
                            ])->textInput([
                                'class' => 'content_16',
                                'placeholder' => 'Tên doanh nghiệp'
                            ]);
                            ?>
                            <?=
                            $form->field($model, 'phone', [
                                'template' => '<label for=""><i class="fal fa-phone-alt"></i>{input}{error}</label>'
                            ])->textInput([
                                'class' => 'content_16',
                                'placeholder' => 'Số điện thoại'
                            ]);
                            ?>
                            <?=
                            $form->field($model, 'email', [
                                'template' => '<label for=""> <i class="far fa-envelope"></i>{input}{error}</label>'
                            ])->textInput([
                                'class' => 'content_16',
                                'placeholder' => 'Email'
                            ]);
                            ?>
                            <?=
                            $form->field($model, 'number_auth', [
                                'template' => '<label for=""><i class="far fa-file-alt"></i>{input}{error}</label>'
                            ])->textInput([
                                'class' => 'content_16',
                                'placeholder' => 'Mã số thuế'
                            ]);
                            ?>
                            <?=
                            $form->field($model, 'business', [
                                'template' => '<label for=""> <i class="fal fa-briefcase"></i>{input}{error}</label>'
                            ])->textInput([
                                'class' => 'content_16',
                                'placeholder' => 'Ngành nghề chính'
                            ]);
                            ?>
                            <?=
                            $form->field($model, 'password', [
                                'template' => '<label for=""> <i class="far fa-lock"></i>{input}{error}</label>'
                            ])->passwordInput([
                                'class' => 'content_16',
                                'placeholder' => 'Nhập mật khẩu'
                            ]);
                            ?>
                            <?=
                            $form->field($model, 'passwordre', [
                                'template' => '<label for=""> <i class="far fa-lock"></i>{input}{error}</label>'
                            ])->passwordInput([
                                'class' => 'content_16',
                                'placeholder' => 'Nhập lại mật khẩu'
                            ]);
                            ?>
                            <?=
                            $form->field($model, 'type', [
                                'template' => '{input}'
                            ])->textInput([
                                'type' => 'hidden',
                                'value' => \frontend\models\User::TYPE_DOANH_NGHIEP,
                            ]);
                            ?>
                            <?= $form->field($model, 'terms_and_condition')
                                ->radio([
                                    'label' => 'Bạn phải đồng ý với điều khoản & chính sách của Meter',
                                    'value' => 1,
                                    'uncheck' => null,
                                    'style' => 'float:left;margin-right:15px;width: auto;
    height: auto;
    margin-bottom: 0;'
                                ]) ?>
                            <button class="btn-animation content_16" type="submit">Đăng ký</button>
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>

            </div>
            <div class="main__right">
                <a href=""><img src="<?= yii::$app->homeUrl ?>images/imgDN.png" alt=""></a>
            </div>
        </div>
    </div>
</div>
