<?php

namespace frontend\widgets\qa;

use common\models\qa\QACategory;
use yii\base\Widget;

class QAMenuWidget extends \frontend\components\CustomWidget {

    public $view = 'view_menu';
    public $id = 0;
    public $limit = 0;
    public $data = [];
    public $ishot = 0;

    public function init() {
        parent::init();
    }

    public function run() {
        //
        $this->data = QACategory::getDataById($this->id);
        if(isset($this->data['active'])) {
            unset($this->data['active']);
        }
        //
        return $this->render($this->view, [
                    'data' => $this->data
        ]);
    }

}

?>