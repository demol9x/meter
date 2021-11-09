<?php

namespace frontend\widgets\menuCategory;

use yii\base\Widget;
use common\models\product\ProductCategory;

class MenuCategoryInShopWidget extends \frontend\components\CustomWidget {

    public $view = 'view';
    public $shop_id = 0;
    public $data = array();

    public function init() {
        parent::init();
    }

    public function run() {
        $this->data = ProductCategory::getItemInShop($this->shop_id);
        return $this->render($this->view, [
                    'data' => $this->data,
        ]);
    }

}

?>