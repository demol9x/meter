<?php

namespace frontend\modules\package;
use Yii;
/**
 * news module definition class
 */
class Package extends \yii\base\Module {

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'frontend\modules\package\controllers';

    /**
     * @inheritdoc
     */
    public function init() {

            $this->setViewPath(Yii::getAlias('@root') . '/frontend/modules/package/views');

    }

}
