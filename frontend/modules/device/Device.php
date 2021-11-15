<?php

namespace frontend\modules\device;

use Yii;

/**
 * product module definition class
 */
class User extends \yii\base\Module {

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'frontend\modules\device\controllers';

    /**
     * @inheritdoc
     */
    public function init() {
        if (\common\components\ClaSite::isMobile()) {
            $this->controllerNamespace = 'frontend\mobile\modules\device\controllers';
            $this->setViewPath(Yii::getAlias('@root') . '/frontend/mobile/modules/device/views');
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
