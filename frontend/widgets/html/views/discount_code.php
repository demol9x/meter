<style>
    .discount_code .inputf {
        padding: 10px 20px;
    }

    .discount_code .inputf input {
        border: 6px solid #ebebeb;
        border-radius: 6px;
        height: 38px;
        margin-right: 20px;
        margin-left: 15px;
    }

    .discount_code .inputf .ckechf {
        display: inline-block;
        background: #dbbf6d;
        padding: 7px 20px;
        border-radius: 6px;
        color: #fff;
        font-weight: bold;
        cursor: pointer;
    }

    .note-inputf {
        padding-left: 20px;
    }

    .note-inputf .error {
        color: red;
    }

    .note-inputf .error {
        color: red;
    }

    .note-inputf .success {
        color: green;
    }
</style>
<div class="discount_code">
    <div class="inputf">
        <span>Bạn có mã giảm giá từ doanh nghiệp:</span> <input type="text" class="input-s" placeholder="Nhập mã giảm giá"> <span class="ckechf" data-shop="<?= $shop['id'] ?>" data-href="<?= \yii\helpers\Url::to(['/product/shoppingcart/check-code', 'shop_id' => $shop['id']]) ?>">Áp dụng</span><span class="note-inputf"></span>
        <input type="hidden" class="input-r svtotal-shop-gg" id="total-gg-<?= $shop['id'] ?>" data-price="0" name="discount_code[<?= $shop['id'] ?>]">
    </div>
</div>