<?php

namespace frontend\widgets\product;

use Yii;
use yii\base\Widget;
use common\models\product\Product;

class ProductWidget extends \frontend\components\CustomWidget {

    public $limit = 10;
    public $view = 'view';
    public $ishot = 0;
    public $other = [];
    protected $products = [];

    public function init() {
        $this->products = Product::getProduct([
            'limit' => $this->limit,
            'ishot' => $this->ishot
        ]);
        //
        parent::init();
    }

    public function run() {
        //
        return $this->render($this->view, [
                    'products' => $this->products,
                    'other' => $this->other,
        ]);
    }

}

?>