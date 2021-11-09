<style type="text/css">
    #alertBox .otp-order p {
        text-align: center;
        font-size: 14px;
        padding: 1px 10px;
    }

    body .otp-order .title {
        font-weight: bold;
        font-size: 14px;
        text-transform: uppercase;
        margin-top: -10px;
    }

    .otp-order .value {
        font-weight: bold;
        color: #0e8238;
    }
</style>
<?php
switch ($error) {
    case 'check': ?>
        <script type="text/javascript">
            html = '<div class="otp-order"><p class="title">Xác nhận thanh toán bằng OCOP V.</p>';
            html += $('#opt-data').html();
            html += '<p><span style="color:red"><?= $user->_error_opt ?></span></div>';
            promptCS(html, '******');
            $('#PromptCSInput').attr('type', 'password');
        </script>
        <?php break; ?>
    <?php
    case 'send': ?>
        <script type="text/javascript">
            alert('<?= $user->_error_opt ?>');
        </script>
        <?php break; ?>
<?php } ?>