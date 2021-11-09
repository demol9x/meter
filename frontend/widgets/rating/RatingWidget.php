<?php

namespace frontend\widgets\rating;

use yii\base\Widget;
use Yii;
use common\models\rating\Rating;

class RatingWidget extends \frontend\components\CustomWidget {

    public $view = 'view';
    public $limit = 1;
    public $type = 0; // Loại đối tượng
    public $object_id = 0; // Id đối tượng
    public $data = [];
    public $exist = [];
    public $ratings = [];
    public $title = '';
    public $statistic = [];
    public $avg = 0;

    public function init() {
        // check user rating object
        $this->exist = Rating::find()->where('user_id=:user_id AND type=:type AND object_id=:object_id', [
                    ':user_id' => \Yii::$app->user->getId(),
                    ':type' => $this->type,
                    ':object_id' => $this->object_id
                ])->one();
        // get all rating of object
        $this->ratings = Rating::getRatings($this->type, $this->object_id);
        $this->avg = Rating::getAvgRating($this->type, $this->object_id);
        //
        $this->statistic = $this->getStatistic($this->ratings);
        //
        parent::init();
    }

    public function run() {
        //
        return $this->render($this->view, [
                    'data' => $this->data,
                    'type' => $this->type,
                    'object_id' => $this->object_id,
                    'exist' => $this->exist,
                    'ratings' => $this->ratings,
                    'title' => $this->title,
                    'statistic' => $this->statistic,
                    'avg' => $this->avg
        ]);
    }

    public function getStatistic($data) {
        $result = [
            5 => ['count' => 0, 'percent' => 0, 'label' => Yii::t('app', 'rate_5')],
            4 => ['count' => 0, 'percent' => 0, 'label' => Yii::t('app', 'rate_4')],
            3 => ['count' => 0, 'percent' => 0, 'label' => Yii::t('app', 'rate_3')],
            2 => ['count' => 0, 'percent' => 0, 'label' => Yii::t('app', 'rate_2')],
            1 => ['count' => 0, 'percent' => 0, 'label' => Yii::t('app', 'rate_1')],
        ];
        $count = count($data);
        if (isset($data) && $data) {
            foreach ($data as $item) {
                $result[$item['rating']]['count'] ++;
            }
        }
        $onepercent = $count / 100;
        if ($onepercent) {
            foreach ($result as $star => $rating) {
                $result[$star]['percent'] = ceil($rating['count'] / $onepercent);
            }
        }
        return $result;
    }

}

?>