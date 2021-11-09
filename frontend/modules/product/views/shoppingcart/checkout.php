<?php
\Yii::$app->session->open();

use yii\helpers\Url;
use common\components\ClaHost;
use common\components\HtmlFormat;

$permoney = \common\models\gcacoin\Gcacoin::getPerMoneyCoin();
?>
<style type="text/css">
    .sale_aff {
        clear: both;
        padding-top: 10px;
    }

    .price-not-sale {
        text-decoration: line-through;
        color: #bebebe;
        display: inline-block;
        margin-left: 1px;
    }

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

    body .title-detail-product .nice-select {
        width: 300px;
        float: left;
        margin-right: 10px;
        clear: unset;
    }

    body .title-detail-product .nice-select.address-shop .current:after {
        content: "Giao hàng từ:";
        font-weight: normal;
        position: absolute;
        left: 0px;
        top: -1px;
        line-height: 20px;
        white-space: nowrap;
        color: #232121;
    }

    .fee-ship {
        float: left;
        margin: 10px;
    }

    .nice-select.address-shop .current {
        padding-left: 87px;
    }

    .box-shadow-payment .address-ship-content {
        padding: 0px 0px;
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
                                <img src="images/ico-bansanpham.png" alt=""> Đơn hàng của bạn
                            </h2>
                        </div>
                        <?php
                        foreach ($dataProcess as $shop_id => $items) {
                            $shop = common\models\shop\Shop::findOne($shop_id);
                            $transports = common\models\transport\ShopTransport::getByShopOrder($shop_id, $items);
                            $shop_img = $shop['avatar_name'] ? ClaHost::getImageHost() . $shop['avatar_path'] . 's50_50/' . $shop['avatar_name'] :  ClaHost::getImageHost() . '/imgs/shop_default.png';
                        ?>
                            <section id="cart-<?= $shop_id ?>" class="shop-cart-item cart">
                                <div class="bg-cart-page hidden-xs">
                                    <div class="row">
                                        <div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="bg-scroll">
                                                <div class="title-user-shop">
                                                    <div class="name-user-shop">
                                                        <img src="<?= $shop_img ?>" alt="<?= $shop['name'] ?>" />
                                                        <h2><?= $shop['name'] ?></h2>
                                                    </div>
                                                    <div class="coin-user-shop">
                                                        <img src="<?= Url::home() ?>images/coin-us-dollar-icon.png" alt=""> <?= Yii::t('app', 'can_use_gca_coin') ?>
                                                    </div>
                                                </div>
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
                                                <div class="cart-tbody">
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
                                                        <div class="item-cart productid-11088257">
                                                            <div style="width: 40%" class="a-left">
                                                                <div class="image">
                                                                    <a class="product-image" title="<?= $item['name'] ?>" href="<?= $url ?>">
                                                                        <img width="100" height="auto" alt="<?= $item['name'] ?>" src="<?= ClaHost::getImageHost(), $item['avatar_path'], 's100_100/', $item['avatar_name'] ?>" />
                                                                    </a>
                                                                </div>
                                                                <h2 class="product-name">
                                                                    <a href="<?= $url ?>" title="<?= $item['name'] ?>"><?= $item['name'] ?></a>
                                                                </h2>
                                                            </div>
                                                            <div style="width: 17%">
                                                                <span class="item-price"> <span class="price"><?= number_format($item['price'], 0, ',', '.') ?> <?= Yii::t('app', 'currency') ?></span></span>
                                                            </div>
                                                            <div style="width: 17%;">
                                                                <p>x<?= $item['quantity'] ?></p>
                                                            </div>
                                                            <div style="width: 17%">
                                                                <span class="cart-price"> <span class="price"><?= number_format($total, 0, ',', '.') ?> <?= Yii::t('app', 'currency') ?></span> </span>
                                                            </div>
                                                            <div style="width: 9%">
                                                                <a class="button remove-item remove-item-cart" title="<?= Yii::t('app', 'delete') ?>" href="<?= Url::to(['/product/shoppingcart/remove', 'key' => $item['product_id']]) ?>"><span><span><?= Yii::t('app', 'delete') ?></span></span></a>
                                                            </div>
                                                        </div>
                                                    <?php
                                                    }
                                                    ?>
                                                    <?php if ($shop->status_affiliate === \common\components\ClaLid::STATUS_ACTIVED && ($sale_buy_shop_coin ||  $sale_buy_shop_money)) { ?>
                                                        <div class="sale_aff">
                                                            <p>
                                                                <span>
                                                                    Thanh toán bằng OCOP V giảm:
                                                                    <span class="sale-coin" data-sale-coin="<?= $sale_buy_shop_coin ?>">
                                                                        <?= $sale_buy_shop_coin ?>
                                                                    </span>
                                                                    V
                                                                </span>
                                                                <span> - </span>
                                                                <span>
                                                                    Thanh toán bằng hình thức khác OCOP V tích lũy:
                                                                    <?= $sale_buy_shop_money ?> V
                                                                </span>
                                                            </p>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                                <?=
                                                    frontend\widgets\html\HtmlWidget::widget([
                                                        'input' => [
                                                            'shop' => $shop,
                                                        ],
                                                        'view' => 'discount_code',
                                                    ]);
                                                ?>
                                            </div>
                                        </div>
                                        <div class="cart-collaterals col-lg-12 col-md-12 col-sm-12 col-xs-12" style="position: static;">
                                            <div class="totals">
                                                <p class="note-totals"><?= Yii::t('app', 'quantity_sum') ?> : <?= $count ?></span></p>
                                                <div class="right-totals">
                                                    <div class="totals-prices">
                                                        <p>
                                                            <?= Yii::t('app', 'sum') ?> :
                                                            <span class="item-total svtotal-shop-tt" id="total-<?= $shop['id'] ?>" data-pold="<?= $totals ?>" data-price="<?= $totals ?>"><?= number_format($totals, 0, ',', '.') ?>
                                                            </span>
                                                            <?= Yii::t('app', 'currency') ?>
                                                            <i class="coin-sq"></i>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    $(document).ready(function() {
                                        updatePrice(<?= $shop["id"] ?>);
                                    });
                                </script>
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
                                <img src="images/ico-bansanpham.png" alt="">Thanh toán
                            </h2>
                        </div>
                        <div class="address-ship-content">
                            <div class="box-address-ship">
                                <p>
                                    Tổng tiền hàng: <b id="ttl-th"><?= formatMoney($ordertotal) ?></b> <span> <?= Yii::t('app', 'currency') ?></span>
                                </p>
                                <!-- <p>
                                    Phí vận chuyển: <b id="ttl-vc">Liên hệ</b>
                                </p> -->
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
<div id="log-ajax-order"></div>
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
<style type="text/css">
    .popup-ctn-sapphire {
        height: 60vh;
        background: #fff;
    }

    .popup-sapphire {
        top: 0px;
        left: 0px;
    }

    body .popup-ctn-sapphire {
        max-width: 800px;
    }
</style>