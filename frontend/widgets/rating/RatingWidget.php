<?php

namespace frontend\widgets\rating;

use common\models\rating\RatingImage;
use common\models\rating\RatingLike;
use Yii;
use common\models\rating\Rating;

class RatingWidget extends \frontend\components\CustomWidget
{

    public $view = 'view';
    public $limit = 5;
    public $page = 1;
    public $type = 0; // Loại đối tượng
    public $object_id = 0; // Id đối tượng
    public $data = [];
    public $title = 'Đánh giá';
    public $rating = [];
    public $images = [];
    public $total;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $this->data = $this->getData();
        $this->images = $this->getImagges();
        return $this->render($this->view, [
            'data' => $this->data,
            'type' => $this->type,
            'object_id' => $this->object_id,
            'limit' => $this->limit,
            'page' => $this->page,
            'title' => $this->title,
            'rating' => $this->rating,
            'images' => $this->images,
            'total' => $this->total,
        ]);
    }

    function getData()
    {
        $data = [];
        if ($this->object_id && $this->type) {
            $rating = Rating::getRating([
                'object_id' => $this->object_id,
                'type' => $this->type,
                'limit' => $this->limit,
                'page' => $this->page,
            ]);
            if ($rating['data']) {
                $this->total = $rating['total'];
                foreach ($rating['data'] as $rt) {
                    if (Yii::$app->user->id) {
                        $rating_like = RatingLike::find()->where(['rating_id' => $rt['id'], 'user_id' => Yii::$app->user->id])->one();
                        if ($rating_like) {
                            $rt['is_like'] = true;
                        } else {
                            $rt['is_like'] = false;
                        }
                    } else {
                        $rt['is_like'] = false;
                    }
                    $data[] = $rt;
                }
            }

        }
        return $data;
    }

    function getImagges()
    {
        if ($this->object_id && $this->type) {
            $query = RatingImage::find()->where(['type' => $this->type,'object_id' => $this->object_id])->orderBy('created_at DESC');
            $count = $query->count();
            $data = $query->asArray()->all();
            return [
                'images' => $data,
                'total' => $count
            ];
        }
        return [
            'images' => [],
            'total' => 0
        ];
    }

}

?>