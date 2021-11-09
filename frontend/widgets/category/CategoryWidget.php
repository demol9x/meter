<?php

namespace frontend\widgets\category;

use yii\base\Widget;
use common\components\ClaCategory;

class CategoryWidget extends \frontend\components\CustomWidget {

    public $type = 0;
    public $parent = 0;
    public $level = 0;
    protected $data = array();
    public $view = 'view'; // view of widget
    protected $product = null; // view of widget

    public function init() {
        // get category
        if ($this->type) {
            $category = new ClaCategory(array('type' => $this->type, 'create' => true));
            $this->data = $category->createArrayCategory($this->parent);
        }
        parent::init();
    }

    public function run() {
        if ($this->type) {
            return $this->render($this->view, [
                        'data' => $this->data,
                        'level' => $this->level,
            ]);
        }
    }

}
