<?php

use common\components\ClaHost;

if (isset($attributes) && $attributes) {
    foreach ($attributes as $att) {
        ?>
        <div class="item-option-product-detail">
            <div class="title-ring-size">
                <img src="<?= ClaHost::getImageHost(), $att['avatar_path'], $att['avatar_name'] ?>" alt="<?= $att['name'] ?>" />
                <label for=""><?= $att['name'] ?></label>
            </div>
            <?php if (isset($att['options']) && $att['options']) { ?>
                <select name="attrChangeprice[<?= $att['id']; ?>]"
                        id="attrChangeprice_<?= $att['id']; ?>" class="att_change_price">
                    <?php foreach ($att['options'] as $option) { ?>
                        <option value="<?= $option['id'] ?>" data-cp="<?= $option['change_price'] ?>"><?= $option['value'] ?></option>
                    <?php } ?>
                </select>
            <?php } ?>
        </div>
        <?php
    }
}
?>

<script type="text/javascript">
    jQuery(function () {
        var total_price = 0;
        jQuery('.att_change_price').change(function () {
            total_price = product_price;
            if (product_price) {
                jQuery('.att_change_price').children('option:selected').each(function (index) {
                    total_price += eco.ParseNumber(jQuery(this).attr('data-cp'));
                });
                jQuery(selecter_price).html(eco.FormatNumber(total_price) + currency_unit);
            }
        });
    });
    var selecter_price = '<?php echo $selecter_price; ?>';
    var currency_unit = '<?php echo $currency_unit; ?>';
    var product_price = <?php echo (int) $product['price']; ?>;
    var eco = {};
    eco.ToNumber = function (nStr) {
        if (nStr !== null && nStr !== NaN) {
            var rgx = /[^\d]/;
            while (rgx.test(nStr)) {
                nStr = nStr.replace(rgx, '');
            }
            return (parseInt(nStr)) ? parseInt(nStr) : 0;
        }
        return 0;

    };
    eco.ParseNumber = function (nStr) {
        if (nStr == null || nStr == NaN || nStr == "undifined") {
            return 0;
        }
        return parseInt(nStr);
    };
    eco.FormatNumber = function (nStr) {
        nStr += '';
        x = nStr.split(',');
        x1 = x[0];
        x2 = x.length > 1 ? ',' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + '.' + '$2');
        }
        var value = x1 + x2;
        if (value === "NaN") {
            return 0;
        }
        return value;
    };
</script>
