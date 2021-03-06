<?php

use yii\helpers\Url;

$this->title = $sale->getTextSale();
$percent = 1 + $sale->percent / 100;
?>
<style>
    .nsl {
        color: #17a349;
        font-size: 18px;
        font-weight: bold;
    }
</style>
<div class="shopping-cart-page">
    <section id="address-ship" class="address-ship">
        <form id="payment_method" method="post" enctype="multipart/form-data">
            <input id="form-token" type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->csrfToken ?>" />
            <div class="form-create-store">
                <div class="title-form">
                    <h2><img src="<?= Yii::$app->homeUrl ?>images/ico-map-marker.png" alt=""> <?= $this->title  ?></h2>
                </div>
                <div class="form-group field-userbank-name required" style="padding: 15px 25px;">
                    <p class="nsl"><?= $sale->getTextSale2(); ?></p>
                    <div class="item-input-form">
                        <label class="" for="userbank-name">Số Voucher(1 V = 1000đ = <?= $percent ?> Vs)</label>
                        <div class="group-input">
                            <div class="full-input">
                                <input autocomplete="off" type="text" id="money" placeholder="Nhập số Voucher bạn muốn nhận." class="form-control" name="money" maxlength="255" aria-required="true">
                                <div class="help-block"></div>
                                <p class="skip"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group field-userbank-name" style="padding: 0px 25px;">
                    <div class="item-input-form">
                        <label class="" for="userbank-name">Số tiền thanh toán: <span id="tt_sn" style="color: green;"></span> VNĐ</label>
                    </div>
                    <div class="item-input-form">
                        <label class="" for="userbank-name">Số V nhận được: <span style="color: green;"></span> 0</label>
                    </div>
                    <div class="item-input-form">
                        <label class="" for="userbank-name">Số Vs nhận được: <span id="vsr" style="color: green;"></span></label>
                    </div>
                </div>
                <div class="title-form">
                    <h2> Hình thức thanh toán </h2>
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
                        if ($('#imgf-avatar_1').val() && $('#imgf-avatar_2').val()) {
                            $('#payment_method').submit();
                        } else {
                            alert('Bạn chưa điền đủ ảnh.');
                            load = 0;
                        }
                    }
                } else {
                    alert('Số tiền phải là bội số của 10');
                    load = 0;
                }

            } else {
                alert('Số tiền không hợp lệ hoặc Bạn chưa điền đủ thông tin');
                load = 0;
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
    $(document).on('keyup', '#money', function() {
        var money = $('#money').val();
        money = money.replace(/\,/g, '');
        money = parseInt(money);
        $('#tt_sn').html(formatMoney(money * 1000, 0, ',', '.'));
        $('#vsr').html(formatMoney(money * <?= $percent ?>, 0, ',', '.'));
    });
</script>