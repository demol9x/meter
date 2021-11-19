
<link rel="stylesheet" href="<?= yii::$app->homeUrl?>css/doimatkhau.css">


<div class="item_right">
    <div class="form-create-store">
        <div class="title-form">
            <h2 class="content_15"><img src=<?= yii::$app->homeUrl?>images/ico-lock.png" alt=""> ĐỔI MẬT KHẨU</h2>
        </div>

        <form id="user-form" class="form-horizontal" action="" method="post">
            <input type="hidden" name="_csrf" value="MVMyakRrTFgGP0EgfFkPHQgYZl4lHgkzQ35fGAEjCxREBWA9PS8gGQ==">
            <div class="change-password">
                <div class="width-change-password">
                    <div class="item-change-password">
                        <label class="content_14" for="">Nhập mật khẩu cũ</label>
                        <input type="password" id="userrecruiterinfo-name_company" class="form-control content_13" name="password" required="" value="" maxlength="255" placeholder="********">
                    </div>
                    <div class="item-change-password">
                        <label class="content_14" for="">Nhập mật khẩu mới</label>
                        <input type="password" id="passwordre" class="form-control content_13" name="passwordre" required="" value="" minlength="6" placeholder="********">
                    </div>
                    <div class="item-change-password" placeholder="" name="password" required="" value="" maxlength="255" minlength="6">
                        <label class="content_14" for="">Nhập lại mật khẩu mới</label>
                        <input type="password" required="" id="passwordre2" class="form-control content_13" name="passwordre2" value="" minlength="6" placeholder="********">
                        <div style="color: red" id="error-pass"></div>
                    </div>
                    <div class="item-change-password">
                        <label for=""></label>
                        <button id="submit" class="content_13 btn-style-2">Xác nhận</button>
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
</div>