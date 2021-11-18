<?php

namespace frontend\modules\profile;

use Yii;

/**
 * profile module definition class
 */
class Profile extends \yii\base\Module {

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'frontend\modules\profile\controllers';

    /**
     * @inheritdoc
     */
    public function init() {

            $this->setViewPath(Yii::getAlias('@root') . '/frontend/modules/profile/views');


        parent::init();

        // custom initialization code goes here
    }

    public function beforeAction($action) {
        return parent::beforeAction($action);
    }

}
