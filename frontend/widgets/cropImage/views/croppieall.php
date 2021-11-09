<link rel="stylesheet" type="text/css" href="<?= Yii::$app->homeUrl ?>css/croppie/croppie.css">
<script type="text/javascript" src="<?= Yii::$app->homeUrl ?>css/croppie/croppie.js"></script>
<div class="box-croppie">
  <div id="upload-demo"></div>
  <input type="hidden" id="imagebase64" name="imagebase64">
  <a href="#" class="upload-result">Send</a>
</div>
<div id="res"></div>
<div id="boxjsCroppie">
  <script type="text/javascript">
        var $uploadCrop = $('#upload-demo');
            $uploadCrop.croppie({
                viewport: {
                    width: 400,
                    height: 400,
                    type: 'square'
                },
                boundary: {
                    width: 400,
                    height: 400
                }
            });
        $uploadCrop.croppie('bind', 'http://images6.fanpop.com/image/photos/35100000/kawaii-anime-kawaii-anime-35161658-368-500.jpg');
    $('.upload-result').on('click', function (ev) {
          // console.log($uploadCrop);
          $uploadCrop.croppie('result', {
              type: 'canvas',
              size:  {
                  width: 400,
                  height: 400
              }
          }).then(function (resp) {
              $.ajax({
                url: '<?= \yii\helpers\Url::to(['/management/crop/updatebgrfilecrop']) ?>',
                data: {url_img : resp},
                type: 'POST',
                success: function(result){
                  $('#avatar-shop').attr('src', result);
                }
            });
          });
      });
  </script>
</div>

