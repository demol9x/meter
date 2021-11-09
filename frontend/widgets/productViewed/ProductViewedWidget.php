<?php

namespace frontend\widgets\productViewed;

use Yii;
use yii\base\Widget;
use common\components\ClaLid;
use common\models\product\Product;

class ProductViewedWidget extends \frontend\components\CustomWidget {

    public $view = 'view';
    public $title = '';
    public $products = [];
    public $_product_id = 0;

    public function init() {
        $ids = ClaLid::getCookie(Product::PRODUCT_VIEWED);
        if (isset($ids) && $ids) {
            $ids = json_decode($ids);
            $this->products = Product::getProductsByIds($ids, $this->_product_id);
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