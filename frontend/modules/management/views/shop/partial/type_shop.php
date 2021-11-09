<?php
use common\components\ClaHost;
?>
<style type="text/css">
    #wrap_image_album2 {
        cursor: pointer;
        clear: both;
        overflow: hidden;
        margin-bottom: 20px;
        margin-left: 15%;
        margin-right: 0%;
        min-height: 132px;
        background:  unset;
        border: 1px solid #ebebeb;
    }
    .auth-img .boxuploadfile{
        padding-left: 169px;
        margin-bottom: 10px;
        position: unset;
    }
    .auth-img .skip{
        position: absolute;
        margin-top: 15px;
    }
</style>

<div class="item-input-form auth-img" style="margin-top: -30px">
    <div class="group-input">
        <p class="skip center">2 mặt CMT hoặc thẻ căn cước, hộ chiếu (Bắt buộc), đăng ký kinh doanh, giấy tờ khác (nếu có)</p>
        <?=
        /**
         * Banner main
         */
        backend\widgets\upload\UploadWidget::widget([
            'type' => 'images',
            'id' => 'imageupload2',
            'buttonheight' => 25,
            'path' => array('shop'),
            'limit' => 100,
            'multi' => true,
            'imageoptions' => array(
                'resizes' => array(array(200, 200))
            ),
            'buttontext' => 'Thêm ảnh',
            'displayvaluebox' => false,
            'oncecomplete' => "callbackcomplete2(da);",
            'onUploadStart' => 'ta=false;',
            'queuecomplete' => 'ta=true;',
        ]);
        ?>
    </div>
</div>

<div class="group-input" id="wrap_image_album2">
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
        // $("#wrap_image_album2").sortable();
        // $("#wrap_image_album2").disableSelection();
        // $('#wrap_image_album2').click(function() {
        //     $('#imageupload2').click();
        //     event.stopPropagation();
        // });
    });
</script>
<script type="text/javascript">

    function callbackcomplete2(data) {
        var html = '<div class="col-md-55">';
        html += '<div class="thumbnail">';
        html += '<div class="image view view-first">';
        html += '<img style="width: 100%; display: block;" src="' + data.imgurl + '" />';
        html += '<input type="hidden" value="' + data.imgid + '" name="newimage2[]" class="newimage" />';
        html += '<div class="mask">';
        html += '<div class="tools tools-bottom">';
        html += '<a onclick="deleteNewImage(this, \'col-md-55\')" href="javascript:void(0)" title="Xóa ảnh này"><i class="fa fa-times"></i></a>';
        html += '</div>';
        html += '</div>';
        html += '</div>';
        html += '</div>';
        html += '</div>';

        jQuery('#wrap_image_album2').append(html);
    }

    function deleteNewImage(_this, wrap) {
        if (confirm('Bạn có chắc muốn xóa ảnh?')) {
            $(_this).closest('.' + wrap).remove();
        }
        event.stopPropagation();
        return false;
    }

    $.postJSON = function (url, data, func) {
        $.post(url + (url.indexOf("?") == -1 ? "?" : "&") + "callback=?", data, func, "json");
    };

    function deleteOldImage(_this, wrap, id) {
        if (confirm('Bạn có chắc muốn xóa ảnh?')) {
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