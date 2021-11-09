<?php

namespace frontend\widgets\shoppingcart;

use yii\base\Widget;

class Shoppingcart extends \frontend\components\CustomWidget {

    protected $link = '';
    protected $products = array();
    protected $quantity = 0;
    public $view = 'view';
    protected $name = 'shoppingcart';
    protected $shoppingcart = null;
    protected $ordertotal = 0;

    public function init() {
        \Yii::$app->session->open();
        $shoppingcart = new \frontend\components\Shoppingcart();
        $this->products = $shoppingcart->cartstore;
        $this->quantity = count($this->products);
        $this->link = \yii\helpers\Url::to(['/product/shoppingcart/index']);
        $this->ordertotal = $shoppingcart->getOrderTotal();
        parent::init();
    }

    public function run() {
        return $this->render($this->view, array(
            'products' => $this->products,
            'quantity' => $this->quantity,
            'link' => $this->link,
            'ordertotal' => $this->ordertotal
        ));
    }

}
