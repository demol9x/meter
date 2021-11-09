<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\ClaHost;

/* @var $this yii\web\View */
/* @var $model common\models\product\Brand */
/* @var $form yii\widgets\ActiveForm */
?>
<script src="<?php echo Yii::$app->homeUrl ?>js/upload/ajaxupload.min.js"></script>
<div class="brand-form">

    <div class="row">
        <?php
        $form = ActiveForm::begin([
                    'id' => 'product-form',
                    'options' => [
                        'class' => 'form-horizontal'
                    ]
        ]);
        ?>
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-bars"></i> <?= Html::encode($this->title) ?> </h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?=
                $form->field($model, 'name', [
                    'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
                ])->textInput([
                    'class' => 'form-control',
                    'placeholder' => 'Nhập tên thương hiệu'
                ])->label($model->getAttributeLabel('name'), [
                    'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
                ])
                ?>

                <div class="form-group">
                    <?= Html::activeLabel($model, 'avatar', ['class' => 'control-label col-md-2 col-sm-2 col-xs-12']) ?>
                    <div class="col-md-10 col-sm-10 col-xs-12">
                        <?= Html::activeHiddenInput($model, 'avatar') ?>
                        <div id="brandavatar_img" style="display: inline-block; max-width: 100px; max-height: 100px; overflow: hidden; vertical-align: top;">  
                            <?php if ($model->avatar_path && $model->avatar_name) { ?>
                                <img src="<?php echo ClaHost::getImageHost() . $model->avatar_path . 's100_100/' . $model->avatar_name; ?>" style="width: 100%;" />
                            <?php } ?>
                        </div>
                        <div id="brandavatar_form" style="display: inline-block;">
                            <?= Html::button('Chọn ảnh đại diện', ['class' => 'btn']); ?>
                        </div>
                    </div>
                </div>
                <script type="text/javascript">
                    $(document).ready(function () {
                        jQuery('#brandavatar_form').ajaxUpload({
                            url: '<?= yii\helpers\Url::to(['/product/brand/uploadfile']); ?>',
                            name: 'file',
                            onSubmit: function () {
                            },
                            onComplete: function (result) {
                                var obj = $.parseJSON(result);
                                if (obj.status == '200') {
                                    if (obj.data.realurl) {
                                        jQuery('#brand-avatar').val(obj.data.avatar);
                                        if (jQuery('#brandavatar_img img').attr('src')) {
                                            jQuery('#brandavatar_img img').attr('src', obj.data.realurl);
                                        } else {
                                            jQuery('#brandavatar_img').append('<img src="' + obj.data.realurl + '" />');
                                        }
                                        jQuery('#brandavatar_img').css({"margin-right": "10px"});
                                    }
                                }
                            }
                        });
                    });
                </script>

                <?=
                $form->field($model, 'status', [
                    'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
                ])->dropDownList(common\components\ClaLid::optionsStatus(), [
                    'class' => 'form-control',
                ])->label($model->getAttributeLabel('status'), [
                    'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
                ])
                ?>

            </div>
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

</div>
