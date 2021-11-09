<style>
    #sortable { list-style-type: none; margin: 0; padding: 0; width: 100%; }
    #sortable li { margin: 3px 3px 3px 0; padding: 1px; float: left; width: 200px; height: 210px; text-align: center; }
    #algalley .alimgbox .alimglist .alimgitem{
        width: 100%;
    }
    #algalley .alimgbox .alimglist .alimgitem .alimgitembox{
        height: 200px;
        position: relative;
    }
    #algalley .alimgbox .alimglist .alimgitem .alimgaction{
        position: absolute;
        bottom: 0px;
    }
</style>

<div class="form-group no-margin-left">
    <?php echo CHtml::label(Yii::t('shop', 'shop_image'), null, array('class' => 'col-sm-2 control-label')); ?>
    <div class="controls col-sm-10">

        <?php
        $this->widget('common.widgets.upload.Upload', array(
            'type' => 'images',
            'id' => 'imageupload',
            'buttonheight' => 25,
            'path' => array('shops', Yii::app()->user->id),
            'limit' => 100,
            'multi' => true,
            'imageoptions' => array(
                'resizes' => array(array(200, 200))
            ),
            'buttontext' => 'Thêm ảnh',
            'displayvaluebox' => false,
            'oncecomplete' => "completeUpload(da);",
            'onUploadStart' => 'ta=false;',
            'queuecomplete' => 'ta=true;',
        ));
        ?>

        <div>
            <span style="font-size: 12px;color: blue"><i>* Kéo thả để thay đổi vị trí</i></span>
            <div style="display:none" id="Albums_imageitem_em_" class="errorMessage"><?php echo Yii::t('album', 'album_must_one_img'); ?></div>
            <ul id="sortable">
                <?php
                if (!$model->isNewRecord) {
                    $images = $model->getImages(ShopImages::TYPE_IMAGES);
                    foreach ($images as $image) {
                        $this->renderPartial('imageitem', array('image' => $image, 'avatar_id' => $model->avatar_id));
                    }
                }
                ?>
            </ul>
        </div>
    </div>
</div>
<script>

    function completeUpload(da) {
        var html = '<li class="ui-state-default">';
        html += '<div class="alimgitem">';
        html += '<div class="alimgitembox">';
        html += '<div class="delimg">';
        html += '<a href="#" class="new_delimgaction">';
        html += '<i class="icon-remove">';
        html += '</i>';
        html += '</a>';
        html += '</div>';
        html += '<div class="alimgthum">';
        html += '<img src="' + da.imgurl + '" />';
        html += '</div>';
        html += '<div class="alimgaction">';
        html += '<input class="position_image" type="hidden" name="order_img[]" value="newimage" />';
        html += '</div>';
        html += '<input type="hidden" value="' + da.imgid + '" name="newimage[<?php echo ShopImages::TYPE_IMAGES ?>][]" class="newimage" />';
        html += '</div>';
        html += '</div>';
        html += '</li>';
        jQuery('#sortable').append(html);
        updateImgBox();
    }

    jQuery(document).on('click', '.new_delimgaction', function () {
        jQuery(this).closest('.ui-state-default').remove();
        updateImgBox();
        return false;
    });
    jQuery(document).on('click', '.delimgaction', function () {
        if (confirm('<?php echo Yii::t('album', 'album_delete_image_confirm'); ?>')) {
            var thi = $(this);
            var href = thi.attr('href');
            if (href) {
                jQuery.ajax({
                    url: href,
                    type: 'POST',
                    dataType: 'JSON',
                    success: function (res) {
                        if (res.code == 200) {
                            jQuery(thi).closest('.ui-state-default').remove();
                            updateImgBox();
                        }
                    }
                });
            }
        }
        return false;
    });
    function updateImgBox() {
//        $('#algalley .alimglist').masonry('reloadItems');
//        $('#algalley .alimglist').masonry('layout');
    }
</script>