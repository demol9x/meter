<?php

use yii\helpers\Url;

$this->title = Yii::t('app', 'gca_coin');
$sale = \common\models\SaleV::getNow();
$salen = \common\models\SaleV::getNear();
?>
<style>
    .buyv {
        background: #17a349;
        color: #fff;
        text-align: center;
        padding: 4px 15px;
        opacity: 0.3;
    }

    .buyv.active {
        opacity: 1;
    }
</style>
<div class="form-create-store">
    <div class="title-form">
        <h2><img src="/images/ico-map-marker.png" alt=""> Thông tin Voucher </h2>
    </div>
    <div class="row" style="padding: 15px 25px;">
        <div class="col-md-4"><label>Số dư <?= __VOUCHER ?></label></div>
        <div class="col-md-4"><?= (isset($coin) && $coin) ? formatCoin($coin->getCoin()) : 0  ?> (<?= __VOUCHER ?>)</div>
        <div class="col-md-4" style="text-align: right;">
            <a class="buyv buyvn <?= $sale ? '' : 'active' ?>" <?= $sale ? ''  : 'href="' . Url::to(['gcacoin/recharge']) . '"'; ?>>
                <i class="fa fa-plus" aria-hidden="true" style="padding-right: 2px" style="font-size: 1em"></i>
                Thêm Voucher
            </a>
        </div>
    </div>
    <div class="row" style="padding: 15px 25px;">
        <div class="col-md-4"><label>Số dư <?= __VOUCHER_SALE ?></label></div>
        <div class="col-md-4"><?= (isset($coin) && $coin) ? formatCoin($coin->getCoinSale()) : 0  ?> (<?= __VOUCHER_SALE ?>)</div>
        <div class="col-md-4" style="text-align: right;">
            <a class="buyv buyvs <?= $sale ? 'active' : '' ?>" <?= $sale ? 'href="' . Url::to(['gcacoin/recharge-sale']) . '"'  : ''; ?>>
                <i class="fa fa-plus" aria-hidden="true" style="padding-right: 2px" style="font-size: 1em"></i>
                Thêm Voucher khuyễn mãi
            </a>
            <br/>
            <?php if ($sale) { ?>
                <i>Đang chạy chương trình nạp Voucher khuyến mãi. <a href="<?= Url::to(['gcacoin/recharge-sale']) ?>">Nạp ngay.</i>
            <?php } else if ($salen) { ?>
                <i>Chương trình nạp khuyến mãi tiếp theo sẽ bắt đầu vào <?= date('h:i:s d-m', $salen->time_start) ?></i>
            <?php } else { ?>
                <i>Hiện tại không có chương trình nạp Voucher khuyến mãi.</i>
            <?php } ?>
        </div>
    </div>
    <div class="row" style="padding: 15px 25px;">
        <div class="col-md-4"><label>Số dư <?= __VOUCHER_RED ?> khả dụng</label></div>
        <div class="col-md-4"><?= formatCoin($coin->getCoinRed() - $coin_waning)  ?> (<?= __VOUCHER_RED ?>)</div>
    </div>
    <?php if ($coin_waning > 0) { ?>
        <div class="row" style="padding: 15px 25px;">
            <div class="col-md-4"><label>Số <?= __VOUCHER_RED ?> đang chờ rút</label></div>
            <div class="col-md-4"><?= formatCoin($coin_waning)  ?> (<?= __VOUCHER_RED ?>)</div>
        </div>
    <?php } ?>
    <div class="row" style="padding: 15px 25px;">
        <div class="col-md-4"><label>Số <?= __VOUCHER_RED ?> tạm khóa</label></div>
        <div class="col-md-4"><?= formatCoin(\common\models\gcacoin\CoinConfinement::getCoinConfinement(Yii::$app->user->id))  ?> (<?= __VOUCHER_RED ?>)</div>
        <div class="col-md-4" style="text-align: right">
            <a id="coin_confinement_open" href="<?= Url::to(['/management/gcacoin/confinement']) ?>">
                <i class="fa fa-eye" aria-hidden="true" style="padding-right: 2px" style="font-size: 1em"></i>
                Chi tiết
            </a>
        </div>
    </div>
    <!-- <div class="row" style="padding: 15px 25px;">
        <div class="col-md-4">
            <label>Mã QR</label>
        </div>
        <div class="col-md-4">
            <?php
            $data = [
                'type' => 'user',
                'data' => [
                    'user_id' => Yii::$app->user->id
                ]
            ];
            ?>
            <img src="<?= \common\components\ClaQrCode::GenQrCode($data) ?>" style="width: 170px;
    height: 170px;
    border-radius: 0;">
        </div>
    </div> -->
</div>
<?= $this->render('view_history', ['history' => $history, 'title' => 'Lịch sử giao dịch']) ?>