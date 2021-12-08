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
                html = '<div class="otp-order"><p class="title">Otp thanh toán bằng <?=__NAME_SITE?> V.</p>';
                html+= $('#opt-data').html();
                html += '<p><span style="color:red"><?= $message ?></span> <a class="click" onclick="sendOtpAgain()">Gửi lại OTP</a></p></div>';
                
                promptCS(html, 'Nhập OTP.');
            </script>
        <?php break; ?>
        <?php case 'send': ?>
            <script type="text/javascript">
                alert('<?= $message ?>');
            </script>
        <?php break; ?>
        <?php case 'phone': ?>
            <script type="text/javascript">
                alert('<?= $message ?>');
            </script>
        <?php break; ?>

<?php } ?>