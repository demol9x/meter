<?php

namespace frontend\widgets\search;

use yii\base\Widget;

class SearchWidget extends \frontend\components\CustomWidget {

    public $view = 'view';
    public $key = '';

    public function init() {
        $this->key = \Yii::$app->request->get('key', '');
        parent::init();
    }

    public function run() {
        //
        return $this->render($this->view, [
                    'key' => $this->key
        ]);
    }

}

?>