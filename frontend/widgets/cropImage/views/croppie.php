<?php if(isset($img)) {?>
    <link rel="stylesheet" type="text/css" href="<?= Yii::$app->homeUrl ?>css/croppie/croppie.css">
    <script type="text/javascript" src="<?= Yii::$app->homeUrl ?>css/croppie/croppie.js"></script>
    <style type="text/css">
        .cr-boundary {
            border: 1px solid #ebebeb;
        }
        .upload-result {
            background: #17a349;
            color: #fff;
            display: inline-block;
            padding: 7px 15px;
            border-radius: 3px;
        }

    </style>
    <div class="box-croppie">
      <div id="upload-demo"></div>
      <input type="hidden" id="imagebase64" name="imagebase64">
      <div class="center">
            <p id="responce-croppie" class="responce-croppie"></p>
          <a class="click upload-result">Lưu ảnh</a>
      </div>
    </div>
    <div id="res"></div>
    <script type="text/javascript">
        var widthCr =  <?= $size[0] ?>;
        var hegthCr =  <?= $size[1] ?>;
        var width_box= $('#box-crops-in-flex').width();
        if(width_box < widthCr) {
            hegthCr = hegthCr*width_box/widthCr;
            widthCr = width_box;
        }
        var $uploadCrop = $('#upload-demo');
            $uploadCrop.croppie({
                viewport: {
                    width: widthCr,
                    height: hegthCr,
                    type: 'square'
                },
                boundary: {
                    width: widthCr,
                    height: hegthCr
                }
            });
            $uploadCrop.croppie('bind', '<?= $img ?>');
            // $('.vanilla-rotate').on('click', function(ev) {
            //     vanilla.rotate(parseInt($(this).data('deg')));
            // });
        $('.upload-result').on('click', function (ev) {
            // console.log($uploadCrop);
            $uploadCrop.croppie('result', {
                type: 'canvas',
                size:  {
                    width: <?= $size[0] ?>,
                    height: <?= $size[1] ?>
                }
            }).then(function (resp) {
                $('#responce-croppie').html('Đang lưu...');
                $.ajax({
                  url: '<?= $url ?>',
                  data: {url_img : resp <?= isset($id_image_product) ? ', id: \''.$id_image_product.'\'' : '' ?>},
                  type: 'POST',
                  success: function(result){
                    $('<?= $id ?>').attr('src', result);
                    $('#responce-croppie').html('Đã lưu.');
                  }
              });
            });
        });
    </script>
<?php } ?>

