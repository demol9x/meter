<?php

namespace frontend\widgets\shop;

use Yii;
use yii\base\Widget;
use common\models\shop\Shop;

class ShopWidget extends \frontend\components\CustomWidget {

    public $limit = 10;
    public $view = 'view';
    public $ishot = 0;
    public $other = [];
    protected $shop = [];

    public function init() {
        $this->shop = Shop::getShop([
            'limit' => $this->limit,
            'ishot' => $this->ishot
        ]);
        //
        parent::init();
    }

    public function run() {
        //
        return $this->render($this->view, [
                    'shop' => $this->shop,
                    'other' => $this->other,
        ]);
    }

}

?>