<?php

use backend\components\ProductCategoryAttributeHelper;
use common\models\product\ProductAttribute;
use common\models\product\ProductCategory;
use common\models\product\ProductAttributeSet;
use common\models\product\ProductConfigurable;

$attribute_set_id = 1;
if ($attribute_set_id) {
    // attribute normal
    echo ProductCategoryAttributeHelper::attRenderHtmlAll($attribute_set_id, $model);
}
?>
<style type="text/css">
    .select-two{
        width: 600px;
    }
</style>
<script>
    jQuery(document).ready(function () {
        jQuery(".select-two").select2({
            placeholder: "",
            allowClear: true
        });
    });
</script>
