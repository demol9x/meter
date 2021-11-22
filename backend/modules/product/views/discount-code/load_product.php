<?php if ($product_ns) foreach ($product_ns as $product) { ?>
    <tr class="trupdt">
        <td><input type="checkbox" name="add[]" value="<?= $product->id ?>" class="checkp"></td>
        <td>
            <b><?= $product->name ?></b>
        </td>
    </tr>
<?php }
else { ?>
    <tr>
        <td colspan="5">Không có sản phẩm</td>
    </tr>
<?php } ?>