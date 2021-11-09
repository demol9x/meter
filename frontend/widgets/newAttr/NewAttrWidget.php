<?php

namespace frontend\widgets\newAttr;

use Yii;
use yii\base\Widget;

class NewAttrWidget extends \frontend\components\CustomWidget {

    public $view = 'view';
    public $attr = '';
    public $limit = 16;
    public $order = "id DESC";
    public $title = "";
    public $_new = "";
    protected $news = [];

    public function init() {
        $this->news = \common\models\news\News::getNewByAttr([
                    'attr' => $this->attr,
                    'order' => $this->order,
                    'limit' => $this->limit,
                    '_new' => $this->_new
        ]);
        //
        parent::init();
    }

    public function run() {
        //
        return $this->render($this->view, [
                    'title' => $this->title,
                    'news' => $this->news
        ]);
    }

}

?>