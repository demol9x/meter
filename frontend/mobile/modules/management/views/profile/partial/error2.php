<?php
switch ($error) {
    case 'otp': ?>
        <?php
        $text = $user->getTextOtp();
        ?>
        <script type="text/javascript">
            html = '<?= $text[0] ?>';
            html += '<p><span style="color:red"><?= $user->_error_opt ?></span></p>';
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
        <?php break; ?>
    <?php
    case 'save': ?>
        <script type="text/javascript">
            alert("Lưu lỗi. Vui lòng quày lại sau ít phút.");
        </script>
        <?php break; ?>

<?php } ?>