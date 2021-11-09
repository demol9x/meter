<?php

use yii\helpers\Url;
use common\components\ClaHost;
use yii\bootstrap\ActiveForm;
use common\models\product\Product;
use common\models\product\ProductImage;
use common\components\HtmlFormat;

$free = 10;
?>

<div class="shopping-cart-page">
    <section id="cart" class="cart">
        <div class="container">
            <div class="box-shadow-payment">
                <?=
                $this->render('partial/step_shopping', [
                    'active' => 2
                ]);
                ?>
            </div>
            <?php if ($dataProcess) { ?>
                <div class="bg-cart-page hidden-xs">
                    <div class="row">
                        <div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-shc">
                                <div class="bg-scroll">
                                    <div class="cart-thead">
                                        <div style="width: 40%" class="a-left"><?= Yii::t('app', 'product') ?></div>
                                        <div style="width: 17%" class="a-center"><span class="nobr"><?= Yii::t('app', 'price') ?></span></div>
                                        <div style="width: 17%" class="a-center"><?= Yii::t('app', 'quantity') ?></div>
                                        <div style="width: 17%" class="a-center"><?= Yii::t('app', 'costs') ?></div>
                                        <div style="width: 9%"><?= Yii::t('app', 'delete') ?></div>
                                    </div>
                                    <?php
                                    $totals = 0;
                                    $count = 0;
                                    foreach ($dataProcess as $shop_id => $items) {
                                        $shop = common\models\shop\Shop::findOne($shop_id);
                                        $shop_img = $shop['avatar_name'] ? ClaHost::getImageHost(). $shop['avatar_path']. 's50_50/'. $shop['avatar_name'] :  ClaHost::getImageHost().'/imgs/shop_default.png';
                                        ?>
                                        <div class="item-shop">
                                            <div class="title-user-shop">
                                                <div class="name-user-shop">
                                                    <img src="<?= $shop_img ?>" alt="<?= $shop['name'] ?>" />
                                                    <h2><?= $shop['name'] ?></h2>
                                                </div>
                                                <div class="coin-user-shop">
                                                    <img src="<?= Url::home() ?>images/coin-us-dollar-icon.png" alt=""> <?= Yii::t('app', 'can_use_gca_coin') ?>
                                                </div>
                                            </div>
                                            <div class="cart-tbody">
                                                <?php
                                                foreach ($items as $item) {
                                                    $count++;
                                                    $url = Url::to([
                                                                '/product/product/detail',
                                                                'id' => $item['id'],
                                                                'alias' => HtmlFormat::parseToAlias($item['name'])
                                                    ]);
                                                    $total = $item['price'] * $item['quantity'];
                                                    $totals += $total;
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
                                                            <button data-id="<?= $item['id'] ?>" class="reduced items-count btn-minus" type="button">–</button>
                                                            <input data-id="<?= $item['id'] ?>" type="text" maxlength="10" min="1" class="input-text number-sidebar qtyItem quantity-<?= $item['id'] ?>" size="10" value="<?= $item['quantity'] ?>">
                                                            <button data-id="<?= $item['id'] ?>" class="increase items-count btn-plus" type="button">+</button>
                                                        </div>
                                                        <div style="width: 17%">
                                                            <span class="cart-price"> <span class="price"><span class="price-sum-<?= $item['id'] ?>"><?= number_format($total, 0, ',', '.') ?></span> <?= Yii::t('app', 'currency') ?></span> </span>
                                                        </div>
                                                        <div style="width: 9%">
                                                            <a class="button remove-item remove-item-cart" title="<?= Yii::t('app', 'delete') ?>" href="<?= Url::to(['/product/shoppingcart/remove', 'key' => $item['id']]) ?>"><span><span> <?= Yii::t('app', 'delete') ?></span></span></a>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="cart-collaterals col-lg-12 col-md-12 col-sm-12 col-xs-12" style="position: static;">
                            <div class="totals">
                                <p class="note-totals"><?= Yii::t('app', 'quantity_sum') ?>: <?= $count ?></p>
                                <div class="right-totals">
                                    <a class="remove-all-btn" href="<?= Url::to(['/product/shoppingcart/delete-all']) ?>">
                                        <i class="fa fa-times"></i> <?= Yii::t('app', 'delete_all_product') ?>
                                    </a>
                                    <a class="payment-btn btn-style-2" href="<?= Url::to(['/product/shoppingcart/ship-address']) ?>"><?= Yii::t('app', 'order_continue') ?></a>
                                    <div class="totals-prices">
                                        <p><?= Yii::t('app', 'sum') ?> : <span class="total-start"><?= number_format($totals, 0, ',', '.') ?> <?= Yii::t('app', 'currency') ?></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <div class="box-shadow-payment">
                    <p style="margin: 30px;"><?= Yii::t('app', 'havent_product_inshoppingcart') ?></p>
                </div>
            <?php } ?>
        </div>
    </section>
</div>


<script type="text/javascript">
    function updateShoppingcart(id, quantity, text) {
        $.ajax({
            url: "<?= Url::to(['/product/shoppingcart/update']) ?>",
            data: {id: id, 'quantity': quantity},
            success: function (result) {
                var re_arr = JSON.parse(result);
                console.log(re_arr);
                $('.price-' + re_arr['id']).html(formatMoney(re_arr['price'], 0, ',', '.') + ' ' + text);
                $('.price-sum-' + re_arr['id']).html(formatMoney(re_arr['order'], 0, ',', '.'));
                $('.total-start').html(formatMoney(re_arr['ordertotal'], 0, ',', '.') + text);
                $('.quantity-' + re_arr['id']).first().val(re_arr['quantity']);
            }
        });
    }
    $(document).ready(function () {
        $('.reduced').click(function () {
            var id = $(this).attr('data-id');
            var value = parseInt($('.quantity-' + id).first().val());
            var result = $('.quantity-' + id);
            if (value > 1)
                result.val(value - 1);
            return false;
        });
        $('.increase').click(function () {
            var id = $(this).attr('data-id');
            var value = parseInt($('.quantity-' + id).first().val());
            var result = $('.quantity-' + id);
            result.val(value + 1);
            return false;
        });
        $('.items-count').click(function () {
            var text = ' <?= Yii::t('app', 'currency') ?>';
            var id = $(this).attr('data-id');
            var quantity = parseInt($('.quantity-' + id).val());
            updateShoppingcart(id, quantity, text);
        });
        $('.number-sidebar').change(function () {
            var text = ' <?= Yii::t('app', 'currency') ?>';
            var id = $(this).attr('data-id');
            var quantity = parseInt($('.quantity-' + id).val());
            updateShoppingcart(id, quantity, text);
        });
    })
</script>