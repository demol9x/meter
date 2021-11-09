<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\authclient\widgets\AuthChoice;
use yii\helpers\Url;
$authAuthChoice = AuthChoice::begin([
            'baseAuthUrl' => ['/site/auth']
]);
$this->title = 'Đăng nhập';
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
                        <h2 class="center">Đăng nhập</h2>
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
                                    'placeholder' => 'Email hoặc số điện thoại'
                                ])->label($model->getAttributeLabel('email'), [
                                    'class' => 'hidden'
                                ]);
                            ?>
                            <?=
                                $form->field($model, 'password', [
                                    'template' => '<div class="col-md-8 col-md-offset-2">{input}{label}{error}{hint}</div>'
                                ])->passwordInput([
                                    'class' => 'form-control',
                                    'placeholder' => $model->getAttributeLabel('password')
                                ])->label($model->getAttributeLabel('password'), [
                                    'class' => 'hidden'
                                ]);
                            ?>
                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-2">
                                    <div class="fogot-password">
                                        <div class="awe-check">
                                            <div class="checkbox">
                                                <input type="checkbox" class="ais-checkbox" name="SignupForm[check]" type="checkbox" value="1"  tabindex="5"">
                                                <label><span class="text-clip" title="checkbox">Đăng ký nhận bản tin của GCA</span></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Buttons-->
                            <div class="form-group">
                                <div class="col-md-offset-2 col-md-8">
                                    <button id="signup" type="submit" name="Submit" value="I agree" class="btn btn-signups" tabindex="6"> Đăng nhập</button>
                                </div>
                            </div>
                            <div class="form-group center">
                                <div class="col-md-offset-2 col-md-8">
                                    <span>---------------------- Hoặc đang ký nhanh bằng tài khoản MXH ----------------------</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-offset-2 col-md-8">
                                    <?php
                                        foreach ($authAuthChoice->getClients() as $client) {
                                            $title = $client->title;
                                            ?>
                                            <?=
                                            $authAuthChoice->clientLink($client, 'Đăng nhập bằng ' . ($title == 'Google' ? 'Google' : 'Facebook'), [
                                                'class' => 'btn btn-signups btn-' . ($title == 'Google' ? 'google' : 'facebook') . ' push-top-xs'
                                            ])
                                            ?>
                                            <?php
                                        }
                                    ?>
                                </div>
                            </div>
                            <hr>
                            <p class="text-center">Bạn chưa có tài khoản thành viên ? <a href="<?= Url::to(['/login/login/signup']) ?>"><strong>Đăng ký ngay</strong></a>
                            </p>
                        </fieldset>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div><!-- /content-wrap -->
</div>