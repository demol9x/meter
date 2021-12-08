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

            $this->setViewPath(Yii::getAlias('@root') . '/frontend/modules/shop/views');


        // custom initialization code goes here
    }

}
