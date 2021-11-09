<?php
use yii\helpers\Url;
?>
<p>
    Thông báo đơn hàng mới từ <a href="<?= __SERVER_NAME ?>/">OCOP</a>
</p>
<p>
   Có đơn hàng mới từ OCOP với tổng giá trị đơn hàng là: <?= number_format($order['order_total'], 0, ',', '.') ?> VNĐ
    <br/>
    <i>(chưa bao gồm phí vận chuyển)</i>
</p>
<p>Thông tin sản phẩm:</p>
<table class="table table-hover">
    <thead>
        <tr>
            <th>Tên sản phẩm</th>
            <th>Số lượng</th>
        </tr>
    </thead>
    <tbody>
        <?php  if($items) foreach ($items as $product) { ?>
            <tr>
                <td><?= $product['name'] ?></td>
                <td><?= $product['quantity'] ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<p>
    <?php if($order['transport_id']) { ?>
    	Đơn hàng vận chuyển bằng: <?= \common\models\transport\Transport::getName($order['transport_type']) ?>
    	<br/>
        Mã đơn hàng hàng: <?= $order['transport_id'] ?>
        <br/>
        Phí giao hàng: <?= number_format($order['shipfee'], 0, ',', '.') ?> VNĐ
    <?php } else { ?>
    	Đơn hàng vận chuyển bằng hình thức thủ công.
    <?php } ?>
</p>
<p>Thời gian tạo đơn hàng: <?= date('d-m-Y H:i:s', time()) ?></p>
<p>Tên người mua: <?= $address['name_contact'] ?></p>
<p>Điện thoại người mua: <?= $address['phone'] ?></p>
<p>Email người mua: <?= $address['email'] ?></p>
<p>Tên gian hàng: <?= $shop['name'] ?></p>
<p>Điện thoại gian hàng: <?= $shop['phone'] ?></p>
<p>Email gian hàng: <?= $shop['email'] ?></p>
<p><a href="<?= __SERVER_NAME ?>/admin/order/order/index?OrderSearch[id]=<?= $order['id'] ?>">Xem chi tiết</a></p>