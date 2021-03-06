<?php

namespace common\components\payments\gates\vnpay\helpers;

use yii\base\Component;

//
class VNPayHelper extends Component {

    public $url_api = 'https://pay.vnpay.vn/vpcpay.html';
    public $vnp_TmnCode = '';
    public $vnp_HashSecret = '';
    public $receiver_email = '';
    public $cur_code = 'VND';
    public $version = '';
    public $lang_code = 'vn';
    public $vnp_OrderType = 'billpayment';

    function __construct($vnp_TmnCode, $vnp_HashSecret, $receiver_email, $url_api) {
        $this->version = '2.0.0';
        $this->url_api = $url_api;
        $this->vnp_TmnCode = $vnp_TmnCode;
        $this->vnp_HashSecret = $vnp_HashSecret;
        $this->receiver_email = $receiver_email;
    }

    function GetTransactionDetail($token) {
        ###################### BEGIN #####################
        $params = array(
            'vnp_TmnCode' => $this->vnp_TmnCode,
            'vnp_HashSecret' => MD5($this->vnp_HashSecret),
            'version' => $this->version,
            'function' => 'GetTransactionDetail',
            'token' => $token
        );

        $post_field = '';
        foreach ($params as $key => $value) {
            if ($post_field != '')
                $post_field .= '&';
            $post_field .= $key . "=" . $value;
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url_api_get);
        curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_field);
        $result = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        if ($result != '' && $status == 200) {
            $nl_result = json_decode($result);
            return $nl_result;
        }
        return false;
        ###################### END #####################
    }

    /*

      H??m l???y link thanh to??n b???ng th??? visa
      ===============================
      Tham s??? truy???n v??o b???t bu???c ph???i c??
      order_code
      total_amount
      payment_method

      buyer_fullname
      buyer_email
      buyer_mobile
      ===============================
      $array_items m???ng danh s??ch c??c item name theo quy t???c
      item_name1
      item_quantity1
      item_amount1
      item_url1
      .....
      payment_type Ki???u giao d???ch: 1 - Ngay; 2 - T???m gi???; N???u kh??ng truy???n ho???c b???ng r???ng th?? l???y theo ch??nh s??ch c???a NganLuong.vn
     */

    function BankCheckout($order_code, $total_amount, $order_description, $return_url, $cancel_url, $bank_code) {
        $inputData = array(
            "vnp_Version" => "2.0.0",
            "vnp_TmnCode" => $this->vnp_TmnCode,
            "vnp_Amount" => $total_amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => $this->cur_code,
            "vnp_IpAddr" => $_SERVER['REMOTE_ADDR'],
            "vnp_Locale" => $this->lang_code,
            "vnp_OrderInfo" => $order_description,
            "vnp_OrderType" => $this->vnp_OrderType,
            "vnp_ReturnUrl" => $return_url,
            "vnp_TxnRef" => $order_code,
        );

        if (isset($bank_code) && $bank_code != "") {
            $inputData['vnp_BankCode'] = $bank_code;
        }
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . $key . "=" . $value;
            } else {
                $hashdata .= $key . "=" . $value;
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $this->url_api . "?" . $query;
        $vnp_HashSecret = $this->vnp_HashSecret;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = md5($vnp_HashSecret . $hashdata);
            $vnp_Url .= 'vnp_SecureHashType=MD5&vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = (object) array(
                    'error_code' => '00',
                    'message' => 'success',
                    'checkout_url' => $vnp_Url,
        );
        return $returnData;
    }

    function paySuccess($options = []) {
        $vnp_SecureHash = $_GET['vnp_SecureHash'];
        $inputData = array();
        foreach ($_GET as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }
        unset($inputData['vnp_SecureHashType']);
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . $key . "=" . $value;
            } else {
                $hashData = $hashData . $key . "=" . $value;
                $i = 1;
            }
        }

        $secureHash = md5($this->vnp_HashSecret . $hashData);
        $newDateString = null;
        if ($_GET['vnp_PayDate']) {
            $myDateTime = date('YmdHis', $_GET['vnp_PayDate']);
            $newDateString = $myDateTime;
        }
        $status = $_GET['vnp_ResponseCode'];
        if ($secureHash == $vnp_SecureHash) {
            $order_id = $_GET['vnp_TxnRef'];
            $log = \common\components\payments\gates\vnpay\models\LogVnPay::getModel($order_id);
            if(!$log->status) {
                $log->order_id = $order_id;
                $log->amount = $_GET['vnp_Amount'];
                $log->order_code = $_GET['vnp_TransactionNo'];
                $log->created_time = $newDateString;
                $log->site_id = 1;
                $log->bank_code = $_GET['vnp_BankCode'];
                $log->sign = $hashData;
                $log->status = 1;
                $log->save();
            }
            if($log->correct) {
                $order = \common\models\order\Order::findOne($log->order_id);
                if($order) {
                    $order->payment_status = \common\components\payments\ClaPayment::PAYMENT_STATUS_SUCCESS;
                    if($order->save()) {
                        return $order;
                    }
                }
            }
            $transStatus = 'Giao d???ch th??nh c??ng';
            return true;
        } else {
            $transStatus = 'Ch??? k?? kh??ng h???p l???';
            echo $transStatus;
            die();
        }
        return false;
    }

    function CheckoutCall($post_field) {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url_api);
        curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_field);
        $result = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        //
        if ($result != '' && $status == 200) {
            //$xml_result = str_replace('&', '&amp;', (string) $result);
            //$nl_result = simplexml_load_string($xml_result);
            $nl_result = json_decode($result);
            if (!$nl_result) {
                $nl_result = (object) array();
            }
            $nl_result->error_message = $this->GetErrorMessage($nl_result->error_code);
        } else {
            $nl_result->error_message = $error;
        }
        return $nl_result;
    }

    function GetErrorMessage($error_code) {
        $arrCode = array(
            '00' => 'Th??nh c??ng',
            '99' => 'L???i ch??a x??c minh',
            '06' => 'M?? merchant kh??ng t???n t???i ho???c b??? kh??a',
            '02' => '?????a ch??? IP truy c???p b??? t??? ch???i',
            '03' => 'M?? checksum kh??ng ch??nh x??c, truy c???p b??? t??? ch???i',
            '04' => 'T??n h??m API do merchant g???i t???i kh??ng h???p l??? (kh??ng t???n t???i)',
            '05' => 'Sai version c???a API',
            '07' => 'Sai m???t kh???u c???a merchant',
            '08' => '?????a ch??? email t??i kho???n nh???n ti???n kh??ng t???n t???i',
            '09' => 'T??i kho???n nh???n ti???n ??ang b??? phong t???a giao d???ch',
            '10' => 'M?? ????n h??ng kh??ng h???p l???',
            '11' => 'S??? ti???n giao d???ch l???n h??n ho???c nh??? h??n quy ?????nh',
            '12' => 'Lo???i ti???n t??? kh??ng h???p l???',
            '29' => 'Token kh??ng t???n t???i',
            '80' => 'Kh??ng th??m ???????c ????n h??ng',
            '81' => '????n h??ng ch??a ???????c thanh to??n',
            '110' => '?????a ch??? email t??i kho???n nh???n ti???n kh??ng ph???i email ch??nh',
            '111' => 'T??i kho???n nh???n ti???n ??ang b??? kh??a',
            '113' => 'T??i kho???n nh???n ti???n ch??a c???u h??nh l?? ng?????i b??n n???i dung s???',
            '114' => 'Giao d???ch ??ang th???c hi???n, ch??a k???t th??c',
            '115' => 'Giao d???ch b??? h???y',
            '118' => 'tax_amount kh??ng h???p l???',
            '119' => 'discount_amount kh??ng h???p l???',
            '120' => 'fee_shipping kh??ng h???p l???',
            '121' => 'return_url kh??ng h???p l???',
            '122' => 'cancel_url kh??ng h???p l???',
            '123' => 'items kh??ng h???p l???',
            '124' => 'transaction_info kh??ng h???p l???',
            '125' => 'quantity kh??ng h???p l???',
            '126' => 'order_description kh??ng h???p l???',
            '127' => 'affiliate_code kh??ng h???p l???',
            '128' => 'time_limit kh??ng h???p l???',
            '129' => 'buyer_fullname kh??ng h???p l???',
            '130' => 'buyer_email kh??ng h???p l???',
            '131' => 'buyer_mobile kh??ng h???p l???',
            '132' => 'buyer_address kh??ng h???p l???',
            '133' => 'total_item kh??ng h???p l???',
            '134' => 'payment_method, bank_code kh??ng h???p l???',
            '135' => 'L???i k???t n???i t???i h??? th???ng ng??n h??ng',
            '140' => '????n h??ng kh??ng h??? tr??? thanh to??n tr??? g??p',);

        return $arrCode[(string) $error_code];
    }

}
