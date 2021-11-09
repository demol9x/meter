<div class="col-xs-3">
    <b>Tên sản phẩm</b>
</div>
<div class="col-xs-3">
    <b>Màu sắc</b>
</div>
<div class="col-xs-3">
    <b>Kích cỡ</b>
</div>
<div class="col-xs-3">
    &nbsp;
</div>

<div class="col-xs-3">
    <span><?= $product['name'] ?></span>
</div>
<div class="col-xs-3">
    <select class="form-control" id="color-more">
        <?php foreach ($colors as $color) { ?>
            <option value="<?= str_replace(' ', '', $color) ?>"><?= $color ?></option>
        <?php } ?>
    </select>
</div>
<div class="col-xs-3">
    <select class="form-control" id="size-more">
        <?php foreach ($sizes as $size => $stock) { ?>
            <option value="<?= str_replace(' ', '', $size) ?>"><?= $size ?></option>
        <?php } ?>
    </select>
</div>
<div class="col-xs-3">
    <button id="add-more-product-to-cart" class="btn btn-success" type="button">Thêm</button>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#add-more-product-to-cart').click(function () {
            var id = <?= $product['id'] ?>;
            var color = $('#color-more').val();
            var size = $('#size-more').val();
            var order_id = <?= $order_id ?>;
            $.getJSON(
                    '<?= \yii\helpers\Url::to(['/order/order/add-more-product']) ?>',
                    {id: id, order_id: order_id, color: color, size: size},
                    function (data) {
                        if (data.code == 200) {
                            alert('Thêm sản phẩm vào giỏ hàng thành công');
                            location.reload(true);
                        }
                    }
            );
        });
    });
</script>