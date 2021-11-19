<?php
/**
 * Created by PhpStorm.
 * User: hungtm
 * Date: 11/17/2018
 * Time: 10:25 AM
 */

namespace api\modules\v1\controllers;

use common\components\ClaLid;
use common\components\ClaMeter;
use common\models\package\Package;
use common\models\sms\SmsOtp;
use common\models\sms\SmsOtpLog;
use common\models\sms\SmsOtpLogApi;
use Yii;
use api\components\RestController;


/**
 *
 */
class HomeController extends RestController
{

    public function actionIndex(){
        $request = Yii::$app->getRequest()->getBodyParams();
        $packages = Package::find()->where(['status' => 1])->orderBy('order ASC, updated_at DESC')->all();
//        $abc = ClaMeter::betweenTwoPoint(21.03788157357153,105.78169447099677,20.982511126187653, 105.79112325893907);
        $abc = ClaMeter::distance(21.03788157357153,105.78169447099677,20.982511126187653, 105.79112325893907,"M");
        print_r('<pre>');
        print_r($abc);
        die;
        return $this->responseData([
            'package' => $packages
        ]);
    }

    /**
     * @return array
     */
    protected function verbs()
    {
        return [
            'get-otp' => ['POST'],
            'test-send-sms' => ['GET'],
        ];
    }
}