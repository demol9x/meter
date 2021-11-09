<?php

namespace frontend\widgets\productRelation;

use Yii;
use yii\base\Widget;

class ProductRelationWidget extends \frontend\components\CustomWidget {

    public $view = 'view';
    public $title = '';
    public $product_id = 0;
    public $category_id = 0;
    public $limit = 10;
    protected $products = [];

    public function init() {
        $this->products = \common\models\product\Product::getRelationProducts([
                    'category_id' => $this->category_id,
                    'product_id' => $this->product_id,
                    'limit' => $this->limit
        ]);
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