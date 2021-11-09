<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = __SERVER_NAME . "/cap-nhat-mat-khau.html?token=" . $user->password_reset_token;
?>
<div class="password-reset">
    <p>Xin chào <?= Html::encode($user->username) ?>,</p>

    <p>Mã đổi mật khẩu: <b><?= $user->password_reset_token ?></b></p>
    <p>Vui lòng nhâp mã hoặc thực hiện theo liên kết dưới đây để đặt lại mật khẩu của bạn:</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>