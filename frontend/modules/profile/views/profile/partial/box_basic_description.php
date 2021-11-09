<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
?>
<div class="section-summary section-edit-user">
    <h2>
        <i class="fa fa-list" aria-hidden="true"></i>Thông Tin Chung
    </h2>
    <div class="view-control">
        <div class="step-2">
            <div class="change-main-user">
                <?php
                if ($user_info->description == '') {
                    ?>
                    Mô tả ngắn gọn thông tin hồ sơ và mục tiêu nghề nghiệp của bạn
                    <?php
                } else {
                    echo nl2br($user_info->description);
                }
                ?>
            </div>
            <div class="edit-main-user">
                <?php
                $form = ActiveForm::begin([
                            'id' => 'user-description-form',
                            'action' => Url::to(['/profile/profile/update-info-description'])
                        ])
                ?>
                <div class="form-group">
                    <?=
                    $form->field($user_info, 'description')->textarea([
                        'class' => 'form-control',
                        'rows' => 7,
                    ])->label($user_info->getAttributeLabel('description'), [
                        'class' => ''
                    ]);
                    ?>
                </div>
                <div class="form-group">
                    <i>5000 ký tự có thể nhập thêm</i>
                </div>
                <div class="form-group right">
                    <button type="button" class="btn btn-default stl_btn_remove btn-close-box">Hủy</button>
                    <button type="submit" class="btn btn-default stl_btn_save">Lưu</button>
                </div>
                <?php
                ActiveForm::end();
                ?>
            </div>
        </div>
        <div class="user-avatar-edit btn-close-box">
            <button type="button" class="btn btn-sm btn-default">
                <i class="glyphicon glyphicon-pencil"></i>
            </button>
        </div>
    </div>
</div>
<script type="text/javascript">

    $('#user-description-form').on('beforeSubmit', function (e) {
        var _form = $(this);
        $.post(
                _form.attr('action'),
                _form.serialize()
                ).done(function (result) {
            if (result.code == 200) {
                $('.step-2').html(result.html);
            }
        }).fail(function () {
            console.log('server error');
        });
        return false;
    });
</script>