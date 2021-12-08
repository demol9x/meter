<?php

use common\components\ClaHost;

?>
<style type="text/css">
    .thumbnail {
        margin-bottom: 0px;
    }

    .thumbnail img {
        max-width: 100%;
        display: block;
        height: 100%;
        margin: 0 auto;
    }

    .hidden {
        display: none !important;
    }

    .col-md-55 {
        position: relative;
        min-height: 1px;
        float: left;
        padding-right: 10px;
        padding-left: 10px;
    }

    .thumbnail .caption {
        padding: 9px;
        color: #333;
    }

    .thumbnail .image {
        height: 100%;
        overflow: hidden;
    }

    .radio, .checkbox {
        position: relative;
        display: block;
        margin-top: 10px;
        margin-bottom: 10px;
    }

    .view-first .mask {
        opacity: 0;
        background-color: rgba(0, 0, 0, 0.5);
        transition: all 0.4s ease-in-out;
    }

    .view .mask, .view .content {
        position: absolute;
        width: 100%;
        overflow: hidden;
        top: 0;
        left: 0;
    }

    .view-first .tools {
        transform: translateY(-100px);
        opacity: 0;
        transition: all 0.2s ease-in-out;
    }

    .view .tools {
        text-transform: uppercase;
        color: #fff;
        text-align: center;
        position: relative;
        font-size: 17px;
        padding: 3px;
        background: rgba(0, 0, 0, 0.35);
        margin: 43px 0 0 0;
    }

    .thumbnail {
        margin-bottom: 0px;
    }

    .thumbnail {
        height: 190px;
        overflow: hidden;
    }

    .thumbnail {
        display: block;
        padding: 4px;
        margin-bottom: 20px;
        line-height: 1.42857143;
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 4px;
        -webkit-transition: border .2s ease-in-out;
        -o-transition: border .2s ease-in-out;
        transition: border .2s ease-in-out;
    }
</style>
<div class="form-group">
    <?=
    /**
     * Banner main
     */
    backend\widgets\upload\UploadWidget::widget([
        'type' => 'images',
        'id' => 'imageupload',
        'buttonheight' => 25,
        'path' => array('package'),
        'limit' => 100,
        'multi' => true,
        'imageoptions' => array(
            'resizes' => array(array(200, 200))
        ),
        'buttontext' => 'Thêm ảnh',
        'displayvaluebox' => false,
        'oncecomplete' => "callbackcomplete(da);",
        'onUploadStart' => 'ta=false;',
        'queuecomplete' => 'ta=true;',
    ]);
    ?>
</div>

<div class="row" id="wrap_image_album">
</div>
<script type="text/javascript">

    function callbackcomplete(data) {
        var html = '<div class="col-md-55">';
        html += '<div class="thumbnail">';
        html += '<div class="image view view-first">';
        html += '<img id="img-up-' + data.imgid + '" style="display: block;" src="' + data.imgurl + '" />';
        html += '<input type="hidden" value="' + data.imgid + '" name="newimage[]" class="newimage" />';
        html += '<div class="mask">';
        html += '<p>&nbsp;</p>';
        html += '<div class="tools tools-bottom">';
        html += '<a onclick="deleteNewImage(this, \'col-md-55\')" href="javascript:void(0)" title="Xóa ảnh này"><i class="fa fa-times"></i></a>';
        html += '</div>';
        html += '</div>';
        html += '</div>';
        html += '<div class="caption">';

        html += '</div>';
        html += '</div>';
        html += '</div>';

        jQuery('#wrap_image_album').append(html);
    }

    function deleteNewImage(_this, wrap) {
        if (confirm('Bạn có chắc muốn xóa ảnh?')) {
            $(_this).closest('.' + wrap).remove();
        }
        return false;
    }

    $.postJSON = function (url, data, func) {
        $.post(url + (url.indexOf("?") == -1 ? "?" : "&") + "callback=?", data, func, "json");
    };

    function deleteOldImage(_this, wrap, id) {
        if (confirm('Bạn có chắc muốn xóa ảnh?')) {
            $.getJSON(
                "<?= \yii\helpers\Url::to(['/ajax/delete-image']) ?>",
                {id: id}
            ).done(function (data) {
                $(_this).closest('.' + wrap).remove();
            }).fail(function (jqxhr, textStatus, error) {
                var err = textStatus + ", " + error;
                console.log("Request Failed: " + err);
            });
        }
        return false;
    }
</script>
