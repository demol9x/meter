<?php

namespace frontend\modules\product;

use Yii;

/**
 * product module definition class
 */
class Product extends \yii\base\Module {

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'frontend\modules\product\controllers';

    /**
     * @inheritdoc
     */
    public function init() {
            $this->setViewPath(Yii::getAlias('@root') . '/frontend/modules/product/views');

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
