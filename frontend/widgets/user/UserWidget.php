<?php

namespace frontend\widgets\user;


use yii\base\Widget;

class UserWidget extends \frontend\components\CustomWidget {

    public $view = 'view';
    public $limit = 0;
    public $data = [];
    public $ishot = 0;

    public function init() {
        parent::init();
    }

    public function run() {

        return $this->render($this->view, [
        ]);
    }

}

?>