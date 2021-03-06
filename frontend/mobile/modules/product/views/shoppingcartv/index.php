<?php

use yii\helpers\Url;
use common\components\ClaHost;

$min = $product->getQuantityMin();
$quantity = $min > $quantity ? $min : $quantity;
$vs = $voucher ? $voucher->getCoinSale() : 0;
?>
<style>
    body .shopping-cart-page .cart .bg-cart-page .bg-scroll {
        margin-bottom: 0px;
    }

    body .box-shadow-payment .address-ship-content {
        padding: 0px;
        margin-bottom: -6px;
    }

    body .box-shadow-payment .address-ship-content .box-address-ship:nth-child(odd) {
        background: #fff;
    }

    .note-totals.over-money {
        color: red !important;
    }
</style>
<div class="shopping-cart-page">
    <section id="cart" class="cart">
        <div class="container">
            <?php if ($product) { ?>
                <form action="" method="POST" id="fonsmid" class="fonsm <?= $voucher ? ''  : 'no-login' ?>">
                    <div class="bg-cart-page">
                        <div class="row">
                            <div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <?php if ($address) { ?>
                                    <div class="box-shadow-payment">
                                        <div class="section-payment-item">
                                            <div class="title-form">
                                                <h2>
                                                    <img src="images/ico-bansanpham.png" alt=""> <?= Yii::t('app', 'ship_address') ?>
                                                </h2>
                                            </div>
                                            <div class="address-ship-content">
                                                <div class="box-address-ship">
                                                    <p>
                                                        <b><?= Yii::t('app', 'full_name') ?>:</b> <?= $address['name_contact'] ?>
                                                    </p>
                                                    <p>
                                                        <b><?= Yii::t('app', 'phone') ?>:</b> <?= $address['phone'] ?>
                                                    </p>
                                                    <p>
                                                        <b><?= Yii::t('app', 'address') ?>:</b> <?= $address['address'] . ' (' . join(', ', [$address['ward_name'], $address['district_name'], $address['province_name']]) . ')' ?>
                                                    </p>
                                                    <div class="btn-add-address">
                                                        <a href="<?= Url::to(['/product/shoppingcartv/ship-address']) ?>"><?= Yii::t('app', 'select_address_other') ?></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>

                                <div class="bg-cart-page-mobile cart-droplist visible-xs">
                                    <div class="cart-droplist__content arrow_box">
                                        <div class="mini-list">
                                            <ul class="list-item-cart">
                                                <?php
                                                $url = $product->getLink();
                                                ?>
                                                <li class="item productid-1108">
                                                    <a class="product-image" title="<?= $product['name'] ?>" href="<?= $url ?>">
                                                        <img width="100" height="auto" alt="<?= $product['name'] ?>" src="<?= ClaHost::getImageHost(), $product['avatar_path'], 's100_100/', $product['avatar_name'] ?>" />
                                                    </a>
                                                    <div class="detail-item">
                                                        <div class="product-details-bottom">
                                                            <span class="price"><?= $product->getPriceText($quantity) ?></span>
                                                            <div class="quantity-select">
                                                                <button data-id="1" class="reduced items-count btn-minus" type="button">???</button>
                                                                <input name="quantity" data-id="1" type="text" maxlength="10" min="1" class="input-text number-sidebar qtyMobile quantity-1" size="10" value="<?= $quantity ?>">
                                                                <button data-id="1" class="increase items-count btn-plus" type="button">+</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>

                                            <div class="top-subtotal"><?= Yii::t('app', 'sum') ?>: <span class="price total-price price-sum-1"></span></div>
                                            <div class="top-subtotal note-totals">
                                                <?php if ($voucher) { ?>
                                                    S??? d??
                                                    <span class="price total-price">
                                                        <?= $vs . ' ' . __VOUCHER_SALE ?>
                                                    </span>
                                                <?php } else { ?>
                                                    <span class="price total-price">
                                                        S???n ph???m ch??? c?? th??? thanh to??n b???ng <?= __VOUCHER_SALE ?>.
                                                    </span>
                                                <?php } ?>
                                            </div>
                                            <div class="actions">
                                                <button class="btn-checkout" aria-label="<?= Yii::t('app', 'order_continue') ?>"><span><i class="fa fa-money" aria-hidden="true"></i> <?= Yii::t('app', 'order_continue') ?></span></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a class="open-popup-link" id="login-btt" href="#login-box-popup"></a>
                    <script>
                        $(document).ready(function() {
                            $('.reduced').click(function() {
                                var id = $(this).attr('data-id');
                                var value = parseInt($('.quantity-' + id).first().val());
                                var result = $('.quantity-' + id);
                                if (value > 1)
                                    result.val(value - 1);
                                result.change();
                                return false;
                            });
                            $('.increase').click(function() {
                                var id = $(this).attr('data-id');
                                var value = parseInt($('.quantity-' + id).first().val());
                                var result = $('.quantity-' + id);
                                result.val(value + 1);
                                result.change();
                                return false;
                            });
                            $('.qtyMobile').change();
                        })
                        $('.qtyMobile').change(function() {
                            $('.fonsm').addClass('load-money');
                            quantity = $(this).val();
                            $.ajax({
                                url: "<?= Url::to(['/product/shoppingcartv/update']) ?>",
                                data: {
                                    'quantity': quantity
                                },
                                success: function(result) {
                                    $('.fonsm').removeClass('load-money');
                                    var re_arr = JSON.parse(result);
                                    $('.price-sum-1').html(re_arr['price_text']);
                                    $('.quantity-1').val(re_arr['quantity']);
                                    if (re_arr['price'] > <?= $vs ?>) {
                                        $('.note-totals').addClass('over-money');
                                        $('.fonsm').addClass('over-money');
                                    } else {
                                        $('.note-totals').removeClass('over-money');
                                        $('.fonsm').removeClass('over-money');
                                    }
                                }
                            });
                        });
                        $('#fonsmid').submit(function() {
                            if ($(this).hasClass("no-login")) {
                                confirmCS('C???n ????ng nh???p ????? c?? th??? th??nh to??n. B???n c?? mu???n ????ng nh???p ngay.');
                                yesConFirm = function(option) {
                                    $('#login-btt').click();
                                }
                                return false;
                            }
                            if ($(this).hasClass("over-money")) {
                                alert("Qu?? kh??ch kh??ng ????? Vs ????? thanh to??n. Vui l??ng n???p th??m Vs ????? ti???p t???c giao d???ch.");
                                return false;
                            }
                            if ($(this).hasClass("load-money")) {
                                alert("S??? l?????ng ??ang ???????c c???p nh???t. Qu?? kh??ch vui l??ng th???c hi??n l???i thao t??c ????? ti???p t???c giao d???ch.");
                                return false;
                            }
                            <?php if ($vs) { ?>
                                if ($('#pw2c').val() == '') {
                                    html = '<div class="otp-order"><p class="title">X??c nh???n thanh to??n.</p>';
                                    html += '<p>Nh???p m???t kh???u c???p 2.</p></div>';
                                    promptCS(html, '*******');
                                    $('#PromptCSInput').attr('type', 'password');
                                    yesPrompt = function(otp, data) {
                                        $.ajax({
                                            url: "<?= Url::to(['/product/shoppingcartv/check-otp']) ?>",
                                            data: {
                                                otp: otp,
                                            },
                                            success: function(result) {
                                                if (result == 'success') {
                                                    $('#pw2c').val(value);
                                                    $('#fonsmid').submit();
                                                } else {
                                                    checkAgain();

                                                }
                                            }
                                        });
                                    }
                                    return false;
                                }
                            <?php } ?>
                            return true;
                        });

                        function checkAgain() {
                            html = '<div class="otp-order"><p class="title">X??c nh???n thanh to??n.</p>';
                            html += '<p style="color:red">Nh???p m???t kh???u c???p 2 kh??ng ????ng. Vui l??ng nh???p l???i</p></div>';
                            promptCS(html, '*******');
                            $('#PromptCSInput').attr('type', 'password');
                            yesPrompt = function(otp, data) {
                                $.ajax({
                                    url: "<?= Url::to(['/product/shoppingcartv/check-otp']) ?>",
                                    data: {
                                        otp: otp,
                                    },
                                    success: function(result) {
                                        if (result == 'success') {
                                            $('#pw2c').val(value);
                                            $('#fonsmid').submit();
                                        } else {
                                            checkAgain();
                                        }
                                    }
                                });
                            }
                        }
                    </script>
                    <input name="password" id="pw2c" type="hidden" value="">
                </form>
            <?php } else { ?>
                <div class="box-shadow-payment">
                    <p style="margin: 30px;"><?= Yii::t('app', 'havent_product_inshoppingcart') ?></p>
                </div>
            <?php } ?>
        </div>
    </section>
</div>