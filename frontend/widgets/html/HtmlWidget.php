<?php

namespace frontend\widgets\html;

use yii\base\Widget;

class HtmlWidget extends \frontend\components\CustomWidget {

    public $input = [];
    public $view = 'view';
   
    public function init() {
        parent::init();
    }
    public function run() {
        return $this->render($this->view, $this->input);
    }

}

?>