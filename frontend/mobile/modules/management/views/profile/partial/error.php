<?php 
    switch ($error) {
        case 'otp': ?>
        <script type="text/javascript">
            promptCS('Nếu quý khác bị mất số điện thoại vui lòng liên hệ <a href="tel:02466623632">02466623632</a> để được hướng dẫn thay đổi.<a class="click" onclick="sendOtpAgain()">Gửi lại OTP</a><p class="error center" style="color:red"><?= $message ?></p>', 'Nhập OTP.');
            function yesPrompt(value, data) {
                loadAjax("<?= \yii\helpers\Url::to(['/management/profile/save-otp']) ?>", { otp: value }, $('#sucecss-otp'));
            }
            console.log('<?= $message ?>');
        </script>
        <?php break; ?>
        <?php case 'require': ?>
        <script type="text/javascript">
            $('#input-send').parent().find('.error').remove();
            $('#input-send').parent().append('<p class="error" style="color:red"><?= $attr == 'email' ? 'Email' : 'Số điện thoại' ?> đã được dùng.</p>');
        </script>
        <?php break; ?>

<?php } ?>