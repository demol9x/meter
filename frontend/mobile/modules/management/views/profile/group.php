<?php

use yii\helpers\Html;

$model = new \common\models\user\UserInGroup();
$gruops = $user->getAllGruops();
$listts = (new \common\models\user\UserGroup())->options();
?>
<?php if ($gruops) foreach ($gruops as $gruop) {  ?>
    <div class="row">
        <div class="col-xs-4">
            <select name="UserInGroup[user_group_id]" id="user_group_id">
                <option value="<?= $gruop['id'] ?>"><?= $gruop['name'] ?></option>
            </select>
            <?php if ($gruop['status'] == 2) { ?>
                <p class="note">Thông tin chưa được xác nhận</p>
            <?php } ?>
            <?php if ($gruop['status'] == 0) { ?>
                <p class="note">Thông tin bị từ chối. Vui lòng xóa và tạo lại.</p>
            <?php } ?>
        </div>
        <div class="col-xs-6">
            <div class="form-group">
                <div class="box-imd">
                    <div class="img-view">
                        <img src="<?= \common\components\ClaHost::getLinkImage('', $gruop['image']) ?>" />
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-2">
            <span class="btn delete-selfish" data="<?= $gruop['user_in_group_id'] ?>"><?= Yii::t('app', 'delete') ?></span>
        </div>
    </div>
<?php } ?>
<form class="form-submit-group">
    <div class="row">
        <div class="col-xs-4">
            <select name="UserInGroup[user_group_id]" id="user_group_id">
                <?php foreach ($listts as $key => $value) {  ?>
                    <option value="<?= $key ?>"><?= $value ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-xs-6">
            <div class="form-group">
                <div class="box-imd">
                    <?= Html::activeHiddenInput($model, 'avatar') ?>
                    <div id="useringroupavatar_img" class="img-view">
                        <?php if ($model->image) { ?>
                            <img src="<?= ClaHost::getImageHost() . $model->image; ?>" />
                        <?php } ?>
                    </div>
                    <div id="useringroupavatar_form" style="display: inline-block;">
                        <?= Html::button('Chọn ảnh thẻ chứng thực', ['class' => 'btn']); ?>
                        <?= Html::error($model, 'avatar', ['class' => 'help-block']); ?>
                    </div>
                </div>
            </div>
            <script type="text/javascript">
                $(document).ready(function() {
                    jQuery('#useringroupavatar_form').ajaxUpload({
                        url: '<?= yii\helpers\Url::to(['/upload/uploadfile']); ?>',
                        name: 'file',
                        onSubmit: function() {},
                        onComplete: function(result) {
                            var obj = $.parseJSON(result);
                            if (obj.status == '200') {
                                if (obj.data.realurl) {
                                    jQuery('#useringroup-avatar').val(obj.data.avatar);
                                    if (jQuery('#useringroupavatar_img img').attr('src')) {
                                        jQuery('#useringroupavatar_img img').attr('src', obj.data.realurl);
                                    } else {
                                        jQuery('#useringroupavatar_img').append('<img src="' + obj.data.realurl + '" />');
                                    }
                                    jQuery('#useringroupavatar_img').css({
                                        "margin-right": "10px"
                                    });
                                    $('.form-submit-group').attr('submit', 1);
                                }
                            }
                        }
                    });
                    $('.delete-selfish').click(function() {
                        $(this).addClass('confirmCS');
                        confirmCS('Xác nhận xóa?', {
                            id: $(this).attr('data')
                        });
                        yesConFirm = function(option) {
                            $('.confirmCS').first().closest('.row').remove();
                            id = option.id;
                            href = '<?= \yii\helpers\Url::to(['/management/profile/delete-group']) ?>';
                            loadAjax(href, {
                                id: id
                            }, $('#box-detail1'));
                        }
                        noConFirm = function(option) {
                            $('.confirmCS').removeClass('confirmCS');
                        }
                    });
                });
            </script>
        </div>
        <div class="col-xs-2">
            <button class="btn save-selfish"><?= Yii::t('app', 'save') ?></button>
        </div>
    </div>
    <script>
        $('.form-submit-group').submit(function() {
            if ($(this).attr('submit') == '1') {
                loadAjaxPost("<?= \yii\helpers\Url::to(['/management/profile/update-group']) ?>", $(this).serialize(), $("#bform-submit-group"));
            } else {
                alert('Vui lòng chọn ảnh thẻ chứng thực.');
            }
            return false;
        });
    </script>
</form>