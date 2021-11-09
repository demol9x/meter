<?php

namespace frontend\widgets\productAttChangePrice;

use yii\base\Widget;
use common\models\product\ProductCategory;
use frontend\components\AttributeHelper;

class ProductAttChangePriceWidget extends \frontend\components\CustomWidget {

    public $product;
    public $attribute_set_id;
    public $selecter_price = '.product-detail .product-price .pricetext'; // theo chuan jQuery
    public $currency_unit = ''; // đơn vị tiền tệ hiển thị chỗ giá
    public $view = 'view'; // view of widget  

    public function init() {
        parent::init();
    }

    public function run() {
        //
        if ($this->product && !$this->attribute_set_id) {
            $category = ProductCategory::findOne($this->product['category_id']);
            $this->attribute_set_id = ($category) ? $category->attribute_set_id : 0;
        }
        if ($this->attribute_set_id) {
            $attributeHelper = new AttributeHelper();
            $attributes = $attributeHelper->getChangePriceProduct($this->product['id'], $this->attribute_set_id);
            return $this->render($this->view, array(
                'attributes' => $attributes,
                'product' => $this->product,
                'selecter_price' => $this->selecter_price,
                'currency_unit' => $this->currency_unit,
            ));
        }
        //
    }

}
