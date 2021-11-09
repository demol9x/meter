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
        if (\common\components\ClaSite::isMobile()) {
            $this->controllerNamespace = 'frontend\mobile\modules\profile\controllers';
            $this->setViewPath(Yii::getAlias('@root') . '/frontend/mobile/modules/profile/views');
        }
        $this->layout = 'main';

        parent::init();

        // custom initialization code goes here
    }

    public function beforeAction($action) {
        return parent::beforeAction($action);
    }

}
