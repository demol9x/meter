<?php

namespace frontend\widgets\recruitmentFilterLeft;

use Yii;
use common\models\recruitment\Recruitment;
use yii\base\Widget;

class RecruitmentFilterLeftWidget extends \frontend\components\CustomWidget {

    public $view = 'view';
    public $data = [];
    public $locations = [];
    public $categories = [];
    public $skills = [];
    // tìm kiếm
    public $keyword = '';
    public $category_id = 0;
    public $location = 0;

    public function init() {
        // keyword
        $this->keyword = Yii::$app->request->get('k', '');
        // category_id
        $this->category_id = Yii::$app->request->get('c', 0);
        // location
        $this->location = Yii::$app->request->get('l', 0);

        // địa điểm
        $this->locations = Recruitment::getLocationsSite([
                    'keyword' => $this->keyword,
                    'category_id' => $this->category_id,
                    'location' => $this->location
        ]);
        // ngành nghề
        $this->categories = Recruitment::getCategoriesSite([
                    'keyword' => $this->keyword,
                    'category_id' => $this->category_id,
                    'location' => $this->location
        ]);
        // kĩ năng
        $this->skills = Recruitment::getSkillsSite([
                    'keyword' => $this->keyword,
                    'category_id' => $this->category_id,
                    'location' => $this->location
        ]);
        //
        parent::init();
    }

    public function run() {
        //
        return $this->render($this->view, [
                    'locations' => $this->locations,
                    'categories' => $this->categories,
                    'skills' => $this->skills
        ]);
    }

}

?>