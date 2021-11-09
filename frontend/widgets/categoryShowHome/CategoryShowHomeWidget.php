<?php

namespace frontend\widgets\categoryShowHome;

use yii\base\Widget;
use common\models\product\ProductCategory;

class CategoryShowHomeWidget extends \frontend\components\CustomWidget {

    public $view = 'view';
    public $data = array();

    public function init() {
        parent::init();
    }

    public function run() {
        $this->data = ProductCategory::getShowHome();
        return $this->render($this->view, [
                    'data' => $this->data,
        ]);
    }

}

?>