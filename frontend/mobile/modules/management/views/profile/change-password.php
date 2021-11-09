<?php  
    $this->title = Yii::t('app','change_password');
?>
<div class="form-create-store">
    <div class="title-form">
        <h2>
            <img src="<?= Yii::$app->homeUrl ?>images/ico-lock.png" alt=""> <?= Yii::t('app', 'change_password') ?>
        </h2>
    </div>
     <form id="user-form" class="form-horizontal" action="" method="post">
         <input type="hidden" name="_csrf" value="MVMyakRrTFgGP0EgfFkPHQgYZl4lHgkzQ35fGAEjCxREBWA9PS8gGQ==">      
        <div class="change-password">
            <div class="width-change-password">
                <?php if($user->password_hash) { ?>
                    <div class="item-change-password">
                        <label for="">
                            <?= Yii::t('app', 'enter_password_old') ?>
                        </label>
                        <input type="password" id="userrecruiterinfo-name_company" class="form-control" name="password" required="" value="" maxlength="255" placeholder="********">
                        <div class="help-block"></div>
                    </div>
                <?php } else { ?>
                    <p class="center">
                        <?= Yii::t('app', 'change_password_1') ?>
                    </p>
                <?php } ?>
                <div class="item-change-password">
                    <label for="">
                        <?= Yii::t('app', 'enter_password_new') ?>
                    </label>
                    <input type="password" id="passwordre" class="form-control" name="passwordre" required="" value="" minlength="6" placeholder="********">
                        <div class="help-block"></div>
                </div>
                <div class="item-change-password"  placeholder="" name="password" required="" value="" maxlength="255"  minlength="6" placeholder="********">
                    <label for="">
                        <?= Yii::t('app', 'enter_password_new_again') ?>
                    </label>
                    <input type="password" required="" id="passwordre2" class="form-control" name="passwordre2" value="" minlength="6" placeholder="********">
                    <div style="color: red" id="error-pass"></div>
                </div>
                <!-- <div class="item-change-password">
                    <label for="">
                        Nhập mã xác minh
                    </label>
                    <img src="images/screenshot.png" alt="">
                </div> -->
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
            if($('#passwordre').val() != $('#passwordre2').val()) {
                $('#error-pass').html('Mật khẩu nhập lại không trùng mật khẩu mới.');
                return false;
            }
        });
    });
</script>