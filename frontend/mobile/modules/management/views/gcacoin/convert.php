<?php
$list_bank = \common\models\gcacoin\WithDraw::optionsBank();

use common\models\ActiveFormC;

$text_opt = $user->getTextOtp();
$this->title = 'Rút VOUCHER RED';
?>
<div class="form-create-store">
    <div class="title-form">
        <h2><img src="<?= Yii::$app->homeUrl ?>images/ico-map-marker.png" alt=""> <?= $this->title  ?> </h2>
    </div>
    <div class="row" style="padding-left: 25px;
    padding-top: 20px;">
        <div class="col-md-12">
            <label style="float: left;width: 170px">Số dư khả dụng:</label>
            <p><?= (isset($coin) && $coin) ? number_format(((float)\common\components\ClaGenerate::decrypt($coin->gca_coin_red) - $coin_waning), 0, ',', '.') : 0 ?>
                (Vr)</p>
        </div>
    </div>
    <div class="ctn-form">
        <?php $form = ActiveFormC::begin(); ?>
        <?= $form->fields($model, 'value')->textInput(['maxlength' => true, 'placeholder' => 'Nhập số Vr cần rút (số Vr phải là bội số của 100. Ví dụ: 100,200 ...)']) ?>
        <?= $form->fields($model, 'bank_id', ['arrSelect' => $list_bank])->textSelect(['class' => 'select-province-id']) ?>
        <div class="btn-submit-form">
            <a onclick="convert_xu(this)" class="btn btn-success">Xác nhận</a>
            <a id="payment_method_close" class="btn btn-warning">Hủy</a>
        </div>
        <?php ActiveFormC::end(); ?>
    </div>
</div>
<div class="form-create-store">
    <div class="title-form">
        <h2><img src="/images/ico-map-marker.png" alt=""> Lịch sử rút tiền </h2>
    </div>
    <div class="row box-chitiet-taikhoan" style="padding: 15px 25px;">
        <table class="tbllisting" style="margin-top:15px">
            <tbody>
                <tr class="tblsheader">
                    <th scope="col" class="colCenter">Ngày</th>
                    <th scope="col" class="colCenter">Số V</th>
                    <th scope="col" class="colCenter">Trạng thái</th>
                </tr>
                <?php if (isset($history) && $history) : ?>
                    <?php foreach ($history as $item) : ?>
                        <?php if ($item->status == 1) : ?>
                            <tr>
                                <td class="colCenter"><?= date('d-m-Y H:i:s', $item->updated_at) ?></td>
                                <td class="colRight"><span style="padding-right: 25px"><?= formatMoney($item->value) ?>Vr</span></td>
                                <td style="color: green">
                                    Đã thanh toán
                                </td>
                            </tr>
                        <?php else : ?>
                            <tr>
                                <td class="colCenter"><?= date('d-m-Y H:i:s', $item->updated_at) ?></td>
                                <td class="colRight"><span style="padding-right: 25px"><?= formatMoney($item->value) ?>Vr</span></td>
                                <td style="color: #f0ad4e">
                                    Đang chờ thanh toán
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<style>
    .tbllisting {
        border-collapse: collapse;
        font-family: Arial, Tahoma;
        background: #fff;
        font-weight: bold;
        width: 100%;
    }

    .box-chitiet-taikhoan .tbllisting tr td:first-child,
    .box-chitiet-taikhoan .tbllisting tr th:first-child {
        border-radius: 4px 0 0 4px;
    }

    .box-chitiet-taikhoan .tbllisting th {
        background: #dbbf6d;
        font-weight: bold;
        color: #fff;
    }

    .box-chitiet-taikhoan .tbllisting td,
    .box-chitiet-taikhoan .tbllisting th {
        padding: 10px 15px;
        text-align: center;
        border: 1px solid #eee;
    }

    .colCenter {
        text-align: center !important;
        font-size: 12px;
        padding: 10px;
    }

    .box-chitiet-taikhoan .tbllisting td {
        background: #fff;
        color: #222;
    }

    .box-chitiet-taikhoan .tbllisting td,
    .box-chitiet-taikhoan .tbllisting th {
        padding: 10px 15px;
        text-align: center;
        border: 1px solid #eee;
    }
</style>
<script>
    $('input').keyup(function() {
        var number = $('#money').val();
        number = number.replace(/\,/g, '');
        var a = format_number(number);
        $('#money').val(a);
    });

    function format_number(nStr) {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }

    $(document).ready(function() {
        $('#payment_method_open').click(function() {
            $('#payment_method').css('display', 'block');
        });
        $('#payment_method_close').click(function() {
            $('#payment_method').css('display', 'none');
        })
    });

    function convert_xu(t) {
        var id_bank = $('#bank_id').val();
        var xu = $('#withdraw-value').val();
        $.ajax({
            url: '<?= \yii\helpers\Url::to(['/management/gcacoin/convert']) ?>',
            type: 'POST',
            data: {
                bank_id: id_bank,
                value: xu,
            },
            success: function(dt) {
                var data = JSON.parse(dt);
                if (data.success) {
                    checkOtp(data.data.xu, data.data.bank_id);
                } else {
                    if (data.errors.value) {
                        $('.field-withdraw-value').find('.help-block').text(data.errors.value);
                    }
                    if (data.errors.otp) {
                        alert(data.errors.otp);
                    }
                    if (data.errors.bank_id) {
                        $('.field-bank_id').find('.help-block').text(data.errors.bank_id);
                    }
                    if (data.errors.tk) {
                        alert(data.errors.tk);
                    }
                }
            }
        });
    }

    function checkOtp(xu, bank) {
        text0 = '<?= $text_opt[0] ?>';
        text1 = '<?= $text_opt[1] ?>';
        promptCS(text0, text1);
        $('#PromptCSInput').attr('type', 'password');
        yesPrompt = function(value, data) {
            if (value != null) {
                $.ajax({
                    url: '<?= \yii\helpers\Url::to(['/management/gcacoin/checkotp-convert']) ?>',
                    type: 'POST',
                    data: {
                        xu: xu,
                        bank_id: bank,
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
                            promptCS(text0 + '<br><b style="color: red">' + data.errors + '</b>', text1);
                            $('#PromptCSInput').attr('type', 'password');
                        }
                    }

                });
            }
        }
    }
</script>