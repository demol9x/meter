<?php

use yii\helpers\Url;
use common\components\ClaHost;
use common\components\HtmlFormat;
$permoney = \common\models\gcacoin\Gcacoin::getPerMoneyCoin();
?>
<style type="text/css">
    .shopping-cart-page .payment {
        min-height: auto;
    }

    .title-detail-product .nice-select.transport-method .current:after {
        content: "<?= Yii::t('app', 'transport_method'); ?>:";
        position: absolute;
        left: 0px;
        top: -1px;
        line-height: 20px;
        white-space: nowrap;
        color: #232121;
    }

    .price-not-sale {
        text-decoration: line-through;
        color: #bebebe;
        display: inline-block;
        margin-left: 1px;
    }
    #ttl-tt {
        color: green;
        font-weight: bold;
        font-size: 18px;
        margin-right: 5px;
    }
    #ttl-ttv {
        display: none;
    }

    #ttl-ttv.showp {
        display: inline;
        font-size: 16px;
        font-weight: bold;
    }
</style>
<script type="text/javascript">
    var permoney = <?= $permoney; ?>;

    function updatePriceAll() {
        var vc = $('.svtotal-shop-vc');
        var gg = $('.svtotal-shop-gg');
        var tt = $('.svtotal-shop-tt');
        // var tvc = 0;
        var tgg = 0;
        var ttt = 0;
        // vc.each(function() {
        //     tvc += parseFloat($(this).attr('data-price'));
        // });
        gg.each(function() {
            tgg += parseFloat($(this).attr('data-price'));
        });
        tt.each(function() {
            ttt += parseFloat($(this).attr('data-price'));
        });
        // $('#ttl-vc').html(formatMoney(tvc, 0, ',', '.'));
        $('#ttl-gg').html(formatMoney(tgg, 0, ',', '.'));
        $('#ttl-tt').html(formatMoney(ttt, 0, ',', '.'));
        $('#ttl-ttv').html('= ' + formatMoney(ttt / permoney, 0, ',', '.') + ' V');
    }
    $(document).on('click', '.ckechf', function() {
        parent = $(this).closest('.discount_code');
        parent.find('.input-r').val('');
        parent.find('.input-r').attr('data-price', 0);
        parent.find('.note-inputf').html('');
        div = parent.find('.note-inputf').first();
        url = $(this).attr('data-href');
        div.html('<img style="padding:5px 10px;" src="/images/ajax-loader.gif" />');
        shop_id = $(this).attr('data-shop');
        $.ajax({
            url: url,
            data: {
                code: parent.find('.input-s').first().val()
            },
            type: 'POST',
            dataType: "json",
            success: function(result) {
                div.html(result.message);
                if (result.code == 1) {
                    parent.find('.input-r').val(result.data.code);
                    parent.find('.svtotal-shop-gg').attr("data-price", result.data.discount);
                }
                updatePrice(shop_id);
            }
        });
    });
</script>
<div class="shopping-cart-page">
    <section id="address-ship" class="address-ship">
        <form method="POST" id="form-checkout">
            <input id="form-token" type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->csrfToken ?>" />
            <div class="container">
                <div class="box-shadow-payment">
                    <?=
                        $this->render('partial/step_shopping', [
                            'active' => 4
                        ]);
                    ?>
                    <div class="payment-ship-content">
                        <h2><?= Yii::t('app', 'step_4') ?></h2>
                        <p>
                            <?= Yii::t('app', 'checkout_1') ?>
                        </p>
                    </div>
                </div>
                <div class="box-shadow-payment">
                    <div class="section-payment-item">
                        <div class="title-form">
                            <h2>
                                <img src="images/ico-bank.png" alt=""> <?= Yii::t('app', 'payment_method') ?>
                            </h2>
                        </div>
                        <?= \common\components\payments\gates\vnpay\widgets\Methods\Methods::widget(); ?>
                    </div>
                </div>
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
                                    <a href="<?= Url::to(['/product/shoppingcart/ship-address']) ?>"><?= Yii::t('app', 'select_address_other') ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-shadow-payment">
                    <div class="section-payment-item">
                        <div class="title-form">
                            <h2>
                                <img src="images/ico-bansanpham.png" alt=""> <?= Yii::t('app', 'checkout_2') ?>
                            </h2>
                        </div>
                        <?php
                        foreach ($dataProcess as $shop_id => $items) {
                            $shop = common\models\shop\Shop::findOne($shop_id);
                            $transports = common\models\transport\ShopTransport::getByShopOrder($shop_id, $items);
                        ?>
                            <section id="cart" class="cart">
                                <div class="bg-cart-page-mobile cart-droplist visible-xs">
                                    <div class="cart-droplist__content arrow_box">
                                        <div class="cart-droplist__status">
                                            <i class="fa fa-check" aria-hidden="true"></i>
                                            <span class="cart-counter-list"><?= count($items) ?></span> <?= Yii::t('app', 'product_in_shop') ?>
                                            <a target="_bank" class="shop-name-mobile" href="<?= Url::to(['/shop/shop/detail', 'id' => $shop['id'], 'alias' => $shop['alias']]) ?>"> <?= $shop['name'] ?></a>
                                        </div>
                                        <div class="mini-list">
                                            <ul class="list-item-cart">
                                                <?php
                                                $totals = 0;
                                                $count = 0;
                                                $sale_buy_shop_coin = 0;
                                                $sale_buy_shop_money = 0;
                                                foreach ($items as $item) {
                                                    $count++;
                                                    $url = Url::to([
                                                        '/product/product/detail',
                                                        'id' => $item['product_id'],
                                                        'alias' => HtmlFormat::parseToAlias($item['name'])
                                                    ]);
                                                    $total = $item['price'] * $item['quantity'];
                                                    $totals += $total;
                                                    $sale_buy_shop_coin += isset($item['sale_buy_shop_coin']) ? $item['sale_buy_shop_coin'] : 0;
                                                    $sale_buy_shop_money += isset($item['sale_buy_shop_money']) ? $item['sale_buy_shop_money'] : 0;
                                                ?>
                                                    <li class="item">
                                                        <a class="product-image" title="<?= $item['name'] ?>" href="<?= $url ?>">
                                                            <img width="100" height="auto" alt="<?= $item['name'] ?>" src="<?= ClaHost::getImageHost(), $item['avatar_path'], 's50_50/', $item['avatar_name'] ?>">
                                                        </a>
                                                        <div class="detail-item">
                                                            <div class="product-details">
                                                                <p class="product-name">
                                                                    <a href="<?= $url ?>" title="<?= $item['name'] ?>"><?= $item['name'] ?></a>
                                                                </p>
                                                            </div>
                                                            <div class="product-details-bottom">
                                                                <span class="price"><?= number_format($item['price'], 0, ',', '.') ?> <?= Yii::t('app', 'currency') ?></span>
                                                                <div class="quantity-select">
                                                                    <p>x<?= $item['quantity'] ?></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                <?php } ?>
                                                <li class="item">
                                                    <?=
                                                        frontend\widgets\html\HtmlWidget::widget([
                                                            'input' => [
                                                                'transports' => $transports,
                                                                'shop' => $shop,
                                                                'address' => $address
                                                            ],
                                                            'view' => 'transport_order',
                                                        ]);
                                                    ?>
                                                </li>
                                                <li class="item">
                                                    <?=
                                                        frontend\widgets\html\HtmlWidget::widget([
                                                            'input' => [
                                                                'shop' => $shop,
                                                            ],
                                                            'view' => 'discount_code',
                                                        ]);
                                                    ?>
                                                </li>
                                            </ul>
                                            <div class="top-subtotal">
                                                <?= Yii::t('app', 'sum') ?>:
                                                <span class="item-total price total-price svtotal-shop-tt" data-pold="<?= $totals ?>" data-price="<?= $totals ?>" id="total-<?= $shop["id"] ?>">
                                                    <?= number_format($totals, 0, ',', '.') ?>
                                                </span>
                                                <?= Yii::t('app', 'currency') ?>
                                                <i class="coin-sq"></i>
                                            </div>
                                            <script type="text/javascript">
                                                changeTotal<?= $shop["id"] ?>();
                                            </script>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="box-shadow-payment">
                    <div class="section-payment-item">
                        <div class="title-form">
                            <h2>
                                <img src="images/ico-bansanpham.png" alt=""> Thanh toán
                            </h2>
                        </div>
                        <div class="address-ship-content">
                            <div class="box-address-ship">
                                <p>
                                    Tổng tiền hàng: <b id="ttl-th"><?= formatMoney($ordertotal) ?></b> <span> <?= Yii::t('app', 'currency') ?></span>
                                </p>
                                <p>
                                    Tổng cộng mã giảm giá: <b id="ttl-gg">0</b><span> <?= Yii::t('app', 'currency') ?></span>
                                </p>
                                <p>
                                    Tổng thanh toán: <b id="ttl-tt" data-price="<?= $ordertotal ?>"><?= formatMoney($ordertotal) ?></b> <span> <?= Yii::t('app', 'currency') ?></span>
                                    <span id="ttl-ttv"> = <?= formatMoney($ordertotal / $permoney) ?> V</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="button-order-buy">
                    <a onclick="submitFormCheckout()" href="javascript:void(0)"><?= Yii::t('app', 'order_end') ?></a>
                </div>
            </div>
        </form>
    </section>
</div>
<div id="opt-response" style="display: none;"></div>
<div id="opt-data" style="display: none;"></div>
<style type="text/css">
    .popup-sapphire {
        top: 0px;
        left: 0px;
    }
</style>
<script type="text/javascript">
    function updatePrice(shop_id) {
        var total = $('#total-' + shop_id);
        var cost = $('#cost-transport-' + shop_id).attr('data-price');
        var fee = $('#total-gg-' + shop_id).attr('data-price');
        if (parseFloat(cost) > 0) {
            var sum = parseFloat(total.attr('data-pold')) - parseFloat(fee) + parseFloat(cost);
        } else {
            var sum = parseFloat(total.attr('data-pold')) - parseFloat(fee);
        }
        total.attr('data-price', sum);
        total.html(formatMoney(sum, 0, ',', '.'));
        updatePriceAll();
    }
    $('#form-checkout input').keydown(function(e) {
        if (e.keyCode == 13) {
            var inputs = $(this).parents("form").eq(0).find(":input");
            if (inputs[inputs.index(this) + 1] != null) {
                inputs[inputs.index(this) + 1].focus();
            }
            e.preventDefault();
            return false;
        }
    });

    function submitFormCheckout() {
        var tg = $("input[name='Order[payment_method]']:checked").val();
        if (tg == 'MEMBERIN') {
            loadAjaxPost("<?= \yii\helpers\Url::to(['/product/shoppingcart/get-otp']) ?>", {}, $('#opt-response'));
            return false;
        }
        $('.button-order-buy').html('Đang đặt hàng. Quý khách vui lòng chờ trong giây lát <img style="padding:5px 10px;" src="images/ajax-loader.gif" />');
        $('#form-checkout').submit();
    }

    function sendOtpAgain() {
        removeCustomAlert();
        loadAjaxPost("<?= \yii\helpers\Url::to(['/product/shoppingcart/get-otp']) ?>", {}, $('#opt-response'));
    }
</script>
<script type="text/javascript">
    <?php
    $money_s = \common\models\gcacoin\Gcacoin::getMoney(Yii::$app->user->id);
    if (isset($_SESSION['pay_success_responce']) && $_SESSION['pay_success_responce']) {
        $order_id_log = $_SESSION['pay_success_responce'];
        $log = \common\components\payments\gates\vnpay\models\LogVnPay::getModel($order_id_log);
        if ($log->correct) {
            unset($_SESSION['pay_success_responce']); ?>
            $(document).ready(function() {
                confirmCS('Nạp tiền thành công.<br/> Tiếp tục thanh toán bằng OCOP V?');
                yesConFirm = function(value) {
                    $('#payment_method_member_in').click();
                };
            });
        <?php } else { ?>
            $(document).ready(function() {
                alert('Quý khách đã hoàn tất quá trình thanh toán.Quý khách vui lòng đợi quá trình xác nhận và thanh toán sẽ hoàn thành sau vài giây...');
                setInterval(function() {
                    loadAjaxPost('<?= Url::to(['/product/shoppingcart/check-log', 'order_id' => $order_id_log]) ?>', {}, $('#log-ajax-order'));
                }, 1000);
            });
        <?php } ?>
    <?php } ?>

    function checkMoney() {
        var money = <?= $money_s; ?>;
        var tg = $('.item-total');
        var fee = parseFloat($('#ttl-tt').attr('data-price'));
        if (money < fee) {
            confirmCS('Tài khoản của bạn không đủ. Bạn có muốn nạp V ngay?');
            yesConFirm = function(value) {
                $('#popup-ctn-sapphire').html('<iframe style="width: 100%; height: 100%" src="<?= Url::to(['/management/gcacoin/recharge', 'iframe' => 1]) ?>"></iframe><div class="close-btn-sapphire">x</div>');
                $('.popup-sapphire').css('display', 'block');
            };
            setTimeout(function() {
                $('#input-defaunt').click();
            }, 200);
            return false;
        }
        $('#ttl-ttv').addClass('showp');
        return true;
    }
    $(document).ready(function() {
        $('body').append('<div style="display: none" class="popup-sapphire"> <div class="bg-shadow"></div> <div class="popup-ctn-sapphire" id="popup-ctn-sapphire"><div class="close-btn-sapphire">x</div> </div> </div>');
    });
</script>