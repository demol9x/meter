<?php

use yii\helpers\Url;


$this->title = Yii::t('app', 'user_info');
?>
<style>
    .table-shop {
        overflow-x: unset;
    }

    .form-fixed .row {
        padding: 15px 0px;
        border-bottom: 1px solid #ebebeb;
    }

    .form-fixed select {
        height: 34px;
        width: 100%;
    }

    .btn {
        background: #dbbf6d;
        padding: 7px 20px;
        border: 0px;
        border-radius: 2px;
        display: inline-block;
        color: #fff;
    }

    .delete-selfish {
        background: red;
    }

    .form-fixed .note {
        color: red;
        font-size: 12px;
    }
</style>
<div class="form-create-store">
    <div class="title-form">
        <h2>
            <img src="<?= Yii::$app->homeUrl ?>images/ico-hoso.png" alt=""> <?= Yii::t('app', 'my_file') ?>
        </h2>
        <?php if (!$user->email) { ?>
            <p class="center" style="color: red; padding: 0px 15px">
                Nhắc nhở: quý khách chưa có email. Hãy bổ xung email để nhận được những thông báo quan trọng và bảo vệ tài khoản của quý khách tốt hơn. Email sẽ không thể thay đổi khi đã lưu vì vậy vui lòng nhập chính xác email của bạn.
            </p>
        <?php } ?>
    </div>
    <div class="table-buyer table-shop">
        <table>
            <tbody>
                <tr>
                    <td>
                        <label for=""><?= Yii::t('app', 'name') ?></label>
                    </td>
                    <td>
                        <p><?= $user->username ?></p>
                        <div class="form-fixed" id="username">
                            <input type="text" class="input_text" name="username" placeholder="<?= Yii::t('app', 'enter_new_name') ?>">
                        </div>
                    </td>
                    <td width="170" class="txt-right">
                        <a href="javascript:void(0);" class="open-fixed" data="#username"><i class="fa fa-pencil"></i><?= Yii::t('app', 'change') ?></a>
                        <div class="form-fixed">
                            <a class="save-user"><i class="fa fa-check"></i><?= Yii::t('app', 'save') ?></a>
                            <a class="cance" href="javascript:void(0);"><i class="fa fa-times"></i><?= Yii::t('app', 'cancer') ?></a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="vertical-top">
                        <label for=""><?= Yii::t('app', 'email') ?></label>
                    </td>
                    <td>
                        <p><?= $user->email ?></p>
                        <div class="form-fixed" id="useremail">
                            <input type="text" class="input_text" name="email" placeholder="<?= Yii::t('app', 'enter_new_email') ?>">
                        </div>
                    </td>
                    <td width="170" class="txt-right">
                        <a class="open-fixed" data="#useremail"><i class="fa fa-pencil"></i><?= Yii::t('app', 'change') ?></a>
                        <div class="form-fixed">
                            <a class="save-user-otp"><i class="fa fa-check"></i><?= Yii::t('app', 'save') ?></a>
                            <a class="cance" href="javascript:void(0);"><i class="fa fa-times"></i><?= Yii::t('app', 'cancer') ?></a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="vertical-top">
                        <label for=""><?= Yii::t('app', 'phone') ?></label>
                    </td>
                    <td>
                        <p><?= $user->phone ?></p>
                        <div class="form-fixed" id="userphone">
                            <input type="text" name="phone" class="input_text" placeholder="<?= Yii::t('app', 'enter_new_phone') ?>">
                        </div>
                    </td>
                    <td width="170" class="txt-right">
                        <a class="open-fixed" data="#userphone"><i class="fa fa-pencil"></i><?= Yii::t('app', 'change') ?></a>
                        <div class="form-fixed">
                            <a class="save-user-otp"><i class="fa fa-check"></i><?= Yii::t('app', 'save') ?></a>
                            <a class="cance" href="javascript:void(0);"><i class="fa fa-times"></i><?= Yii::t('app', 'cancer') ?></a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="vertical-top">
                        <label for=""><?= Yii::t('app', 'sex') ?></label>
                    </td>
                    <td>
                        <p><?= $user->sex  ? Yii::t('app', 'man') : ($user->sex === 0 ? Yii::t('app', 'woman') : '') ?></p>
                        <div class="form-fixed" id="usersex">
                            <input type="hidden" class="input_text" name="sex">
                            <div class="awe-check">
                                <div class="group-check-box active">
                                    <div class="radio">
                                        <input type="radio" class="radio-change" name="radiobox" value="1">
                                        <label><span class="text-clip" title="radio"><?= Yii::t('app', 'man') ?></span></label>
                                    </div>
                                    <div class="radio">
                                        <input type="radio" class="radio-change" name="radiobox" value="0">
                                        <label><span class="text-clip" title="radio"><?= Yii::t('app', 'woman') ?></span></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td width="170" class="txt-right">
                        <a class="open-fixed" data="#usersex"><i class="fa fa-pencil"></i><?= Yii::t('app', 'change') ?></a>
                        <div class="form-fixed">
                            <a class="save-user"><i class="fa fa-check"></i><?= Yii::t('app', 'save') ?></a>
                            <a class="cance" href="javascript:void(0);"><i class="fa fa-times"></i><?= Yii::t('app', 'cancer') ?></a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="vertical-top">
                        <label for=""><?= Yii::t('app', 'birthday') ?></label>
                    </td>
                    <td>
                        <p><?= $user->birthday ? date('d/m/Y', $user->birthday) : '' ?></p>
                        <div class="form-fixed" id="userbirthday">
                            <input type="hidden" class="input_text" name="birthday">
                            <div class="row">
                                <div class="col-xs-4">
                                    <input type="number" id="birthday-day" min='0' max='31' placeholder="<?= Yii::t('app', 'day') ?>">
                                </div>
                                <div class="col-xs-4">
                                    <input type="number" id="birthday-month" min='0' max='12' placeholder="<?= Yii::t('app', 'month') ?>">
                                </div>
                                <div class="col-xs-4">
                                    <input type="number" id="birthday-year" min='1890' max='2019' placeholder="<?= Yii::t('app', 'year') ?>">
                                </div>
                            </div>
                        </div>
                    </td>
                    <td width="170" class="txt-right">
                        <a class="open-fixed" data="#userbirthday"><i class="fa fa-pencil"></i><?= Yii::t('app', 'change') ?></a>
                        <div class="form-fixed">
                            <a class="save-user-b"><i class="fa fa-check"></i><?= Yii::t('app', 'save') ?></a>
                            <a class="cance" href="javascript:void(0);"><i class="fa fa-times"></i><?= Yii::t('app', 'cancer') ?></a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="vertical-top">
                        <label for=""><?= Yii::t('app', 'address') ?></label>
                    </td>
                    <td>
                        <p><?= $address ? ($address['address'] ? $address['address'] . ', ' : '') . $address['ward_name'] . ', ' . $address['district_name'] . ', ' . $address['province_name'] : '' ?></p>
                    </td>
                    <td width="170" class="txt-right">
                        <a href="<?= Url::to(['/management/user-address/index']) ?>"><i class="fa fa-pencil"></i><?= Yii::t('app', 'change') ?></a>
                    </td>
                </tr>
                <tr>
                    <td class="vertical-top">
                        <label for="">Bạn là:</label>
                    </td>
                    <td>
                        <p><?= $user->getGruopLabels() ?></p>
                        <div class="form-fixed" id="bform-submit-group">
                            <script>
                                $(document).ready(function() {
                                    loadAjaxPost("<?= \yii\helpers\Url::to(['/management/profile/update-group']) ?>", {}, $("#bform-submit-group"));
                                });
                            </script>
                        </div>
                    </td>
                    <td width="170" class="txt-right">
                        <a class="open-fixed" data="#userbirthday"><i class="fa fa-pencil"></i><?= Yii::t('app', 'change') ?></a>
                        <div class="form-fixed">
                            <a class="cance" href="javascript:void(0);"><i class="fa fa-times"></i><?= Yii::t('app', 'cancer') ?></a>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

    </div>
</div>
<div id="sucecss-otp" style="display: none;"></div>
<script type="text/javascript">
    $(document).ready(function() {
        $('.open-fixed').click(function() {
            $('tr').removeClass('open');
            var id = $(this).attr('data');
            $('.input_text').attr('id', '');
            $(id).children('.input_text').attr('id', 'input-send');
        });
        $('.save-user').click(function() {
            if ($('#input-send').val() == '') {
                $('#input-send').parent().find('.error').remove();
                $('#input-send').parent().append('<p class="error" style="color:red">Vui lòng nhập giá trị thay đổi.</p>');
                return false;
            }
            confirmCS('<?= Yii::t('app', 'Bạn có chắc muốn thay đổi?') ?>', {});
            yesConFirm = function(option) {
                var attr = $('#input-send').attr('name');
                var value = $('#input-send').val();
                var label = $('#input-send').parent().parent().children('p');
                label.html('<img style="padding:5px 10px;" src="images/ajax-loader.gif" />');
                $.getJSON(
                    "<?= \yii\helpers\Url::to(['/management/profile/update-ajax']) ?>", {
                        attr: attr,
                        value: value
                    }
                ).done(function(data) {
                    var label = $('#input-send').parent().parent().children('p');
                    if (data == '1') {
                        switch (attr) {
                            case 'birthday':
                                label.html($('#birthday-day').val() + '/' + $('#birthday-month').val() + '/' + $('#birthday-year').val());
                                break;
                            case 'sex':
                                if (value == '1') {
                                    label.html('<?= Yii::t('app', 'man') ?>');
                                } else {
                                    label.html('<?= Yii::t('app', 'woman') ?>');
                                }
                                break;
                            default:
                                label.html(value);
                        }
                    } else {
                        alert('<?= Yii::t('app', 'please_enter_real') ?>')
                    }
                }).fail(function(jqxhr, textStatus, error) {
                    alert('tt');
                });
            }
        });
        $('.save-user-otp').click(function() {
            if ($('#input-send').val() == '') {
                $('#input-send').parent().find('.error').remove();
                $('#input-send').parent().append('<p class="error" style="color:red">Vui lòng nhập giá trị thay đổi.</p>');
                return false;
            }
            confirmCS('<?= Yii::t('app', 'Bạn có chắc muốn thay đổi?') ?>', {});
            yesConFirm = function(option) {
                var attr = $('#input-send').attr('name');
                var value = $('#input-send').val();
                loadAjax("<?= \yii\helpers\Url::to(['/management/profile/get-otp']) ?>", {
                    attr: attr,
                    value: value
                }, $('#sucecss-otp'));
            }
        });
        $('.save-user-b').click(function() {
            var tg = $('#birthday-month').val() + '/' + $('#birthday-day').val() + '/' + $('#birthday-year').val();
            var tg = $('#input-send').val(tg);
            $('.save-user').first().click();
        });
        $('.radio-change').click(function() {
            $('#input-send').val($(this).val());
        });
    });

    function sendOtpAgain() {
        removeCustomAlert();
        var attr = $('#input-send').attr('name');
        var value = $('#input-send').val();
        loadAjax("<?= \yii\helpers\Url::to(['/management/profile/get-otp']) ?>", {
            attr: attr,
            value: value
        }, $('#sucecss-otp'));
    }
</script>

<!-- <div class="modalContainer otp">
    <div class="alertBox">
        <div class="indboxts">
            <h2>Thông báo từ Gcaeco.vn</h2>
            <p>Vui lòng nhập mã OTP đã được gửi đến số điện thoại cũ của quý khách. Nếu quý khác bị mất số điện thoại vui lòng liên hệ <a href="tel:02466623632">024.6662.3632</a> để được hướng dẫn thay đổi.</p>
            <p>
                <input type="" placeholder="Nhập mã OTP" name="">
            </p>
            <a id="otpYes" class="yes">Đồng ý</a><a id="otpNo" class="no">Hủy bỏ</a>
        </div>
    </div>
</div> -->