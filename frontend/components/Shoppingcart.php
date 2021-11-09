<?php

namespace frontend\components;

use Yii;

/**
 * Xử lý giỏ hàng
 */
class Shoppingcart
{

    const PARAM_CART = 'cart';
    const PRODUCT_ATTRIBUTE_CHANGEPRICE_KEY = 'attrChangeprice';

    public $cartstore = [];

    public function __construct()
    {
        $this->cartstore = Yii::$app->session[self::PARAM_CART];
    }

    public function add($data, $options = [])
    {
        $key = $data['code'];
        //
        $this->cartstore[$key] = $data;
        $this->cartstore[$key]['quantity'] = $options['quantity'];
        //
        Yii::$app->session[self::PARAM_CART] = $this->cartstore;
    }

    public function remove($key)
    {
        unset($this->cartstore[$key]);
        Yii::$app->session[self::PARAM_CART] = $this->cartstore;
    }

    public static function check($product_id)
    {
        $spc = new Shoppingcart();
        if (isset($spc->cartstore[$product_id]) && $spc->cartstore[$product_id]) {
            return 1;
        }
        return 0;
    }

    public function removeAll()
    {
        $this->cartstore = [];
        Yii::$app->session[self::PARAM_CART] = $this->cartstore;
    }

    public function getOrderTotal()
    {
        $total = 0;
        $cartstore = $this->cartstore;
        if ($cartstore) {
            foreach ($cartstore as $item) {
                $total += $item['price'] * $item['quantity'];
            }
        }
        return $total;
    }

    public function getOrderTotalPayCoin()
    {
        $total = 0;
        $cartstore = $this->cartstore;
        if ($cartstore) {
            foreach ($cartstore as $item) {
                $model_item = new \common\models\order\OrderItem();
                $model_item->shop_id = $item['shop_id'];
                $model_item->product_id = $item['id'];
                $model_item->quantity = $item['quantity'];
                $model_item->getAffiliate();
                $total += \common\models\gcacoin\Gcacoin::getCoinToMoney($item['price'] * $item['quantity']) -  $model_item->sale_buy_shop_coin;
            }
        }
        return $total;
    }

    public static function getWeight($shop_id)
    {
        $weight = 0;
        $sp = new Shoppingcart();
        if ($sp->cartstore) {
            foreach ($sp->cartstore as $tg) {
                if ($tg['shop_id'] == $shop_id) {
                    // print_r($tg); die();
                    $weight += $tg['weight'] * $tg['quantity'];
                }
            }
        }
        // echo "<pre>";
        // print_r($sp->cartstore);
        // echo '1'.$weight.'dgdsgdsgds';
        // die();
        return $weight;
    }

    public static function getInfo3($shop_id)
    {
        $info3 = [
            'height' => 0,
            'width' => 0,
            'length' => 0,
        ];
        $sp = new Shoppingcart();
        if ($sp->cartstore) {
            foreach ($sp->cartstore as $tg) {
                if ($tg['shop_id'] == $shop_id) {
                    $info3['width'] += $tg['width'] * $tg['quantity'];
                    $info3['height'] += $tg['height'];
                    $info3['length'] += $tg['length'];
                }
            }
        }
        return $info3;
    }
}
