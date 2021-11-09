<?php

namespace frontend\widgets\cropImage;

use yii\base\Widget;
use common\models\product\Product;

class CropImageWidget extends Widget {

    public $view = 'view';

    public function init() {
        parent::init();
    }

    public function run() {
        //
        return $this->render($this->view, [
        ]);
    }

}

?>