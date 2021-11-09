<?php

use common\components\ClaHost;
?>
<style type="text/css">
    .boxuploadfile {
        position: absolute;
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
        width: 20%;
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
        margin-left: 15%;
        margin-right: 0%;
        min-height: 132px;
        background:  unset;
        border: 1px solid #ebebeb;
        width: unset;
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
        width: 25px;
        height: 25px;
        background: #fff;
    }
</style>
<div class="item-input-form">
    <label class=""><?= isset($title) ? $title : Yii::t('app', 'shop_image_1') ?></label>
    <div class="group-input">
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
                        <img style="display: block;" src="<?= ClaHost::getImageHost(), $image['path'], 's200_200/', $image['name'] ?>" />
                        <div class="mask">
                            <div class="tools tools-bottom">
                                <a onclick="deleteOldImage(this, 'col-md-55',<?= $image['id'] ?>)" href="javascript:void(0)" title="Xóa ảnh này"><i class="fa fa-times"></i></a>
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
        // $("#wrap_image_album").sortable();
        // $("#wrap_image_album").disableSelection();
        // $('#wrap_image_album').click(function() {
        //     $('#imageupload').click();
        //     event.stopPropagation();
        // });
    });
</script>
<script type="text/javascript">

    function callbackcomplete(data) {
        var html = '<div class="col-md-55">';
        html += '<div class="thumbnail">';
        html += '<div class="image view view-first">';
        html += '<img style="width: 100%; display: block;" src="' + data.imgurl + '" />';
        html += '<input type="hidden" value="' + data.imgid + '" name="newimage[]" class="newimage" />';
        html += '<div class="mask">';
        html += '<div class="tools tools-bottom">';
        html += '<a onclick="deleteNewImage(this, \'col-md-55\')" href="javascript:void(0)" title="Xóa ảnh này"><i class="fa fa-times"></i></a>';
        html += '</div>';
        html += '</div>';
        html += '</div>';
        html += '</div>';
        html += '</div>';

        jQuery('#wrap_image_album').append(html);
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

    function deleteOldImage(_this, wrap, id) {
        if (confirm('<?= Yii::t('app', 'delete_sure') ?>')) {
            $.getJSON(
                    "<?= \yii\helpers\Url::to(['/management/shop/delete-image']) ?>",
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