<?php

namespace frontend\widgets\quetionAns;

use yii\base\Widget;
use common\components\ClaCategory;
use common\models\QuestionCategory;
use common\models\QuesAns;

class QuetionAnsWidget extends \frontend\components\CustomWidget {

    public $parent = 0;
    protected $data = array();
    protected $categorys = array();
    public $view = 'view'; // view of widget

    public function init() {
        // get category
        parent::init();
    }

    public function run() {
        return $this->render($this->view, [
                    'categorys' => QuestionCategory::find()->all(),
                    'data' => QuesAns::find()->all(),
                    'parent' => $this->parent,
        ]);
    }

}
