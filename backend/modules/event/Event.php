<?php

namespace backend\modules\event;

/**
 * CustomerReview module definition class
 */
class Event extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\event\controllers';
    public $defaultRoute = 'event/index';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
