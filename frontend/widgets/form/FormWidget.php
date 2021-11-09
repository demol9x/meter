<?php

namespace frontend\widgets\form;

use yii\base\Widget;

class FormWidget extends \frontend\components\CustomWidget {

    public $input = [];
    public $view = 'view';
   
    public function init() {
        parent::init();
    }
    public function run() {
        $this->input['url'] = isset($this->input['url']) ? $this->input['url'] : \yii\helpers\Url::to(['/upload/uploadfile']);
        return $this->render($this->view, $this->input);
    }

}
