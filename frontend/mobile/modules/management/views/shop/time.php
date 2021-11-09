<?php

use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\shop\ShopSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Gói gia hạn';
$this->params['breadcrumbs'][] = $this->title;
$lm = $shop->time_limit_type == 0 ? false : true;
?>
<div class="form-create-store">
    <div class="title-form">
        <h2>
            <img src="<?= Yii::$app->homeUrl ?>images/ico-danhgia.png" alt=""> <?= $this->title ?>
        </h2>
    </div>
    <div class="review-store">
        <div class="row">
            <div class="col-md-4 col-xs-6"><label>Số dư V</label>: <?= formatMoney($coin->getCoin())  ?> (V)</div>
            <div class="col-md-4 col-xs-6" style="text-align: right">
                <a href="<?= Url::to(['gcacoin/recharge']) ?>" id="payment_method_open" class="click">
                    <i class="fa fa-plus" aria-hidden="true" style="padding-right: 2px font-size: 1em; margin-bottom: 10px"></i>
                    Thêm Voucher
                </a>
            </div>
            <div class="col-md-12">
                <label style="float: left;width: 170px">Thời hạn hoạt động:</label>
                <?php if (!$lm) { ?>
                    <p>Không giới hạn</p>
                <?php } else { ?>
                    <p>Đến <?= date('H:i:s d-m-Y', $shop->time_limit) ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="box-package">
            <?php if ($lm) { ?>
                <p style="clear:both">Mua gói giới hạn để tăng thời gian hoạt động.</p>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Tên gói</th>
                            <th>Thời gian</th>
                            <th>Phí (V)</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($package) foreach ($package as $item) { ?>
                            <tr></tr>
                            <td class="name"><?= $item['name'] ?></td>
                            <td class="time"><?= $item['time'] == 0 ? 'Không giới hạn' : formatMoney($item['time'] / 24 / 60 / 60) ?> ngày</td>
                            <td class="price"><?= formatMoney($item['coin']) ?> V</td>
                            <td><a data-confirm="Xác nhận mua gói gia hạn <?= $item['name'] ?>." href="<?= Url::to(['/management/shop/buy-package', 'id' => $item->id]) ?>">Mua</a></td>
                            </li>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } ?>
        </div>
    </div>
</div>
<div class="form-create-store">
    <div class="title-form">
        <h2><img src="/images/ico-map-marker.png" alt=""> Lịch sử gia hạn</h2>
    </div>
    <div class="row box-chitiet-taikhoan" style="padding: 15px 25px;">
        <table class="tbllisting" style="margin-top:15px">
            <tbody>
                <tr class="tblsheader">
                    <th scope="col" class="colCenter">Ngày</th>
                    <th scope="col" class="colCenter">Số V</th>
                    <th scope="col" class="colCenter">Mô tả</th>
                    <th scope="col" class="colCenter">Mã giao dịch</th>
                </tr>
                <?php if (isset($history) && $history) : ?>
                    <?php foreach ($history as $item) : ?>
                        <tr>
                            <td class="colCenter"><?= date('d-m-Y H:i:s', $item->created_at) ?></td>
                            <td class="colRight"><span style="padding-right: 25px"><?= (($item->gca_coin) > 0) ? '+' . formatMoney(($item->gca_coin)) : formatMoney($item->gca_coin) ?>V</span></td>
                            <td class="colCenter">
                                <?php
                                $data = json_decode($item->data);
                                if ($item->type == 'product') {
                                    $name = 'Sản phẩm: <b style="color: green"> ID' . $data->id . '</b>';
                                    $quantity = 'Số lượng <b style="color: green">' . $data->quantity . '</b>';
                                    $ship = 'Phí ship <b style="color: green">' . formatMoney($data->shipfee) . '</b> đ';
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