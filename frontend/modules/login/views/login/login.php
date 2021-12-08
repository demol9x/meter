<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\authclient\widgets\AuthChoice;
use yii\helpers\Url;

$authAuthChoice = AuthChoice::begin([
    'baseAuthUrl' => ['/site/auth'],
]);
?>

<div class="site51_form_col10_dangnhap">
    <div class="bg" style="background-image: url('<?= yii::$app->homeUrl ?>images/bg_dangnhap.png')"></div>
    <div class="container_fix">
        <div class="main">
            <div class="main__left">
                <div class="title">
                    <h2 class="title_60">Đăng nhập</h2>
                </div>
                <p class="content_16">Chào mừng bạn đến với shoppingonline365. Vui lòng đăng nhập để có trải nghiệm mua sắm tốt hơn.</p>
                <?php
                $form = ActiveForm::begin([
                    'id' => '',
                    'options' => [
                        'class' => ''
                    ]
                ]);
                ?>
                <div class="main__left--login">
                    <?=
                    $form->field($model, 'phone', [
                        'template' => '<label for=""><i class="fal fa-phone-alt"></i>{input}{error}</label>'
                    ])->textInput([
                        'class' => 'content_16',
                        'placeholder' => 'Số điện thoại'
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

                </div>
                <div class="main__left--check">
                    <span class="content_16">
                        <input type="checkbox" name="SignupForm[rememberMe]" value="1" checked id="remem"><label for="remem">Ghi nhớ đăng nhập</label>
                    </span>
                    <a href="<?=Url::to('/site/request-password-reset')?>" class="content_16">Quên mật khẩu</a>
                </div>
                <div class="main__left--btn">
                    <button class="btn-1 content_16 btn-animation" type="submit" >Đăng nhập</button>
                    <a class="btn-1 content_16 btn-animation" href="<?= Url::to(['/login/login/signup'])?>">Đăng ký</a>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
            <div class="main__right">
                <a href="#"><img src="<?= yii::$app->homeUrl ?>images/imgDN.png" alt=""></a>
            </div>
        </div>
    </div>
</div>
<script>
    // $(document).ready(function(){
    //     var $errorText= $('.main__left--login .help-block');
    //     var $cssText= $('.main__left--login .form-group:first-child input');
    //     if($errorText != " "){
    //         $($cssText).css("border-bottom", "0.5px solid #289300");
    //     }else{
    //         $($cssText).css("border-bottom", "none");
    //     }
    // })
</script>
