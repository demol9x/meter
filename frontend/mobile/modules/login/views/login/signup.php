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
            'baseAuthUrl' => ['/site/auth'],
            'popupMode' => false
]);
$this->title = Yii::t('app', 'signup_user');
?>
<style type="text/css">
    body .form-horizontal .form-group {
         margin-right: 0px; 
         margin-left: 0px; 
    }
    .help-block-error {
        color: red !important;
        padding: 0px;
        margin-top: -15px;
        margin-bottom: -5px;
    }
    body .bg-pop-white:after {
        background: unset;
    }
</style>
<div class="create-page-store">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md12 col-sm-12 col-xs-12">
                <div class="form-create-store">
                    <?php if(isset($_SESSION['create_shop'])) { ?>
                        <div class="title-form">
                            <h2>
                                <img src="<?= Yii::$app->homeUrl ?>images/ico-bansanpham.png" alt=""> 
                                <?=  Yii::t('app', 'create_shop')  ?>
                            </h2>
                        </div>
                        <div class="list-process-payment" style="border-bottom: none;">
                            <ul>
                                <li class="active current">
                                    <a>
                                        <img src="<?= Yii::$app->homeUrl ?>images/process-1.png" alt="">
                                        <span><?=  Yii::t('app', 'signup_user')  ?></span>
                                    </a>
                                </li>
                                <li>
                                    <a>
                                        <img src="<?= Yii::$app->homeUrl ?>images/process-2.png" alt="">
                                        <span><?=  Yii::t('app', 'enter_info')  ?></span>
                                    </a>
                                </li>
                                <li>
                                    <a>
                                        <img src="<?= Yii::$app->homeUrl ?>images/process-3.png" alt="">
                                        <span><?=  Yii::t('app', 'enter_auth')  ?></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    <?php } else {?>
                        <style type="text/css">
                            #register-box-popup {
                                padding-top: 30px;
                            }
                        </style>
                    <?php } ?>
                    <div class="ctn-form form-buywith-gca">
                        <div id="register-box-popup">
                            <div class="box-account">
                                <div class="bg-pop-white">
                                    <h2><?= Yii::t('app', 'signup_gca') ?></h2>
                                    <p>
                                        <?= Yii::t('app', 'signup_gca_text_1') ?>
                                    </p>
                                    <?php
                                        $form = ActiveForm::begin([
                                                    'id' => 'form-signup',
                                                    'options' => [
                                                        'class' => 'form-horizontal'
                                                    ]
                                        ]);
                                        ?>
                                            <?=
                                                $form->field($model, 'username')->textInput([
                                                    'class' => '',
                                                    'placeholder' => $model->getAttributeLabel('username')
                                                ])->label($model->getAttributeLabel('username'), [
                                                    'class' => 'hidden'
                                                ]);
                                            ?>
                                            <?=
                                                $form->field($model, 'phone')->textInput([
                                                    'class' => '',
                                                    'placeholder' => $model->getAttributeLabel('phone')
                                                ])->label($model->getAttributeLabel('phone'), [
                                                    'class' => 'hidden'
                                                ]);
                                            ?>
                                            <?=
                                                $form->field($model, 'email')->textInput([
                                                    'class' => '',
                                                    'placeholder' => $model->getAttributeLabel('email')
                                                ])->label($model->getAttributeLabel('email'), [
                                                    'class' => 'hidden'
                                                ]);
                                            ?>
                                            <?=
                                                $form->field($model, 'password')->passwordInput([
                                                    'class' => '',
                                                    'placeholder' => $model->getAttributeLabel('password')
                                                ])->label($model->getAttributeLabel('password'), [
                                                    'class' => 'hidden'
                                                ]);
                                            ?>
                                            <div class="form-group passwordre">
                                                <input type="password" id="passwordre" class="form-control" name="passwordre" placeholder="Nhập lại mật khẩu" aria-required="true" aria-invalid="true">
                                                <label class="hidden" for="signupform-password"><?=  Yii::t('app', 'signup_gca_text_2')  ?></label>
                                                <p id="error-repass" class="help-block help-block-error"></p>
                                            </div>

                                            <?php
                                                if(isset($_GET['user_id']) && $_GET['user_id']) {
                                                    $model->user_before = $_GET['user_id'];
                                                    echo $form->field($model, 'user_before')->textInput([
                                                        'class' => '',
                                                        'type' => 'hidden'
                                                    ])->label($model->getAttributeLabel('user_before'), [
                                                        'class' => 'hidden'
                                                    ]);
                                                ?>
                                                <div class="form-group passwordre">
                                                        <input type="" disabled class="form-control" value="ID người giới thiệu: <?= $_GET['user_id'] ?>" >
                                                </div>
                                                <?php } else {
                                                    $model->user_before = 2041;
                                                    echo $form->field($model, 'user_before')->textInput([
                                                        'class' => '',
                                                        'placeholder' => $model->getAttributeLabel('user_before')
                                                    ])->label($model->getAttributeLabel('user_before'), [
                                                        'class' => 'hidden'
                                                    ]);
                                                }
                                            ?>
                                            
                                            <div class="form-group">
                                                <div class="fogot-password">
                                                    <div class="awe-check">
                                                        <div class="checkbox">
                                                            <input type="checkbox" class="ais-checkbox" name="SignupForm[is_notification]" type="checkbox" value="1" <?= $model->is_notification ? 'checked="checked"' : '' ?>  tabindex="5"">
                                                            <label><span class="text-clip" title="checkbox"><?=  Yii::t('app', 'signup_gca_text_3') ?></span></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Buttons-->
                                            <div class="form-group">
                                                <span><?=  Yii::t('app', 'signup_gca_text_4')  ?>
                                                     <strong><a target="_blank" href="/chinh-sach-bao-mat-thong-tin-ca-nhan-t22.html"><?=  Yii::t('app', 'signup_gca_text_5') ?></a></strong>
                                                    <?=  Yii::t('app', '&') ?>
                                                    <strong><a target="_blank" href="/chinh-sach-bao-mat-thong-tin-ca-nhan-t22.html"><?=  Yii::t('app', 'signup_gca_text_6') ?></a></strong>
                                                </span>
                                            </div>
                                            <button id="signup" type="submit" name="Submit" value="I agree" class="btn btn-signups" tabindex="6"> <?=  Yii::t('app', 'signup') ?></button>
                                            <span><?=  Yii::t('app', 'signup_gca_text_7') ?></span>
                                            <div class="button-facebook">
                                                <?php
                                                    foreach ($authAuthChoice->getClients() as $client) {
                                                        $title = $client->title;
                                                        ?>
                                                        <?=
                                                        $authAuthChoice->clientLink($client, '<i class="fa fa-facebook-square"></i>'.Yii::t('app', 'login_with'). ($title == 'Google' ? ' Google' : ' Facebook'), [
                                                            'class' => 'btn btn-signups btn-' . ($title == 'Google' ? 'google' : 'facebook') . ' push-top-xs'
                                                        ])
                                                        ?>
                                                        <?php
                                                    }
                                                $detect = new \common\components\ClaMobileDetect();
                                                if ($detect->is('AndroidOS')) {
                                                    ?>
                                                    <script type="text/javascript">
                                                        jQuery(function () {
                                                            jQuery('.btn-facebook').on('click', function () {
                                                                showAndroidToast('Hello Android!');
                                                            });
                                                        });
                                                        function showAndroidToast(toast) {
                                                            Android.showToast(toast);
                                                        }
                                                    </script>
                                                <?php } ?>
                                            </div>
                                            <p class="center">
                                                <?=  Yii::t('app', 'signup_gca_text_8') ?> <a class="" href="<?= Url::to(['/login/login/login']) ?>" ><?=  Yii::t('app', 'signup_gca_text_9') ?></a>
                                            </p>
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
<script type="text/javascript">
    $(document).ready(function () {
        $('#signup').click(function() {
            if($('#signupform-password').val() != $('#passwordre').val()) {
                $('#error-repass').html('<?= Yii::t('app', 'password_error') ?>');
                return false;
            } else {
                $('#error-repass').html('');
            }
        })
    });  
</script>