<?php
use yii\helpers\Url;
?>
<div class='boxuploadfile'>
    <input id="<?php echo ($this->id) ? $this->id : 'uploadfile'; ?>" type="file" name="<?php echo ($this->id) ? $this->id . '_name' : 'fileupload' ?>" />
    <div class='valuebox hidden2 <?php echo ($this->displayvaluebox) ? '' : 'hidden' ?>'>
        <ul class='ulvalbox clearfix'>
        </ul>
    </div>
</div>
<script>
    $(document).ready(function() {
        upload_config.setMaxqueuesize(<?php echo $this->limit; ?>, "<?php echo ($this->id) ? $this->id : 'uploadfile'; ?>");
        upload_config.setQueuesize(0, "<?php echo ($this->id) ? $this->id : 'uploadfile'; ?>");
        setTimeout(function () {
        $('#<?php echo ($this->id) ? $this->id : 'uploadfile'; ?>').uploadify({
            'buttonText': '<?php echo ($this->buttontext) ? $this->buttontext : 'Upload'; ?>',
            'fileSizeLimit': '<?php echo $this->fileSizeLimit; ?>',
            'width': '<?php echo $this->buttonwidth; ?>',
            'height': '<?php echo $this->buttonheight; ?>',
            'method': 'post',
            'multi':<?= ($this->multi) ? 'true' : 'false'; ?>,
            'formData': {
                'type': '<?php echo $this->type; ?>',
                'path': '<?php echo json_encode($this->path); ?>',
                'key': '<?php echo md5($this->key); ?>',
                'imageoptions': '<?php echo json_encode($this->imageoptions); ?>'
            },
            'swf': '<?php echo Yii::$app->homeUrl . 'js/upload/uploadify/uploadify.swf' ?>',
            'fileTypeExts': '*.gif;*.jpg;*.png;*.jpeg;*.bmp;*.ico',
            'onUploadStart': function(file) {
                if (upload_config.getQueuesize('<?php echo ($this->id) ? $this->id : 'uploadfile'; ?>') >= upload_config.getMaxqueuesize('<?php echo ($this->id) ? $this->id : 'uploadfile'; ?>')) {
                    $('#<?php echo ($this->id) ? $this->id : 'uploadfile'; ?>').uploadify('disable', true);
                    $('#<?php echo ($this->id) ? $this->id : 'uploadfile'; ?>').uploadify('cancel', '*');
                    return false;
                }
                <?php echo $this->onUploadStart; ?>
            },
            'onUploadSuccess': function(file, data, response) {
                var da = JSON.parse(data);
                if (da.code == 200 || da.code == '200') {
                    upload_config.setQueuesize(upload_config.getQueuesize('<?php echo ($this->id) ? $this->id : 'uploadfile'; ?>') + 1, '<?php echo ($this->id) ? $this->id : 'uploadfile'; ?>');
                    var boxfileupload = $('#<?php echo ($this->id) ? $this->id : 'uploadfile'; ?>').closest('.boxuploadfile');
                    var valuebox = boxfileupload.find('.valuebox');
                    var ulvalbox = boxfileupload.find('.valuebox .ulvalbox');
                    valuebox.removeClass('hidden2');
                    ulvalbox.fadeIn(200, function() {
                        ulvalbox.append('<li class="livalbox"><div class="ldvalbox"><i class="removeval" onclick="$(this).parents(\'.livalbox\').remove();upload_config.reduceQueuesize(\'<?php echo ($this->id) ? $this->id : 'uploadfile'; ?>\');">x</i><div class="fileimg"><img src="' + da.imgurl + '" /></div><input type="hidden" name="<?php echo ($this->id) ? $this->id : 'fileupload' ?>_val[]" class="filevalue" value=\'' + da.imgid + '\'/></div></li>');
                    });
                }
                else
                    alert(da.message);
                <?php echo $this->oncecomplete; ?>
                $('#' + file.id).remove();
                //Check xem đã vượt quá maxqueuesize chưa
                if (upload_config.getQueuesize('<?php echo ($this->id) ? $this->id : 'uploadfile'; ?>') >= upload_config.getMaxqueuesize('<?php echo ($this->id) ? $this->id : 'uploadfile'; ?>')) {
                    $('#<?php echo ($this->id) ? $this->id : 'uploadfile'; ?>').uploadify('disable', true);
                    $('#<?php echo ($this->id) ? $this->id : 'uploadfile'; ?>').uploadify('cancel', '*');
                    return false;
                }
            },
            'onQueueComplete': function(queueData) {
                <?php echo $this->queuecomplete; ?>
            },
            'uploader': '<?= Url::to(['/media/upload/uploadimage']) ?>'
        });
        },10);
    });
</script>