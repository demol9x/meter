<?php

namespace frontend\modules\news;
use Yii;
/**
 * news module definition class
 */
class News extends \yii\base\Module {

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'frontend\modules\news\controllers';

    /**
     * @inheritdoc
     */
    public function init() {
        if (\common\components\ClaSite::isMobile()) {
            $this->controllerNamespace = 'frontend\mobile\modules\news\controllers';
            $this->setViewPath(Yii::getAlias('@root') . '/frontend/mobile/modules/news/views');
        }
        parent::init();

        // custom initialization code goes here
    }

}
