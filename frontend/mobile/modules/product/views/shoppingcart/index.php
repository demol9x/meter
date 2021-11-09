<?php

use yii\helpers\Url;
use common\components\ClaHost;
use yii\bootstrap\ActiveForm;
use common\models\product\Product;
use common\models\product\ProductImage;
use common\components\HtmlFormat;

$free = 10;
$count = 0;
foreach ($dataProcess as $shop_id => $items) {
    $count++;
}
?>
<style type="text/css">
    .quantity-select {
        margin-left: 10px;
    }
    .product-details {
        width: 100%;
    }
    .product-details >a {
        font-size: 25px;
    }
</style> 
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
                <div class="bg-cart-page-mobile cart-droplist visible-xs">
                    <div class="cart-droplist__content arrow_box">
                        <div class="cart-droplist__status">
                            <i class="fa fa-check" aria-hidden="true"></i> 
                            <span class="cart-counter-list"><?= $count ?></span> <?= Yii::t('app', 'product_in_shop') ?>
                        </div>
                        <div class="mini-list">
                            <?php
                            $totals = 0;
                            foreach ($dataProcess as $shop_id => $items) {
                                $shop = common\models\shop\Shop::findOne($shop_id);
                                ?>
                                <div class="title-user-shop">
                                    <div class="name-user-shop">
                                        <img src="<?= ClaHost::getImageHost(), $shop['avatar_path'], 's50_50/', $shop['avatar_name'] ?>" alt="<?= $shop['name'] ?>" />
                                        <h2><?= $shop['name'] ?></h2>
                                    </div>
                                    <div class="coin-user-shop">
                                        <img src="<?= Url::home() ?>images/coin-us-dollar-icon.png" alt=""> <?= Yii::t('app', 'can_use_gca_coin') ?>
                                    </div>
                                </div>
                                <ul class="list-item-cart">
                                    <?php
                                    foreach ($items as $item) {
                                        $url = Url::to([
                                                    '/product/product/detail',
                                                    'id' => $item['id'],
                                                    'alias' => HtmlFormat::parseToAlias($item['name'])
                                        ]);
                                        $total = $item['price'] * $item['quantity'];
                                        $totals += $total;
                                        ?>
                                        <li class="item productid-1108">
                                            <a class="product-image" title="<?= $item['name'] ?>" href="<?= $url ?>">
                                                <img width="100" height="auto" alt="<?= $item['name'] ?>" src="<?= ClaHost::getImageHost(), $item['avatar_path'], 's100_100/', $item['avatar_name'] ?>" />
                                            </a>
                                            <div class="detail-item">
                                                <div class="product-details">
                                                    <a href="<?= Url::to(['/product/shoppingcart/remove', 'key' => $item['id']]) ?>" title="<?= Yii::t('app', 'delete') ?>" class="remove-item-cart fa fa-trash-o"></a>
                                                    <p class="product-name"> 
                                                        <a href="<?= $url ?>" title="<?= $item['name'] ?>"><?= $item['name'] ?></a>
                                                    </p>
                                                </div>
                                                <div class="product-details-bottom">
                                                    <span class="price"><?= number_format($item['price'], 0, ',', '.') ?> <?= Yii::t('app', 'currency') ?></span>
                                                    <div class="quantity-select">
                                                        <button data-id="<?= $item['id'] ?>" class="reduced items-count btn-minus" type="button">–</button>
                                                        <input data-id="<?= $item['id'] ?>" type="text" maxlength="10" min="1" class="input-text number-sidebar qtyMobile quantity-<?= $item['id'] ?>" size="10" value="<?= $item['quantity'] ?>">
                                                        <button data-id="<?= $item['id'] ?>" class="increase items-count btn-plus" type="button">+</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    <?php } ?>
                                </ul>
                                <?php
                            }
                            ?>
                            <div class="top-subtotal"><?= Yii::t('app', 'sum') ?>: <span class="price total-price total-start"><?= number_format($totals, 0, ',', '.') ?> <?= Yii::t('app', 'currency') ?></span></div>
                            <div class="actions">
                                <button class="btn-checkout" type="button" aria-label="<?= Yii::t('app', 'order_continue') ?>" onclick="window.location.href = '<?= Url::to(['/product/shoppingcart/ship-address']) ?>'"><span><i class="fa fa-money" aria-hidden="true"></i> <?= Yii::t('app', 'order_continue') ?></span></button>
                                <button class="btn-checkout btn-return" type="button" aria-label="<?= Yii::t('app', 'buy_continue') ?>" onclick="window.location.href = '<?= Yii::$app->homeUrl ?>'"><span><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> <?= Yii::t('app', 'buy_continue') ?></span></button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <div class="box-shadow-payment">
                    <p style="margin: 30px;">Không có sản phẩm nào trong giỏ hàng!</p>
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