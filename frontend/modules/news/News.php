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
        $this->setViewPath(Yii::getAlias('@root') . '/frontend/modules/news/views');
        // custom initialization code goes here
    }

}
