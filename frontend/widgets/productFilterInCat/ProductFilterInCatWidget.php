<?php

namespace frontend\widgets\productFilterInCat;

use Yii;
use yii\base\Widget;
use common\models\product\ProductCategory;
use frontend\components\FilterHelper;

class ProductFilterInCatWidget extends \frontend\components\CustomWidget {

    public $view = 'view';
    public $category_id = 0;
    public $category = [];
    public $attributes = [];

    public function init() {
        //
        if ($this->category_id) {
            $category = ProductCategory::findOne($this->category_id);
            if ($category && $category->attribute_set_id) {
                $filterHelper = new FilterHelper();
                $attributes = $filterHelper->getAttributesOptions($category->attribute_set_id);
                $this->category = $category;
                $this->attributes = $attributes;
            }
        }
        //
        parent::init();
    }

    public function run() {
        //
        return $this->render($this->view, [
            'attributes' => $this->attributes
        ]);
    }

}

?>