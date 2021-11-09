<?php

namespace backend\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use common\components\ClaLid;

/**
 * UserAdmin model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 * @property integer $type
 */
class UserAdmin extends ActiveRecord implements IdentityInterface
{

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;
    const USER_ADMIN = 1; // Tài khoản quản trị
    const USER_DELIVERY = 2; // Tài khoản giao hàng

    public $_error_opt;

    /**
     * @inheritdoc
     */

    public static function tableName()
    {
        return '{{%user_admin}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            ['type', 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Tên đăng nhập',
            'email' => 'Email',
            'status' => 'Trạng thái',
            'created_at' => 'Ngày tạo',
            'type' => 'Loại tài khoản'
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user admin by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user_admin.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function validatePassword2($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash2);
    }

    public function setPassword2($password)
    {
        $this->password_hash2 = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public static function arrayType()
    {
        return [
            self::USER_ADMIN => 'Admin quản trị',
            self::USER_DELIVERY => 'Tài khoản thường',
        ];
    }

    public static function getTypeName($type)
    {
        $data = self::arrayType();
        return isset($data[$type]) ? $data[$type] : $type;
    }

    public static function optionsUserDelivery()
    {
        $data = UserAdmin::find()->where('status=:status AND type=:type', [
            ':status' => ClaLid::STATUS_ACTIVED,
            ':type' => UserAdmin::USER_DELIVERY
        ])->asArray()->all();
        return array_column($data, 'username', 'id');
    }

    public static function generateSelectUserDelivery($user_id)
    {
        $data = UserAdmin::find()->where('status=:status AND type=:type', [
            ':status' => ClaLid::STATUS_ACTIVED,
            ':type' => UserAdmin::USER_DELIVERY
        ])->all();
        $html = '';
        $admin_user_id = Yii::$app->user->id;
        $disabled = '';
        if ($user_id) {
            $disabled = 'disabled';
        }
        if ($admin_user_id == 1 || $admin_user_id == 3) {
            $disabled = '';
        }
        if (isset($data) && $data) {
            $html .= '<select class="select_user_delivery" ' . $disabled . '>';
            $html .= '<option value="0">-------------</option>';
            foreach ($data as $user) {
                $html .= '<option ' . ($user_id == $user->id ? 'selected' : '') . ' value="' . $user->id . '">';
                $html .= $user->username;
                $html .= '</option>';
            }
            $html .= '</select>';
        }
        return $html;
    }

    public static function generateSelectReceivedMoney($received_money)
    {
        $html = '<input ' . ($received_money ? 'checked disabled' : '') . ' type="checkbox" value="1" class="received_money">';
        return $html;
    }

    public static function generateButtonDelivery($status)
    {
        $html = '<input class="btn btn-primary delivery-success" type="button" value="Giao thành công" />';
        $html .= '<br />';
        $html .= '<br />';
        $html .= '<input class="btn btn-primary delivery-waiting" type="button" value="Chờ giao lại" />';
        return $html;
    }

    function checkOtp($otp)
    {
        \Yii::$app->session->open();
        $_SESSION['check_success_otp_admin'] = false;
        $otp_type = \common\components\ClaLid::getSiteinfo()->otp;
        switch ($otp_type) {
            case 1:
                $check_otp = ClaQrCode::checkOtp($this->phone, $otp);
                $check_otp = json_decode($check_otp);
                if ($check_otp->success) {
                    ClaQrCode::updateOtp($this->phone, $otp);
                    Yii::$app->session->remove('otp-convert');
                    return true;
                } else {
                    $this->_error_opt = $check_otp->message;
                    return false;
                }
        }
        if ($this->validatePassword2($otp)) {
            $_SESSION['check_success_otp_admin'] = time();
            return true;
        }
        $this->_error_opt = 'Mật khẩu cấp 2 không đúng';
        return false;
    }

    function successOtp()
    {
        \Yii::$app->session->open();
        if (isset($_SESSION['check_success_otp_admin']) && $_SESSION['check_success_otp_admin']) {
            $_SESSION['check_success_otp_admin'] = false;
            return true;
        }
        return false;
    }

    function createInfoOtpBackend($post)
    {
        return [
            'success' => true,
            'data' => $post
        ];
        $phone = PhoneOtp::find()->one()->phone;
        $session = ClaQrCode::getSession('otp-recharge');
        if (isset($session) && $session) {
            if ($session['time'] + 90 < time()) {
                Yii::$app->session->remove('otp-recharge');
                ClaQrCode::setSession('otp-recharge', true);
                $getOtp = ClaQrCode::getOtp($phone);
                $getOtp = json_decode($getOtp);
                if ($getOtp->success) {
                    $return = [
                        'success' => true,
                        'data' => $post
                    ];
                } else {
                    $return = [
                        'success' => false,
                        'errors' => $getOtp->message
                    ];
                }
            } else {
                $return = [
                    'success' => true,
                    'data' => $post
                ];
            }
        } else {
            ClaQrCode::setSession('otp-recharge', true);
            $getOtp = ClaQrCode::getOtp($phone);
            $getOtp = json_decode($getOtp);
            if ($getOtp->success) {
                $return = [
                    'success' => true,
                    'data' => $post
                ];
            } else {
                $return = [
                    'success' => false,
                    'errors' => $getOtp->message
                ];
            }
        }
    }

    function getTextOtp()
    {
        $otp_type = \common\components\ClaLid::getSiteinfo()->otp;
        switch ($otp_type) {
            case 1:
                return [
                    0 => 'Nhập mã OTP đã được gửi đến số điện thoại mà quý khách đã đăng ký tài khoản',
                    1 => 'Mã OTP',
                ];
        }
        return [
            0 => 'Xác nhận bằng mật khẩu cấp 2' . ($this->password_hash2 ? '' : '<br><a href="' . \yii\helpers\Url::to(['/management/profile/change-password2']) . '">Quý khách chưa có mật khẩu cấp 2 <b style="color: red">Đến thiết lập ngay</b></a>'),
            1 => 'Mật khẩu cấp 2',
        ];
    }

    function loadRuleNotify($data)
    {
        $tg = isset($data['rule_notifys']) ? $data['rule_notifys'] : [];
        $this->rule_notifys = $tg ? json_encode($tg) : '';
    }

    function isAllRuleNotify()
    {
        if ($this->type == 1 || $this->rule_notifys == json_encode([\common\models\notifications\Notifications::TYPE_USER_ALL])) {
            return true;
        }
        return false;
    }
}
