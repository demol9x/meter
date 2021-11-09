<?php

namespace frontend\modules\recruitment;
use Yii;
/**
 * recruitment module definition class
 */
class Recruitment extends \yii\base\Module {

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'frontend\modules\recruitment\controllers';

    /**
     * @inheritdoc
     */
    public function init() {
        if (\common\components\ClaSite::isMobile()) {
            $this->controllerNamespace = 'frontend\mobile\modules\recruitment\controllers';
            $this->setViewPath(Yii::getAlias('@root') . '/frontend/mobile/modules/recruitment/views');
        }
        parent::init();

        // custom initialization code goes here
    }

}
