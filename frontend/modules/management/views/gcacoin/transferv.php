<?php
$list_bank = \common\models\gcacoin\WithDraw::optionsBank();
$siteif = \common\models\gcacoin\Config::getConfig();

use common\models\ActiveFormC;

$text_opt = $user->getTextOtp();
$this->title = 'Chuyển Vr thành V';
$xu = $coin->getCoinRed();
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
            <p><?= formatCoin($xu) ?> (Vr)</p>
            <p>Tỉ lệ chuyển: 1Vr = 1V</p>
        </div>
    </div>
    <div class="ctn-form">
        <?php $form = ActiveFormC::begin(['options' => ['id' => 'form-transfer']]); ?>
        <?= $form->fields($model, 'value')->textInput(['maxlength' => true, 'placeholder' => 'Nhập số V cần chuyển.']) ?>
        <div class="btn-submit-form">
            <button class="btn btn-success">Xác nhận</button>
        </div>
        <?php ActiveFormC::end(); ?>
    </div>
</div>

<?= $this->render('view_history', ['history' => $history, 'title' => 'Lịch sử chuyển đổi Vr']) ?>
<script>
    $('#form-transfer').submit(function() {
        _this = $(this);
        if ($('#form-transfer .has-error').first().attr('class') != undefined) {
            return false;
        }
        if (parseFloat($('#transfer-value').val()) > <?= $xu  ?>) {
            $('.field-transfer-value').find('.help-block').text('Số V cần chuyển vượt quá số V cho phép.');
            return false;
        }
        checkOtp();
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
                    url: '<?= \yii\helpers\Url::to(['/management/gcacoin/save-transferv']) ?>',
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
</script>