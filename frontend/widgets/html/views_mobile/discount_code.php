<style>
    body .title-user-shop {
        margin-bottom: 15px;
    }

    .discount_code .inputf input {
        border: 6px solid #ebebeb;
        border-radius: 6px;
        height: 38px;
        margin-right: 0px;
        margin-left: 0px;
    }

    .discount_code .inputf .ckechf {
        display: inline-block;
        background: #dbbf6d;
        padding: 7px 15px;
        border-radius: 6px;
        color: #fff;
        font-weight: bold;
        cursor: pointer;
        width: calc(100% - 202px);
        text-align: center;
    }

    .note-inputf {
        text-align: center;
        margin-top: 10px;
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
        <input type="text" class="input-s" placeholder="Nhập mã giảm giá">
        <span class="ckechf" data-shop="<?= $shop['id'] ?>" data-href="<?= \yii\helpers\Url::to(['/product/shoppingcart/check-code', 'shop_id' => $shop['id']]) ?>">Kiểm tra</span>
        <p class="note-inputf"></p>
        <input type="hidden" class="input-r svtotal-shop-gg" id="total-gg-<?= $shop['id'] ?>" data-price="0" name="discount_code[<?= $shop['id'] ?>]">
    </div>
</div>