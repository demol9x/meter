<?php

use yii\widgets\ActiveForm;
use yii\bootstrap\Html;
use yii\helpers\Url;
?>
<style type="text/css">
    .form-group.required label:after{
        content: '*';
        color: red;
        margin-left: 5px;
    }
    .has-error .help-block, .help-block{
        color: red;
    }
    .has-error .control-label{
        color: #333333;
    }
    .has-error .form-control{
        border-color: #cccccc;
    }
    .has-success .control-label{
        color: #333333;
    }
    .has-success .form-control{
        border-color: #cccccc;
    }
    .form-infor-user .form-group{
        min-height: 50px;
    }
    .wrap-camera{
        position: fixed;
        top: 20%;
        left: 40%;
        background: rgb(241, 241, 242);
        box-shadow: 1px 1px 8px #000;
        z-index: 999;
        padding: 10px;
        display: none;
    }
    .info .bg-success{
        padding: 15px;
        text-align: center;
        font-size: 20px;
    }
    .select-scale .selectric .label{
        padding-left: 12px;
    }
    .wrap-knowledge .item{
        margin-bottom: 15px;
    }
</style>
<?php if ($browser_name != 'SAFARI') { ?>
    <script type="text/javascript" src="<?= Yii::$app->homeUrl ?>js/webcam.js"></script>
<?php } ?>
<script src="<?= Yii::$app->homeUrl ?>/js/upload/ajaxupload.min.js"></script>
<div class="site-hoso" id="main-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pad-10">
                <?= frontend\widgets\breadcrumbs\BreadcrumbsWidget::widget() ?>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <?php
                $form = ActiveForm::begin([
                            'options' => array(
                                'class' => '',
                                'enctype' => 'multipart/form-data'
                            ),
                ]);
                ?>
                <div class="wrap-camera">
                    <label>Live Camera</label>
                    <div id="my_camera"></div>
                    <div style="margin-top: 10px;">
                        <a class="btn btn-default" href="javascript:void(0)" onclick="take_snapshot()">Chụp</a>
                        <a class="btn btn-default" onclick="closeCamera()">Đóng</a>
                    </div>
                </div>
                <div class="steps-hoso">
                    <div class="bg-step bg-step-1">
                        <img src="<?= Yii::$app->homeUrl ?>images/tit-1.png">
                    </div>
                    <div class="flex-box">
                        <div class="box-left-position">
                            <div class="position-apply">
                                <div class="title-position">
                                    <h2>Vị trí ứng tuyển:</h2>
                                </div>
                                <div class="select-box-position">
                                    <?=
                                    $form->field($model, 'recruitment_id')->dropDownList([
                                        $recruitment['id'] => $recruitment['title']
                                    ])->label(false);
                                    ?>
                                </div>
                            </div>
                            <div class="position-apply">
                                <div class="title-position">
                                    <h3>Nguyện vọng làm tại:</h3>
                                </div>
                                <div class="select-box-position">
                                    <?=
                                    $form->field($model, 'location_desire')->dropDownList($locations)->label(false);
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="box-right-position">
                            <?php if ($browser_name != 'SAFARI') { ?>
                                <a id="wrap-result-image-camera" href="javascript:void(0)" onclick="openCamera()">
                                    <img src="<?= $src_avatar ?>" />
                                </a>
                            <?php } else { ?>
                                <a id="wrap-result-image-camera" href="javascript:void(0)" onclick="triggerAvatar()">
                                    <img src="<?= $src_avatar ?>" />
                                </a>
                            <?php } ?>
                            <span>(hoặc chọn ảnh từ máy tính)</span>
                            <div id="job_avatar_form">
                                <?= Html::button('Chọn ảnh đại diện', ['class' => 'btn btn-sm']) ?>
                            </div>
                            <?=
                            $form->field($model, 'src_avatar')->hiddenInput()->label(false);
                            ?>
                            <?=
                            $form->field($model, 'avatar')->hiddenInput()->label(false);
                            ?>
                        </div>
                    </div>
                </div>
                <div class="steps-hoso">
                    <div class="bg-step bg-step-1">
                        <img src="<?= Yii::$app->homeUrl ?>images/tit-2.png">
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="form-infor-user">
                                <div class="panel-body" >
                                    <?=
                                    $form->field($model, 'name', [
                                        'template' => '<div><div class="col-md-4">{label}</div><div class="col-md-8">{input}{error}{hint}</div></div>'
                                    ])->textInput([
                                        'class' => 'form-control',
                                        'placeholder' => 'Vui lòng viết hoa, có dấu ...'
                                    ]);
                                    ?>

                                    <div class="form-group required">
                                        <label class="control-label col-md-4">Ngày sinh:</label>
                                        <div class="controls col-md-8 ">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <?=
                                                    Html::activeDropDownList($model, 'day', $model->getDays());
                                                    ?>
                                                </div>
                                                <div class="col-md-4">
                                                    <?=
                                                    Html::activeDropDownList($model, 'month', $model->getMonths());
                                                    ?>
                                                </div>
                                                <div class="col-md-4">
                                                    <?=
                                                    Html::activeDropDownList($model, 'year', $model->getYears());
                                                    ?>
                                                </div>
                                            </div>
                                            <?=
                                            Html::error($model, 'birthday', [
                                                'class' => 'help-block'
                                            ])
                                            ?>
                                        </div>     
                                    </div>

                                    <?=
                                    $form->field($model, 'identity_card', [
                                        'template' => '<div><div class="col-md-4">{label}</div><div class="col-md-8">{input}{error}{hint}</div></div>'
                                    ])->textInput([
                                        'class' => 'form-control',
                                        'placeholder' => 'Vui lòng nhập chính xác'
                                    ]);
                                    ?>

                                    <?=
                                    $form->field($model, 'address', [
                                        'template' => '<div><div class="col-md-4">{label}</div><div class="col-md-8">{input}{error}{hint}</div></div>'
                                    ])->textInput([
                                        'class' => 'form-control',
                                        'placeholder' => 'VD: 365 Cộng Hòa, Phường 12, Quận Tân Bình'
                                    ]);
                                    ?>

                                    <?=
                                    $form->field($model, 'province_id', [
                                        'template' => '<div><div class="col-md-4">{label}</div><div class="col-md-8">{input}{error}{hint}</div></div>'
                                    ])->dropDownList(\common\models\Province::optionsProvince());
                                    ?>

                                    <?=
                                    $form->field($model, 'email', [
                                        'template' => '<div><div class="col-md-4">{label}</div><div class="col-md-8">{input}{error}{hint}</div></div>'
                                    ])->textInput([
                                        'class' => 'form-control',
                                        'placeholder' => 'Công ty sẽ gửi kết quả qua email'
                                    ]);
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="form-infor-user">
                                <div class="panel-body" >
                                    <?=
                                    $form->field($model, 'sex', [
                                        'template' => '<div><div class="col-md-4">{label}</div><div class="col-md-8">{input}{error}{hint}</div></div>'
                                    ])->radioList([
                                        1 => 'Nam',
                                        2 => 'Nữ'
                                    ]);
                                    ?>

                                    <?=
                                    $form->field($model, 'birthplace', [
                                        'template' => '<div><div class="col-md-4">{label}</div><div class="col-md-8">{input}{error}{hint}</div></div>'
                                    ])->dropDownList(\common\models\Province::optionsProvince());
                                    ?>

                                    <?=
                                    $form->field($model, 'married_status', [
                                        'template' => '<div><div class="col-md-4">{label}</div><div class="col-md-8">{input}{error}{hint}</div></div>'
                                    ])->radioList([
                                        1 => 'Độc thân',
                                        2 => 'Đã kết hôn'
                                    ]);
                                    ?>

                                    <?=
                                    $form->field($model, 'hotline', [
                                        'template' => '<div><div class="col-md-4">{label}</div><div class="col-md-8">{input}{error}{hint}</div></div>'
                                    ])->textInput([
                                        'class' => 'form-control',
                                        'placeholder' => 'VD: 0975667788'
                                    ]);
                                    ?>

                                    <?=
                                    $form->field($model, 'income_desire', [
                                        'template' => '<div><div class="col-md-4">{label}</div><div class="col-md-8">{input}{error}{hint}</div></div>'
                                    ])->textInput([
                                        'class' => 'form-control',
                                        'placeholder' => 'VD: $500 - $1000'
                                    ]);
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12" id="txtInformation">
                            <h2>Vì sao bạn muốn ứng tuyển vị trí này?</h2>
                            <?=
                            $form->field($model, 'reason')->textarea([
                                'rows' => 6
                            ])->label(FALSE);
                            ?>
                        </div>
                    </div>
                </div>
                <div class="steps-hoso">
                    <div class="bg-step bg-step-1">
                        <img src="<?= Yii::$app->homeUrl ?>images/tit-3.png">
                    </div>
                    <div class="row">
                        <div class="col-xs-12" id="txtInformation">
                            <div class="wrap-knowledge form-group">
                                <div class="item col-xs-12">
                                    <div class="row">
                                        <label class="control-label col-md-1 txt-right">Trường: </label>
                                        <div class="controls col-md-3"> 
                                            <input name="ApplyEducation[1][school]" class="form-control" placeholder="Trường" type="text" />
                                        </div>
                                        <label class="control-label col-md-1 txt-right">Ngành: </label>
                                        <div class="controls col-md-3"> 
                                            <input name="ApplyEducation[1][major]" class="form-control" placeholder="Ngành" type="text" />
                                        </div>
                                        <label class="control-label col-md-1 txt-right">Hệ: </label>
                                        <div class="controls col-md-3"> 
                                            <input name="ApplyEducation[1][qualification_type]" class="form-control" placeholder="Hệ" type="text" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button id="btn-add-knowledge" type="button" class="btn-add-field right mar-right-15">
                                <i class="fa fa-plus-circle fa-lg"></i>Thêm trường học
                            </button>
                            <h3>Chứng chỉ khác (nếu có)</h3>
                            <?=
                            $form->field($model, 'certificate')->textarea([
                                'rows' => 6
                            ])->label(FALSE);
                            ?>
                        </div>
                    </div>
                </div>
                <div class="steps-hoso">
                    <div class="bg-step bg-step-1">
                        <img src="<?= Yii::$app->homeUrl ?>images/tit-4.png">
                    </div>
                    <div class="row">



                        <div class="col-xs-12" id="txtInformation">
                            <div class="wrap-work-history">
                                <div class="item">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Công ty: </label>
                                        <div class="controls col-md-9"> 
                                            <div class="row">
                                                <div class="controls col-xs-5">
                                                    <input name="ApplyWorkHistory[1][company]" class="form-control" placeholder="Công ty đã làm gần đây" type="text" />
                                                </div>
                                                <label class="control-label col-xs-2 txt-right">Vị trí: </label>
                                                <div class="controls col-xs-5">
                                                    <input name="ApplyWorkHistory[1][position]" class="form-control" placeholder="Vị trí" type="text" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Lĩnh vực hoạt động / Ngành nghề công ty: </label>
                                        <div class="controls col-md-9"> 
                                            <div class="row">
                                                <div class="controls col-xs-5">
                                                    <input name="ApplyWorkHistory[1][field_business]" class="form-control" placeholder="Lĩnh vực hoạt động" type="text" />
                                                </div>
                                                <label class="control-label col-xs-2 txt-right">Quy mô: </label>
                                                <div class="controls col-xs-5 select-scale">
                                                    <?php
                                                    $scales = \common\models\recruitment\ApplyWorkHistory::getArrayScale();
                                                    ?>
                                                    <select name="ApplyWorkHistory[1][scale]">
                                                        <?php foreach ($scales as $value => $name) { ?>
                                                            <option value="<?php echo $value ?>"><?php echo $name ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Mô tả chi tiết công việc đã làm: </label>
                                        <div class="controls col-md-9"> 
                                            <div class="row">
                                                <div class="col-xs-12 form-group">
                                                    <div class="row">
                                                        <label class="control-label col-xs-3"> Công việc cụ thể: </label>
                                                        <div class="controls col-xs-9">
                                                            <input name="ApplyWorkHistory[1][job_detail]" class="form-control" placeholder="Công việc cụ thể" type="text" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 form-group">
                                                    <div class="row">
                                                        <label class="control-label col-xs-3"> Thời gian làm việc: </label>
                                                        <div class="controls col-xs-9">
                                                            <input name="ApplyWorkHistory[1][time_work]" class="form-control" placeholder="Thời gian làm việc" type="text" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 form-group">
                                                    <div class="row">
                                                        <label class="control-label col-xs-3"> Nguyên nhân nghỉ việc: </label>
                                                        <div class="controls col-xs-9">
                                                            <input name="ApplyWorkHistory[1][reason_offwork]" class="form-control" placeholder="Nguyên nhân nghỉ việc" type="text" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button id="btn-add-work-history" type="button" class="btn-add-field right mar-right-15">
                                <i class="fa fa-plus-circle fa-lg"></i>Thêm nơi làm việc
                            </button>
                        </div>
                    </div>
                </div>
                <div class="steps-hoso" style="margin-top:15px;">
                    <div class="col-xs-6 send-cv">
                        <div class="push-cv">
                            <span style="display: block; margin-bottom: 10px;">Đính kèm Hồ sơ cá nhân (.doc hoặc .pdf)</span>
                            <input type="file" name="file_cv" />
                        </div>
                    </div>
                    <div class="col-xs-6 send-cv">
                        <button class="btn-add-field right colorff6a00">Gửi hồ sơ</button>
                        <button class="btn-add-field right mar-right-15" style="padding: 10px 30px;">Trở về</button>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#btn-add-work-history').click(function () {
            var stt = $('.wrap-work-history .item').length;
            stt++;
            $.getJSON(
                    '<?= Url::to(['/recruitment/apply/render-work-history']) ?>',
                    {stt: stt},
                    function (result) {
                        $('.wrap-work-history').append(result.html);
                        $("select").selectric();
                    }
            );
        });
        $('#btn-add-knowledge').click(function () {
            var stt = $('.wrap-knowledge .item').length;
            stt++;
            $.getJSON(
                    '<?= Url::to(['/recruitment/apply/render-education']) ?>',
                    {stt: stt},
                    function (result) {
                        $('.wrap-knowledge').append(result.html);
                    }
            );
        });
    });

    jQuery(function ($) {
        jQuery('#job_avatar_form').ajaxUpload({
            url: '<?= Url::to(['/recruitment/apply/uploadfile']) ?>',
            name: 'file',
            onSubmit: function () {
            },
            onComplete: function (result) {
                var obj = $.parseJSON(result);
                if (obj.status == '200') {
                    if (obj.data.realurl) {
                        jQuery('#apply-avatar').val(obj.data.avatar);
                        jQuery('#apply-src_avatar').val(obj.data.realurl);
                        if (jQuery('#wrap-result-image-camera img').attr('src')) {
                            jQuery('#wrap-result-image-camera img').attr('src', obj.data.realurl);
                        } else {
                            jQuery('#wrap-result-image-camera img').attr('src', obj.data.realurl);
                        }
                        jQuery('#wrap-result-image-camera').css({"margin-right": "10px"});
                    }
                }
            }
        });

    });

</script>
<script language="JavaScript">
<?php if ($browser_name != 'SAFARI') { ?>
        Webcam.set({
            width: 300,
            height: 300,
            image_format: 'jpeg',
            jpeg_quality: 90
        });
        Webcam.attach('#my_camera');
        function take_snapshot() {
            // take snapshot and get image data
            Webcam.snap(function (data_uri) {
                // Upload image to server
                Webcam.upload(data_uri, '<?= Url::to(['/recruitment/apply/uploadfile']) ?>', function (code, text) {
                    // Upload complete!
                    // 'code' will be the HTTP response code from the server, e.g. 200
                    // 'text' will be the raw response content
                    //                    console.log(code);
                    //                    console.log(text);
                    var obj = JSON.parse(text);
                    jQuery('#apply-avatar').val(obj.data.avatar);
                    jQuery('#apply-src_avatar').val(obj.data.realurl);
                    jQuery('#wrap-result-image-camera img').attr('src', obj.data.realurl);
                });

                $('.wrap-camera').hide();
            });
        }
<?php } ?>
    function closeCamera() {
        $('.wrap-camera').hide();
    }
    function openCamera() {
        $('.wrap-camera').show();
    }
    function triggerAvatar() {
        $('#job_avatar_form input[type="file"]').trigger('click')
    }
</script>
