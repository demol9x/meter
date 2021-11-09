<?php

use yii\helpers\Url;
?>
<div class="wrap-item-option">
    <?php
    foreach ($attributes as $key => $attribute) {
        if ($attribute['items']) {
            ?>
            <div class="item-option-product-detail">
                <div class="title-ring-size">
                    <img src="images/item-detail.png" alt="">
                    <label for=""><?= $attribute['name'] ?></label>
                </div>
                <select onchange="checkProduct()" name="Attribute[<?= $attribute['field_app'] ?>]" id="Attribute_<?= $attribute['field_app'] ?>" app="<?= $attribute['field_app'] ?>" appname="<?= $attribute['name'] ?>">
                    <option value="0">--- Chọn ---</option>
                    <?php foreach ($attribute['items'] as $item) { ?>
                        <option value="<?= $item['index_key'] ?>"><?= $item['value'] ?></option>
                    <?php } ?>
                </select>
                <br />
                <div class="error" style="display: none">
                    Bạn phải chọn thuộc tính này
                </div>
            </div>
            <?php
        }
    }
    ?>
    <input type="hidden" id="product_id" value="0" />
</div>
<div class="addcart-detail-product">
    <?php
    $urlAddToBag = Url::to(['/product/shoppingcart/add-cart']);
    ?>
    <a data-href="<?= $urlAddToBag ?>" class="btn-add-cart hvr-float-shadow" onclick="addtocart(this)" href="javascript:void(0)">
        <img src="<?= Url::home() ?>images/bag-detail.png"><?= Yii::t('app', 'add_to_bag') ?>
    </a>
</div>

<div class="view-detaill-more">
    <a class="hvr-float-shadow" href="#details"><?= Yii::t('app', 'view_product_detail') ?></a>
</div>

<script type="text/javascript">

    function addCommas(nStr)
    {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }

    function addtocart(_this) {
        var check = checkProduct();
        if (check == true) {
            var product_id = $('#product_id').val();
            var url = $(_this).attr('data-href');
            url += '?id=' + product_id;
            location.href = url;
        } else {
            return false;
        }
    }

    function checkProduct() {
        var data = {};
        var dataCompare = <?= json_encode($dataCompare); ?>;
        var dataPrice = <?= json_encode($productsPrice) ?>;
        var errors = [];
        $('.wrap-item-option .item-option-product-detail').each(function () {
            var value = $(this).find('select').val();
            var app = $(this).find('select').attr('app');
            if (value == 0) {
                var name = $(this).find('select').attr('appname');
                errors.push(name);
                $(this).find('.error').text('Bạn phải chọn ' + name).css('display', 'block');
            } else {
                $(this).find('.error').css('display', 'none');
                data[app] = value;
            }
        });
        if (errors.length == 0) {
            console.log(987);
            var key = '';
            for (i in data) {
                if (key != '') {
                    key += '_';
                }
                key += data[i];
            }
            key = key.replace('.', '_');
            var product_id = dataCompare[key];
            var price = dataPrice[product_id];
            if (price) {
                price = addCommas(price);
                $('.item-price-product p').text(price + ' VNĐ');
                $('#product_id').val(product_id);
                return true;
            } else {
                $('.item-price-product p').text('Liên hệ');
                $('#product_id').val(0);
                return false;
            }
        } else {
            $('#product_id').val(0);
            return false;
        }
    }

    $(document).ready(function () {
        $('#Attribute_Fk_ktl').change(function () {
            var ktl = $(this).val();
            $('#wrap_detail_weight_range').remove();
            generateWeightRange(ktl);
        });
    });

    function generateWeightRange(ktl) {
        var html = '<div class="item-option-product-detail" id="wrap_detail_weight_range">';
        //
        html += '<div class="title-ring-size">';
        html += '<img src="images/item-detail.png" alt="">';
        html += '<label for="">Chi tiết trọng lượng</label>';
        html += '</div>';
        //
        html += '<select onchange="checkProduct()" name="[Attribute[khoangtrongluong]]" id="Attribute_khoangtrongluong" app="khoangtrongluong" appname="Chi tiết trọng lượng">';
        html += '<option value="0">--- Chọn ---</option>';
        var weightRange = <?= json_encode($dataWeightRange); ?>;
        //
        var detailWeightRange = weightRange[ktl];
        for (i in detailWeightRange) {
            html += '<option value="' + detailWeightRange[i] + '">' + detailWeightRange[i] + ' Chỉ</option>';
        }
        //
        html += '</select>';
        //
        html += '<br />';
        html += '<div class="error" style="display: none">';
        html += 'Bạn phải chọn thuộc tính này';
        html += '</div>';
        //
        html += '</div>';
        $('.wrap-item-option').append(html);
        $('#Attribute_khoangtrongluong').niceSelect();
    }
</script>