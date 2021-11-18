<?php

namespace frontend\modules\user;

use Yii;

/**
 * product module definition class
 */
class User extends \yii\base\Module {

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'frontend\modules\user\controllers';

    /**
     * @inheritdoc
     */
    public function init() {
        if (\common\components\ClaSite::isMobile()) {
            $this->controllerNamespace = 'frontend\mobile\modules\user\controllers';
            $this->setViewPath(Yii::getAlias('@root') . '/frontend/mobile/modules/user/views');
        }
        parent::init();

        // custom initialization code goes here
    }

//    public function getViewPath() {
//        if (\common\components\ClaSite::isMobile()) {
//            return 'frontend\mobile\modules\product\views';
//        } else {
//            return 'frontend\modules\product\views';
//        }
//    }

}
