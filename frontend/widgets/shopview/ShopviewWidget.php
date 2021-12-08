<?php
namespace frontend\widgets\shopview;

use Yii;
use yii\base\Widget;
class ShopviewWidget extends \frontend\components\CustomWidget {
    public $view='view';
    public $data = [];
    public $us_wish=[];

    public function init() {
        parent::init();
    }

    public function run() {
        return $this->render($this->view, array(
            'data' => $this->data,
            'us_wish'=>$this->us_wish,
        ));
    }

}
