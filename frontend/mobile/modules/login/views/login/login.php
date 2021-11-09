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
            'popupMode' => false
        ]);
$this->title = Yii::t('app', 'login_gca');
?>
<style type="text/css">
    .required label:after{
        content: '*';
        color: red;
        margin-left: 5px;
    }
    .bg-pop-white {
        overflow: hidden;
        padding-top: 30px;
    }
    body .bg-pop-white:after {
        background: unset;
    }
</style>
<div class="container signup">
    <div class="content-wrap">
        <div class="site-register col-xs-12">
            <div class="width-box">
                <div class="box-register">
                    <div class="bg-pop-white">
                        <h2 class="center"><?= $this->title ?></h2>
                    </div>
                    <div class="text-span push-top-xs center">---*---</div>
                    <?php
                    $form = ActiveForm::begin([
                                'id' => 'form-signup',
                                'options' => [
                                    'class' => 'form-horizontal'
                                ]
                    ]);
                    ?>
                    <fieldset class="push-top-xs">
                        <hr>
                        <?=
                        $form->field($model, 'email', [
                            'template' => '<div class="col-md-8 col-md-offset-2">{input}{label}{error}{hint}</div>'
                        ])->textInput([
                            'class' => 'form-control',
                            'placeholder' => Yii::t('app', 'login_gca_text_7')
                        ])->label($model->getAttributeLabel('email'), [
                            'class' => 'hidden'
                        ]);
                        ?>
                        <?=
                        $form->field($model, 'password', [
                            'template' => '<div class="col-md-8 col-md-offset-2">{input}{label}{error}{hint}</div>'
                        ])->passwordInput([
                            'class' => 'form-control',
                            'placeholder' => Yii::t('app', 'login_gca_text_8')
                        ])->label($model->getAttributeLabel('password'), [
                            'class' => 'hidden'
                        ]);
                        ?>
                        <div class="form-group">
                            <div class="col-md-8 col-xs-7 col-md-offset-2">
                                <div class="fogot-password">
                                    <div class="awe-check">
                                        <div class="checkbox">
                                            <input type="checkbox" class="ais-checkbox" name="SignupForm[check]" type="checkbox" value="1"  tabindex="5">
                                            <label><span class="text-clip" title="checkbox"><?= Yii::t('app', 'login_gca_text_2') ?></span></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Buttons-->
                        <div class="form-group">
                            <p class="rse" style="float: right; margin-top: -50px; margin-right: 13px;"><a href="<?= Url::to(['/site/request-password-reset']) ?>">Quên mật khẩu?</a></p>
                            <div class="col-md-offset-2 col-md-8">
                                <button id="signup" type="submit" name="Submit" value="I agree" class="btn btn-signups" tabindex="6"> <?= Yii::t('app', 'login') ?></button>
                            </div>
                        </div>
                        <div class="form-group center">
                            <div class="col-md-offset-2 col-md-8">
                                <span><?= Yii::t('app', 'login_gca_text_4') ?></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <?php
                                foreach ($authAuthChoice->getClients() as $client) {
                                    $title = $client->title;
                                    ?>
                                    <?=
                                    $authAuthChoice->clientLink($client, '<i class="fa fa-facebook-square"></i>'.Yii::t('app', 'login_with') . ($title == 'Google' ? ' Google' : ' Facebook'), [
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
                        </div>
                        <hr>
                        <p class="center">
                            <?= Yii::t('app', 'login_gca_text_5') ?><a href="<?= Url::to(['/login/login/signup']) ?>"><?= Yii::t('app', 'login_gca_text_6') ?></a>
                        </p>
                    </fieldset>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div><!-- /content-wrap -->
</div>