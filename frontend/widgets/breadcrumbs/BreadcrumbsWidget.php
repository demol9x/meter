<?php

namespace frontend\widgets\breadcrumbs;

use yii\base\Widget;

class BreadcrumbsWidget extends \frontend\components\CustomWidget {

    public $view = 'view';

    public function init() {
        parent::init();
    }

    public function run() {
        //
        $data = \Yii::$app->params['breadcrumbs'];
        //
        return $this->render($this->view, [
                    'data' => $data
        ]);
    }

}

?>