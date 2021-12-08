<?php
$product_attribute = \common\models\product\ProductAttribute::find()->all();
$product_attribute_select = $model->getData();

?>
<style>
    .select2-container {
        width: 100% !important;
    }

    .body-attribute {
        margin-top: 10px;
    }

    .body-attribute-value {
        margin-top: 15px;
    }

    .body-attribute-value label {
        margin-bottom: 5px !important;
    }
</style>
<div class="x_title body-attribute-value">
    <div class="col-md-10">
        <select name="attributes" id="product_attribute" multiple="multiple">
            <?php if (isset($product_attribute) && $product_attribute): ?>
                <?php foreach ($product_attribute as $attribute): ?>
                    <option value="<?= $attribute->id ?>" <?= isset($product_attribute_select[$attribute['id']]) && $product_attribute_select[$attribute['id']] ? 'selected' : '' ?>><?= $attribute->name ?></option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>
    </div>
    <div class="col-md-2">
        <a class="btn btn-success" onclick="add_attribute()">Thêm</a>
    </div>
    <div class="clearfix"></div>
</div>
<div class="bd">
    <?php if (isset($product_attribute_select) && $product_attribute_select): ?>
        <?php foreach ($product_attribute_select as $key => $product_attribute_value):
            $attribute_items = \common\models\product\ProductAttributeItem::find()->where(['attribute_id' => $key])->all();
            ?>
            <div class="body-attribute-value">
                <label class="control-label"><?= \common\models\product\ProductAttribute::findOne($key)->name ?></label>
                <select class="attribute-value" data-attribute_id="<?= $key ?>" name="product_attribute[<?= $key ?>][]"
                        aria-required="true" multiple="multiple">
                    <?php if (isset($attribute_items) && $attribute_items): ?>
                        <?php foreach ($attribute_items as $item): ?>
                            <option value="<?= $item['id'] ?>" <?= in_array($item['id'], $product_attribute_value) ? 'selected' : '' ?>><?= $item['value'] ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<a class="btn btn-primary" style="margin-top: 15px" onclick="genAttribute()">Tạo biến thể sản phẩm</a>
<div class="product-variable">

</div>

<script>
    jQuery(document).ready(function () {
        jQuery("#product_attribute").select2({
            placeholder: "Chọn bộ thuộc tính",
            allowClear: true,
        });
        jQuery(".attribute-value").select2({
            placeholder: "Chọn giá trị cho bộ thuộc tính",
            allowClear: true,
        });
    });


    function add_attribute() {
        var product_attribute_select = $('#product_attribute').val();
        $.ajax({
            url: '<?= \yii\helpers\Url::to(['/product/product/load-attribute']) ?>',
            type: 'post',
            data: {
                product_attribute_select: product_attribute_select,
                product_id: '<?= $model->id ? $model->id : '' ?>'
            },
            success: function (response) {
                console.log(response);
                $('.bd').empty().append(response);
            },
            error: function () {
            }
        });
    }

    function genAttribute() {
        var request = {};
        $(".attribute-value").each(function (index) {
            var value = $(this).val();
            var key = $(this).data('attribute_id');
            if(value){
                request[key] = value;
            }
        });
        $.ajax({
            url: '<?= \yii\helpers\Url::to(['/product/product/set-variable']) ?>',
            type: 'post',
            data: {
                data: request,
                product_id: '<?= $model->id ? $model->id : '' ?>'
            },
            success: function (response) {
                console.log(response);
                $('.product-variable').empty().append(response)
            },
            error: function () {
            }
        });
    }

</script>