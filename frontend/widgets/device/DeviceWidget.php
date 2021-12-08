<?php

namespace frontend\widgets\device;


use common\models\product\Product;
use yii\base\Widget;
use yii;

class DeviceWidget extends \frontend\components\CustomWidget {

    public $view = 'view';
    public $limit = 0;
    public $data = [];
    public $sort= 'new';

    public function init() {
        $this->sort = Yii::$app->request->get('sort', $this->sort);
        $this->data = Product::getProduct(array_merge($_GET,[
            'limit' => $this->limit,
            'sort'=>$this->sort,
        ]));

        parent::init();
    }

    public function run() {

        return $this->render($this->view, [
            'data'=>$this->data
        ]);
    }

}

?>