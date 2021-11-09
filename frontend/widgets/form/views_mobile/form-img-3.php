<?php
use yii\helpers\Html;
echo isset($script) ? $script : '';
echo isset($css) ? $css : '';
?>
<style type="text/css">
    .img-form > div {
        float: left;
        margin: 10px;
    }
</style>
<div class="item-input-form" style="overflow: hidden;">
    <?= Html::activeLabel($model, $id, ['class' => 'control-label']) ?>
    <div class="img-form">
        <?= Html::activeHiddenInput($model, $id, ['id' =>'imgf-'.$id]) ?>
        <div id="avatar_img_<?= $id ?>" style="display: inline-block; max-width: 100px; max-height: 100px; overflow: hidden; vertical-align: top;">  
        </div>
        <div id="avatar_form_<?= $id ?>" class="btn-imgs" style="display: inline-block;">
            <?= Html::button('Chọn ảnh', ['class' => 'btn']); ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        jQuery('#avatar_form_<?= $id ?>').ajaxUpload({
            url: '<?= $url; ?>',
            name: 'file',
            onSubmit: function () {
            },
            onComplete: function (result) {
                var obj = $.parseJSON(result);
                if (obj.status == '200') {
                    if (obj.data.realurl) {
                        jQuery('#imgf-<?= $id ?>').val(obj.data.avatar);
                        if (jQuery('#avatar_img_<?= $id ?> img').attr('src')) {
                            jQuery('#avatar_img_<?= $id ?> img').attr('src', obj.data.realurl);
                        } else {
                            jQuery('#avatar_img_<?= $id ?>').append('<img src="' + obj.data.realurl + '" />');
                        }
                        jQuery('#avatar_img_<?= $id ?>').css({"margin-right": "10px"});
                    }
                }
            }
        });
    });
</script>
