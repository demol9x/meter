<?php

use yii\helpers\Url;
use common\models\ActiveFormC;

$this->beginContent('@frontend/views/layouts/main.php');
?>
<?= $content ?>
<style>
    .regiter-bs {
        height: 100%;
        background: green;
        color: #fff;
        padding: 4px 6px;
        border-radius: 3px;
        cursor: pointer;
    }

    .ctn-review-popup {
        min-height: unset;
    }

    .ctn-review-popup textarea {
        margin: 0px 0px 20px 0px;
        height: 100px;
    }

    .box-fixed {
        position: fixed;
        z-index: 999999999;
        top: 0px;
        left: 0px;
        background: #0003;
        width: 100%;
        height: 100vh;
    }

    .box-fixed .flex {
        width: 100%;
        height: 100%;
        display: flex;
    }

    .box-fixed .child-flex {
        margin: auto;
    }

    .is-errors,
    .is-errors * {
        list-style: none;
        color: red;
    }

    .ctn-review-popup .note {
        display: none;
    }

    .ctn-review-popup .note.active {
        display: block;
    }

    .save-ajax .nice-select {
        width: 100%;
        margin-bottom: 15px;
    }

    .save-ajax .nice-select ul {
        width: 100%;
    }

    .disable {
        display: none !important;
    }
</style>
<?php
$account_status = \common\models\shop\Shop::checkAccountStatus(Yii::$app->user->id);
if ($account_status) { ?>
    <div id="form-sell" class="white-popup mfp-hide">
        <?php $model_sell = new \common\models\form\FormRegisterSell(); ?>
        <div class="box-account">
            <span class="mfp-close"></span>
            <div class="bg-pop-white">
                <div class="title-popup">
                    <h2>Đăng ký bán cho tin: <b id="name-news-sell"></b></h2>
                </div>
                <div class="ctn-review-popup">
                    <p class="is-errors note" id="note-sell">Lưu ý: Khi bạn đăng ký lại. Nội dung đăng ký trước đó sẽ bị xóa.</p>
                    <?php $form = ActiveFormC::begin([
                        'action' => Url::to(['/form/save-sell']),
                        'options' => [
                            'class' => 'save-ajax',
                            'id' => 'save-sell',
                        ]
                    ]); ?>
                    <?= $form->field($model_sell, 'news_id')->textInput(['type' => 'hidden'])->label(false) ?>
                    <?= $form->fields($model_sell, 'price')->textInput(['maxlength' => true, 'class' => 'form-control change-price-s', 'placeholder' => 'VD: 1.000']) ?>
                    <?= $form->fields($model_sell, 'quantity')->textInput(['maxlength' => true, 'placeholder' => 'VD: 1 tấn']) ?>
                    <?= $form->fields($model_sell, 'note')->textArea(['maxlength' => true, 'placeholder' => 'Mô tả thêm về sản phẩm']) ?>
                    <div class="is-errors" id="error-sell">

                    </div>
                    <button id="btn-rgs-sell">Đăng ký</button>
                    <?php ActiveFormC::end(); ?>
                </div>
            </div>
        </div>
    </div>
    <div id="form-buy" class="white-popup mfp-hide">
        <?php $model_buy = new \common\models\form\FormRegisterBuy(); ?>
        <div class="box-account">
            <span class="mfp-close"></span>
            <div class="bg-pop-white">
                <div class="title-popup">
                    <h2>Đăng ký mua cho tin: <b id="name-news-buy"></b></h2>
                </div>
                <div class="ctn-review-popup">
                    <p class="is-errors note" id="note-buy">Lưu ý: Khi bạn đăng ký lại. Nội dung đăng ký trước đó sẽ bị xóa.</p>
                    <?php $form = ActiveFormC::begin([
                        'action' => Url::to(['/form/save-buy']),
                        'options' => [
                            'class' => 'save-ajax',
                            'id' => 'save-buy',
                        ]
                    ]); ?>
                    <?= $form->field($model_buy, 'news_id')->textInput(['type' => 'hidden'])->label(false) ?>
                    <style>
                        .field-formregisterbuy-price label {
                            display: none;
                        }
                    </style>
                    <?= $form->fields($model_buy, 'type_price', ['arrSelect' => [0 => 'Giá đặt mua', 1 => "Thỏa thuận"]])->textSelect() ?>
                    <?= $form->fields($model_buy, 'price')->textInput(['maxlength' => true, 'class' => 'form-control change-price-s', 'placeholder' => 'VD: 1.000']) ?>
                    <?= $form->fields($model_buy, 'quantity')->textInput(['maxlength' => true, 'placeholder' => 'VD: 1 tấn']) ?>
                    <div class="is-errors" id="error-buy">
                    </div>
                    <button id="btn-rgs-buy">Đăng ký</button>
                    <?php ActiveFormC::end(); ?>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).on('change', '#type_price', function() {
            if ($(this).val() == '1') {
                $('.field-formregisterbuy-price').addClass('disable');
                $('#formregisterbuy-price').val(-1);
            } else {
                $('.field-formregisterbuy-price').removeClass('disable');
                $('#formregisterbuy-price').val('');
            }
        });
        $(document).on('click', '.register_sell', function() {
            $('#formregistersell-news_id').val($(this).attr('data-user_id'));
            if ($(this).attr('data-note') == '1') {
                $('#note-sell').addClass('active');
                $('#btn-rgs-sell').html('Đăng ký lại');
            } else {
                $('#note-sell').removeClass('active');
                $('#btn-rgs-sell').html('Đăng ký');
            }
            $('#name-news-sell').html($(this).parent().parent().find('h3').first().html());
        });
        $(document).on('click', '.register_buy', function() {
            $('#formregisterbuy-news_id').val($(this).attr('data-user_id'));
            if ($(this).attr('data-note') == '1') {
                $('#note-buy').addClass('active');
                $('#btn-rgs-buy').html('Đăng ký lại');
            } else {
                $('#note-buy').removeClass('active');
                $('#btn-rgs-buy').html('Đăng ký');
            }
            $('#name-news-buy').html($(this).parent().parent().find('h3').first().html());
        });
        $(document).on('submit', '.save-ajax', function() {
            $('body').append('<div id="fixed-loading-img" class="box-fixed"><div class="flex"><div class="child-flex"><img class="ajax-loader-img" src="' + baseUrl + 'images/ajax-loader.gif" /></div></div></div>');
            _this = $(this);
            $.ajax({
                url: _this.attr('action'),
                data: _this.serialize(),
                type: 'POST',
                success: function(result) {
                    $('#fixed-loading-img').remove();
                    if (result == 'success') {
                        location.href = '';
                        return false;
                    } else {
                        $('#error-sell').html(result);
                    }
                }
            });
            return false;
        });
        $(document).on("keydown", ".change-price-s", function() {
            $(this).addClass("change-price-sactive");
            setTimeout(function() {
                var tg = $(".change-price-sactive");
                tg.val(tg.val().replace(/\./g, ""));
                tg.val(formatMoney(tg.val(), 0, ',', '.'));
                tg.removeClass('change-price-sactive');
            }, 150);
        });
    </script>
<?php } else { ?>
    <div id="form-note" class="white-popup mfp-hide">
        <div class="box-account">
            <span class="mfp-close"></span>
            <div class="bg-pop-white">
                <div class="title-popup">
                    <h2>Tài khoản của quý khách chưa đủ điều kiện để thực hiện chức năng này</h2>
                </div>
                <div class="ctn-review-popup">
                    <p class="is-errors">Để có thể tham gia đăng ký mua - bán. Quý khách cần đăng ký làm chủ gian hàng với đầy đủ thông tin xác thực và được chập thuận bởi BQT. Vui lòng nhấn vào đường dẫn dưới để biết thêm thông tin...</p>
                    <a href="<?= Url::to(['/content-page/detail', 'alias' => 'dieu-kien-dang-ky-mua-ban', 'id' => 1]) ?>" target="_blank"><button id="btn-rgs-sell">Tìm hiểu thểm</button></a>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php $this->endContent(); ?>