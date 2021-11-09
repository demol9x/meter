<?php

use common\components\ClaHost;
$siteinfo = common\components\ClaLid::getSiteinfo();
$shop->address = $shop->address.', '.$shop->ward_name.', '.$shop->district_name.', '.$shop->province_name;
?>
<div id="wrap-print-order-border" style="padding: 15px;">
    <div class="col-xs-3">
        <img style="width: 170px;" src="<?= $siteinfo['logo'] ?>" />
    </div>
    <div class="col-xs-5" style="text-align: center;">
        <h2 class="help-text-print">Hóa đơn in tại gian hàng ocopmart.org</h2>
        <p>Liên hệ: <?= $siteinfo['phone'] ?></p>
    </div>
    <div class="col-xs-4">
        <p>
            <?= $siteinfo->company ?>
            <br/>
            <?= $siteinfo->address ?>
        </p>
    </div>
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-6">
                <p><b>Tên gian hàng</b>: <?= $shop->name ?></p>
                <p><b>Tên chủ gian hàng</b>: <?= $shop->name_contact ?></p>
                <p><b>Địa chỉ gian hàng</b>: <?= $shop->address ?></p>
                <p><b>Tên khách</b>: <?= $model->name ?></p>
                <p><b>Địa chỉ</b>: <?= $model->address ?></p>
                <p><b>Mã đơn hàng</b>: OR<?= $model->id ?></p>
            </div>
            <div class="col-xs-6">
                <p><b>Điện thoại gian hàng</b>: <?= $shop->phone ?></p>
                <p><b>Email gian hàng</b>: <?= $shop->email ?></p>
                <p>&nbsp;</p>
                <p><b>Điện thoại</b>: <?= $model->phone ?></p>
                <p><b>Email</b>: <?= $model->email ?></p>
            </div>
        </div>
    </div>
    <table class="table table-bordered" id="table-order">
        <thead>
            <tr>
                <th>Tên</th>
                <th>Giá tiền</th>
                <th>SL</th>
                <th>Tổng tiền</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $total_price = 0;
            foreach ($products as $product) {
                $total_item =  $product['price'] * $product['quantity'];
                $total_price += $total_item;
                ?>
                <tr>
                    <td><?= $product['product_name'] ?></td>
                    <td><?= number_format($product['price'], 0, ',', '.') ?> đ</td>
                    <td><?= $product['quantity'] ?></td>
                    <td><?= number_format($total_item, 0, ',', '.') ?> đ</td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
    <div class="clearfix"></div>
    <p class="pull-right text-result">
        <i class="fa fa-money" style="width: 15px;"></i> 
        <span>
            Tổng tiền đơn hàng: 
        </span>
        <b style="color: red"><?= number_format($total_price, 0, ',', '.') ?> đ</b>
    </p>

    <div class="clearfix"></div>
    <p class="pull-right text-result">
        <i class="fa fa-money" style="width: 15px;"></i> 
        <span>
            Phí ship: 
        </span>
        <b style="color: red"><?= ($model->shipfee > 0) ? number_format($model->shipfee, 0, ',', '.').' đ' : 'Liên hệ' ?></b>
    </p>
    <div class="clearfix"></div>
    <p class="pull-right text-result">
        <i class="fa fa-money" style="width: 15px;"></i> 
        <span>
            Tổng tiền thanh toán: 
        </span>
        <?php
        $price_real = $total_price - $model->money_customer_transfer + $model->shipfee;
        ?>
        <b style="color: red"><?= number_format($price_real, 0, ',', '.') ?> đ</b>
    </p>
    <div class="clearfix"></div>
</div>
