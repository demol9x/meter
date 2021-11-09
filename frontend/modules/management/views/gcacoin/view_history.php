<div class="form-create-store">
    <div class="title-form">
        <h2><img src="/images/ico-map-marker.png" alt=""> Lịch sử giao dịch </h2>
    </div>
    <div class="row box-chitiet-taikhoan" style="padding: 15px 25px;">
        <?php if (isset($history) && $history) : ?>

            <table class="tbllisting" style="margin-top:15px">
                <tbody>
                    <tr class="tblsheader">
                        <th scope="col" class="colCenter">Ngày</th>
                        <th scope="col" class="colCenter">Loại ví</th>
                        <th scope="col" class="colCenter">Số V</th>
                        <th scope="col" class="colCenter">Mô tả</th>
                        <th scope="col" class="colCenter">Số dư</th>
                        <th scope="col" class="colCenter">Mã giao dịch</th>
                    </tr>
                    <?php foreach ($history as $item) : ?>
                        <tr>
                            <td class="colCenter"><?= date('d-m-Y H:i:s', $item->created_at) ?></td>
                            <td><?= $typev = $item->getTypeCoin() ?></td>
                            <td class="colRight"><span style="padding-right: 25px"><?= (($item->gca_coin) > 0) ? '+' . formatCoin(($item->gca_coin)) : formatCoin($item->gca_coin) ?></span></td>
                            <td class="colCenter">
                                <?php
                                $data = json_decode($item->data);
                                if ($item->type == 'product') {
                                    $name = 'Sản phẩm: <b style="color: green"> ID' . $data->id . '</b>';
                                    $quantity = 'Số lượng <b style="color: green">' . $data->quantity . '</b>';
                                    $ship = 'Phí ship <b style="color: green">' . formatCoin($data->shipfee) . '</b> đ';
                                    print_r($name . '. ' . $quantity . '. ' . $ship);
                                } elseif ($item->type == 'order') {
                                    $key = 'Key: <b style="color: green">' . \common\models\order\Order::findOne($data->order_id)->key;
                                    $code = 'Mã hóa đơn <b style="color: green"> OR' . $data->order_id . '</b>';
                                    print_r($code . '. ' . $key);
                                } elseif ($item->type == 'member') {
                                    print_r($item->data);
                                } else {
                                    print_r($item->data);
                                }
                                ?>
                            </td>
                            <td>
                                <?= formatCoin($item->last_coin) . $typev ?>
                            </td>
                            <td>
                                OCOP<?= $item->id ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <a style="display: block; text-align: center; margin-top: 11px; font-weight: bold;" href="<?= \yii\helpers\Url::to(['history']) ?>">Xem tất cả</a>
        <?php endif; ?>
    </div>
</div>