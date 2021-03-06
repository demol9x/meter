<?php
namespace common\components\payments\gates\member\helpers;
use yii\base\Component;
//
class MemberHelper extends Component {

    public $url_api = 'https://member.gcaeco.vn/checkout/get-transaction';
    public $url_api_get = 'https://member.gcaeco.vn/checkout/get-transaction-detail?debug=true';
    public $merchant_id = '';
    public $merchant_password = '';
    public $receiver_email = '';
    public $cur_code = 'vnd';
    public $version = '';
    public $lang_code = 'vi';

    function __construct($merchant_id, $merchant_password, $receiver_email, $url_api) {
        $this->version = '3.1';
        $this->url_api = $url_api;
        $this->merchant_id = $merchant_id;
        $this->merchant_password = $merchant_password;
        $this->receiver_email = $receiver_email;
    }

    function GetTransactionDetail($token) {
        ###################### BEGIN #####################
        $params = array(
            'merchant_id' => $this->merchant_id,
            'merchant_password' => MD5($this->merchant_password),
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

    function WalletCheckout($order_code, $total_amount, $payment_type, $order_description, $tax_amount, $fee_shipping, $discount_amount, $return_url, $cancel_url, $buyer_fullname, $buyer_email, $buyer_mobile, $buyer_address, $array_items, $bank_code) {
        $params = array(
            'cur_code' => $this->cur_code,
            'version' => $this->version,
            'merchant_id' => $this->merchant_id, //M?? merchant khai b??o t???i member, ch??a c???n ph???n n??y
            'receiver_email' => $this->receiver_email,
            'merchant_password' => MD5($this->merchant_password), //MD5(M???t kh???u k???t n???i gi???a merchant)
            'order_code' => $order_code, //M?? h??a ????n do website b??n h??ng sinh ra
            'total_amount' => $total_amount, //T???ng s??? ti???n c???a h??a ????n
            'payment_method' => 'WALLET', //Ph????ng th???c thanh to??n, nh???n m???t trong c??c gi?? tr??? 'VISA','ATM_ONLINE', 'ATM_OFFLINE' ho???c 'NH_OFFLINE'
            'bank_code' => $bank_code, //Ph????ng th???c thanh to??n, nh???n m???t trong c??c gi?? tr??? 'VISA','ATM_ONLINE', 'ATM_OFFLINE' ho???c 'NH_OFFLINE'
            'payment_type' => $payment_type, //Ki???u giao d???ch: 1 - Ngay; 2 - T???m gi???; N???u kh??ng truy???n ho???c b???ng r???ng th?? l???y theo ch??nh s??ch c???a
            'order_description' => $order_description, //M?? t??? ????n h??ng
            'tax_amount' => $tax_amount, //T???ng s??? ti???n thu???
            'fee_shipping' => $fee_shipping, //Ph?? v???n chuy???n
            'discount_amount' => $discount_amount, //S??? ti???n gi???m gi??
            'return_url' => $return_url, //?????a ch??? website nh???n th??ng b??o giao d???ch th??nh c??ng
            'cancel_url' => $cancel_url, //?????a ch??? website nh???n "H???y giao d???ch"
            'buyer_fullname' => $buyer_fullname, //T??n ng?????i mua h??ng
            'buyer_email' => $buyer_email, //?????a ch??? Email ng?????i mua
            'buyer_mobile' => $buyer_mobile, //??i???n tho???i ng?????i mua
            'buyer_address' => $buyer_address, //?????a ch??? ng?????i mua h??ng
            'total_item' => count($array_items),
            'lang_code' => $this->lang_code,
        );
        $post_field = '';
        foreach ($params as $key => $value) {
            if ($post_field != '')
                $post_field .= '&';
            $post_field .= $key . "=" . $value;
        }
        if (count($array_items) > 0) {
            foreach ($array_items as $array_item) {
                foreach ($array_item as $key => $value) {
                    if ($post_field != '')
                        $post_field .= '&';
                    $post_field .= $key . "=" . $value;
                }
            }
        }
        //die($post_field);

        $nl_result = $this->CheckoutCall($post_field);
        return $nl_result;
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
            if(!$nl_result){
                $nl_result = (object)array();
            }
            $nl_result->error_message = $this->GetErrorMessage($nl_result->error_code);
        } else{
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