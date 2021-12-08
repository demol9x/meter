<?php
/**
 * Created by PhpStorm.
 * User: hungtm
 * Date: 11/17/2018
 * Time: 10:25 AM
 */

namespace api\modules\v1\controllers;

use common\components\ClaLid;
use common\models\sms\SmsOtp;
use common\models\sms\SmsOtpLog;
use common\models\sms\SmsOtpLogApi;
use Yii;
use api\components\RestController;


/**
 *
 */
class SmsController extends RestController
{

    public function actionTestSendSms()
    {
        die();
        // Setup cURL
        $ch = curl_init('http://api-02.brand1.xyz:8080/service/sms_api');
        $postData = [
            'user' => 'gcaeco',
            'pass' => 'GCaEc0G9',
            'phone' => '0948145789',
            'mess' => 'Hello Hung',
            'tranId' => time(),
            'brandName' => __NAME,
            'dataEncode' => 0,
            'sendTime' => ''
        ];
        //
        $payload = json_encode( $postData );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json;charset=UTF-8'));
        # Return response instead of printing.
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        # Send request.
        $result = curl_exec($ch);
        curl_close($ch);
        # Print response.
        echo '<pre>';
        print_r($result);
        echo '</pre>';
        die();
    }

    public function sendSms($postData)
    {
        // Setup cURL
        $ch = curl_init('http://api-02.brand1.xyz:8080/service/sms_api');

        //
        curl_setopt_array($ch, array(
            CURLOPT_POST => TRUE,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json;charset=UTF-8'
            ),
            CURLOPT_POSTFIELDS => json_encode($postData)
        ));

        // Send the request
        $response = curl_exec($ch);

        // Check for errors
        if ($response === FALSE) {
            die(curl_error($ch));
        }

        // Decode the response
        $responseData = json_decode($response, TRUE);
        $log = new SmsOtpLogApi();
        $log->code = $responseData['code'];
        $log->message = $responseData['message'];
        $log->tran_id = $responseData['tranId'];
        $log->oper = $responseData['oper'];
        $log->total_sms = $responseData['totalSMS'];
        $log->save();
        // Print the date from the response
        echo $responseData['published'];
    }

    /**
     * API Get OTP
     * PARAM phone
     * @return array
     */
    public function actionGetOtp()
    {
        if (Yii::$app->request->isPost) {
            $params = $_REQUEST;
            $phone = isset($params['phone']) ? $params['phone'] : 0;
            //
            $countGetOtpToday = SmsOtp::countGetOtpToday($phone);
            if ($countGetOtpToday >= SmsOtp::MAX_SMS_ONE_DAY) {
                $this->success = false;
                $this->message = 'Số lượng mã OTP của bạn đã vượt quá ' . SmsOtp::MAX_SMS_ONE_DAY . ' mã trong một ngày';
                return $this->responseData();
            }
            //
            $newOtp = SmsOtp::generateNumericOTP(6);
            //
            $model = SmsOtp::getPhoneModel($phone);
            $model->phone = $phone;
            $model->otp_number = $newOtp;
            $model->status = ClaLid::STATUS_DEACTIVED;
            if ($model->save()) {
                // Send SMS
                $tranID = __NAME.'-' . $phone . '-' . time();
                $mess = 'Ma OTP la ' . $model->otp_number . '. Ma OTP chi su dung 1 lan cho giao dich tai san TMDT WWW.'.__NAME.'. Quy khach vui long bao mat thong tin. Hotline: 0984349724';
                $postData = [
                    'user' => 'gcaeco',
                    'pass' => 'GCaEc0G9',
                    'phone' => $phone,
                    'mess' => $mess,
                    'tranId' => $tranID,
                    'brandName' => __NAME,
                    'dataEncode' => 0,
                    'sendTime' => ''
                ];
                $this->sendSms($postData);
                // Log
                $operator = '';
                SmsOtpLog::logOtp($phone, $newOtp, $operator, ClaLid::STATUS_DEACTIVED);
                //
                $this->success = true;
                $this->message = 'Mã OTP của bạn là ' . $newOtp;
                return $this->responseData([
                    'OTP' => $newOtp
                ]);
            } else {
                $this->success = false;
                $this->message = 'Đã xảy ra lỗi, hãy thử lại';
                return $this->responseData();
            }
        }
    }

    /**
     * API check OTP
     * PARAM phone, otp
     * @return array
     */
    public function actionCheckOtp()
    {
        if (Yii::$app->request->isPost) {
            $params = $_REQUEST;
            $phone = isset($params['phone']) ? $params['phone'] : 0;
            $otp = isset($params['otp']) ? $params['otp'] : 0;
            $checkCorrect = SmsOtp::checkOtpCorrect($phone, $otp);
            if ($checkCorrect === true) {
                $this->success = true;
                $this->message = 'Mã OTP chính xác';
            } else {
                $this->success = false;
                $this->message = 'Mã OTP không chính xác hoặc đã hết hạn 30 phút';
            }
            return $this->responseData();
        }
    }

    /**
     * API update OTP
     * PARAM phone, otp
     * @return array
     */
    public function actionUpdateOtp()
    {
        if (Yii::$app->request->isPost) {
            $params = $_REQUEST;
            $phone = isset($params['phone']) ? $params['phone'] : 0;
            $otp = isset($params['otp']) ? $params['otp'] : 0;
            SmsOtp::updateStatusOtpToUsed($phone, $otp);
            $this->success = true;
            $this->message = 'Updated';
            return $this->responseData();
        }
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