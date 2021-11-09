<?php

use common\models\product\ProductAttribute;
?>
<?php
if (isset($options) && count($options)) {
    foreach ($options as $key => $opt) {
        ?>
        <div class="item opupdate" id="<?= $opt['id']; ?>">
            <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                <input type="text" name="ProductAttributeOption[update][<?= $opt['id']; ?>][value]" value="<?= $opt['value']; ?>" class="form-control">
            </div>
            <div class="col-md-1 col-sm-1 col-xs-12 form-group has-feedback">
                <input type="text" name="ProductAttributeOption[update][<?= $opt['id']; ?>][sort_order]" value="<?= $opt['sort_order']; ?>" class="form-control">
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback">
                <input type="text" name="ProductAttributeOption[update][<?= $opt['id']; ?>][code_app]" value="<?= $opt['code_app']; ?>" class="form-control">
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback">
                <?php if ($model->type_option == ProductAttribute::TYPE_OPTION_COLOR) { ?>
                    <input type="text" name="ProductAttributeOption[update][<?= $opt['id']; ?>][ext]" value="<?= $opt['ext']; ?>" class="form-control colorpicker">
                <?php } else { ?>
                    <input type="text" name="ProductAttributeOption[update][<?= $opt['id']; ?>][ext]" value="<?= $opt['ext']; ?>" class="form-control">
                <?php } ?>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback">
                <div class="radio">
                    <label>
                        <input type="radio" value="u-<?php echo $opt['id']; ?>" <?= $model->default_value == $opt['index_key'] ? 'checked' : '' ?> name="ProductAttributeOption[default_value]"> Chọn
                    </label>
                </div>
            </div>
            <div class="col-md-1 col-sm-1 col-xs-12 form-group has-feedback">
                <button type="button" class="btn btn-danger btn-remove-attribute-option">Xóa</button>
            </div>
        </div>
        <?php
    }
}
?>