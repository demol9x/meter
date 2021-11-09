<?php

use yii\helpers\Url;
?>

<p>
    Thông báo đặt hàng thành công từ <a href="<?= __SERVER_NAME ?>/">OCOP</a>
</p>
<p>
    Bạn đã đặt hàng thành công với tổng chí phí đơn hàng là: <?= $order['order_total'] ?>
</p>
<p>
    <?php if($order['transport_id']) { ?>
        Mã đơn hàng hàng <?= (strlen($order['transport_id']) > 10) ? "Giao hàng tiết kiệm" : "Giao hàng nhanh" ?>của quý khác là: <?= $order['transport_id'] ?>
    <?php } ?>
</p>
<p>Thời gian đặt hàng: <?= date('d-m-Y H:i:s', time()) ?></p>