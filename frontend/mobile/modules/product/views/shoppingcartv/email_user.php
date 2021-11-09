<?php
use yii\helpers\Url;
?>
<p>
    Thông báo đặt hàng thành công từ <a href="<?= __SERVER_NAME ?>/">OCOP</a>
</p>
<p>
    Bạn đã đặt hàng thành công với tổng giá trị đơn hàng là: <?= number_format($order['order_total'], 0, ',', '.') ?> VNĐ
    <br/>
    <i>(chưa bao gồm phí vận chuyển)</i>
</p>
<p>
    <?php if($order['transport_id']) { ?>
    	Đơn hàng vận chuyển bằng:  <?= \common\models\transport\Transport::getName($order['transport_type']) ?>
    	<br/>
        Mã đơn hàng hàng: <?= $order['transport_id'] ?>
        <br/>
        Phí giao hàng: <?= number_format($order['shipfee'], 0, ',', '.') ?> VNĐ
    <?php } else { ?>
    	Đơn hàng vận chuyển bằng hình thức thủ công.
    <?php } ?>
</p>
<p>Thời gian tạo đơn hàng: <?= date('d-m-Y H:i:s', time()) ?></p>
<p><a href="<?= __SERVER_NAME ?><?= Url::to(['/management/order/view']) ?>">Xem chi tiết</a></p>