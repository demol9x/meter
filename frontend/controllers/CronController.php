<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\rating\Rating;
use common\models\rating\RateResponse;
use common\models\product\Product;
use yii\web\Response;
use common\models\User;
use yii\helpers\Url;

/**
 * Site controller
 */
class CronController extends CController
{

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionCronUnconfinementCoin()
    {
        $list = \common\models\gcacoin\CoinConfinement::getListUnconfinement();
        $kt = 0;
        echo "<pre>";
        foreach ($list as $item) {
            $gca_coin = \common\models\gcacoin\Gcacoin::getModel($item['shop_id']);
            $first_coin = $gca_coin->getCoinRed();
            // print_r($gca_coin->addMoney($item->money));
            if ($gca_coin->addCoinRed($item->coin)) {
                $item->status = 2;
                if ($item->save(false) && $gca_coin->save(false)) {
                    $kt++;
                    $oid = ($order = \common\models\order\Order::findOne($item['order_id'])) ? $order->getOrderLabelId() : 0;
                    $history = new \common\models\gcacoin\GcaCoinHistory();
                    $history->user_id = $gca_coin->user_id;
                    $history->type = 'PAY_MEMBER_RETURN';
                    $history->data = 'Cộng tiền từ đơn hàng ' . $oid . ' sau thời gian tạm giữ';
                    $history->gca_coin = $item->coin;
                    $history->first_coin = $first_coin;
                    $history->last_coin = $gca_coin->getCoinRed();
                    $history->type_coin = 1;
                    $history->save(false);
                    //sen mail
                    $user = \frontend\models\User::findOne($gca_coin->user_id);
                    if ($user && $user->email) {
                        \common\models\mail\SendEmail::sendMail([
                            'email' => $user->email,
                            'title' => 'Cộng tiền từ đơn hàng ' . $oid . ' sau thời gian tạm giữ',
                            'content' => 'Số dư thay đổi <b style="color: green"> ' . number_format($history->gca_coin, 0, ',', '.') . '</b> OCOP Vr.  Số dư hiện tại: <b style="color: green">' . number_format($history->last_coin, 0, ',', '.') . '</b>  OCOP Vr'
                        ]);
                    }
                    //send notification
                    $noti = new \common\models\notifications\Notifications();
                    $code = 'Mã đơn hàng <b style="color: green"> ' . $oid . '</b>';
                    $noti->title = 'Cộng tiền từ đơn hàng ' . $oid . ' sau thời gian tạm giữ';
                    $noti->description = 'Cộng tiền từ đơn hàng ' . $oid . ' sau thời gian tạm giữ. Số dư thay đổi <b style="color: green">' . number_format($history->gca_coin, 0, ',', '.') . '</b>  OCOP Vr.  Số dư hiện tại: <b style="color: green">' . number_format($history->last_coin, 0, ',', '.') . '</b>  OCOP Vr';
                    $noti->link = \yii\helpers\Url::to(['/management/gcacoin/index']);
                    $noti->type = 3;
                    $noti->recipient_id = $gca_coin->user_id;
                    $noti->unread = \common\components\ClaLid::STATUS_ACTIVED;
                    $noti->save();
                    if ($order) {
                        $order->addAffiliate();
                    }
                }
            }
        }
        $file = 'logCronUFC.log';
        $data = '';
        $fp = @fopen($file, "r");
        // Kiểm tra file mở thành công không
        if (!$fp) {
            echo 'Mở file không thành công';
        } else {
            while (!feof($fp)) {
                $data .= fgets($fp);
            }
        }
        $myfile = fopen($file, "w") or die("Unable to open file!");
        $time = date('d-m-Y H:i:s');
        $data .= "Đã công tiền cho $kt vào " . $time . "\\n";
        fwrite($myfile, $data);
        fclose($myfile);
        if ($kt >= count($list)) {
            echo 'Cập nhật thành công';
        } else {
            echo 'Cập nhật có lỗi';
        }
        $orders = \common\models\order\Order::getAllAddMoneyOther();
        if ($orders) {
            foreach ($orders as $order) {
                $order->addAffiliate();
            }
        }
        $file = 'logCronAMN.log';
        $data = '';
        $fp = @fopen($file, "r");
        // Kiểm tra file mở thành công không
        if (!$fp) {
            echo 'Mở file không thành công';
        } else {
            while (!feof($fp)) {
                $data .= fgets($fp);
            }
        }
        $myfile = fopen($file, "w") or die("Unable to open file!");
        $time = date('d-m-Y H:i:s');
        $data .= "Đã chay cron vào " . $time . "\\n";
        fwrite($myfile, $data);
        fclose($myfile);
        return "Da them";
    }

    public function actionCronAddMoneyOther()
    {
        $notifys = \common\models\notifications\Notifications::find()->where(['recipient_id' => \common\models\notifications\Notifications::TYPE_WAITING_SEND])->andWhere('updated_at <=' .  time() + 1)->all();
        if ($notifys) {
            foreach ($notifys as $notify) {
                $notify->recipient_id = $notify->recipient_real_id;
                \common\models\notifications\Notifications::pushMessageAllUsers($notify->attributes);
                $notify->delete();
            }
        }
        $file = 'logCronNTF.log';
        $data = '';
        $fp = @fopen($file, "r");
        // Kiểm tra file mở thành công không
        if (!$fp) {
            echo 'Mở file không thành công';
        } else {
            while (!feof($fp)) {
                $data .= fgets($fp);
            }
        }
        $myfile = fopen($file, "w") or die("Unable to open file!");
        $time = date('d-m-Y H:i:s');
        $data .= "Đã cron " . count($notifys) . " vào " . $time . "\\n";
        fwrite($myfile, $data);
        fclose($myfile);
        return "Cron success";
    }

    public function actionCronUnconResetFile()
    {
        $file = 'logCronUFC.log';
        $myfile = fopen($file, "w") or die("Unable to open file!");
        fwrite($myfile, '');
        fclose($myfile);
        $file = 'logCronSM.log';
        $myfile = fopen($file, "w") or die("Unable to open file!");
        fwrite($myfile, '');
        fclose($myfile);
        $file = 'logCronAMN.log';
        $myfile = fopen($file, "w") or die("Unable to open file!");
        fwrite($myfile, '');
        fclose($myfile);
        $file = 'logCronNTF.log';
        $myfile = fopen($file, "w") or die("Unable to open file!");
        fwrite($myfile, '');
        fclose($myfile);
    }

    // public function actionTest()
    // {
    //     $order_shops = \common\models\order\OrderShop::find()->where(['id' => 912])->all();
    //     if ($order_shops) {
    //         foreach ($order_shops as $order_shop) {
    //             $order_shop->addAffiliate();
    //         }
    //     }
    //     $file = 'logCronAMN.log';
    //     $data = '';
    //     $fp = @fopen($file, "r");
    //     // Kiểm tra file mở thành công không
    //     if (!$fp) {
    //         echo 'Mở file không thành công';
    //     } else {
    //         while (!feof($fp)) {
    //             $data .= fgets($fp);
    //         }
    //     }
    //     $myfile = fopen($file, "w") or die("Unable to open file!");
    //     $time = date('d-m-Y H:i:s');
    //     $data .= "Đã chay cron vào " . $time . "\\n";
    //     fwrite($myfile, $data);
    //     fclose($myfile);
    //     return "Da them";
    // }

    public function actionSendMail()
    {
        $count_send = 0;
        $emails = \common\models\mail\SendEmail::find()->where(['status' => 1])->andWhere('count < 3')->limit(5)->all();
        if ($emails) {
            $email_manager = \Yii::$app->params['adminEmail'];
            $app_name = \Yii::$app->name;
            foreach ($emails as $email) {
                $email_tos = explode(',', $email->email);
                $email_to = $email_tos[0];
                $kt = \Yii::$app->mailer->compose()
                    ->setFrom([$email_manager => $app_name])
                    ->setTo($email_to)
                    ->setCc($email_tos)
                    ->setSubject($email->title)
                    ->setHtmlBody($email->content)
                    ->send();
                $email->count += 1;
                if ($kt) {
                    $count_send++;
                    $email->status = 0;
                }
                $email->save(false);
            }
        }
        $file = 'logCronSM.log';
        $data = '';
        $fp = @fopen($file, "r");
        // Kiểm tra file mở thành công không
        if (!$fp) {
            echo 'Mở file không thành công';
        } else {
            while (!feof($fp)) {
                $data .= fgets($fp);
            }
        }
        $myfile = fopen($file, "w") or die("Unable to open file!");
        $time = date('d-m-Y H:i:s');
        $data .= "Đã gửi cho $count_send mail vào " . $time . "\\n";
        fwrite($myfile, $data);
        fclose($myfile);
        return 'Đã gửi thành công:' . $count_send . ' email';
    }

    // public function actionSetEmail() {
    //     $shops = \common\models\shop\Shop::find()->select('shop.*, user.email as avatar1')->leftJoin('user', 'user.id = shop.id')->where("(shop.email IS NULL OR shop.email = '') AND user.email IS NOT NULL")->all();
    //     if($shops) foreach ($shops as $shop) {
    //         $shop->email = $shop->avatar1;
    //         $shop->save(false);
    //     }
    //     // echo "<pre>";
    //     // print_r($shops);
    //     die();
    // }
}
