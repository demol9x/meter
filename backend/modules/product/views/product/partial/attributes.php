<?php

use backend\components\ProductAttributeHelper;
use common\models\product\ProductAttribute;
use common\models\product\ProductCategory;
use common\models\product\ProductAttributeSet;
use common\models\product\ProductConfigurable;

$category = ProductCategory::findOne($model->category_id);
$attribute_set_id = ($category) ? $category->attribute_set_id : 0;
if ($attribute_set_id) {

    // attribute normal
    echo ProductAttributeHelper::attRenderHtmlAll($attribute_set_id, $model);
    
    // attribute change price
    if (count($attributes_changeprice)) {
        echo $this->render('subtabchangeprice', array('model' => $model, 'attributes_changeprice' => $attributes_changeprice));
    }
    
    //
    $proConfig = ProductConfigurable::findOne($model->id);
    $proConfig = '';
    $att_cf_ids = array();
    if ($proConfig) {
        if ($proConfig->attribute1_id > 0) {
            $att_cf_ids[] = $proConfig->attribute1_id;
        }
        if ($proConfig->attribute2_id > 0) {
            $att_cf_ids[] = $proConfig->attribute2_id;
        }
        if ($proConfig->attribute3_id > 0) {
            $att_cf_ids[] = $proConfig->attribute3_id;
        }
    }
    // attribute configurable
    $attributes_cf = ProductAttributeSet::getAttributeConfigurable($attribute_set_id, $att_cf_ids);
}
