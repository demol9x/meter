<?php

namespace frontend\modules\login;
use Yii;
/**
 * login module definition class
 */
class Login extends \yii\base\Module {

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'frontend\modules\login\controllers';

    /**
     * @inheritdoc
     */
    public function init() {
        if (\common\components\ClaSite::isMobile()) {
            $this->controllerNamespace = 'frontend\mobile\modules\login\controllers';
            $this->setViewPath(Yii::getAlias('@root') . '/frontend/mobile/modules/login/views');
        }
        parent::init();

        // custom initialization code goes here
    }

}
