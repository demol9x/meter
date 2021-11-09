<?php

$this->title = 'Lịch sử giao dịch';
?>

<div class="form-create-store">
    <div class="title-form">
        <h2><img src="/images/ico-map-marker.png" alt=""> <?= $this->title  ?></h2>
    </div>
    <div class="row box-chitiet-taikhoan" style="padding: 15px 25px;">
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
                <?php if (isset($history) && $history) : ?>
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
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<style>
    .tbllisting {
        border-collapse: collapse;
        font-family: Arial, Tahoma;
        background: #fff;
        font-weight: bold;
        width: 100%;
    }

    .box-chitiet-taikhoan .tbllisting tr td:first-child,
    .box-chitiet-taikhoan .tbllisting tr th:first-child {
        border-radius: 4px 0 0 4px;
    }

    .box-chitiet-taikhoan .tbllisting th {
        background: #dbbf6d;
        font-weight: bold;
        color: #fff;
    }

    .box-chitiet-taikhoan .tbllisting td,
    .box-chitiet-taikhoan .tbllisting th {
        padding: 10px 15px;
        text-align: center;
        border: 1px solid #eee;
    }

    .colCenter {
        text-align: center !important;
        font-size: 12px;
        padding: 10px;
    }

    .box-chitiet-taikhoan .tbllisting td {
        background: #fff;
        color: #222;
    }

    .box-chitiet-taikhoan .tbllisting td,
    .box-chitiet-taikhoan .tbllisting th {
        padding: 10px 15px;
        text-align: center;
        border: 1px solid #eee;
    }
</style>