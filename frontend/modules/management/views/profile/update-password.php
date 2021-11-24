<?php
use yii\widgets\ActiveForm;
?>

<link rel="stylesheet" href="<?= yii::$app->homeUrl?>css/doimatkhau.css">
<div class="item_right">
    <div class="form-create-store">
        <div class="title-form">
            <h2 class="content_15"><img src=<?= yii::$app->homeUrl?>images/ico-lock.png" alt=""> ĐỔI MẬT KHẨU</h2>
        </div>

        <?php
        $form = ActiveForm::begin([
                'id'=>'user-form',
                'class'=>'form-horizontal',
        ])
        ?>

            <div class="change-password">
                <div class="width-change-password">
                    <div class="form-group">
                        <div class="item-change-password"><label class="content_14" for="user-old_password">Nhập mật khẩu cũ</label><input type="password" id="user-old_password" class="form-control content_13" name="password" placeholder="Nhập mật khẩu cũ" aria-invalid="false"><div class="help-block"></div></div>
                    </div>
                    <div class="form-group">
                        <div class="item-change-password"><label class="content_14" for="user-old_password">Nhập mật mới</label><input type="password" id="user-old_password" class="form-control content_13" name="passwordre" placeholder="Nhập mật khẩu cũ" aria-invalid="false"><div class="help-block"></div></div>
                    </div>
                    <div class="form-group">
                        <div class="item-change-password"><label class="content_14" for="user-old_password">Nhập lại mật khẩu mới</label><input type="password" id="user-old_password" class="form-control content_13" name="passwordre2" placeholder="Nhập mật khẩu cũ" aria-invalid="false"><div class="help-block"></div></div>
                    </div>
                    <div id="error-pass content_14"></div>
                    <div class="item-change-password">
                        <button id="submit" class="content_13 btn-style-2" type="submit">Xác nhận</button>
                    </div>
                </div>
            </div>
        <?php
        ActiveForm::end();
        ?>
    </div>

</div>