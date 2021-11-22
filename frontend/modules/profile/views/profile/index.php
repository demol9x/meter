<?php

use  common\components\ClaHost;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>

<div class="item_right">
    <!--    <style>-->
    <!--        .table-shop {-->
    <!--            overflow-x: unset;-->
    <!--        }-->
    <!---->
    <!--        .form-fixed .row {-->
    <!--            padding: 15px 0px;-->
    <!--            border-bottom: 1px solid #ebebeb;-->
    <!--        }-->
    <!---->
    <!--        .form-fixed select {-->
    <!--            height: 34px;-->
    <!--            width: 100%;-->
    <!--        }-->
    <!---->
    <!--        .btn {-->
    <!--            background: #dbbf6d;-->
    <!--            padding: 7px 20px;-->
    <!--            border: 0px;-->
    <!--            border-radius: 2px;-->
    <!--            display: inline-block;-->
    <!--            color: #fff;-->
    <!--        }-->
    <!---->
    <!--        .delete-selfish {-->
    <!--            background: red;-->
    <!--        }-->
    <!---->
    <!--        .form-fixed .note {-->
    <!--            color: red;-->
    <!--            font-size: 12px;-->
    <!--        }-->
    <!--    </style>-->
    <div class="form-create-store">
        <div class="title-form">
            <h2 class="content_15"><img src="<?= yii::$app->homeUrl ?>images/ico-hoso.png" alt=""> Hồ sơ của tôi</h2>
        </div>
        <?php
        $form = ActiveForm::begin([
            'id'=>'',
            'class'=>'',

        ])
        ?>
            <div class="table-buyer table-shop">
                <table>
                    <tbody>
                    <tr>
                        <td>
                            <label for="">Tên</label>
                        </td>
                        <td>
                            <p><?= $user['username'] ?></p>
                            <?=
                            $form->field($user, 'phone', [
                                'template' => '<div class="form-fixed" id="username">{{input}{error} </div>'
                            ])->passwordInput([
                                'class' => 'form-control content_13',
                                'placeholder' => 'nhập tên mới',
                            ])->label('Nhập mật khẩu cũ',['class'=>'content_14']);
                            ?>
                            <div class="form-fixed" id="username">
                                <input type="text" class="input_text" name="username" placeholder="Nhập tên mới">
                            </div>
                        </td>
                        <td width="170" class="txt-right">
                            <a href="javascript:void(0);" class="open-fixed" data="#username"><i
                                        class="fa fa-pencil"></i>Thay đổi</a>
                            <div class="form-fixed">
                                <a class="save-user" ><i class="fa fa-check"></i>Lưu</a>
                                <a class="cance" href="javascript:void(0);"><i class="fa fa-times"></i>Hủy</a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="vertical-top">
                            <label for="">Email</label>
                        </td>
                        <td>
                            <p><?= $user['email'] ?></p>
                            <div class="form-fixed" id="useremail">
                                <input type="text" class="input_text" name="email" placeholder="Nhập email mới">
                            </div>
                        </td>
                        <td width="170" class="txt-right">
                            <a class="open-fixed" data="#useremail"><i class="fa fa-pencil"></i>Thay đổi</a>
                            <div class="form-fixed">
                                <a class="save-user-otp"><i class="fa fa-check"></i>Lưu</a>
                                <a class="cance" href="javascript:void(0);"><i class="fa fa-times"></i>Hủy</a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="vertical-top">
                            <label for="">Điện thoại</label>
                        </td>
                        <td>
                            <p><?= $user['phone'] ?></p>
                            <div class="form-fixed" id="userphone">
                                <input type="text" name="phone" class="input_text" placeholder="NHập số điện thoại mới">
                            </div>
                        </td>
                        <td width="170" class="txt-right">
                            <a class="open-fixed" data="#userphone"><i class="fa fa-pencil"></i>Thay đổi</a>
                            <div class="form-fixed">
                                <a class="save-user-otp"><i class="fa fa-check"></i>Lưu</a>
                                <a class="cance" href="javascript:void(0);"><i class="fa fa-times"></i>Hủy</a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="vertical-top">
                            <label for="">Giới tính</label>
                        </td>
                        <td>
                            <p><?= $user->sex ?></p>
                            <div class="form-fixed" id="usersex">
                                <input type="hidden" class="input_text" name="sex">
                                <div class="awe-check">
                                    <div class="group-check-box active">
                                        <label class="radio">
                                            <input type="radio" class="radio-change" name="radiobox" value="1">
                                            <div class="label"><span class="text-clip" title="radio">Nam</span></div>
                                        </label>
                                        <label class="radio">
                                            <input type="radio" class="radio-change" name="radiobox" value="0">
                                            <div class="label"><span class="text-clip" title="radio">Nữ</span></div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td width="170" class="txt-right">
                            <a class="open-fixed" data="#usersex"><i class="fa fa-pencil"></i>Thay đổi</a>
                            <div class="form-fixed">
                                <a class="save-user"><i class="fa fa-check"></i>Lưu</a>
                                <a class="cance" href="javascript:void(0);"><i class="fa fa-times"></i>Hủy</a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="vertical-top">
                            <label for="">Ngày sinh</label>
                        </td>
                        <td>
                            <p><?= date('d/m/Y', $user->birthday) ?></p>
                            <div class="form-fixed" id="userbirthday">
                                <input type="hidden" class="input_text" name="birthday">
                                <div class="row userbirthday">
                                    <div class="col-xs-4">
                                        <input type="number" id="birthday-day" min="0" max="31" placeholder="Ngày">
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="number" id="birthday-month" min="0" max="12" placeholder="Tháng">
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="number" id="birthday-year" min="1890" max="2019" placeholder="năm">
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td width="170" class="txt-right">
                            <a class="open-fixed" data="#userbirthday"><i class="fa fa-pencil"></i>Thay đổi</a>
                            <div class="form-fixed">
                                <a class="save-user-b"><i class="fa fa-check"></i>Lưu</a>
                                <a class="cance" href="javascript:void(0);"><i class="fa fa-times"></i>Hủy</a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="vertical-top">
                            <label for="">Địa chỉ</label>
                        </td>
                        <td>
                            <p><?= $user->address ?></p>
                        </td>
                        <td width="170" class="txt-right">
                            <a href="<?= Url::to(['/profile/profile/box-address']) ?>">
                                <i class="fa fa-pencil"></i>Thay đổi</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('').click(function() {
            var email = $('#data-mail1').val();
            var url = '<?= \yii\helpers\Url::to(['/forms/newletter/create']) ?>';
            if (email) {
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        email: email
                    },
                    success: function(responce) {
                        alert(responce);
                    },
                });
            } else {
                alert('Vui lòng nhập email');
            }
            return false;
        });
    });
</script>