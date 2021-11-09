<?php

namespace frontend\controllers;

use common\components\ClaLid;
use Yii;
use yii\web\Controller;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Url;
use frontend\components\Transport;
use common\components\shipping\ClaShipping;
use common\models\Districts;

/**
 * Site controller
 */
class TransportController extends Controller
{

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionGetCostTransport()
    {
        $options = $_POST;
        return Transport::getCostTransport($options);
    }

    public function actionGetCostTransportShop($options = [])
    {
        //phuong thuc
        if (isset($_POST['f_district']) && isset($_POST['f_province']) && isset($_POST['t_province']) && isset($_POST['t_district']) && isset($_POST['method']) && isset($_POST['weight']) && isset($_POST['shop_id']) && $_POST['method']) {
            $claShipping = new ClaShipping();
            $claShipping->loadVendor(['method' => $_POST['method']]);
            $options['data'] = $claShipping->vendor->calculDataPrice($_POST);
            if (!$options['data']) {
                return Yii::t('app', 'ghn_not_support');
            }
        }
        if (isset($_POST['shop_id']) && $_POST['shop_id']) {
            return Transport::getCost($_POST['shop_id'], isset($_POST['method']) ? $_POST['method'] : 0, $options);
        }
        return false;
    }

    // chuyen cho hook
    public function actionUpdateStatus($type)
    {
        $type = Yii::$app->request->get('type');
        $text = file_get_contents('php://input') ? json_encode(file_get_contents('php://input')) : '';
        $text .= (isset($_POST) && $_POST) ? json_encode($_POST) : '';
        $data = [
            'order_id' => 0,
            'time' => time(),
            'status' => 0,
            'type' => $type,
            'content' => $text,
            'created_at' => time()
        ];
        $kt = \common\models\order\OrderShopHistory::saveData($data);
        $option['data']['OrderCode'] = 0;
        $claShipping = new \common\components\shipping\ClaShipping();
        $claShipping->loadVendor(['method' => $type]);
        switch ($type) {
            case \common\components\shipping\ClaShipping::METHOD_GHN:
                $data = json_decode(file_get_contents('php://input'), true);
                if (isset($data['OrderCode']) && $data['OrderCode']) {
                    $option['data']['OrderCode'] = $data['OrderCode'];
                }
                break;

            case \common\components\shipping\ClaShipping::METHOD_GHTK:
                if (isset($_POST['label_id']) && $_POST['label_id']) {
                    $option['data']['OrderCode'] = $_POST['label_id'];
                }
                break;
        }
        if ($option['data']['OrderCode']) {
            return $claShipping->updateStatusFromHook($option);
        }
        return false;
    }

    public function actionTest()
    {
        echo date('Y-m-d h:i:s', time());
    }
}
