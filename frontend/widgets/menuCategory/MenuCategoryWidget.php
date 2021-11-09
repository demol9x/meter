<?php

namespace frontend\widgets\menuCategory;

use yii\base\Widget;
use common\models\product\ProductCategory;

class MenuCategoryWidget extends \frontend\components\CustomWidget
{

    public $view = 'view';
    public $parent = 0;
    public $cat_parent = 0;
    public $data = array();
    public $attr = array();

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $this->data = ProductCategory::getItemChildAll($this->parent, $this->attr);
        if ($this->parent && !$this->data) {
            $this->data = ProductCategory::getItemChildAll($this->cat_parent, $this->attr);
        }
        return $this->render($this->view, [
            'data' => $this->data,
        ]);
    }
}
