<?php

namespace frontend\modules\search;
use Yii;
/**
 * search module definition class
 */
class Search extends \yii\base\Module {

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'frontend\modules\search\controllers';

    /**
     * @inheritdoc
     */
    public function init() {
        if (\common\components\ClaSite::isMobile()) {
            $this->controllerNamespace = 'frontend\mobile\modules\search\controllers';
            $this->setViewPath(Yii::getAlias('@root') . '/frontend/mobile/modules/search/views');
        }
        parent::init();

        // custom initialization code goes here
    }

}
