<?php

namespace frontend\widgets\productNewOnDay;

use yii\base\Widget;
use common\models\product\ProductCategory;

class ProductNewOnDayWidget extends \frontend\components\CustomWidget {

    public $view = 'view';
    public $data = array();

    public function init() {
        parent::init();
    }

    public function run() {
        $this->data = ProductCategory::find()->where(['isnew' => 1, 'status' => 1])->orderBy('order, id desc')->all();
        return $this->render($this->view, [
                    'data' => $this->data,
        ]);
    }

}

?>