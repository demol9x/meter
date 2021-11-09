<?php

namespace frontend\widgets\productTopsearch;

use yii\base\Widget;
use common\models\product\ProductTopsearch;

class ProductTopsearchWidget extends \frontend\components\CustomWidget {

    public $view = 'view'; // view of widget
    public $limit = 0;
    public $data = [];

    public function init() {
        $this->data = ProductTopsearch::getTopsearch([
            'limit' => $this->limit
        ]);
        parent::init();
    }

    public function run() {
        return $this->render($this->view, [
                    'data' => $this->data,
        ]);
    }

}
