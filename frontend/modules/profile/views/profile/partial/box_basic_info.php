<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use common\components\ClaHost;
?>

<script src="<?= Yii::$app->homeUrl ?>js/upload/ajaxupload.min.js"></script>

<div class="section-user section-edit-user">
    <div class="frame-user">
        <div class="avatar-user">
            <div class="update-pic-user" style="background:url('<?= Yii::$app->homeUrl ?>images/blog1.jpg') center center no-repeat; display:none">
            </div>
            <div class="update-pic-user" id="container-avatar">
                <?php if ($user_info->avatar_path && $user_info->avatar_name) { ?>
                    <img src="<?= ClaHost::getImageHost(), $user_info->avatar_path, 's150_150/', $user_info->avatar_name ?>" />
                <?php } else { ?>
                    <i class="fa fa-3x fa-user"></i>
                <?php } ?>
            </div>
            <div class="user-avatar-edit">
                <button id="job_avatar_form" type="button" class="btn btn-sm btn-default">
                    <i class="glyphicon glyphicon-pencil"></i>
                </button>
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function () {
                jQuery('#job_avatar_form').ajaxUpload({
                    url: '<?= Url::to(['/profile/profile/upload-avatar']) ?>',
                    name: 'file',
                    onSubmit: function () {
                    },
                    onComplete: function (result) {
                        var obj = $.parseJSON(result);
                        if (obj.status == '200') {
                            if (obj.data.realurl) {
                                $('#container-avatar').html('<img src="' + obj.data.realurl + '" />');
                            }
                        }
                    }
                });
            });
        </script>
        <div class="ctn-info-user step-1">
            <div class="change-main-user">
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
        </div>
        <div class="bottom-frame-user">
            <a href="#" class="btn-contact-info">
                <i class="fa fa-fw fa-suitcase"></i>
                <span>Thông Tin Cá Nhân</span>
            </a>
        </div>
    </div>
    <div class="btn-main-user btn-close-box">
        <i class="glyphicon glyphicon-pencil"></i>Chỉnh sửa thông tin
    </div>
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