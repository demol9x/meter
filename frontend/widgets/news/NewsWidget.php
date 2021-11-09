<?php

namespace frontend\widgets\news;

use common\models\news\News;
use yii\base\Widget;

class NewsWidget extends \frontend\components\CustomWidget {

    public $view = 'view';
    public $limit = 4;
    public $data = [];
    public $ishot = 0;
    public $category_id = 0;
    public $category = [];
    public $relation = 0;
    public $isnew = 0;
    public $_id = 0;

    public function init() {
        parent::init();
    }

    public function run() {
        //
        $this->data = News::getNews([
                    'limit' => $this->limit,
                    'ishot' => $this->ishot,
                    'relation' => $this->relation,
                    'category_id' => $this->category_id,
                    'isnew' => $this->isnew,
                    '_id' => $this->_id
        ]);

        if ($this->category_id) {
            $this->category = \common\models\news\NewsCategory::getOneMuch($this->category_id);
        }

        //
        return $this->render($this->view, [
                    'data' => $this->data,
                    'category' => $this->category
        ]);
    }

}
