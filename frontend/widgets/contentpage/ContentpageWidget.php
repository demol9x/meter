<?php

namespace frontend\widgets\contentpage;

use yii\base\Widget;

class ContentpageWidget extends \frontend\components\CustomWidget {

    public $view = 'view';
    public $page_id = 0;

    public function init() {
        parent::init();
    }

    public function run() {
        //
        $model = \common\models\news\ContentPage::findOne($this->page_id);
        //
        return $this->render($this->view, [
                    'model' => $model
        ]);
    }

}

?>