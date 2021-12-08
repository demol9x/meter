<?php

namespace frontend\widgets\shop;

use common\models\general\UserWish;
use frontend\models\User;
use Yii;
use yii\base\Widget;
use common\models\shop\Shop;

class ShopWidget extends \frontend\components\CustomWidget {

    public $limit = 10;
    public $view = 'view';
    public $ishot = 0;
    public $other = [];
    protected $shop = [];
    public $us_wish=[];

    public function init() {
        $this->shop = User::getS([
            'limit' => $this->limit,
        ]);
        $this->us_wish = UserWish::find()->where(['user_id_from' => Yii::$app->user->id,'type' => \frontend\models\User::TYPE_DOANH_NGHIEP])->asArray()->all();
        $this->us_wish = array_column($this->us_wish, 'user_id', 'id');
        parent::init();
    }

    public function run() {
        return $this->render($this->view, [
                    'shop' => $this->shop['data'],
                    'us_wish'=>$this->us_wish
        ]);
    }

}

?>