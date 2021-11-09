<?php

namespace api\modules\v1\controllers;

use api\components\RestController;
use common\components\ClaQrCode;

/**
 *
 */
class NotifyController extends RestController
{

    public function actionGet()
    {

    }

    public function actionTest()
    {
        $notify = new \common\components\notifications\ClaMobileNotify();
        $msg = array
        (
            'message' => 'here is a message. message',
            'title' => 'This is a title. title',
            'subtitle' => 'This is a subtitle. subtitle', // chưa cần
            'tickerText' => 'Ticker text here...Ticker text here...Ticker text here', // chưa cần
            'vibrate' => 1, // chưa cần
            'largeIcon' => 'large_icon', // chưa cần
            'smallIcon' => 'small_icon', // chưa càn
        );

        $noti = array(
            "body" => "Hôm nay thế nào?",
            "title" => "Tiêu đề tin nhắn",
            "text" => "Click me to open an Activity!", // chưa cần
            "sound" => "warning", // Chưa cần
        );
        $user_id = 177;
        $response = $notify->send($user_id, array('notification' => $noti,));
        //$response = $notify->send($user_id, array('message' => $msg, 'notification' => $noti));
        var_dump($response);
        die;
    }

    public function actionTest2()
    {
        $msg = array
        (
            'message' => 'here is a message. message',
            'title' => 'This is a title. title',
            'subtitle' => 'This is a subtitle. subtitle',
            'tickerText' => 'Ticker text here...Ticker text here...Ticker text here',
            'vibrate' => 1,
            'largeIcon' => 'large_icon',
            'smallIcon' => 'small_icon'
        );

        $n = array(
            "body" => "great match!",
            "title" => "NEW NOTIFICATION!",
            //"text" => "Click me to open an Activity!",
            //"sound" => "warning"
        );
        $tokens = ['fn-0krWU-2Y:APA91bHNnNyd3VQL_WgvzrBMl9xK20d_J1qH_vvol3e2HVGiJClzAeTrq8tTPwuY5VS3yrPDirr8MyoqslPT1mgfjxHSzvv7zHKE2r1Ue5fFJLDsrMpFoRzU4LOigTGgZID6Xz_P08Xx'];
        $message_status = $this->send_notification($tokens, $msg, $n);
        echo $message_status;
        die('123');
    }

    function send_notification($tokens, $message = "", $n)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $fields = array(
            'to' => reset($tokens),
            //'registration_ids' => $tokens,
            'priority' => "high",
            'notification' => $n,
            //'data' => $message
        );

        //var_dump($fields);

        $headers = array(
            'Authorization:key = AAAA4VR2RhU:APA91bE5rmLDgJmxQ5nFpUFEvu8LMHbN0gwoMcEGw9s1vm2mA4d1x6foH7eEOvKA6-9IKXBYRrSLed9610s9L1QhWH9ucYQPBGucAfzhbuxmHH4CuLqBgB3BxeuZtz6XrvIuiPBoOH1l',
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }

    /**
     *
     * @return type
     */
    protected function verbs()
    {
        return [
            'login' => ['POST'],
        ];
    }

    public function actionNotifyMessage()
    {
        $post = \Yii::$app->request->post();
        $id = isset($post['toid']) ? $post['toid'] : '';
        $fromid = isset($post['fromid']) ? $post['fromid'] : '';
        $data = [
            'fromid' => $fromid
        ];
        $data = json_encode($data);
        if (isset($id) && $id) {
            ClaQrCode::sendNotifi(ClaQrCode::TYPE_MESSAGE_OFFLINE,$data,'','',$id);
        }
    }
}
