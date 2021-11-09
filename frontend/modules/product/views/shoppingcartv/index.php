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

    body .shopping-cart-page .cart-collaterals .totals .note-totals.over-money {
        color: red !important;
    }
</style>
<div class="shopping-cart-page">
    <section id="cart" class="cart">
        <div class="container">
            <?php if ($product) { ?>
                <form action="" method="POST" id="fonsmid" class="fonsm <?= $voucher ? ''  : 'no-login' ?>">
                    <div class="bg-cart-page hidden-xs">
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
                                <div class="form-shc">
                                    <div class="bg-scroll">
                                        <?php
                                        $url = $product->getLink();
                                        ?>
                                        <div class="item-shop">
                                            <div class="cart-thead">
                                                <div style="width: 49%" class="a-left"><?= Yii::t('app', 'product') ?></div>
                                                <div style="width: 17%" class="a-center"><span class="nobr"><?= Yii::t('app', 'price') ?></span></div>
                                                <div style="width: 17%" class="a-center"><?= Yii::t('app', 'quantity') ?></div>
                                                <div style="width: 17%" class="a-center"><?= Yii::t('app', 'costs') ?></div>
                                            </div>
                                            <div class="cart-tbody">
                                                <div class="item-cart productid-11088257">
                                                    <div style="width: 49%" class="a-left">
                                                        <div class="image">
                                                            <a class="product-image" title="<?= $product['name'] ?>" href="<?= $url ?>">
                                                                <img width="100" height="auto" alt="<?= $product['name'] ?>" src="<?= ClaHost::getLinkImage($product['avatar_path'], $product['avatar_name'], 's100_100/') ?>" />
                                                            </a>
                                                        </div>
                                                        <h2 class="product-name">
                                                            <a href="<?= $url ?>" title="<?= $product['name'] ?>"><?= $product['name'] ?></a>
                                                        </h2>
                                                    </div>
                                                    <div style="width: 17%">
                                                        <span class="item-price"> <span class="price"><?= $text = $product->getPriceText($quantity) ?></span></span>
                                                    </div>
                                                    <div style="width: 17%;">
                                                        <button data-id='1' class="reduced items-count btn-minus" type="button">–</button>
                                                        <input name="quantity" type="text" maxlength="10" min="1" class="input-text number-sidebar qtyItem quantity-1" size="10" value="<?= $quantity ?>">
                                                        <button data-id='1' class="increase items-count btn-plus" type="button">+</button>
                                                    </div>
                                                    <div style="width: 17%">
                                                        <span class="cart-price"> <span class="price"><span class="price-sum-1"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="cart-collaterals">
                                    <div class="totals">
                                        <p class="note-totals"> <?= $voucher ? "Số dư " . __VOUCHER_SALE . ": " . $vs : 'Sản phẩm chỉ có thể thanh toán bằng ' . __VOUCHER_SALE . '.' ?></p>
                                        <div class="right-totals">
                                            <button class="payment-btn btn-style-2">Thanh toán</button>
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
                            $('.qtyItem').change();
                        })
                        $('.qtyItem').change(function() {
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
                                confirmCS('Cần đăng nhập để có thể thành toán. Bạn có muốn đăng nhập ngay.');
                                yesConFirm = function(option) {
                                    $('#login-btt').click();
                                }
                                return false;
                            }
                            if ($(this).hasClass("over-money")) {
                                alert("Quý khách không đủ Vs để thanh toán. Vui lòng nạp thêm Vs để tiếp tục giao dịch.");
                                return false;
                            }
                            if ($(this).hasClass("load-money")) {
                                alert("Số lượng đang được cập nhật. Quý khách vui lòng thực hiên lại thao tác để tiếp tục giao dịch.");
                                return false;
                            }
                            <?php if ($vs) { ?>
                                if ($('#pw2c').val() == '') {
                                    html = '<div class="otp-order"><p class="title">Xác nhận thanh toán.</p>';
                                    html += '<p>Nhập mật khẩu cấp 2.</p></div>';
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
                            html = '<div class="otp-order"><p class="title">Xác nhận thanh toán.</p>';
                            html += '<p style="color:red">Nhập mật khẩu cấp 2 không đúng. Vui lòng nhập lại</p></div>';
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