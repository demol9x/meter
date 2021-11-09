<?php $this->title = 'Đổi mật khẩu cấp 2'; ?>
<div class="form-create-store">
    <div class="title-form">
        <h2>
            <img src="<?= Yii::$app->homeUrl ?>images/ico-lock.png" alt=""> <?= $this->title ?>
        </h2>
    </div>
    <form id="user-form" class="form-horizontal" action="" method="post">
        <input type="hidden" name="_csrf" value="MVMyakRrTFgGP0EgfFkPHQgYZl4lHgkzQ35fGAEjCxREBWA9PS8gGQ==">
        <div class="change-password">
            <div class="width-change-password">
                <?php if ($user->password_hash2) { ?>
                    <div class="item-change-password">
                        <label for="">
                            Mật khẩu cấp 2 cũ
                        </label>
                        <input type="password" id="userrecruiterinfo-name_company" class="form-control" name="password" required="" value="" maxlength="255" placeholder="********">
                        <div class="help-block"></div>
                    </div>
                <?php } else { ?>
                    <p class="center">
                        Bạn chưa có mật khẩu bảo mật cấp 2 cho tài khoản. Vui lòng cập nhật mật khẩu cấp 2 để tài khoản của bạn được bảo mật hơn.
                    </p>
                <?php } ?>
                <div class="item-change-password">
                    <label for="">
                        <?= Yii::t('app', 'enter_password_new') ?>
                    </label>
                    <input type="password" id="passwordre" class="form-control" name="passwordre" required="" value="" minlength="6" placeholder="********">
                    <div class="help-block"></div>
                </div>
                <div class="item-change-password" placeholder="" name="password" required="" value="" maxlength="255" minlength="6" placeholder="********">
                    <label for="">
                        <?= Yii::t('app', 'enter_password_new_again') ?>
                    </label>
                    <input type="password" required="" id="passwordre2" class="form-control" name="passwordre2" value="" minlength="6" placeholder="********">
                    <div style="color: red" id="error-pass"></div>
                </div>
                <p style="float: right;">
                    <a class="reset-pass click">Quên mật khẩu cấp 2</a>
                </p>
                <div class="item-change-password">
                    <label for=""></label>
                    <button id="submit" class="btn-style-2">Xác nhận</button>
                </div>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#submit').click(function() {
            if ($('#passwordre').val() != $('#passwordre2').val()) {
                $('#error-pass').html('Mật khẩu nhập lại không trùng mật khẩu mới.');
                return false;
            }
        });
        $('.reset-pass').click(function() {
            confirmCS('OCOP sẽ tự động thay đổi mật khẩu cấp 2 và gửi thông tin đến email của quý khách. Xác nhận thay đổi.');
            yesConFirm = function(option) {
                location.href = '<?= \yii\helpers\Url::to(['reset-pass2']) ?>';
            }
        })
    });
</script>