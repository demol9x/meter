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
        return dirname($class->getFileName()) . DIRECTORY_SEPARATOR . 'views';
    }

}
