<div class="form-create-store">
    <div class="title-form">
        <h2><img src="/gcaeco/images/ico-map-marker.png" alt=""> Thông tin giao dịch </h2>
    </div>
    <?php if (isset($model) && $model): ?>
        <?php if ($model->type == 'product'): ?>
        <?php $idprd = json_decode($model->data)->id; ?>
            <div class="row" style="padding: 15px 25px;">
                <div class="col-md-4"><label>Sản phẩm thanh toán</label></div>
                <div class="col-md-4"><?= \common\models\product\Product::findOne($idprd)->name ?></div>
            </div>
        <?php endif; ?>

        <?php if ($model->type == 'order'): ?>
            <?php $idodr = json_decode($model->data)->order_id; ?>
            <div class="row" style="padding: 15px 25px;">
                <div class="col-md-4"><label>Mã hóa đơn</label></div>
                <div class="col-md-4"><?= \common\models\order\Order::findOne($idodr)->key ?></div>
            </div>
        <?php endif; ?>

        <div class="row" style="padding: 15px 25px;">
            <div class="col-md-4"><label>Số tiền</label></div>
            <div class="col-md-4"><?= ($model->gca_coin > 0) ? '+' . number_format($model->gca_coin) : number_format($model->gca_coin) ?>
                gcacoin
            </div>
        </div>
        <div class="row" style="padding: 15px 25px;">
            <div class="col-md-4"><label>Ngày giao dịch</label></div>
            <div class="col-md-4"><?= date('d-m-Y',$model->created_at) ?></div>
        </div>
    <?php endif; ?>
</div>