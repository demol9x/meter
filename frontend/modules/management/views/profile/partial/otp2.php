<?php 
$text = $user->getTextOtp();
?>
<script type="text/javascript">
    html = '<?= $text[0] ?>';
    promptCS(html, '<?= $text[1] ?>');
    $('#PromptCSInput').attr('type', 'password');
    function yesPrompt(value, data) {
        loadAjax("<?= \yii\helpers\Url::to(['/management/profile/save-otp']) ?>", {
            otp: value,
            attr: '<?= $attr ?>',
            value: '<?= $value ?>',
        }, $('#sucecss-otp'));
    }
</script>