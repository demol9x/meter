<?php

namespace frontend\widgets\packageFilter;

use common\models\Province;
use Yii;
use yii\base\Widget;
use  common\models\package\Package;

class PackageFilterWidget extends \frontend\components\CustomWidget {

    public $view = 'view';
    public $data = [];
    public $province = [];
    public $categories = [];
    // tìm kiếm
    public $keyword = '';
    public $province_id = 0;
    public $location = 0;

    public function init() {
        // province
        $this->province_id = Yii::$app->request->get('p', 0);
        // keyword
        $this->keyword = Yii::$app->request->get('k', '');
        // location
        $params = [
            'province_id'=> $this->province_id,
        ];
        $this->province_id = Package::getProvince_1($params);
        uasort($this->province_id, function ($a, $b) {
            if ($a['count_job'] == $b['count_job']) {
                return 0;
            }
            return ($a['count_job'] < $b['count_job']) ? 1 : -1;
        });

        // thành phố
        $this->province = Province::find()->all();
        parent::init();
    }

    public function run() {
        return $this->render($this->view, [
                    'province' => $this->province,
                    'keyword' => $this->keyword,
                    'province_id' => $this->province_id,
                    'location' => $this->location
        ]);
    }

}

?>