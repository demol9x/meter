<?php

use common\components\ClaHost;
?>
<link href="<?= Yii::$app->homeUrl ?>css/crop/cropper.css" rel="stylesheet">
<link href="<?= Yii::$app->homeUrl ?>css/crop/crop.css" rel="stylesheet">
<script type="text/javascript" src="<?= Yii::$app->homeUrl ?>js/crop/cropper.js"></script>
<script type="text/javascript" src="<?= Yii::$app->homeUrl ?>js/crop/crop.js"></script>
<style type="text/css">
    .thumbnail{
        margin-bottom: 0px;
    }
    .thumbnail img{
        max-width: 100%;
        display: block;
        max-height: 100%;
        margin: 0 auto;
    }
</style>
<div class="form-group">
    <label class="control-label col-md-2 col-sm-2 col-xs-12">Ảnh</label>
    <div class="col-md-10 col-sm-10 col-xs-12">
        <?=
        /**
         * Banner main
         */
        backend\widgets\upload\UploadWidget::widget([
            'type' => 'images',
            'id' => 'imageuploadauth',
            'buttonheight' => 25,
            'path' => array('news'),
            'limit' => 100,
            'multi' => true,
            'imageoptions' => array(
                'resizes' => array(array(200, 200))
            ),
            'buttontext' => 'Thêm ảnh',
            'displayvaluebox' => false,
            'oncecomplete' => "callbackcompleteauth(da);",
            'onUploadStart' => 'ta=false;',
            'queuecomplete' => 'ta=true;',
        ]);
        ?>
    </div>
</div>

<div class="row" id="wrap_image_album_auth">
    <?php
    if (isset($images) && $images) {
        foreach ($images as $image) {
            ?>
            <div class="col-md-55">
                <div class="thumbnail">
                    <div class="image view view-first">
                        <img  id="img-up-<?= $image['id'] ?>" style="display: block;" src="<?= ClaHost::getImageHost(), $image['path'], 's200_200/', $image['name'] ?>" />
                        <input type="hidden" value="<?= $image['id'] ?>" name="newimageauth[]" class="newimageauth" />
                        <div class="mask">
                            <p>&nbsp;</p>
                            <div class="tools tools-bottom">
                                <a onclick="deleteOldImage(this, 'col-md-55', <?= $image['id'] ?>)" href="javascript:void(0)"><i class="fa fa-times"></i></a>
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
<script>
    $(function () {
        $("#wrap_image_album_auth").sortable();
        $("#wrap_image_album_auth").disableSelection();
    });
</script>
<script type="text/javascript">

    function callbackcompleteauth(data) {
        var html = '<div class="col-md-55">';
        html += '<div class="thumbnail">';
        html += '<div class="image view view-first">';
        html += '<img id="img-up-'+data.imgid+'" style="display: block;" src="' + data.imgurl + '" />';
        html += '<input type="hidden" value="' + data.imgid + '" name="newimageauth[]" class="newimageauth" />';
        html += '<div class="mask">';
        html += '<p>&nbsp;</p>';
        html += '<div class="tools tools-bottom">';
        html += '<a onclick="deletenewimageauth(this, \'col-md-55\')" href="javascript:void(0)" title="Xóa ảnh này"><i class="fa fa-times"></i></a>';
        html += '</div>';
        html += '</div>';
        html += '</div>';
        html += '</div>';
        html += '</div>';

        jQuery('#wrap_image_album_auth').append(html);
    }

    function deletenewimageauth(_this, wrap) {
        if (confirm('Bạn có chắc muốn xóa ảnh?')) {
            $(_this).closest('.' + wrap).remove();
        }
        return false;
    }

    $.postJSON = function (url, data, func) {
        $.post(url + (url.indexOf("?") == -1 ? "?" : "&") + "callback=?", data, func, "json");
    };
</script>

<div class="box-crops">
    <div class="flex">
        <div class="in-flex">
            <div class="close-box-crops">x</div>
            <?php 
                echo \backend\widgets\cropImage\CropImageWidget::widget([
                    'input' => [
                        'img' => ''
                    ]
                ]); 
            ?>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.close-box-crops').click(function () {
                $('.box-crops').css('left', '-100%');
            });
        });
    </script>
    <script type="text/javascript">
        function cropimages(_this, img, id) {
            img = img.replace('/s200_200', '');
            $('.box-crops').css('left', '0px');
            $('#upload_crop').attr('data-id', id);
            $('#image').attr('src', img);
            $('.cropper-canvas').first().find('img').attr('src', img);
            loadimg(img, 800, 800);
        }
    </script>
</div>