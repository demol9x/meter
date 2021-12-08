<?php

use common\components\ClaHost;
use common\models\product\Product;
use common\models\product\ProductAttribute;
use common\models\product\ProductAttributeItem;
use common\models\product\ProductVariables;
use yii\helpers\Url;
use common\components\HtmlFormat;

?>
<div class="modal-content wow fadeInDown" data-wow-duration="1s">
    <span class="close">&times;</span>
    <div class="item-title-popup">
        <div class="title-popup-donhang">
            <h3 class="title_26">KIỂM TRA ĐƠN HÀNG</h3>
            <img class="Rectangle" src="<?= Yii::$app->homeUrl ?>images/Rectangle.png">
        </div>
    </div>
    <div class="item-product">
        <?php
        if (isset($products) && $products) {
            foreach ($products as $key => $product) {
                $url = Url::to([
                    '/product/product/detail',
                    'id' => $product['id'],
                    'alias' => HtmlFormat::parseToAlias($product['name'])
                ]);
                $price = $product['price'];
                $attribute_id = [];
                if ($product['var_id']) {
                    $product_attr_varable = ProductVariables::getVarable(['id' => $product['var_id']]);
                    $price = $product_attr_varable['price'];

                    $attribute_id = (array)json_decode($product_attr_varable['key']);
                }
                ?>
                <div class="item-donhang-product">
                    <div class="image">
                        <img src="<?= ClaHost::getImageHost(), $product['avatar_path'] . $product['avatar_name'] ?>"
                             alt="<?= $product['name'] ?>">
                    </div>
                    <div class="detail-item">
                        <h4 class="title_28"><?= $product['name'] ?></h4>
                        <?php if (count($attribute_id)) { ?>
                            <div class="tt-color-mm">
                                <?php foreach ($attribute_id as $attr) {
                                    $val = explode('~',$attr);
                                    $group_name = ProductAttribute::getName($val[0]);
                                    $name = ProductAttributeItem::getItemByAttribute($val[1]);
                                    ?>
                                    <p class="content_16"><?=$group_name?>: <?=$name['value']?></p>
                                <?php } ?>
                            </div>
                        <?php } ?>
                        <h5 class="price title_30"><?= ($price) ? number_format($price, 0, ',', '.') . ' ' . Yii::t('app', 'currency') : 'Liên hệ' ?></h5>
                        <?php if ($product['price_market']) { ?>
                            <div class="price_sale">
                                <p class="content_16"><?= number_format($product['price_market'], 0, ',', '.') . ' ' . Yii::t('app', 'currency'); ?></p>
                                <?php if ($product['price_market'] > $price && $price > 0) { ?>
                                    <span class="content_16">-<?= \common\components\ClaLid::getDiscount($product['price_market'], $price) ?>%</span>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="Quantity-item">
                    <p class="content_16">Số lượng</p>

                    <div class="custom custom-btn-numbers form-control">
                        <button onclick="var result = document.getElementById('tity'); var tity = result.value; if( !isNaN(tity) &amp; tity > 1 ) result.value--;return false;"
                                class="btn-minus btn-cts" type="button">-
                        </button>
                        <div class="input"><input class="content_16" type="text" class="tity input-text" id="tity"
                                                  name="Quantity-item" size="4" value="<?=$product['quantity']?>" maxlength="99999999">
                        </div>
                        <button onclick="var result = document.getElementById('tity'); var tity = result.value; if( !isNaN(tity)) result.value++;return false;"
                                class="btn-plus btn-cts" type="button">+
                        </button>
                    </div>
                </div>
            <?php }
        } ?>

        <ul class="payments-item">
            <li>
                <p class="content_16">Tiền hàng:</p>
                <p class="content_16"><?= number_format($ordertotal, 0, ',', '.'); ?>đ</p>
            </li>
            <li>
                <p class="title_18">Tổng tiền thanh toán:</p>
                <p class="title_18"><?= number_format($ordertotal, 0, ',', '.'); ?>đ</p>
            </li>
        </ul>
        <form>
            <textarea class="content_16" name="" id="" placeholder="Chat"></textarea>
        </form>

        <a href="<?= $link ?>" title="" class="create-order content_16">tạo đơn hàng<img
                    src="<?= Yii::$app->homeUrl ?>images/form_foot.png"></a>
    </div>
</div>
<script>
    $(document).ready(function () {

        var modal = document.getElementById("kiemtradonhang");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks on <span> (x), close the modal
        span.onclick = function () {
            modal.style.display = "none";
        };

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function (event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        };
    });
</script>