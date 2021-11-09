<?php

namespace frontend\modules\media;
use Yii;
/**
 * news module definition class
 */
class Media extends \yii\base\Module {

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'frontend\modules\media\controllers';

    /**
     * @inheritdoc
     */
    public function init() {
        if (\common\components\ClaSite::isMobile()) {
            $this->controllerNamespace = 'frontend\mobile\modules\media\controllers';
            $this->setViewPath(Yii::getAlias('@root') . '/frontend/mobile/modules/media/views');
        }
        parent::init();

        // custom initialization code goes here
    }

}
