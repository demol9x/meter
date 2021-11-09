<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
?>
<div class="change-main-user ajax-box-basic-info">
    <h2><?= $user['username'] ?></h2>
    <p>Vị trí hiện tại. 
        <span class="wrap-expected-position"><?= $user_info['expected_position'] ? $user_info['expected_position'] : 'Ví dụ: Developer' ?></span>
    </p>
    <?php if ($user_info['new_graduate']) { ?>
        <p>Tôi mới tốt nghiệp/chưa có kinh nghiệm làm việc</p>
    <?php } else { ?>
        <p>Số năm kinh nghiệm: <?= $user_info['experience'] ?></p>
    <?php } ?>
    <div class="download-resume">
        <a id="download-resume-button" href="#" target="_blank" class="btn-outline">
            <i class="fa fa-fw fa-file-pdf-o"></i> 
            Tải hồ sơ
        </a>
    </div>
</div>
<div class="edit-main-user">
    <?php
    $form = ActiveForm::begin([
                'id' => 'user-info-form',
                'action' => Url::to(['/profile/profile/update-info'])
            ])
    ?>

    <?=
    $form->field($user, 'username', [
        'template' => '{label}{input}{error}{hint}'
    ])->textInput([
        'class' => 'form-control'
    ])->label($user->getAttributeLabel('username'), [
        'class' => ''
    ]);
    ?>

    <?=
    $form->field($user_info, 'expected_position', [
        'template' => '{label}{input}{error}{hint}'
    ])->textInput([
        'class' => 'form-control',
        'placeholder' => 'Vị trí hiện tại. Ví dụ: Developer'
    ])->label($user_info->getAttributeLabel('expected_position'), [
        'class' => ''
    ]);
    ?>

    <?=
    $form->field($user_info, 'new_graduate')->checkbox();
    ?>

    <div class="wrap-box-experience" style="display: <?= $user_info->new_graduate ? 'none' : 'block' ?>">
        <?=
        $form->field($user_info, 'experience', [
            'template' => '{label}{input}{error}{hint}'
        ])->textInput([
            'class' => 'form-control'
        ])->label($user_info->getAttributeLabel('experience'), [
            'class' => ''
        ]);
        ?>
    </div>

    <div class="form-group">
        <button type="button" class="btn btn-default stl_btn_remove btn-close-box">Hủy</button>
        <button type="submit" class="btn btn-default stl_btn_save">Lưu</button>
    </div>
    <?php
    ActiveForm::end();
    ?>
</div>
<script type="text/javascript">

    $('#user-info-form').on('beforeSubmit', function (e) {
        var _form = $(this);
        $.post(
                _form.attr('action'),
                _form.serialize()
                ).done(function (result) {
            if (result.code == 200) {
                $('.step-1').html(result.html);
            }
        }).fail(function () {
            console.log('server error');
        });
        return false;
    });

    $('#userinfo-new_graduate').change(function () {
        if ($(this).is(':checked')) {
            $('.wrap-box-experience').hide();
        } else {
            $('.wrap-box-experience').show();
        }
    });
</script>