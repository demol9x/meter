<?php

namespace frontend\widgets\promotion;

use Yii;
use yii\base\Widget;

class PromotionWidget extends \frontend\components\CustomWidget {

    public $view = 'view';
    public $limit = 16;
    public $order = "id DESC";
    public $title = "";
    public $other = [];
    protected $products = [];
    protected $time_end = [];
    protected $promotion;

    public function init() {
        date_default_timezone_set("Asia/Bangkok");
        $promotion = \common\models\promotion\Promotions::getPromotionNow();
        if($promotion) {
            $hour = $promotion->getHourNow();
            $this->promotion = $promotion;
            $promotion_id =  $promotion ?  $promotion->id : 0;
            $this->time_end =  $promotion ?  $promotion->enddate : 0;
            $product_id = isset($_GET['province_id']) ? $_GET['province_id'] : '';
            $this->products = \common\models\promotion\ProductToPromotions::getProductByAttr([
                    'attr' => [
                        't.id' => $promotion_id,
                        'hour_space_start' => $hour,
                    ],
                    'order' => 'u.last_request_time desc, pt.id desc',
                    'limit' => $this->limit
                ]);
        }
       
        //
        parent::init();
    }

    public function run() {
        //
        if($this->promotion) {
            return $this->render($this->view, [
                    'promotion' => $this->promotion,
                    'title' => $this->title,
                    'products' => $this->products,
                    'other' => $this->other,
                    'time_end' => $this->time_end
            ]);
        }
        
    }

}

?>