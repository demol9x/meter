<?php

namespace frontend\widgets\recruitmentFilter;

use Yii;
use common\models\recruitment\Recruitment;
use yii\base\Widget;

class RecruitmentFilterWidget extends \frontend\components\CustomWidget {

    public $view = 'view';
    public $data = [];
    public $locations = [];
    public $categories = [];
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
        $this->locations = Recruitment::getLocationsSiteForSearch();
        // ngành nghề
        $this->categories = Recruitment::getCategoriesSiteForSearch();
        //
        parent::init();
    }

    public function run() {
        //
        return $this->render($this->view, [
                    'locations' => $this->locations,
                    'categories' => $this->categories,
                    'keyword' => $this->keyword,
                    'category_id' => $this->category_id,
                    'location' => $this->location
        ]);
    }

}

?>