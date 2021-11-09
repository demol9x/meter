<?php

namespace frontend\widgets\categoryShowHome2;

use yii\base\Widget;
use common\models\product\ProductCategory;

class CategoryShowHome2Widget extends \frontend\components\CustomWidget {

    public $view = 'view';
    public $data = array();

    public function init() {
        parent::init();
    }

    public function run() {
        $this->data = ProductCategory::find()->where(['show_in_home_2' => 1, 'status' => 1])->orderBy('order ASC')->all();
        return $this->render($this->view, [
                    'data' => $this->data,
        ]);
    }

}

?>