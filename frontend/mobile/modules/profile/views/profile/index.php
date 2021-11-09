<?php

use yii\helpers\Url;
?>
<style type="text/css">
    .required label:after{
        content: '*';
        color: red;
        margin-left: 5px;
    }
    .edit-info-education{
        display: none;
    }
</style>
<div class="site-account-info">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">
                <div class="box-info-user">

                    <?=
                    $this->render('partial/box_basic_info', [
                        'user' => $user,
                        'user_info' => $user_info
                    ])
                    ?>

                    <?=
                    $this->render('partial/box_basic_description', [
                        'user' => $user,
                        'user_info' => $user_info
                    ])
                    ?>

                    <?=
                    $this->render('partial/box_skill', [
                        'user' => $user,
                        'user_info' => $user_info
                    ])
                    ?>

                    <?=
                    $this->render('partial/box_education', [
                        'user' => $user,
                        'user_education' => $user_education,
                        'educations' => $educations
                    ])
                    ?>

                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                <div class="box-tool-user">
                    <div class="tool-1">
                        <h2>Hồ sơ của bạn</h2>
                        <div class="ctn-tool-top">
                            <ul>
                                <li><a href="">+ Thông Tin Chung</a></li>
                                <li><a href="">+ Kỹ năng</a></li>
                                <li><a href="">+ Kinh nghiệm làm việc</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="tool-1">
                        <h2>Cài đặt</h2>
                        <div class="ctn-tool">
                            <p>Hồ sơ đính kèm</p>
                            <div id="wrap-file-info">
                                <?php if (isset($file) && $file) { ?>
                                    <table class="table table-bordered" style="margin: 15px 0 5px 0; color: #888888">
                                        <tr><td><?= $file->display_name ?></td></tr>
                                        <tr><td>Cập nhật: <?= date('d-m-Y', $file->updated_at) ?></td></tr>
                                        <tr>
                                            <td style="text-align: center">
                                                <a style="background: none; text-decoration: underline" href="<?= Url::to(['/profile/profile/download-file-cv', 'id' => $file->id]) ?>">Download</a>
                                            </td>
                                        </tr>
                                    </table>
                                <?php } ?>
                            </div>
                            <div class="box-upload-hs">
                                <a href="javascript:void(0)" onclick="uploadcv()">Tải hồ sơ</a>
                                <i>Định dạng file chỉ có thể là .doc, .docx và pdf, files phải nhỏ hơn 2MB.</i>
                                <input style="display: none" id="user_job_files" type="file" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    function uploadcv() {
        $('#user_job_files').trigger('click');
        jQuery('#user_job_files').change(function (event) {
            var formData = new FormData();
            formData.append('file', event.target.files[0]);
            $.ajax({
                url: '<?= Url::to(['/profile/profile/upload-cv']) ?>',
                type: 'POST',
                data: formData,
                processData: false, // tell jQuery not to process the data
                contentType: false, // tell jQuery not to set contentType
                success: function (result) {
                    jQuery('#wrap-file-info').html(result.html);
                }
            });
        });
    }

</script>