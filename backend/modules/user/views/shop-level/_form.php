<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\ClaHost;
/* @var $this yii\web\View */
/* @var $model common\models\user\UserMoney */
/* @var $form yii\widgets\ActiveForm */
?>
<script src="<?php echo Yii::$app->homeUrl ?>js/upload/ajaxupload.min.js"></script>
<div class="user-money-form">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <?php
            $form = ActiveForm::begin([
                        'id' => 'user-money-form',
                        'options' => [
                            'class' => 'form-horizontal',
                            'enctype' => 'multipart/form-data'
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
                            'placeholder' => $model->getAttributeLabel('name')
                        ])->label($model->getAttributeLabel('name'), [
                            'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
                        ])
                    ?>

                    <?=
                        $form->field($model, 'link', [
                            'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
                        ])->textInput([
                            'class' => 'form-control',
                            'placeholder' => $model->getAttributeLabel('link')
                        ])->label($model->getAttributeLabel('link'), [
                            'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
                        ])
                    ?>
                    <div class="form-group">
                        <?= Html::activeLabel($model, 'avatar', ['class' => 'control-label col-md-2 col-sm-2 col-xs-12']) ?>
                        <div class="col-md-10 col-sm-10 col-xs-12">
                            <?= Html::activeHiddenInput($model, 'avatar') ?>
                            <div id="shoplevelavatar_img" style="display: inline-block; max-width: 100px; max-height: 100px; overflow: hidden; vertical-align: top;">  
                                <?php if ($model->avatar_path && $model->avatar_name) { ?>
                                    <img src="<?php echo ClaHost::getImageHost() . $model->avatar_path . 's100_100/' . $model->avatar_name; ?>" style="width: 100%;" />
                                <?php } ?>
                            </div>
                            <div id="shoplevelavatar_form" style="display: inline-block;">
                                <?= Html::button('Chọn ảnh đại diện', ['class' => 'btn']); ?>
                            </div>
                        </div>
                    </div>
                    <script type="text/javascript">
                        $(document).ready(function () {
                            jQuery('#shoplevelavatar_form').ajaxUpload({
                                url: '<?= yii\helpers\Url::to(['shop-level/uploadfile']); ?>',
                                name: 'file',
                                onSubmit: function () {
                                },
                                onComplete: function (result) {
                                    var obj = $.parseJSON(result);
                                    if (obj.status == '200') {
                                        if (obj.data.realurl) {
                                            jQuery('#shoplevel-avatar').val(obj.data.image);
                                            if (jQuery('#shoplevelavatar_img img').attr('src')) {
                                                jQuery('#shoplevelavatar_img img').attr('src', obj.data.realurl);
                                            } else {
                                                jQuery('#shoplevelavatar_img').append('<img src="' + obj.data.realurl + '" />');
                                            }
                                            jQuery('#shoplevelavatar_img').css({"margin-right": "10px"});
                                        }
                                    }
                                }
                            });
                        });
                    </script>
                    <div class="form-group">
                        <?= Html::activeLabel($model, 'image', ['class' => 'control-label col-md-2 col-sm-2 col-xs-12']) ?>
                        <div class="col-md-10 col-sm-10 col-xs-12">
                            <?= Html::activeHiddenInput($model, 'image') ?>
                            <div id="shoplevelimage_img" style="display: inline-block; max-width: 100px; max-height: 100px; overflow: hidden; vertical-align: top;">  
                                <?php if ($model->image_path && $model->image_name) { ?>
                                    <img src="<?php echo ClaHost::getImageHost() . $model->image_path . 's100_100/' . $model->image_name; ?>" style="width: 100%;" />
                                <?php } ?>
                            </div>
                            <div id="shoplevelimage_form" style="display: inline-block;">
                                <?= Html::button('Chọn ảnh đại diện', ['class' => 'btn']); ?>
                            </div>
                        </div>
                    </div>
                    <script type="text/javascript">
                        $(document).ready(function () {
                            jQuery('#shoplevelimage_form').ajaxUpload({
                                url: '<?= yii\helpers\Url::to(['shop-level/uploadfile']); ?>',
                                name: 'file',
                                onSubmit: function () {
                                },
                                onComplete: function (result) {
                                    var obj = $.parseJSON(result);
                                    if (obj.status == '200') {
                                        if (obj.data.realurl) {
                                            jQuery('#shoplevel-image').val(obj.data.image);
                                            if (jQuery('#shoplevelimage_img img').attr('src')) {
                                                jQuery('#shoplevelimage_img img').attr('src', obj.data.realurl);
                                            } else {
                                                jQuery('#shoplevelimage_img').append('<img src="' + obj.data.realurl + '" />');
                                            }
                                            jQuery('#shoplevelimage_img').css({"margin-right": "10px"});
                                        }
                                    }
                                }
                            });
                        });
                    </script>
                </div>
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
