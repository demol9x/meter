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
                <?=
                $form->field($model, 'old_password', [
                    'template' => '<div class="item-change-password">{label}{input}{error}{hint}</div>'
                ])->passwordInput([
                    'class' => 'form-control content_13',
                    'placeholder' => 'Nhập mật khẩu cũ',
                ])->label('Nhập mật khẩu cũ',['class'=>'content_14']);
                ?>
                <?=
                $form->field($model, 'new_password', [
                    'template' => '<div class="item-change-password">{label}{input}{error}{hint}</div>'
                ])->passwordInput([
                    'id'=>'passwordre',
                    'class' => 'form-control content_13',
                    'placeholder' => 'Nhập mật khẩu mới',
                ])->label('Nhập mật khẩu mới',['class'=>'content_14']);
                ?>

                <?=
                $form->field($model, 'new_password_dre', [
                    'template' => '<div class="item-change-password">{label}{input}{error}{hint}</div>'
                ])->passwordInput([
                    'id'=>'passwordre2',
                    'class' => 'form-control content_13',
                    'placeholder' => 'Nhập lại mật khẩu mới',
                ])->label('Nhập lại mật khẩu mới',['class'=>'content_14']);
                ?>
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