<?php
/**
 * Created by PhpStorm.
 * User: trung
 * Date: 12/1/2021
 * Time: 10:31 AM
 */
?>
<?php if ($orders): ?>
    <?php foreach ($orders as $order): ?>
        <div class="item-info-donhang  " id="box-b1-632">
            <?php foreach ($order['items'] as $item): ?>
                <div class="table-donhang table-shop">
                    <table>
                        <tbody>
                        <tr>
                            <td width="100">
                                <div class="img">
                                    <a target="_blank" href="<?= \yii\helpers\Url::to(['/product/product/detail', 'id' => $item['product_id']]) ?>">
                                        <img src="<?= \common\components\ClaHost::getImageHost() . $item['avatar_path'] . $item['avatar_name'] ?>"
                                             alt="<?= $item['name'] ?>">
                                    </a>
                                </div>
                            </td>
                            <td class="vertical-top" width="250">
                                <h2>
                                    <a target="_blank" href="<?= \yii\helpers\Url::to(['/product/product/detail', 'id' => $item['product_id']]) ?>"><?= $item['name'] ?></a>
                                </h2>
                                <span class="quantity">x<?= (int)$item['quantity'] ?></span>
                            </td>
                            <td>
                                <p class="price-donhang"><?= number_format($item['price']) ?> đ</p>
                            </td>
                            <td style="text-align: right;">
                                <p class="price-donhang">
                                    <?= number_format($item['price'] * $item['quantity']) ?> đ </p>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            <?php endforeach; ?>
            <div class="title bottom-item-info-donhang">
                <p class="code-item">Đơn hàng: <b>OR<?= $order['id'] ?></b></p>
                <div class="btn-view-shop">
                    <p>
                        Phí vận chuyển: Liên hệ </p>
                    <p>
                        Tổng tiền: <?= number_format($order['order_total']) ?> đ </p>

                </div>
                <div class="code-donhang">
                    <?php if ($order['status'] == 1): ?>
                        <a class="click cancer" onclick="cancer(<?= $order['id'] ?>)">Hủy đơn hàng</a>
                    <?php endif; ?>
                    <a class="open-popup-link open-popup-link-b" data-id="632" href="#donhang-chuanbi">Chi tiết đơn hàng</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>