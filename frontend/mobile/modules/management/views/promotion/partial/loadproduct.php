<?php 
    $list_time = explode(' ', $promotion->time_space);
    $hour = $promotion->getHourNow();
?>
<?php foreach ($products as $product) { 
    $text_price = number_format($product['price'], 0, ',', '.');
    $price = $product['price'];
    if ($product['price_range']) {
        $price_range = explode(',', $product['price_range']);
        $price = $price_range[0];
        $price_max = number_format($price_range[0], 0, ',', '.');
        $price_min = number_format($price_range[count($price_range) - 1], 0, ',', '.');
        $text_price = $price_max != $price_min ? $price_min . ' - ' . $price_max : $price_min;
    }
    ?>
    <tr data-key="<?= $product['id_promotion_sale'] ?>"> 
        <td><?= $product['name'] ?>(<?= $text_price ?>)</td>
        <td><input class="price-sale" placeholder="nhập giá khuyến mãi" type="number" max="<?= $price ?>" value="<?= $product['price_promotion_sale'] ?>" /></td>
        <td><input class="quantity-sale" placeholder="nhập số lượng" type="number" value="<?= $product['quantity_promotion_sale'] ?>"  /></td>
        <td>
            <select id="hour-promotion" class="hour-sale">
                <?php for ($i=0; $i < count($list_time); $i++) {  ?>
                    <option value="<?= $list_time[$i] ?>" <?= $list_time[$i] == $product['hour_space_start'] ? 'selected' : '' ?>><?= $list_time[$i] ?>h - <?= isset($list_time[$i+1]) ? $list_time[$i+1] : $list_time[0] ?>h</option>
                <?php } ?>
            </select>
        </td>
        <td><a class="click remove-after" title="Xóa" data-id="<?= $product['id_promotion_sale'] ?>" aria-label ><span class="glyphicon glyphicon-trash"></span></a></td>
    </tr>
<?php } ?>
<input type="hidden" id="input-value-after" name="input-value-after" value="<?php if($products) foreach ($products as $product) echo ','.$product['id']; ?>">
<script type="text/javascript">
    $('#count-product').html(<?= count($products) ?>);
</script>