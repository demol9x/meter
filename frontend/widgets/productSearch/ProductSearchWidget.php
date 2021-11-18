<?php

namespace frontend\widgets\productSearch;

use Yii;
use yii\base\Widget;

use frontend\components\FilterHelper;


class ProductSearchWidget extends \frontend\components\CustomWidget {

    public $view = 'view';

    public $keyword = '';

    public function init() {
        $this->keyword = Yii::$app->request->get('k', '');
        //
        parent::init();
    }

    public function run() {
        //

        return $this->render($this->view, [
            'keyword' => $this->keyword,


        ]);
    }

}

?>