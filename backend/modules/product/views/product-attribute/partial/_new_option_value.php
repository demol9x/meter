<?php

use common\models\product\ProductAttribute;
?>
<div class="item">
    <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
        <input type="text" name="ProductAttributeOption[new][1][value]" class="form-control">
    </div>
    <div class="col-md-1 col-sm-1 col-xs-12 form-group has-feedback">
        <input type="text" name="ProductAttributeOption[new][1][sort_order]" class="form-control">
    </div>
    <div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback">
        <input type="text" name="ProductAttributeOption[new][1][code_app]" class="form-control">
    </div>
    <div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback">
        <?php if ($model->type_option == ProductAttribute::TYPE_OPTION_COLOR) { ?>
            <input type="text" name="ProductAttributeOption[new][1][ext]" class="form-control colorpicker">
        <?php } else { ?>
            <input type="text" name="ProductAttributeOption[new][1][ext]" class="form-control">
        <?php } ?>
    </div>
    <div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback">
        <div class="radio">
            <label>
                <input type="radio" value="n-1" name="ProductAttributeOption[default_value]"> Chọn
            </label>
        </div>
    </div>
    <div class="col-md-1 col-sm-1 col-xs-12 form-group has-feedback">
        <button type="button" class="btn btn-danger btn-remove-attribute-option">Xóa</button>
    </div>
</div>