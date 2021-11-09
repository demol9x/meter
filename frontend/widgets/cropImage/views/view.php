<div class="box-crop">
  <div class="row">
    <div class="col-md-12">
      <!-- <h3>Demo:</h3> -->
      <div class="img-container">
        <img id="image" src="" alt="Picture">
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 docs-buttons">
      <!-- <h3>Toolbar:</h3> -->
      <!-- <div class="btn-group">
        <button type="button" class="btn btn-primary" data-method="setDragMode" data-option="move" title="Move">
          <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;setDragMode&quot;, &quot;move&quot;)">
            <span class="fa fa-arrows"></span>
          </span>
        </button>
        <button type="button" class="btn btn-primary" data-method="setDragMode" data-option="crop" title="Crop">
          <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;setDragMode&quot;, &quot;crop&quot;)">
            <span class="fa fa-crop"></span>
          </span>
        </button>
      </div> -->

      <div class="btn-group">
        <button type="button" class="btn btn-primary" data-method="zoom" data-option="0.1" title="Zoom In">
          <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;zoom&quot;, 0.1)">
            <span class="fa fa-search-plus"></span>
          </span>
        </button>
        <button type="button" class="btn btn-primary" data-method="zoom" data-option="-0.1" title="Zoom Out">
          <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;zoom&quot;, -0.1)">
            <span class="fa fa-search-minus"></span>
          </span>
        </button>
      </div>

     <!--  <div class="btn-group">
        <button type="button" class="btn btn-primary" data-method="move" data-option="-10" data-second-option="0" title="Move Left">
          <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;move&quot;, -10, 0)">
            <span class="fa fa-arrow-left"></span>
          </span>
        </button>
        <button type="button" class="btn btn-primary" data-method="move" data-option="10" data-second-option="0" title="Move Right">
          <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;move&quot;, 10, 0)">
            <span class="fa fa-arrow-right"></span>
          </span>
        </button>
        <button type="button" class="btn btn-primary" data-method="move" data-option="0" data-second-option="-10" title="Move Up">
          <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;move&quot;, 0, -10)">
            <span class="fa fa-arrow-up"></span>
          </span>
        </button>
        <button type="button" class="btn btn-primary" data-method="move" data-option="0" data-second-option="10" title="Move Down">
          <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;move&quot;, 0, 10)">
            <span class="fa fa-arrow-down"></span>
          </span>
        </button>
      </div> -->

      <div class="btn-group">
        <button type="button" class="btn btn-primary" data-method="rotate" data-option="-45" title="Rotate Left">
          <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;rotate&quot;, -45)">
            <span class="fa fa-rotate-left"></span>
          </span>
        </button>
        <button type="button" class="btn btn-primary" data-method="rotate" data-option="45" title="Rotate Right">
          <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;rotate&quot;, 45)">
            <span class="fa fa-rotate-right"></span>
          </span>
        </button>
      </div>

      <!-- <div class="btn-group">
        <button type="button" class="btn btn-primary" data-method="scaleX" data-option="-1" title="Flip Horizontal">
          <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;scaleX&quot;, -1)">
            <span class="fa fa-arrows-h"></span>
          </span>
        </button>
        <button type="button" class="btn btn-primary" data-method="scaleY" data-option="-1" title="Flip Vertical">
          <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;scaleY&quot;, -1)">
            <span class="fa fa-arrows-v"></span>
          </span>
        </button>
      </div> -->

     <button type="button" class="btn btn-primary" data-method="reset" title="Reset">
        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;reset&quot;)">
          <span class="fa fa-refresh"></span>
        </span>
      </button>

      <!-- <div class="btn-group">
        <button type="button" class="btn btn-primary" data-method="crop" title="Crop">
          <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;crop&quot;)">
            <span class="fa fa-check"></span>
          </span>
        </button>
        <button type="button" class="btn btn-primary" data-method="clear" title="Clear">
          <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;clear&quot;)">
            <span class="fa fa-remove"></span>
          </span>
        </button>
      </div>

      <div class="btn-group">
        <button type="button" class="btn btn-primary" data-method="disable" title="Disable">
          <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;disable&quot;)">
            <span class="fa fa-lock"></span>
          </span>
        </button>
        <button type="button" class="btn btn-primary" data-method="enable" title="Enable">
          <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;enable&quot;)">
            <span class="fa fa-unlock"></span>
          </span>
        </button>
      </div> -->

      <div class="btn-group" id="crop-img-upload">
        <label class="btn btn-primary btn-upload" for="inputImage" title="Upload image file">
          <input type="file" class="sr-only" id="inputImage" name="file" accept=".jpg,.jpeg,.png,.gif,.bmp,.tiff">
          <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Import image with Blob URLs">
            <span class="fa fa-upload"></span>
          </span>
        </label>

        <!-- <button type="button" class="btn btn-primary" data-method="destroy" title="Destroy">
          <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;destroy&quot;)">
            <span class="fa fa-power-off"></span>
          </span>
        </button> -->
      </div>
      
      <div class="btn-group btn-group-crop">
        <span type="button" id="upload_crop" class="btn btn-success" data-method="getCroppedCanvas" data-option="{ &quot;width&quot;: 800, &quot;height&quot;: 800 }">
          <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;getCroppedCanvas&quot;, { width: 800, height: 800 })">
            Lưu lại
          </span>
        </span>
      </div>

      <!-- Show the cropped image in modal -->
      <div class="modal fade docs-cropped" id="getCroppedCanvasModal" aria-hidden="true" aria-labelledby="getCroppedCanvasTitle" role="dialog" tabindex="-1">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="getCroppedCanvasTitle">Cropped</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <a class="btn btn-primary" id="download" href="javascript:void(0);" download="cropped.jpg">Download</a>
              <a class="btn btn-primary" id="upto" href="javascript:void(0);" download="cropped.jpg">UP to</a>
            </div>
          </div>
        </div>
      </div><!-- /.modal -->
    </div><!-- /.docs-toggles -->
  </div>
</div>
<!-- <?php if(isset($model)) { ?>
  <?= $form->fields($model, $path, ['class'=> ''])->textInput(['id' => 'input_path_crop_id']) ?>
  <?= $form->fields($model, $name, ['class'=> ''])->textInput(['id' => 'input_name_crop_id']) ?>
<?php } ?> -->
<script type="text/javascript">
  function upfile(url_img, id) {
    jQuery.ajax({
        url: '<?= \yii\helpers\Url::to(['/management/crop/uploadproductfilecrop']) ?>',
        type: 'POST',
        data: {'url_img': url_img, 'id' : id},
        // dataType: 'JSON',
        success: function (data) {
            $('#img-up-'+id).attr('src', data);
            $('.close-box-crops').click();
        }
    });
  }
  function upfile_bgr_shop(url_img) {
    jQuery.ajax({
        url: '<?= \yii\helpers\Url::to(['/management/crop/updatebgrfilecrop']) ?>',
        type: 'POST',
        data: {'url_img': url_img},
        // dataType: 'JSON',
        success: function (data) {
            $('#bgr-shop').attr('src', data);
            $('.close-box-crops').click();
            $('#crop-img-upload').css('display', 'inline-block');
        }
    });
  }
  function upfile_ava_shop(url_img) {
    jQuery.ajax({
        url: '<?= \yii\helpers\Url::to(['/management/crop/updateavafilecrop']) ?>',
        type: 'POST',
        data: {'url_img': url_img},
        // dataType: 'JSON',
        success: function (data) {
            $('#avatar-shop').attr('src', data);
            $('.close-box-crops').click();
            $('#crop-img-upload').css('display', 'inline-block');
        }
    });
  }
</script>