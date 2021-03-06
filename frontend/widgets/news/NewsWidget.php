<?php

namespace frontend\widgets\news;

use common\models\news\News;
use yii\base\Widget;

class NewsWidget extends \frontend\components\CustomWidget {

    public $view = 'view';
    public $limit = 4;
    public $data = [];
    public $ishot;
    public $category_id ;
    public $category = [];
    public $relation = 0;
    public $isnew;
    public $_id = 0;
    public $id_re=0;
    public $cate_diff;

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
                    '_id' => $this->_id,
                    'cate_diff'=>$this->cate_diff
        ]);

        if ($this->category_id) {
            $this->category = \common\models\news\NewsCategory::getOneMuch($this->category_id);
        }

        //
        return $this->render($this->view, [
                    'data' => $this->data,
                    'category' => $this->category,
                     'id_re' =>$this->id_re,
                    'cate_diff'=>$this->cate_diff
        ]);
    }

}
