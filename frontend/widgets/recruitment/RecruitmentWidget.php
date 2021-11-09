<?php

namespace frontend\widgets\recruitment;

use common\models\recruitment\Recruitment;
use yii\base\Widget;

class RecruitmentWidget extends \frontend\components\CustomWidget {

    public $view = 'view';
    public $limit = 0;
    public $data = [];
    public $ishot = 0;
    public $salary_min = 0;
    public $relation = 0;

    public function init() {
        parent::init();
    }

    public function run() {
        //
        $this->data = Recruitment::getRecruitment([
                    'limit' => $this->limit,
                    'ishot' => $this->ishot,
                    'salary_min' => $this->salary_min,
                    'relation' => $this->relation
        ]);
        //
        return $this->render($this->view, [
                    'data' => $this->data
        ]);
    }

}

?>