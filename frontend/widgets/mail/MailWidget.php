<?php

namespace frontend\widgets\mail;

use yii\base\Widget;
use common\models\product\Product;

class MailWidget extends Widget {

    public $view = 'view';
    public $input = [];

    public function init() {
        parent::init();
    }

    public function run() {
        //
        return $this->render($this->view, $this->input);
    }

}

?>