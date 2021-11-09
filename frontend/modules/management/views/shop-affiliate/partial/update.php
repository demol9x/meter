<td><input class="chudtp new-add-n" type="checkbox" checked name="list[<?= $product['id'] ?>][id]" value="1"></td>
<td>
    <b><?= $product->name ?></b>
</td>
<td><input class="udtp affiliate_gt_product" type="text" min="0" data-old="<?= $product->affiliate_gt_product ?>" name="list[<?= $product['id'] ?>][affiliate_gt_product]" value="<?= $product->affiliate_gt_product ?>">%</td>
<td><input class="udtp affiliate_m_v" type="text" min="0" data-old="<?= $product->affiliate_m_v ?>" name="list[<?= $product['id'] ?>][affiliate_m_v]" value="<?= $product->affiliate_m_v ?>">%</td>
<td><input class="udtp affiliate_charity" type="text" min="0" data-old="<?= $product->affiliate_charity ?>" name="list[<?= $product['id'] ?>][affiliate_charity]" value="<?= $product->affiliate_charity ?>">%</td>
<td><input class="udtp affiliate_safe" type="text" min="0" data-old="<?= $product->affiliate_safe ?>" name="list[<?= $product['id'] ?>][affiliate_safe]" value="<?= $product->affiliate_safe ?>">%</td>
<td class="tool">
    <a class="bfcb update-it click">Sửa</a>
    <a href="" class="bfcb del-it click">Xóa</a>
    <a class="afcb save-it click" product_id="<?= $product['id'] ?>">Lưu</a>
    <a class="afcb cancer-it click">Hủy</a>
</td>
<?php if ($error) { ?>
    <script>
        alert('Dữ liệu không thỏa mãn. Vui lòng kiểm tra lại');
    </script>
<?php } else { ?>
    <script>
        $('.new-add-n').click();
        $('.new-add-n').removeClass('new-add-n');
    </script>
<?php } ?>