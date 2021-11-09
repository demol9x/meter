<?php

namespace frontend\widgets\review;

use common\models\review\CustomerReviews;
use yii\base\Widget;
use yii\helpers\Html;

class ReviewWidget extends \frontend\components\CustomWidget {

    public $model;
    public $view = 'view';
    public $limit = 1;

    public function init() {
        parent::init();
    }

    public function run() {
        $data = CustomerReviews::getCustomerReview();
        return $this->render($this->view, [
            'data' => $data
        ]);
    }

}

?>