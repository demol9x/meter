<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink =$resetLink = __SERVER_NAME . "/cap-nhat-mat-khau.html?token=" . $user->password_reset_token;;
?>
Xin chào <?= $user->username ?>,

Thực hiện theo liên kết dưới đây để đặt lại mật khẩu của bạn:

<?= $resetLink ?>
