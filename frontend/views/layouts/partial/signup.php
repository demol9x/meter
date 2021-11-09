<?php

use yii\authclient\widgets\AuthChoice;
use yii\helpers\Url;

$popup = true;
if (common\components\ClaSite::isMobile()) {
    $popup = false;
}
$authAuthChoice = AuthChoice::begin([
            'baseAuthUrl' => ['/site/auth'],
            'popupMode' => $popup
        ]);
?>

<div id="login-box-popup" class="white-popup mfp-hide">
    <div class="box-account">
        <span class="mfp-close"></span>
        <div class="bg-pop-white">
            <h2><?= Yii::t('app', 'login_gca') ?></h2>
            <p>
                <?= Yii::t('app', 'login_gca_text_1') ?>
            </p>
            <form action=""  id="form-login-pub">
                <input required="" type="text" name="LoginForm[email]" placeholder="Nhập email hoặc số điện thoại">
                <input required="" type="password" name="LoginForm[password]" placeholder="Nhập mật khẩu">
                <center style="color: red" id="error-login" ></center>
                <div class="fogot-password">
                    <div class="awe-check">
                        <div class="checkbox">
                            <input type="checkbox" class="ais-checkbox" value="checkbox">
                            <label><span class="text-clip" title="checkbox"><?= Yii::t('app', 'login_gca_text_2') ?></span></label>
                        </div>
                    </div>
                    <a href="<?= Url::to(['/site/request-password-reset']) ?>"><?= Yii::t('app', 'login_gca_text_3') ?></a>
                </div>
                <button class="btn-login"><?= Yii::t('app', 'login') ?></button>
                <span><?= Yii::t('app', 'login_gca_text_4') ?></span>
                <div class="button-facebook">
                    <?php
                    foreach ($authAuthChoice->getClients() as $client) {
                        $title = $client->title;
                        ?>
                        <?=
                        $authAuthChoice->clientLink($client, Yii::t('app', 'login_with') . ($title == 'Google' ? 'Google' : 'Facebook'), [
                            'class' => 'btn-' . ($title == 'Google' ? 'google' : 'facebook') . ' push-top-xs'
                        ])
                        ?>
                        <?php
                    }
                    ?>
                </div>
                <p class="center">
                    <?= Yii::t('app', 'login_gca_text_5') ?><a href="<?= Url::to(['/login/login/signup']) ?>"><?= Yii::t('app', 'login_gca_text_6') ?></a>
                </p>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('.btn-login').click(function () {
            var form = $('#form-login-pub').serialize();
            var url = '<?= Url::to(['/login/login/loginajax']) ?>';
            $.ajax({
                type: "POST",
                url: url,
                data: form,
                success: function (responce) {
                    if (responce == '1') {
                        window.location.reload(true);
                    } else {
                        $('#error-login').html(responce);
                    }
                },
            });
            return false;
        });
    });
</script>