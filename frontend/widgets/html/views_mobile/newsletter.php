<h2><?= Yii::t('app', 'register_to_recive_news') ?></h2>
<div class="forms">
    <input class="input-email" id="input-mail-contact" type="email" placeholder="<?= Yii::t('app','enter_email') ?>">
    <input  id="submit-mail-contact" class="footer-form-input-submit footer-btn" type="submit" value="<?= Yii::t('app','signup') ?>">
    </br>
    <i id="error-mail-contact" style="color: red"></i>
</div>
<script type="text/javascript">
    function validateEmail(email) {
      var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
      return emailReg.test( email );
    }
    $(document).ready(function () {
        $('#submit-mail-contact').click( function() {
            $('#submit-mail-contact').css('display', 'none');
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