<?php
$list_bank = \common\models\gcacoin\WithDraw::optionsBank();
$siteif = \common\models\gcacoin\Config::getConfig();

use common\models\ActiveFormC;

$text_opt = $user->getTextOtp();
$this->title = 'Chuyển VOUCHER';
$xu = $coin->getCoin();
?>
<style>
    .box-input {
        position: relative;
    }

    .box-input .btn-right {
        position: absolute;
        z-index: 1;
        right: 0px;
        display: block;
        top: 0px;
        height: 44px;
        padding: 10px;
        background: green;
        color: #fff;
        cursor: pointer;
    }

    body .form-create-store .help-block {
        color: red;
    }

    #box-info {
        text-align: center;
    }

    #box-info li {
        list-style: none;
    }
</style>
<div class="form-create-store">
    <div class="title-form">
        <h2><img src="<?= Yii::$app->homeUrl ?>images/ico-map-marker.png" alt=""> <?= $this->title ?></h2>
    </div>
    <div class="row" style="padding-left: 25px;
    padding-top: 20px;">
        <div class="col-md-12">
            <label style="float: left;width: 170px">Số dư khả dụng:</label>
            <p><?= formatCoin($xu) ?>
                (V)</p>
        </div>
    </div>
    <div class="row" style="padding-left: 25px;
    padding-top: 20px;">
        <div class="col-md-6">
            <label style="float: left;width: 170px">Số V tối đa có thể chuyển:</label>
            <p><?= formatCoin($tr_max = $siteif->getMaxFreeTransfer($xu)) ?> (V)</p>
        </div>
        <div class="col-md-6">
            <label style="float: left;width: 170px">Phí chuyển:</label>
            <p><?= $siteif->transfer_fee . ' ' . $siteif->getUnitTransfer() ?> </p>
        </div>
    </div>
    <div class="ctn-form">
        <?php $form = ActiveFormC::begin(['options' => ['id' => 'form-transfer']]); ?>
        <?= $form->fields($model, 'value')->textInput(['maxlength' => true, 'placeholder' => 'Nhập số '.__VOUCHER.' cần chuyển.']) ?>
        <div class="box-input">
            <input type="hidden" id="transfer-user_receive" name="Transfer[user_receive]" value="">
            <?= $form->fields($model, 'user_receive_search')->textInput(['maxlength' => true, 'placeholder' => 'Nhập ID hoặc tên tài khoản hoặc tên doanh nghiệp']) ?>
            <span class="btn-right checkinfo">Kiểm tra người nhận</span>
        </div>
        <div id="box-info">
        </div>
        <div class="btn-submit-form">
            <button class="btn btn-success">Xác nhận</button>
        </div>
        <?php ActiveFormC::end(); ?>
    </div>
</div>
<?= $this->render('view_history', ['history' => $history, 'title' => 'Lịch sử chuyển tiền']) ?>
<script>
    $('#form-transfer').submit(function() {
        _this = $(this);
        if ($('#form-transfer .has-error').first().attr('class') != undefined) {
            return false;
        }
        if (parseFloat($('#transfer-value').val()) > <?= $tr_max ?>) {
            $('.field-transfer-value').find('.help-block').text('Số V cần chuyển vượt quá số V cho phép.');
            return false;
        }
        if (_this.attr('csave') == '1') {
            checkOtp();
        } else {
            alert("Vui lòng kiểm tra tài khoản nhận.");
        }
        return false;
    });

    function checkOtp() {
        text0 = '<?= $text_opt[0] ?>';
        text1 = '<?= $text_opt[1] ?>';
        promptCS(text0, text1);
        $('#PromptCSInput').attr('type', 'password');
        yesPrompt = function(value, data) {
            if (value != null) {
                addLoading();
                $.ajax({
                    url: '<?= \yii\helpers\Url::to(['/management/gcacoin/save-transfer']) ?>',
                    type: 'POST',
                    data: {
                        xu: $('#transfer-value').val(),
                        user_receive: $('#transfer-user_receive').val(),
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
                            removeLoading();
                            promptCS(text0 + '<br><b style="color: red">' + data.errors + '</b>', text1);
                            $('#PromptCSInput').attr('type', 'password');
                        }
                    }

                });
            }
        }
    }

    // $('.checkinfo').click(function() {
    //     checkUser();
    // });
    $('#transfer-user_receive_search').change(function() {
        checkUser();
    });

    function checkUser() {
        loadAjax('<?= \yii\helpers\Url::to(['/management/gcacoin/info-user']) ?>', {
            user_id: $('#transfer-user_receive_search').val()
        }, $('#box-info'));
    }
</script>