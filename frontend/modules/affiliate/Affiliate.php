<?php

namespace frontend\modules\affiliate;
use Yii;
/**
 * Affiliate module definition class
 */
class Affiliate extends \yii\base\Module {

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'frontend\modules\affiliate\controllers';

    /**
     * @inheritdoc
     */
    public function init() {
        
        // if (\common\components\ClaSite::isMobile()) {
        //     $this->controllerNamespace = 'frontend\mobile\modules\affiliate\controllers';
        //     $this->setViewPath(Yii::getAlias('@root') . '/frontend/mobile/modules/affiliate/views');
        // }
        parent::init();

        // custom initialization code goes here
    }

}
