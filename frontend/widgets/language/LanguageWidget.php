<?php

namespace frontend\widgets\language;

use yii\base\Widget;

class LanguageWidget extends \frontend\components\CustomWidget {

    public $view = 'view';

    public function init() {
        parent::init();
    }

    public function run() {
        $current = \common\components\ClaLid::getCurrentLanguage();
        //
        return $this->render($this->view, [
                    'current' => $current
        ]);
    }

}

?>