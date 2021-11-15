<div class="footer_3">
    <div class="text_content">ĐĂNG KÍ NHẬN TIN</div>
    <p>Vui lòng nhập email của bạn để được hỗ trợ nhanh nhất!</p>
    <form>
        <div class="flex_foot">
            <input id="input-mail-contact" type="email" placeholder="Email của bạn...">
            <button id="submit-mail-contact" type="submit"><img src="<?= Yii::$app->homeUrl ?>images/form_foot.png"></button>
        </div>
        <i id="error-mail-contact" style="color: red"></i>
    </form>
</div>

<script type="text/javascript">
    function validateEmail(email) {
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        return emailReg.test( email );
    }
    $(document).ready(function () {
        $('#submit-mail-contact').click( function() {
            var email = $('#input-mail-contact').val();
            $('#error-mail-contact').html('');
            if(email && validateEmail(email)) {
                $.getJSON(
                    '<?= \yii\helpers\Url::to(['/site/email']) ?>',
                    {email: email},
                    function (data) {
                        if (data.code == 200) {
                            alert('<?= Yii::t('app','new_success') ?>');
                        } else {
                            $('#error-mail-contact').html(data.error);
                            $('#submit-mail-contact').css('display', 'inline-block');
                        }
                    }
                );
            } else {
                $('#error-mail-contact').html('Vui lòng nhập đúng!!!');
                $('#submit-mail-contact').css('display', 'inline-block');
            }
            return false;
        });
    });
</script>