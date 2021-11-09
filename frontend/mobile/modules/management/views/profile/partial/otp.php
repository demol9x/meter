<?php  if($success) { ?>
<script type="text/javascript">
    promptCS('Vui lòng nhập mã OTP đã được gửi đến số điện thoại <b><?= $user['phone'] ?></b>. Nếu quý khác bị mất số điện thoại vui lòng liên hệ <a href="tel:02466623632">02466623632</a> để được hướng dẫn thay đổi.<a class="click" onclick="sendOtpAgain()">Gửi lại OTP</a>', 'Nhập OTP');
    function yesPrompt(value, data) {
        loadAjax("<?= \yii\helpers\Url::to(['/management/profile/save-otp']) ?>", { otp: value }, $('#sucecss-otp'));
    }

</script>
<?php } else { ?>
    <script type="text/javascript">
        $('#input-send').parent().find('.error').remove();
        $('#input-send').parent().append('<p class="error" style="color:red"><?= $error ?></p>');
    </script>
<?php } ?>