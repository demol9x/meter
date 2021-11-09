<?php

use yii\helpers\Url;

$member = \common\components\payments\ClaPayment::PAYMENT_METHOD_MEMBERIN;
$this->title = "Nhận Voucher";
?>
<style></style>
<div class="shopping-cart-page">
    <section id="address-ship" class="address-ship">
        <form id="payment_method" method="post" enctype="multipart/form-data">
            <input id="form-token" type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->csrfToken ?>" />
            <div class="form-create-store">
                <div class="title-form">
                    <h2><img src="<?= Yii::$app->homeUrl ?>images/ico-map-marker.png" alt=""> <?= $this->title  ?></h2>
                </div>
                <div class="form-group field-userbank-name required" style="padding: 15px 25px;">
                    <div class="item-input-form">
                        <label class="" for="userbank-name">Số Voucher(1 V = 1000đ)</label>
                        <div class="group-input">
                            <div class="full-input">
                                <input type="text" id="money" placeholder="Nhập số Voucher bạn muốn nhận." class="form-control" name="money" maxlength="255" aria-required="true">
                                <div class="help-block"></div>
                                <p class="skip"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="title-form">
                    <h2><img src="/images/ico-map-marker.png" alt=""> Hình thức thanh toán </h2>
                </div>
                <?= \common\components\payments\gates\vnpay\widgets\Gcacoin\Gcacoin::widget(['data' => ['code' => $key]]); ?>
                <div align="center">
                    <a onclick="payment_method(this)" class="btn btn-success">Xác nhận</a>
                </div>
            </div>
        </form>
    </section>
</div>
<script>
    var load = 0;
    function payment_method(t) {
        if (load == 0) {
            load = 1;
            var type = $('input[name="Order[payment_method]"]:checked').val();
            var money = $('#money').val();
            money = money.replace(/\,/g, '');
            money = parseInt(money);
            if (money) {
                if (money % 10 == 0) {
                    if (type == 'MEMBERIN') {
                        $.ajax({
                            url: '<?= Url::to(['/management/gcacoin/payment-method']) ?>',
                            type: 'POST',
                            data: {
                                type: type,
                                money: money,
                                _csrf: '<?= Yii::$app->request->getCsrfToken() ?>'
                            },
                            success: function(dt) {
                                var data = JSON.parse(dt);
                                if (data.success) {
                                    checkOtp(data.token);
                                } else {
                                    alert(data.errors);
                                }
                            }
                        });
                    } else {
                        $('form').submit();
                    }
                } else {
                    alert('Số tiền phải là bội số của 10');
                }

            } else {
                alert('Số tiền không hợp lệ hoặc Bạn chưa điền đủ thông tin');
            }

        }
    }

    function checkOtp(token) {
        promptCS('Nhập mã OTP đã được gửi đến số điện thoại mà quý khách đã đăng ký tài khoản thành viên', 'Mã OTP');
        yesPrompt = function(value, data) {
            if (value != null) {
                $.ajax({
                    url: '<?= \yii\helpers\Url::to(['/management/gcacoin/checkout']) ?>',
                    type: 'POST',
                    data: {
                        token: token,
                        otp: value,
                    },
                    success: function(dt) {
                        var data = JSON.parse(dt);
                        if (data.success) {
                            alert(data.message);
                            setTimeout(function() {
                                window.location.reload();
                            }, 2000)
                        } else {
                            promptCS('Nhập mã OTP đã được gửi đến số điện thoại mà quý khách đã đăng ký tài khoản thành viên<br><b style="color: red">' + data.errors + '</b>', 'Mã OTP');
                        }
                    }

                });
            }
        };
    }
</script>