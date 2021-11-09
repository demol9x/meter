<?php

namespace frontend\widgets\productCombo;

use Yii;
use yii\base\Widget;
use common\models\product\Product;
use common\models\product\ProductRelation;

class ProductComboWidget extends \frontend\components\CustomWidget {

    public $view = 'view';
    public $title = '';
    public $product_id = 0;
    protected $products = [];

    public function init() {
        //
        $ids = ProductRelation::getProductIdInRel($this->product_id);
        //
        if ($ids) {
            $this->products = Product::getProductsByIds($ids, $this->product_id);
        }
        //
        parent::init();
    }

    public function run() {
        //
        return $this->render($this->view, [
                    'title' => $this->title,
                    'products' => $this->products
        ]);
    }

}

?>