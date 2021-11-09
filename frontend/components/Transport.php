<?php

namespace frontend\components;

use common\components\shipping\ClaShipping;
use Yii;

/**
 * Xử lý giỏ hàng
 */
class Transport
{

    const PARAM_CART = 'transport';

    public $transports = [];

    public function __construct()
    {
        $this->transports = Yii::$app->session[self::PARAM_CART];
    }

    public function add($shop_id, $data = [])
    {
        $key = $shop_id;
        //
        $this->transports[$key] = $data;
        //
        Yii::$app->session[self::PARAM_CART] = $this->transports;
    }

    public function remove($key)
    {
        unset($this->transports[$key]);
        Yii::$app->session[self::PARAM_CART] = $this->transports;
    }

    public function removeAll()
    {
        $this->transports = [];
        Yii::$app->session[self::PARAM_CART] = $this->transports;
    }

    public function addTransport($shop_id, $method, $options, $data)
    {
        $tran = new Transport();
        $transport['method'] = $method;
        $transport['order'] = array(
            "pick_name" => "HCM-nội thành",
            "pick_address" => $options['pick_address'],
            "pick_province" => $options['pick_province'],
            "pick_district" => $options['pick_district'],
            "pick_tel" => "0911222333",
            "tel" => "0911222333",
            "name" => "GHTK - HCM - Noi Thanh",
            "address" => $options['address'],
            "province" => $options['province'],
            "district" => $options['district'],
            "is_freeship" => "1",
            "pick_date" => date('Y-m-d', time()),
            "pick_money" => $data['fee'],
            "note" => "",
            "value" => 0
        );
        $tran->add($shop_id, $transport);
    }

    public function addTransportGhn($shop_id, $method, $options, $data)
    {
        $tran = new Transport();
        $transport['method'] = $method;
        $transport['order'] = array(
            "pick_money" => 0,
            "ServiceID" => $options['ServiceID'],
            "Weight" => $options['Weight'],
            "Width" => $options['Width'],
            "Length" => $options['Length'],
            "Height" => $options['Height'],
            "FromDistrictID" => $options['FromDistrictID'],
            "ToDistrictID" => $options['ToDistrictID'],
        );
        $tran->add($shop_id, $transport);
    }

    public static function getCost($shop_id, $method, $options)
    {
        $tran = new Transport();
        if ($method) {
            $claShipping = new ClaShipping();
            $claShipping->loadVendor(['method' => $method]);
            $data = $claShipping->calculateFee($options);
            $tran->add($shop_id, ['method' => $method]);
            return isset($data['fee']) ? $data['fee'] : false;
        }
        $tran->add($shop_id, ['method' => 0]);
        return false;
    }

    public static function getInfoTransport($orderShop, $data_pr = [])
    {
        if ($orderShop->transport_type) {
            $claShipping = new ClaShipping();
            $claShipping->loadVendor(['method' => $orderShop->transport_type]);
            $options['data'] = $claShipping->vendor->getDataCreateOrder($orderShop, $data_pr);
            $data = $claShipping->createOrder($options);
            if (isset($data['success']) && isset($data['success'])) {
                return $data;
            } else {
                return 0;
            }
        }
        return 0;
    }

    public static function getCostTransport($post)
    {
        $claShipping = new \common\components\shipping\ClaShipping();
        $text = '<script type="text/javascript"> loadImgQR();</script>';
        //phuong thuc
        if (isset($post['f_district']) && isset($post['f_province']) && isset($post['t_province']) && isset($post['t_district']) && isset($post['method']) && isset($post['weight']) && $post['method']) {
            $claShipping->loadVendor(['method' => $post['method']]);
            $options['data'] = $claShipping->vendor->calculDataPrice($post);
            if (!$options['data']) {
                return Yii::t('app', 'ghn_not_support') . $text;
            }
            $data = $claShipping->calculateFee($options);
            if (is_numeric($data['fee'])) {
                return number_format($data['fee'], 0, ',', '.') . ' ' . Yii::t('app', 'currency') . '<script type="text/javascript"> $("#fee-ship").attr("data-price", "' . $data['fee'] . '"); loadImgQR();</script>';
            } else {
                return Yii::t('app', 'ghn_not_support') . $text;
            }
        } else {
            return Yii::t('app', 'contact') . $text;
        }
        return false;
    }

    public static function getCostTransportApi($post)
    {
        $claShipping = new \common\components\shipping\ClaShipping();
        //phuong thuc
        if (isset($post['f_district']) && isset($post['f_province']) && isset($post['t_province']) && isset($post['t_district']) && isset($post['method']) && isset($post['weight']) && $post['method']) {
            $claShipping->loadVendor(['method' => $post['method']]);
            $options['data'] = $claShipping->vendor->calculDataPrice($post);
            if (!$options['data']) {
                return Yii::t('app', 'ghn_not_support');
            }
            $data = $claShipping->calculateFee($options);
            if (is_numeric($data['fee'])) {
                return $data['fee'];
            } else {
                return Yii::t('app', 'ghn_not_support');
            }
        } else {
            return Yii::t('app', 'contact');
        }
        return false;
    }
}
