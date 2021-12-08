<?php

namespace frontend\modules\login;
use Yii;
/**
 * login module definition class
 */
class Login extends \yii\base\Module {

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'frontend\modules\login\controllers';

    /**
     * @inheritdoc
     */
    public function init() {
            $this->setViewPath(Yii::getAlias('@root') . '/frontend/modules/login/views');

        parent::init();

        // custom initialization code goes here
    }

}
