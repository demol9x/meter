<?php

namespace frontend\widgets\brand;

use yii\base\Widget;
use common\models\product\Product;

class BrandWidget extends Widget {

    public $view = 'view';
    public $products = [];
    public $brand_id = 0;
    public $limit = 0;
    public $title = '';
    public $brand = [];

    public function init() {
        parent::init();
    }

    public function run() {
        //
        $this->products = Product::getProductsByBrand($this->brand_id, [
                    'limit' => $this->limit
        ]);
        //
        $this->brand = \common\models\product\Brand::findOne($this->brand_id);
        //
        return $this->render($this->view, [
                    'products' => $this->products,
                    'title' => $this->title,
                    'brand' => $this->brand
        ]);
    }

}

?>