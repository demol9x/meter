<?php

use yii\helpers\Url;
use common\components\HtmlFormat;
?>
<style>
    .box-table-shoppingcart {
        max-height: 350px;
        overflow: auto;
    }
</style>
<div class="flex-col flex-right box-shopping-cart">
    <div class="ico-img">
        <a href="javascript:void(0);">
            <i class="fa fa-shopping-bag"></i>
        </a>
    </div>
    <div id="box-shopping-cart">
        <div class="title-box">
            <h2>
                <a href="<?= $link ?>">
                    <?= Yii::t('app', 'shoppingcart') ?>
                    <span><?= $quantity ?> <?= Yii::t('app', 'product') ?></span>
                </a>
            </h2>
        </div>
        <div class="cart-mini">
            <div class="uk-dropdown" style="">
                <h5><?= Yii::t('app', 'my_shoppingcart') ?></h5>
                <div class="box-table-shoppingcart">
                    <table class="table-shoppingcart">
                        <tbody>
                            <?php
                            if (isset($products) && $products) {
                                foreach ($products as $key => $product) {
                                    $url = Url::to([
                                        '/product/product/detail',
                                        'id' => $product['id'],
                                        'alias' => HtmlFormat::parseToAlias($product['name'])
                                    ]);
                            ?>
                                    <tr>
                                        <td class="title">
                                            <a href="<?= $url ?>" title="<?= $product['name'] ?>"><?= $product['name'] ?></a>
                                        </td>
                                        <td class="quantity">
                                            <div>
                                                <?= $product['quantity'] ?>
                                            </div>
                                        </td>
                                        <td class="price" data-price="<?= $product['price'] ?>">
                                            <?= number_format($product['price'], 0, ',', '.'); ?>đ
                                        </td>
                                        <td>
                                            <a class="remove click" data-href="<?= Url::to(['/product/shoppingcart/remove', 'key' => $product['id']]) ?>"><i class="fa fa-times"></i></a>
                                        </td>
                                    </tr>
                            <?php }
                            } ?>
                        </tbody>
                    </table>
                </div>
                <table class="table-shoppingcart">
                    <tfoot>
                        <tr class="total">
                            <td colspan="2" class="title">
                                <?= Yii::t('app', 'sum_money') ?>
                            </td>
                            <td class="price">
                                &nbsp;<?= number_format($ordertotal, 0, ',', '.'); ?>đ
                            </td>
                            <td>&nbsp;</td>
                        </tr>
                    </tfoot>
                </table>
                <a href="<?= $link ?>" class="uk-button"><?= Yii::t('app', 'pay') ?></a>
            </div>
            <div class="close-popup"></div>
        </div>
    </div>
</div>
<script>
    $('.table-shoppingcart .remove').click(function() {
        loadAjax($(this).attr('data-href'), {}, $(this));
        $(this).closest('tr').remove();
        price = $('#box-shopping-cart tbody .price');
        price_t = 0;
        count = 0;
        price.each(function(index) {
            price_t += parseFloat($(this).attr('data-price'));
            count++;
            console.log($(this).attr('data-price'));
        });
        $('#box-shopping-cart .total .price').html('' + formatMoney(price_t, 0, ',', '.') + 'đ');
        $('#box-shopping-cart .title-box span').html('' + count + ' sản phẩm');
        return false;
    });
</script>