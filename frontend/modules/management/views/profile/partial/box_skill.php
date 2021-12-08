<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use common\models\recruitment\Skill;
?>
<div class="section-summary section-edit-user">
    <h2>
        <i class="fa fa-fw fa-flash" aria-hidden="true"></i> Kỹ năng
    </h2>
    <div class="view-control">
        <div class="step-skills">
            <div class="change-main-user ">
                Thêm kỹ năng nghề nghiệp đề nhận được những đề nghị công việc phù hợp hơn
            </div>
            <?php
            $form = ActiveForm::begin([
                        'id' => 'user-skills-form',
                        'action' => Url::to(['/profile/profile/update-skills'])
            ]);
            ?>
            <div class="edit-main-user">
                <div class="form-group">
                    <label class="arial">Thêm kỹ năng nghề nghiệp đề nhận được những đề nghị công việc phù hợp hơn</label>
                    <input type="text" id="userinfo-skills" class="form-control width-50" name="UserInfo[skills]" value="" autocomplete="off">
                    <button type="button" onclick="addSkill()" class="add-skill">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
                <div class="form-group right">
                    <button type="button" class="btn btn-default stl_btn_remove btn-close-box">Hủy</button>
                    <button type="submit" class="btn btn-default stl_btn_save">Lưu</button>
                </div>
            </div>
            <div class="box-tag-skill">
                <?php
                if (isset($user_info->skills) && $user_info->skills) {
                    $skills = Skill::getSkillByIds($user_info->skills);
                    foreach ($skills as $skill) {
                        ?>
                        <a href="javascript:void(0)">
                            <i class="fa fa-tags" aria-hidden="true"></i> <?= $skill ?>
                            <i onclick="removeSkill(this)" class="fa fa-times" aria-hidden="true"></i>
                            <input type="hidden" value="<?= $skill ?>" name="skills[]" />
                        </a>
                        <?php
                    }
                }
                ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
        <div class="user-avatar-edit btn-close-box">
            <button type="button" class="btn btn-sm btn-default">
                <i class="glyphicon glyphicon-pencil"></i>
            </button>
        </div>
    </div>
</div>
<script type="text/javascript">

    $('#user-skills-form').on('beforeSubmit', function (e) {
        var _form = $(this);
        $.post(
                _form.attr('action'),
                _form.serialize()
                ).done(function (result) {
            if (result.code == 200) {
                $('.step-skills').html(result.html);
            }
        }).fail(function () {
            console.log('server error');
        });
        return false;
    });

    function removeSkill(_this) {
        if (confirm('Bạn có chắc muốn xóa kỹ năng này?')) {
            $(_this).closest('a').remove();
        }
    }

    function addSkill() {
        var skill = $('#userinfo-skills').val();
        if (skill == '') {
            alert('Bạn hãy nhập kỹ năng muốn thêm!');
            return false;
        }
        var html = '<a href="javascript:void(0)">';
        html += '<i class="fa fa-tags" aria-hidden="true"></i>' + skill;
        html += '<i onclick="removeSkill(this)" class="fa fa-times" aria-hidden="true"></i>';
        html += '<input type="hidden" value="' + skill + '" name="skills[]" />';
        html += '</a>';
        $('.box-tag-skill').append(html);
    }

    $(document).ready(function () {
        var skills = <?= \common\models\recruitment\Skill::getSkillsJsondata(); ?>;
        var skillsArray = $.map(skills, function (value, key) {
            return {
                value: value,
                data: key
            };
        });
        $('#userinfo-skills').autocomplete({
            lookup: skillsArray
        });
    });
</script>