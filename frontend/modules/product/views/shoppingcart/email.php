<?php

use yii\helpers\Url;
?>

<p>
    Thông báo đặt hàng thành công từ <a href="<?= __SERVER_NAME ?>/">OCOP</a>
</p>
<p>
    Bạn đã đặt hàng thành công với tổng chí phí đơn hàng là: <?= $orderShop['order_total'] ?>
</p>
<p>
    <?php if($orderShop['transport_id']) { ?>
        Mã đơn hàng hàng <?= (strlen($orderShop['transport_id']) > 10) ? "Giao hàng tiết kiệm" : "Giao hàng nhanh" ?>của quý khác là: <?= $orderShop['transport_id'] ?>
    <?php } ?>
</p>
<p>Thời gian đặt hàng: <?= date('d-m-Y H:i:s', time()) ?></p>