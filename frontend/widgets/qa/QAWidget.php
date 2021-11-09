<?php

namespace frontend\widgets\qa;

use common\models\qa\QA;
use yii\base\Widget;

class QAWidget extends \frontend\components\CustomWidget {

    public $view = 'view';
    public $limit = 4;
    public $data = [];
    public $ishot = 0;

    public function init() {
        parent::init();
    }

    public function run() {
        //
        $this->data = QA::getNews([
                    'limit' => $this->limit,
                    'ishot' => $this->ishot
        ]);
        //
        return $this->render($this->view, [
                    'data' => $this->data
        ]);
    }

}

?>