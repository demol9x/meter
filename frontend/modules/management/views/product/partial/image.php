<?php

use common\components\ClaHost;
?>
<style type="text/css">
    .boxuploadfile {
        padding-bottom: 10px;
    }
    .thumbnail{
        margin-bottom: 0px;
    }
    .thumbnail img{
        max-width: 100%;
        display: block;
        max-height: 85px;
        margin: 0 auto;
    }
    .col-md-55 {
        width: 25%;
        float: left;
        height: 130px;
        overflow: hidden;
        border: 1px solid #ddd;
    }
    .mask {
        position: absolute;
        bottom: 0px;
        display: block;
        width: 100%;
        height: 56px;
    }
    #wrap_image_album {
        cursor: pointer;
        clear: both;
        overflow: hidden;
        margin-bottom: 20px;
        margin-left: 20%;
        margin-right: 12%;
        min-height: 260px;
        background:  unset;
        border: 1px solid #ebebeb;
    }
    .boxuploadfile > span {
        /*display: none !important;*/
    }
    .view-first {
        position: relative;
        height: 123px;
        background: #fff;
        overflow: hidden;
    }
    .tools-bottom {
        margin-top: 0px;
        position: absolute;
        right: 0px;
        top: 0px;
        width: 50px;
        height: 25px;
        background: #ffffffa6;
    }
    .tools-bottom a {
        display: inline-block;
        float: left;
        width: 25px;
        height: 25px;
        font-size: 18px;
    }
</style>
<div class="item-input-form">
    <label class="bold"><?= Yii::t('app', 'image') ?></label>
    
    <div class="group-input">
        <p><?= Yii::t('app', 'img_p_1') ?><span style="color: red"> (*)</span>
            <br/>
            <span class="red"><?= Yii::t('app', 'img_p_2') ?></span></p>
        <p class="alert-imgs" style="color: red"></p>
        <?=
        /**
         * Banner main
         */
        backend\widgets\upload\UploadWidget::widget([
            'type' => 'images',
            'id' => 'imageupload',
            'buttonheight' => 25,
            'path' => array('shop'),
            'limit' => 100,
            'multi' => true,
            'imageoptions' => array(
                'resizes' => array(array(200, 200))
            ),
            'buttontext' => Yii::t('app', 'add_image'),
            'displayvaluebox' => false,
            'oncecomplete' => "callbackcomplete(da);",
            'onUploadStart' => 'ta=false;',
            'queuecomplete' => 'ta=true;',
        ]);
        ?>
    </div>
</div>

<div class="group-input" id="wrap_image_album">
    <?php
    if (isset($images) && $images) {
        foreach ($images as $image) {
            ?>
            <div class="col-md-55">
                <div class="thumbnail">
                    <div class="image view view-first">
                        <img id="img-up-<?= $image['id'] ?>" style="display: block;" src="<?= ClaHost::getImageHost(), $image['path'], 's200_200/', $image['name'] ?>" />
                        <div class="tools tools-bottom">
                            <a onclick="cropimages(this, '<?= ClaHost::getImageHost(), $image['path'], 's200_200/', $image['name'] ?>',<?= $image['id'] ?>)" href="javascript:void(0)" title="<?= Yii::t('app', 'edit_image') ?>"><i class="fa fa-crop"></i></a>
                            <a onclick="deleteOldImage(this, 'col-md-55',<?= $image['id'] ?>)" href="javascript:void(0)" title="<?= Yii::t('app', 'delete_image') ?>"><i class="fa fa-times"></i></a>
                        </div>
                        <div class="mask">
                           <div class="caption">
                                <div class="radio">
                                    <label>
                                        <input class="stop" type="radio" <?= $model->avatar_id == $image['id'] ? 'checked' : '' ?> value="<?= $image['id'] ?>" name="setava" /> <?= Yii::t('app', 'set_image_main') ?>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    }
    ?>
</div>

<script type="text/javascript">
    function callbackcomplete(data) {
        var html = '<div class="col-md-55">';
        html += '<div class="thumbnail">';
        html += '<div class="image view view-first">';
        html += '<img id="img-up-'+data.imgid+'" style="display: block;" src="' + data.imgurl + '" />';
        html += '<input type="hidden" value="' + data.imgid + '" name="newimage[]" class="newimage" />';
        html += '<div class="tools tools-bottom">';
        html +=' <a onclick="cropimages(this, \''+data.imgurl+'\',\''+data.imgid+'\')" href="javascript:void(0)" title="<?= Yii::t('app', 'edit_image') ?>"><i class="fa fa-crop"></i></a>';
        html += '<a onclick="deleteNewImage(this, \'col-md-55\')" href="javascript:void(0)" title="<?= Yii::t('app', 'delete_image') ?>"><i class="fa fa-times"></i></a>';
        html += '</div>';
        html += '<div class="mask">';
        html += '<div class="caption">';
        
        html += '<div class="radio">';
        html += '<label>';
        html += '<input type="radio" class="stop" value="product_' + data.imgid + '" name="setava" /> <?= Yii::t('app', 'set_image_main') ?>';
        html += '</label>';
        html += '</div>';
        html += '</div>';
        html += '</div>';
        html += '</div>';
        html += '</div>';
        html += '</div>';

        jQuery('#wrap_image_album').append(html);
        setTimeout(function(){
            checknumberimage();
        }, 200);
        event.stopPropagation();
    }

    function deleteNewImage(_this, wrap) {
        if (confirm('<?= Yii::t('app', 'delete_sure') ?>')) {
            $(_this).closest('.' + wrap).remove();
        }
        event.stopPropagation();
        return false;
    }

    $.postJSON = function (url, data, func) {
        $.post(url + (url.indexOf("?") == -1 ? "?" : "&") + "callback=?", data, func, "json");
    };
    function checknumberimage() {
        var imgss =  $('.col-md-55');
        if(imgss.length > 100) {
            for (var i = imgss.length - 1; i >= 100; i--) {
                $(imgss[i]).remove();
            }
        }
    }
    function deleteOldImage(_this, wrap, id) {
        if (confirm('<?= Yii::t('app', 'delete_sure') ?>')) {
            $.getJSON(
                    "<?= \yii\helpers\Url::to(['/management/product/delete-image']) ?>",
                    {id: id}
            ).done(function (data) {
                $(_this).closest('.' + wrap).remove();
            }).fail(function (jqxhr, textStatus, error) {
                var err = textStatus + ", " + error;
                console.log("Request Failed: " + err);
            });
        }
        event.stopPropagation();
        return false;
    }
</script>

<div class="item-input-form">
    <label class="bold" for="">Video</label>
    <div class="group-input">  
        <div class="form-group field-product-videos">
            <div class="item-input-form">
                <label class="" for="product-videos">Nhập đường dẫn link nhúng video(Giới hạn 5 link)</label>
                <div class="">
                    <div class="full-input" id="add-videos">
                        <?php 
                        if($model->videos) {
                            $videos = $model->videos;
                            foreach ($videos as $video) if($video) { ?>
                                <input type="text" placeholder="https://www.youtube.com/embed/0wr6-kZe9kc" class="form-control videos" value="<?= $video ?>" name="Product[videos][]">
                            <?php }
                        } ?>
                        <?php if(count($videos) < 5) { ?>
                            <input type="text" class="form-control videos"  placeholder="https://www.youtube.com/embed/0wr6-kZe9kc" value="" name="Product[videos][]">
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>    
    </div>
</div>
<script type="text/javascript">
    jQuery(document).on('click', '.videos:nth-last-child(1)', function () {
        if($('.videos').length == 1 || ($('.videos:nth-last-child(2)').val() && $('.videos').length <5)) {
            $('#add-videos').append('<input type="text" class="form-control videos" name="Product[videos][]">');
        }
    });
</script>