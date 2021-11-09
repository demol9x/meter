<?php

namespace frontend\modules\qa;
use Yii;
/**
 * news module definition class
 */
class QA extends \yii\base\Module {

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'frontend\modules\qa\controllers';

    /**
     * @inheritdoc
     */
    public function init() {
        if (\common\components\ClaSite::isMobile()) {
            $this->controllerNamespace = 'frontend\mobile\modules\qa\controllers';
            $this->setViewPath(Yii::getAlias('@root') . '/frontend/mobile/modules/qa/views');
        }
        parent::init();

        // custom initialization code goes here
    }

}
