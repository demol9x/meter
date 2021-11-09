<?php

namespace frontend\components;

use yii\base\Widget;
use ReflectionClass;
use Yii;

class CustomWidget extends Widget {

    public function init() {
        //
        parent::init();

        // custom initialization code goes here
    }

    public function getViewPath() {
        $class = new ReflectionClass($this);
        if (\common\components\ClaSite::isMobile()) {
            return dirname($class->getFileName()) . DIRECTORY_SEPARATOR . 'views_mobile';
        } else {
            return dirname($class->getFileName()) . DIRECTORY_SEPARATOR . 'views';
        }
    }

}
