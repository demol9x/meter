<?php

namespace frontend\widgets\productAttr;

use Yii;
use yii\base\Widget;

class ProductAttrWidget extends \frontend\components\CustomWidget {

    public $view = 'view';
    public $attr = '';
    public $limit = 16;
    public $order = "id DESC";
    public $title = "";
    public $other = [];
    public $_product = "";
    protected $products = [];

    public function init() {
        $this->products = \common\models\product\Product::getProductByAttr([
                    'attr' => $this->attr,
                    'order' => $this->order,
                    'limit' => $this->limit,
                    '_product' => $this->_product
        ]);
        //
        parent::init();
    }

    public function run() {
        //
        return $this->render($this->view, [
                    'title' => $this->title,
                    'products' => $this->products,
                    'other' => $this->other,
        ]);
    }

}

?>