<?php

namespace common\models\notifications;

use Yii;
use yii\helpers\Url;
use common\components\ClaLid;
use yii\db\Query;

/**
 * This is the model class for table "notifications".
 *
 * @property string $id
 * @property string $title
 * @property string $description
 * @property string $link
 * @property integer $type
 * @property string $recipient_id
 * @property string $sender_id
 * @property integer $unread
 * @property string $created_at
 * @property string $updated_at
 */
class Notifications extends \common\models\ActiveRecordC
{

    const PROMOTION = 1; // Thông báo khuyến mãi
    const ORDER = 2; // Thông báo đơn hàng
    const UPDATE_SYSTEM = 3; // Cập nhật hệ thống
    const TYPE_USER_ALL = '-111';
    const TYPE_WAITING_SEND = '-11';
    const TYPE_USER_SHOP = '-1';
    const TYPE_USER_GROUP = 'UG';
    const TYPE_REGION = 'RG';
    const TYPE_PROVINCE = 'PI';

    /**
     * @inheritdoc
     */

    public static function tableName()
    {
        return 'notifications';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'description', 'type'], 'required'],
            [['description'], 'string'],
            [['type', 'unread', 'created_at'], 'integer'],
            [['title', 'link'], 'string', 'max' => 255],
            [['recipient_id', 'updated_at', 'sender_id'], 'safe'],
        ];
    }

    public static function getArrNotification()
    {
        $users = (new \yii\db\Query())->from('user')
            ->select('id, username')
            ->orderBy('id ASC')
            ->all();
        $arr = [
            self::TYPE_USER_ALL => 'Tất cả tài khoản',
            self::TYPE_USER_SHOP => 'Tất cả gian hàng',
        ];
        $lisg = (new \common\models\user\UserGroup())->options();
        if ($lisg) foreach ($lisg as $key => $value) {
            $arr[self::TYPE_USER_GROUP . $key] = self::TYPE_USER_GROUP . '-' . $value;
        }
        if ($users) {
            foreach ($users as $user) {
                $arr[$user['id']] = 'U-' . $user['id'] . '.' . $user['username'];
            }
        }
        $lisg = \common\models\Province::optionRegions();
        if ($lisg) foreach ($lisg as $key => $value) {
            $arr[self::TYPE_REGION . $key] = self::TYPE_REGION . '-' . $value;
        }
        $lisg = (new \common\models\Province())->options();
        if ($lisg) foreach ($lisg as $key => $value) {
            $arr[self::TYPE_PROVINCE . $key] = self::TYPE_PROVINCE . '-' . $value;
        }
        return $arr;
    }

    public static function getArrNotificationG()
    {
        $arr = [
            // self::TYPE_USER_ALL => 'Tất cả tài khoản',
            self::TYPE_USER_SHOP => 'Tất cả gian hàng',
        ];
        $lisg = (new \common\models\user\UserGroup())->options();
        if ($lisg) foreach ($lisg as $key => $value) {
            $arr[self::TYPE_USER_GROUP . $key] = self::TYPE_USER_GROUP . '-' . $value;
        }
        $lisg = \common\models\Province::optionRegions();
        if ($lisg) foreach ($lisg as $key => $value) {
            $arr[self::TYPE_REGION . $key] = self::TYPE_REGION . '-' . $value;
        }
        $lisg = (new \common\models\Province())->options();
        if ($lisg) foreach ($lisg as $key => $value) {
            $arr[self::TYPE_PROVINCE . $key] = self::TYPE_PROVINCE . '-' . $value;
        }
        return $arr;
    }

    public static function getArrNotificationRule()
    {
        $user = Yii::$app->user->identity;
        if ($user->isAllRuleNotify()) {
            return self::getArrNotification();
        } else if ($user->rule_notifys) {
            $rule_notifys = json_decode($user->rule_notifys, true);
            $arr = self::getArrNotificationG();
            $re = [];
            foreach ($rule_notifys as $key) if (isset($arr[$key])) {
                $re[$key] = $arr[$key];
            }
            return $re;
        }
        return [];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Tiêu đề',
            'description' => 'Nội dung',
            'link' => 'Link',
            'type' => 'Loại thông báo',
            'recipient_id' => 'Người nhận',
            'sender_id' => 'Người gửi',
            'unread' => 'Chưa đọc',
            'created_at' => 'Ngày tạo',
            'updated_at' => 'Ngày gửi(Gủi ngay nếu bỏ trống hoặc nhập thời gian nhỏ hơn thời gian hiện tại)',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->created_at = time();
            } else {
                $this->updated_at = time();
            }
            //
            return true;
        } else {
            return false;
        }
    }

    public static function updateStatusOrder($order)
    {
        $notify = [];
        $order_id = $order->id;
        $notify['title'] = Yii::t('app', 'update_order_message') . 'OR' . $order_id;
        $notify['description'] = Yii::t('app', 'update_order_message_2') . 'OR' . $order_id . Yii::t('app', 'update_order_message_3') . \common\models\order\Order::arrayStatus($order->status);
        $notify['type'] = Notifications::ORDER;
        if (Yii::$app->user->id != $order->shop_id) {
            $notify['link'] = \common\components\ClaUrl::to(['/management/order/index']);
            $notify['recipient_id'] = $order->shop_id;
            Notifications::pushMessage($notify);
            $shop = \common\models\shop\Shop::findOne($order->shop_id);
            if ($shop && $shop['email']) {
                \common\models\mail\SendEmail::sendMail([
                    'email' => $shop['email'],
                    'title' => $notify['title'],
                    'content' => $notify['description']
                ]);
            }
        }
        if (Yii::$app->user->id != $order->user_id) {
            $notify['link'] = \common\components\ClaUrl::to(['/management/order/index']);
            $notify['recipient_id'] = $order->user_id;
            Notifications::pushMessage($notify);
            $address = \common\models\user\UserAddress::getDefaultAddressByUserId($order->user_id);
            if ($address && $address['email']) {
                \common\models\mail\SendEmail::sendMail([
                    'email' => $address['email'],
                    'title' => $notify['title'],
                    'content' => $notify['description']
                ]);
            }
        }
    }

    public static function getAllNotifications($options = [])
    {
        $query = Notifications::find()->where(['recipient_id' => Yii::$app->user->id]);
        if (isset($options['type']) && $options['type']) {
            $query->andWhere(['type' => $options['type']]);
        }
        if (isset($options['limit']) && $options['limit']) {
            $query->limit($options['limit']);
        }
        $data = $query
            ->orderBy('id DESC')
            ->asArray()
            ->all();
        return $data;
    }

    public static function pushMessage($notify)
    {
        $model = new Notifications();
        $model->title = $notify['title'];
        $model->description = $notify['description'];
        $model->link = $notify['link'];
        $model->type = $notify['type'];
        $model->recipient_id = $notify['recipient_id'];
        $model->unread = ClaLid::STATUS_ACTIVED;
        if ($model->save()) {
            $notify = new \common\components\notifications\ClaMobileNotify();
            $noti = array(
                "body" => $model->description,
                "title" => $model->title,
                "text" => "Click me to open an Activity!", // chưa cần
                "sound" => "warning", // Chưa cần
                'badge' => self::countUnreadNotifications($model->recipient_id), // so luong notify chua doc
            );
            $response = $notify->send($model->recipient_id, array('notification' => $noti));
        }
    }

    public static function pushMessageAllUsers($notify)
    {
        $user_send = Yii::$app->user->id ? Yii::$app->user->id : 0;
        $values = '';
        $time_now = time();
        $model = new Notifications();
        $model->attributes = $notify;
        $model->sender_id = $user_send;
        $model->created_at = $model->updated_at = $time_now;
        $model->recipient_id = Notifications::TYPE_USER_ALL;
        $model->recipient_real_id = $notify['recipient_id'];
        if ($model->save()) {
            if ($notify['recipient_id'] > 0) {
                $values .= '("' . $notify['title'] . '", "' . $notify['description'] . '", "' . $notify['link'] . '", ' . $notify['type'] . ', ' . $notify['recipient_id'] . ', ' . $user_send . ', 1, ' . $time_now . ', ' . $time_now . ')';

                $sql = 'INSERT INTO notifications (title, description, link, type, recipient_id, sender_id, unread, created_at, updated_at) VALUES ' . $values;
                $notify_mb = new \common\components\notifications\ClaMobileNotify();
                $noti = array(
                    "body" => $notify['description'],
                    "title" => $notify['title'],
                    "text" => "Click me to open an Activity!", // chưa cần
                    "sound" => "warning", // Chưa cần
                );
                $response = $notify_mb->send($notify['recipient_id'], array('notification' => $noti));
                Yii::$app->db->createCommand($sql)->execute();
                self::sendApp(strip_tags($notify['title']), strip_tags($notify['description']), $notify['recipient_id'], ['link' => $notify['link'], 'type' => $notify['type']]);
                return 1;
            } else {
                $userIds = [];
                if (is_numeric($notify['recipient_id'])) {
                    switch ($notify['recipient_id']) {
                        case self::TYPE_USER_ALL:
                            $userIds = \common\models\User::getAllUserId();
                            break;
                        case self::TYPE_USER_SHOP:
                            $userIds = \common\models\User::getAllUserIdShop();
                            break;
                    }
                } else {
                    if (strpos($notify['recipient_id'], self::TYPE_USER_GROUP) !== false) {
                        $gr_id = str_replace(self::TYPE_USER_GROUP, '', $notify['recipient_id']);
                        $userIds = \common\models\user\UserInGroup::getAllUserId($gr_id);
                    } elseif (strpos($notify['recipient_id'], self::TYPE_REGION) !== false) {
                        $gr_id = str_replace(self::TYPE_REGION, '', $notify['recipient_id']);
                        $userIds = \common\models\Province::getAllUserIdByRegionID($gr_id);
                    } elseif (strpos($notify['recipient_id'], self::TYPE_PROVINCE) !== false) {
                        $gr_id = str_replace(self::TYPE_PROVINCE, '', $notify['recipient_id']);
                        $userIds = \common\models\Province::getAllUserId($gr_id);
                    }
                }
                if ($userIds) {
                    $values = '';
                    $time_now = time();
                    foreach ($userIds as $user_id) {
                        if ($values != '') {
                            $values .= ',';
                        }
                        if ($user_id > 0) {
                            $values .= '("' . $notify['title'] . '", "' . $notify['description'] . '", "' . $notify['link'] . '", ' . $notify['type'] . ', ' . $user_id . ', ' . $user_send . ', 1, ' . $time_now . ', ' . $time_now . ')';
                        }
                    }
                    $sql = 'INSERT INTO notifications (title, description, link, type, recipient_id, sender_id, unread, created_at, updated_at) VALUES ' . $values;
                    Yii::$app->db->createCommand($sql)->execute();
                    self::sendApp(strip_tags($notify['title']), strip_tags($notify['description']), $userIds, ['link' => $notify['link'], 'type' => $notify['type']]);
                    return 1;
                }
                return 0;
            }
        }
        return 0;
    }

    public static function optionsType()
    {
        return [
            self::PROMOTION => 'Khuyến mãi',
            self::ORDER => 'Đơn hàng',
            self::UPDATE_SYSTEM => 'Cập nhật'
        ];
    }

    public static function getTypeName($type)
    {
        $options = self::optionsType();
        return isset($options[$type]) ? $options[$type] : '';
    }

    public static function getImageNotification($type)
    {
        $img = Url::home() . 'images/';
        if ($type == self::PROMOTION) {
            $img .= 'icon-giamgia.png';
        } else if ($type == self::ORDER) {
            $img .= 'icon-order.png';
        } else if ($type == self::UPDATE_SYSTEM) {
            $img .= 'icon-system.png';
        }
        return $img;
    }

    /**
     * Lay so luong notify chua doc cua mot ai do
     * @param type $user_id
     * @return integer
     */
    static function countUnreadNotifications($user_id = 0)
    {
        $count = 0;
        $user_id = (int)$user_id;
        if ($user_id) {
            $count = \common\models\notifications\Notifications::find()
                ->where(['recipient_id' => $user_id, 'unread' => 1])
                ->count();
        }
        return (int)$count;
    }

    static function sendApp($title, $message, $user_id = null, $options = [])
    {
        $query = (new Query())->select('device_id')->from('user_device');
        if (!$user_id) {
            return false;
        }
        $data = $query->where(['user_id' => $user_id])->all();
        if ($data) {
            $registrationIds = array_column($data, 'device_id');
            $serverToken = 'AAAAzMnH5kQ:APA91bHF9N7iPzxx9VaertSH5kvoHhOVZ-_I9JpgAp9jJwTt-5yFlJUIC8jAszmTR8tj3PqMy1cKiOCW_LySPDPCjU2F0sVesfUmsfYXh4gj8VXuwUJZiPGEjsi-9xR61dOu3jr1K69T';
            $msg = array(
                'title' => $title,
                'body' => $message,
            );
            $options['click_action'] = 'FLUTTER_NOTIFICATION_CLICK';
            if (count($registrationIds) < 1000) {
                $fields = array(
                    "registration_ids" => $registrationIds,
                    'notification' => $msg,
                    'data' => $options
                );
                $headers = array(
                    'Authorization: key=' . $serverToken,
                    'Content-Type: application/json'
                );
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
                $result = curl_exec($ch);
                curl_close($ch);
                return $result;
            } else {
                $registrationIds = array_chunk($registrationIds, 999);
                foreach ($registrationIds as $value) {
                    $fields = array(
                        "registration_ids" => $value,
                        'notification' => $msg,
                        'data' => $options
                    );
                    $headers = array(
                        'Authorization: key=' . $serverToken,
                        'Content-Type: application/json'
                    );
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
                    $result = curl_exec($ch);
                    curl_close($ch);
                }
            }
        }
        return false;
    }

    function afterSave($insert, $changedAttributes)
    {
        $response = self::sendApp(strip_tags($this->title),  strip_tags($this->description), $this->recipient_id, ['link' => $this->link, 'type' => $this->type]);
        return parent::afterSave($insert, $changedAttributes);
    }
}
