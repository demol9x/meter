<?php

use common\models\product\ProductAttribute;
use common\models\product\ProductAttributeOption;

if (isset($model->id) && $model->id) {
    $options = ProductAttributeOption::getOptionByAttribute($model->id);
} else {
    $options = [];
}
?>
<div class="col-md-12">
    <div class="header">
        <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
            <b>Giá trị</b>
        </div>
        <div class="col-md-1 col-sm-1 col-xs-12 form-group has-feedback">
            <b>Thứ tự</b>
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback">
            <b>Mã bên phần mềm</b>
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback">
            <b>Mở rộng</b>
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback">
            <b>Giá trị mặc định</b>
        </div>
        <div class="col-md-1 col-sm-1 col-xs-12 form-group has-feedback">
            <b>&nbsp;</b>
        </div>
    </div>
    <div class="wrap-option-value">
        <?php
        if (isset($options) && $options) {
            echo $this->render('_old_option_value', [
                'model' => $model,
                'options' => $options
            ]);
        } else {
            echo $this->render('_new_option_value', [
                'model' => $model
            ]);
        }
        ?>
    </div>
    <div class="col-xs-12" style="margin-bottom: 50px">
        <button type="button" class="btn btn-info add-more-attribute-option">Thêm giá trị</button>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        var type_option = <?= (isset($model->type_option) && $model->type_option) ? $model->type_option : 0 ?>;
        if (type_option == <?= ProductAttribute::TYPE_OPTION_COLOR ?>) {
            $('.colorpicker').colorpicker();
        }

        $('.add-more-attribute-option').click(function () {
            var stt = $('.wrap-option-value .item').length;
            stt++;

            var html = '<div class="item">';

            html += '<div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">';
            html += '<input type="text" name="ProductAttributeOption[new][' + stt + '][value]" class="form-control">';
            html += '</div>';

            html += '<div class="col-md-1 col-sm-1 col-xs-12 form-group has-feedback">';
            html += '<input type="text" name="ProductAttributeOption[new][' + stt + '][sort_order]" class="form-control">';
            html += '</div>';
            
            html += '<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback">';
            html += '<input type="text" name="ProductAttributeOption[new][' + stt + '][code_app]" class="form-control">';
            html += '</div>';

            html += '<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback">';
            if (type_option == <?= ProductAttribute::TYPE_OPTION_COLOR ?>) {
                html += '<input type="text" name="ProductAttributeOption[new][' + stt + '][ext]" class="form-control colorpicker' + stt + '">';
            } else {
                html += '<input type="text" name="ProductAttributeOption[new][' + stt + '][ext]" class="form-control">';
            }
            html += '</div>';

            html += '<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback">';
            html += '<div class="radio">';
            html += '<label>';
            html += '<input type="radio" value="n-' + stt + '" name="ProductAttributeOption[default_value]" /> Chọn';
            html += '</label>';
            html += '</div>';
            html += '</div>';

            html += '<div class="col-md-1 col-sm-1 col-xs-12 form-group has-feedback">';
            html += '<button type="button" class="btn btn-danger btn-remove-attribute-option">Xóa</button>';
            html += '</div>';

            html += '</div>';

            $('.wrap-option-value').append(html);
            $('.colorpicker' + stt).colorpicker();
        });

        jQuery(document).on('click', '.btn-remove-attribute-option', function () {
            var length = jQuery('.wrap-option-value').find('.item').length;
            if (length > 1) {
                var thi = jQuery(this);
                if (jQuery(thi).closest('.item').hasClass('opupdate')) {
                    jQuery('.wrap-option-value').append('<input name="ProductAttributeOption[delete][' + jQuery(thi).closest('.item').attr('id') + ']" type="hidden" value="' + jQuery(thi).closest('.item').attr('id') + '">');
                }
                jQuery(thi).closest('.item').remove();
                if (length == 2) {
                    jQuery('.wrap-option-value').find('.item').find('.btn-remove-attribute-option').fadeOut('fast');
                }
            }
            return false;
        });

    });

</script>