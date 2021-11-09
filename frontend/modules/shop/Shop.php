<?php

namespace frontend\modules\shop;
use Yii;
/**
 * product module definition class
 */
class Shop extends \yii\base\Module {

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'frontend\modules\shop\controllers';

    /**
     * @inheritdoc
     */
    public function init() {
        if (\common\components\ClaSite::isMobile()) {
            $this->controllerNamespace = 'frontend\mobile\modules\shop\controllers';
            $this->setViewPath(Yii::getAlias('@root') . '/frontend/mobile/modules/shop/views');
        }
        parent::init();

        // custom initialization code goes here
    }

}
