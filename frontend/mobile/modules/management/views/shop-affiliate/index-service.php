<?php

use yii\helpers\Url;
use common\components\ActiveFormC;

$model->affiliate_admin = $model->affiliate_admin . ' %';
$model->affiliate_gt_shop = $model->affiliate_gt_shop . ' %';
?>
<style>
    .table .trupdt .udtp {
        text-align: right;
        width: 22px;
        padding: 0px;
        border: 0px;
        pointer-events: none;
    }

    .table .trupdt .udtp {}

    .table .udtp {
        width: 30px;
        margin-right: 5px;
    }

    .trupdt .afcb {
        display: none;
    }

    .bfcb {
        display: none;
    }

    .trupdt .bfcb {
        display: inline-block;
    }

    .disabledbuttonone {
        pointer-events: none;
        opacity: 0.4;
    }

    .notcheck .disabledbutton {
        pointer-events: none;
        opacity: 0.4;
    }

    body .bnt-ch {
        padding: 0px 10px;
        display: inline-block;
        line-height: 0px;
        font-size: 12px;
        height: 30px;
    }

    body a.bnt-ch {
        height: 30px;
        background: green;
        line-height: 30px;
        color: #fff;
        border-radius: 5px;
        margin-right: 15px;
        text-transform: uppercase;
        font-weight: bold;
    }

    .name-p {
        display: inline-block;
        width: 180px;
    }

    .tool a {
        margin-right: 10px;
        text-transform: uppercase;
        font-size: 12px;
    }

    .item-input-form>.group-input>label {
        width: 20px !important;
        height: 20px;
        overflow: hidden;
    }

    .item-input-form>label {
        width: 200px !important;
    }

    body .ctn-form .item-input-form .group-input {
        width: Calc(100% - 200px);
    }

    input.disable {
        pointer-events: none;
        border: 0px;
        font-weight: bold;
        margin-top: -10px;
    }
</style>
<div class="form-create-store">
    <div class="title-form">
        <h2>
            <img src="<?= Yii::$app->homeUrl ?>images/ico-map-marker.png" alt=""> <?= Yii::t('app', 'affiliate') ?>
        </h2>
    </div>
    <div class="list-address-pay">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link" href="<?= Url::to(['/management/shop-affiliate/index']) ?>">Qu???n l?? Afiliate d??nh cho DN</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link">QR-CODE d???ch v???</a>
            </li>
        </ul>
        <div class="tab-content box-service" id="myTabContent">
            <div class="tab-pane fade active in">
                <div class="ctn-form">
                    <div class="col-md-6">
                        <?php $form = ActiveFormC::begin(); ?>
                        <?= $form->fieldF($model, 'affiliate_admin')->textInput(['class' => 'form-control disable'])->labelF() ?>
                        <?= $form->fieldF($model, 'affiliate_gt_shop')->textInput(['class' => 'form-control disable'])->labelF() ?>
                        <?= $form->fieldF($model, 'affilliate_status_service')->checkBox()->labelF() ?>
                        <?php ActiveFormC::end(); ?>
                    </div>
                    <div class="col-md-6">
                        <?php if ($model->affilliate_status_service) { ?>
                            <?php
                            $data = [
                                'type' => 'user_service',
                                'data' => [
                                    'user_id' => Yii::$app->user->id
                                ]
                            ];
                            $src = \common\components\ClaQrCode::GenQrCode($data);
                            ?>
                            <p>M?? QR CODE d???ch v??? <b><a href="<?= $src ?>" download> T???i ???nh </a></b></p>
                            <img src="<?= $src ?>" style="width: 150px; height: 150px; border-radius: 0;position: relative;">
                        <?php } else { ?>
                            <p>QR CODE d???ch v??? ch??a k??ch ho???t!</p>
                        <?php } ?>
                    </div>
                </div>
                <hr />
                <p style="padding-left: 10px;">S???n ph???m ??p d???ng QR-CODE d???ch v???:</p>
            </div>
            <div class="select-product">
                <form action="<?= Url::to(['update-list']) ?>" class="form-list-affiliate" method="POST" name="yourForm">
                    <table class="table">
                        <thead>
                            <tr>
                                <td>Ch???n</td>
                                <td>T??n s???n ph???m</td>
                                <td>Gi???i thi???u s???n ph???m</td>
                                <td>Mua b???ng V</td>
                                <td>Ocop charity 4.0</td>
                                <td>Gi???m tr???c ti???p</td>
                            </tr>
                        </thead>
                        <tbody id="box-item">
                            <?php
                            $have = false;
                            if ($products) foreach ($products as $product) {
                                if ($product['pay_servive']) {
                                    $have = true;
                                }
                            ?>
                                <tr class="trupdt <?= $product['pay_servive'] ? 'it_pay_servive show-service' : 'it_pay_servivewt' ?>">
                                    <td><input class="chudtp" type="checkbox" name="list[<?= $product['id'] ?>][id]" value="1"></td>
                                    <td>
                                        <b class="name-p"><?= $product->name ?></b>
                                    </td>
                                    <td><input class="udtp affiliate_gt_product" type="text" min="0" data-old="<?= $product->affiliate_gt_product ?>" name="list[<?= $product['id'] ?>][affiliate_gt_product]" value="<?= $product->affiliate_gt_product ?>">%</td>
                                    <td><input class="udtp affiliate_m_v" type="text" min="0" data-old="<?= $product->affiliate_m_v ?>" name="list[<?= $product['id'] ?>][affiliate_m_v]" value="<?= $product->affiliate_m_v ?>">%</td>
                                    <?php if ($product['pay_servive']) { ?>
                                        <td><?= $product->affiliate_charity ?> %</td>
                                        <td><?= $product->affiliate_safe ?> %</td>
                                    <?php } else { ?>
                                        <td><input class="udtp affiliate_charity" type="text" min="0" data-old="<?= $product->affiliate_charity ?>" name="list[<?= $product['id'] ?>][affiliate_charity]" value="<?= $product->affiliate_charity ?>">%</td>
                                        <td><input class="udtp affiliate_safe" type="text" min="0" data-old="<?= $product->affiliate_safe ?>" name="list[<?= $product['id'] ?>][affiliate_safe]" value="<?= $product->affiliate_safe ?>">%</td>
                                    <?php } ?>
                                </tr>
                            <?php }
                            else { ?>
                                <tr>
                                    <td colspan="5">Ch??a c?? s???n ph???m tham gia</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <p id="load-form" class="center"></p>
                    <div class="btn-submit-form notcheck">
                        <a class="bnt-ch add-it click open-popup-link <?= $have ? 'hidden-service'  : '' ?>" href="#box-add">Th??m s???n ph???m</a>
                        <a class="bnt-ch add-it click " id="save-service">C???p nh???t</a>
                        <a class="bnt-ch click  <?= $have ? ''  : 'hidden-service' ?>" id="change-service">?????i s???n ph???m d???ch v???</a>
                    </div>
                    <script>
                        <?php if ($have) { ?>
                            $('.it_pay_servivewt').addClass('hidden-service');
                        <?php } ?>
                        $('#save-service').click(function() {
                            if (confirm('X??c nh???n l??u thay ?????i?')) {
                                $('#load-form').html('??ang c???p nh???t...');
                                _this = $('.form-list-affiliate').first();
                                status = $('#shop-affilliate_status_service').is(":checked") ? '1' : '0';
                                if (status == '1') {
                                    chudtp = $('.chudtp:checked');
                                    if (chudtp.length > 1) {
                                        alert('l???i d??? li???u.');
                                        location.reload();
                                        return false;
                                    }
                                    if (chudtp.length < 1) {
                                        alert('Vui l??ng th??m v?? ch???n m???t s???n ph???m ??p d???ng.');
                                        $('#load-form').html('');
                                        console.log(chudtp.length);
                                        return false;
                                    }
                                }
                                $.ajax({
                                    url: "<?= Url::to(['/management/shop-affiliate/save-service']) ?>",
                                    data: _this.serialize() + '&status=' + status,
                                    type: 'POST',
                                    success: function(result) {
                                        $('#load-form').html('');
                                        if (result == 'success') {
                                            location.reload();
                                        } else {
                                            alert('L???i d??? li???u kh??ng ????ng. Vui l??ng ki???m tra l???i c??c s???n ph???m c???p nh???t');
                                            _this.attr('data-load', '0');
                                        }
                                    }
                                });
                            }
                        })
                        // $('#profile-tab').click(function() {
                        $('.hidden-service').attr('style', 'display:none');
                        $(document).ready(function() {
                            $('.it_pay_servive .chudtp').click();
                        })
                        // $('.it_pay_servive .chudtp').re();
                        // });
                        // $('#home-tab').click(function() {
                        // $('.hidden-service').attr('style', '');
                        // $('.show-service').addClass('hidden');
                        // $('#myTabContent').removeClass('box-service');
                        // });
                        // $('.show-service').addClass('hidden');
                        $('#change-service').click(function() {
                            $('#myTabContent .hidden-service').attr('style', '');
                            $('#myTabContent .disabledbutton').attr('style', 'display:none');
                            $('#change-service').attr('style', 'display:none');
                        });
                    </script>
                </form>
            </div>
        </div>
    </div>
    <div id="box-add" class="white-popup mfp-hide">
        <div class="box-account">
            <span class="mfp-close"></span>
            <div class="bg-pop-white">
                <div class="title-popup">
                    <h2>Ch???n s???n ph???m tham gia affiliate</h2>
                </div>
                <div class="ctn-review-popup">
                    <table class="table">
                        <tbody>
                            <?php if ($product_ns) foreach ($product_ns as $product) { ?>
                                <tr class="trupdt">
                                    <td><input type="checkbox" name="add" value="<?= $product->id ?>" pname="<?= $product->name ?>"></td>
                                    <td>
                                        <b><?= $product->name ?></b>
                                    </td>
                                </tr>
                            <?php }
                            else { ?>
                                <tr>
                                    <td colspan="5">Kh??ng c?? s???n ph???m</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <div class="btn-submit-forms">
                        <a class="bnt-ch add-it-add click">Ch???n</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).on('change', '.chudtp', function() {
            $('.box-service #box-item tr').addClass('trupdt');
            if ($(this).is(':checked')) {
                $(this).closest('tr').removeClass('trupdt');
            } else {
                $(this).click();
            }
            $('.box-service #box-item .trupdt .chudtp').prop('checked', false);
            list = $('.chudtp');
            check = false;
            list.each(function() {
                if ($(this).is(':checked')) {
                    check = true;
                    return false;
                }
            });
            if (check) {
                $('.btn-submit-form').removeClass('notcheck');
            } else {
                $('.btn-submit-form').addClass('notcheck');
            }
        });
        $(document).on('click', '.cancer-it', function() {
            input = $(this).closest('tr').find('.udtp');
            input.each(function() {
                $(this).val($(this).attr('data-old'));
            });
            $(this).closest('tr').find('.chudtp').click();
        });
        $(document).on('click', '.update-it', function() {
            $(this).closest('tr').find('.chudtp').click();
        });
        $(document).on('click', '.save-it', function() {
            tr = $(this).closest('tr');
            tr.addClass('disabledbuttonone');
            $.ajax({
                url: "<?= Url::to(['update']) ?>",
                data: {
                    product_id: $(this).attr('product_id'),
                    'affiliate_gt_product': tr.find('.affiliate_gt_product').first().val(),
                    'affiliate_m_v': tr.find('.affiliate_m_v').first().val(),
                    'affiliate_charity': tr.find('.affiliate_charity').first().val(),
                    'affiliate_safe': tr.find('.affiliate_safe').first().val()
                },
                type: 'POST',
                success: function(result) {
                    tr.removeClass('disabledbuttonone');
                    tr.html(result);
                }
            });
            return false;
        });
        $(document).on('click', '.add-it-add', function() {
            kt = false;
            $('input[name="add"]:checked').each(function() {
                id = $(this).val();
                $('#box-item').append('<tr class=""> <td><input checked class="chudtp" type="checkbox" name="list[' + id + '][id]" value="1"></td> <td> <b class="name-p">' + $(this).attr('pname') + '</b> </td> <td><input class="udtp affiliate_gt_product" type="text" min="0" data-old="0" name="list[' + id + '][affiliate_gt_product]" value="0">%</td> <td><input class="udtp affiliate_m_v" type="text" min="0" data-old="0" name="list[' + id + '][affiliate_m_v]" value="0">%</td> <td><input class="udtp affiliate_charity" type="text" min="0" data-old="0" name="list[' + id + '][affiliate_charity]" value="0">%</td> <td><input class="udtp affiliate_safe" type="text" min="0" data-old="0" name="list[' + id + '][affiliate_safe]" value="0">%</td> <td class="tool"> <a class="bfcb update-it click">S???a</a><a href="" class="afcb save-it click" product_id="' + id + '">L??u</a> <a class="remove-it click">X??a</a> </td> </tr>');
                kt = true;
                $(this).closest('tr').remove();
            });
            if (kt) {
                $('.btn-submit-form').removeClass('notcheck');
                $('.mfp-close').click();
            } else {
                alert('Vui l??ng ch???n s???n ph???m tham gia');
            }
        });
        $(document).on('click', '.remove-it', function() {
            if (confirm('B???n ?????ng ?? x??a?')) {
                $(this).closest('tr').remove();
            }
        });
        $(document).on('click', '.del-it', function() {
            _this = $(this);
            if (confirm('B???n ?????ng ?? x??a?')) {
                $.ajax({
                    url: '<?= Url::to(['/management/shop-affiliate/delele']) ?>',
                    data: {
                        id: $(this).attr('data-id')
                    },
                    type: 'GET',
                    success: function(result) {
                        alert('???? x??a');
                        _this.closest('tr').remove();
                    }
                });
            }
        });
    </script>
</div>
<?php
__addCss(
    ""
);
?>