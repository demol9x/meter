<?php

namespace frontend\modules\management;

use Yii;

/**
 * management module definition class
 */
class Management extends \yii\base\Module {

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'frontend\modules\management\controllers';

    /**
     * @inheritdoc
     */
    public function init() {
        if (\common\components\ClaSite::isMobile()) {
            $this->controllerNamespace = 'frontend\mobile\modules\management\controllers';
            $this->setViewPath(Yii::getAlias('@root') . '/frontend/mobile/modules/management/views');
        }

        $this->layout = 'main';

        parent::init();

        // custom initialization code goes here
    }

    public function beforeAction($action) {
        if (\common\components\ClaSite::isMobile()) {
            Yii::$app->view->dynamicPlaceholders = [
                'asset' => 'AppAssetManagementMobile'
            ];
        } else {
            Yii::$app->view->dynamicPlaceholders = [
                'asset' => 'AppAssetManagement'
            ];
        }
        // Yii::$app->view->dynamicPlaceholders = [
        //         'asset' => 'AppAssetManagement'
        //     ];
        return parent::beforeAction($action);
    }

}
