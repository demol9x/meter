<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\models\UserRecruiterInfo;
use common\components\ClaHost;

/* @var $this yii\web\View */
/* @var $model frontend\models\UserRecruiterInfo */
/* @var $form yii\widgets\ActiveForm */
?>
<script src="<?php echo Yii::$app->homeUrl ?>js/upload/ajaxupload.min.js"></script>
<div class="user-recruiter-info-form">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <?php
            $form = ActiveForm::begin([
                        'id' => 'user-recruiter-info-form',
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
                    $form->field($user, 'username', [
                        'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
                    ])->textInput([
                        'maxlength' => true,
                        'placeholder' => 'Tên nhà tuyển dụng'
                    ])->label('Tên nhà tuyển dụng', [
                        'class' => 'control-label col-md-2 col-sm-2 col-xs-12',
                    ]);
                    ?>

                    <?=
                    $form->field($user, 'email', [
                        'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
                    ])->textInput([
                        'maxlength' => true,
                        'placeholder' => 'Email',
                        'readonly' => 'readonly'
                    ])->label('Email', [
                        'class' => 'control-label col-md-2 col-sm-2 col-xs-12',
                    ]);
                    ?>

                    <?=
                    $form->field($model, 'contact_name', [
                        'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
                    ])->textInput([
                        'maxlength' => true,
                        'placeholder' => 'Nhập tên người liên hệ'
                    ])->label($model->getAttributeLabel('contact_name'), [
                        'class' => 'control-label col-md-2 col-sm-2 col-xs-12',
                    ]);
                    ?>

                    <div class="form-group">
                        <?= Html::activeLabel($model, 'avatar', ['class' => 'control-label col-md-2 col-sm-2 col-xs-12']) ?>
                        <div class="col-md-10 col-sm-10 col-xs-12">
                            <?= Html::activeHiddenInput($model, 'avatar') ?>
                            <div id="useravatar_img" style="display: inline-block; max-width: 100px; max-height: 100px; overflow: hidden; vertical-align: top;">  
                                <?php if ($model->avatar_path && $model->avatar_name) { ?>
                                    <img src="<?= ClaHost::getImageHost(), $model->avatar_path, 's100_100/', $model->avatar_name; ?>" style="width: 100%;" />
                                <?php } ?>
                            </div>
                            <div id="useravatar_form" style="display: inline-block;">
                                <?= Html::button('Chọn ảnh đại diện', ['class' => 'btn']); ?>
                            </div>
                        </div>
                    </div>
                    <script type="text/javascript">
                        $(document).ready(function () {
                            jQuery('#useravatar_form').ajaxUpload({
                                url: '<?= yii\helpers\Url::to(['/management/user-recruiter-info/uploadfile']); ?>',
                                name: 'file',
                                onSubmit: function () {
                                },
                                onComplete: function (result) {
                                    var obj = $.parseJSON(result);
                                    if (obj.status == '200') {
                                        if (obj.data.realurl) {
                                            jQuery('#userrecruiterinfo-avatar').val(obj.data.avatar);
                                            if (jQuery('#useravatar_img img').attr('src')) {
                                                jQuery('#useravatar_img img').attr('src', obj.data.realurl);
                                            } else {
                                                jQuery('#useravatar_img').append('<img src="' + obj.data.realurl + '" />');
                                            }
                                            jQuery('#useravatar_img').css({"margin-right": "10px"});
                                        }
                                    }
                                }
                            });
                        });
                    </script>

                    <?=
                    $form->field($model, 'phone', [
                        'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
                    ])->textInput([
                        'maxlength' => true,
                        'placeholder' => 'Nhập số điện thoại'
                    ])->label($model->getAttributeLabel('phone'), [
                        'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
                    ]);
                    ?>

                    <?=
                    $form->field($model, 'scale', [
                        'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
                    ])->dropDownList(UserRecruiterInfo::optionsScale(), [
                        'prompt' => '--- Chọn qui mô công ty ---'
                    ])->label($model->getAttributeLabel('scale'), [
                        'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
                    ]);
                    ?>

                    <?=
                    $form->field($model, 'address', [
                        'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
                    ])->textInput([
                        'maxlength' => true,
                        'placeholder' => 'Nhập địa chỉ đầy đủ VD: Tòa nhà Fashion Mall 335 đường Cầu Giấy, Mai Dịch, Cầu Giấy, Hà Nội'
                    ])->label($model->getAttributeLabel('address'), [
                        'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
                    ]);
                    ?>

                    <?=
                    $form->field($model, 'province_id', [
                        'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
                    ])->dropDownList($provinces, [
                        'prompt' => '--- Chọn tỉnh/thành phố ---',
                        'class' => 'form-control select-province-id'
                    ])->label($model->getAttributeLabel('province_id'), [
                        'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
                    ]);
                    ?>

                    <?=
                    $form->field($model, 'district_id', [
                        'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
                    ])->dropDownList($districts, [
                        'prompt' => '--- Chọn quận/huyện ---',
                        'class' => 'form-control select-district-id'
                    ])->label($model->getAttributeLabel('district_id'), [
                        'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
                    ]);
                    ?>

                    <?=
                    $form->field($model, 'ward_id', [
                        'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
                    ])->dropDownList($wards, [
                        'prompt' => '--- Chọn phường/xã ---',
                        'class' => 'form-control select-ward-id'
                    ])->label($model->getAttributeLabel('ward_id'), [
                        'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
                    ]);
                    ?>

                    <?=
                    $form->field($model, 'description', [
                        'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
                    ])->textArea(['rows' => 4])->label($model->getAttributeLabel('description'), [
                        'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
                    ]);
                    ?>

                </div>
                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('.select-province-id').change(function () {
            var province_id = $(this).val();
            $.getJSON(
                    "<?= \yii\helpers\Url::to(['/suggest/getdistrict']) ?>",
                    {province_id: province_id, label: 'Quận/huyện'}
            ).done(function (data) {
                $('.select-district-id').html(data.html);
                $('.select-ward-id').html('<option>Phường/xã</option>');
            }).fail(function (jqxhr, textStatus, error) {
                var err = textStatus + ", " + error;
                console.log("Request Failed: " + err);
            });
        });

        $('.select-district-id').change(function () {
            var district_id = $(this).val();
            $.getJSON(
                    "<?= \yii\helpers\Url::to(['/suggest/getward']) ?>",
                    {district_id: district_id, label: 'Phường/xã'}
            ).done(function (data) {
                $('.select-ward-id').html(data.html);
            }).fail(function (jqxhr, textStatus, error) {
                var err = textStatus + ", " + error;
                console.log("Request Failed: " + err);
            });
        });
    });
</script>
