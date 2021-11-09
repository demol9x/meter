<?php

namespace frontend\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

use common\components\ClaQrCode;
use yii\db\Query;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $type_social
 * @property string $id_social
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 * @property string $facebook
 * @property string $link_facebook
 */
class User extends ActiveRecord implements IdentityInterface
{

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;
    //
    const TYPE_SOCIAL_FACEBOOK = 1;
    const TYPE_SOCIAL_GOOGLE = 2;
    const PARDAM_CODE_APP = "PGAAPP";

    public $_error_opt;
    public $_shop = 0;

    /**
     * @inheritdoc
     */

    public static function tableName()
    {
        return '{{%user}}';
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
            ['email', 'email'],
            ['email', 'unique'],
            ['phone', 'unique'],
            ['user_before', 'integer', 'on' => ['backend']],
            ['username', 'trim'],
            ['phone', 'required'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['password_hash', 'string', 'min' => 6, 'max' => 255],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            [['email', 'address', 'facebook', 'link_facebook', 'id_social'], 'string', 'max' => 255],
            [['type_social', 'image_path', 'image_name', 'avatar_path', 'avatar_name'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app', 'full_name'),
            'phone' => Yii::t('app', 'phone'),
            'address' => Yii::t('app', 'address'),
            'sex' => Yii::t('app', 'sex'),
            'province_id' => Yii::t('app', 'province_id'),
            'status' => Yii::t('app', 'status'),
            'facebook' => Yii::t('app', 'facebook'),
            'link_facebook' => Yii::t('app', 'link_facebook'),
            'created_at' => 'Ngày tạo',
            'user_before' => 'Mã giới thiệu',
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
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by phone
     *
     * @param string $phone
     * @return static|null
     */
    public static function findByPhone($phone)
    {
        return static::findOne(['phone' => $phone, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
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
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
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
        if (!$this->password_hash) {
            return false;
        }
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function validatePassword2($password)
    {
        if (!$this->password_hash2) {
            return false;
        }
        return Yii::$app->security->validatePassword($password, $this->password_hash2);
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

    public function setPassword2($password)
    {
        $this->password_hash2 = Yii::$app->security->generatePasswordHash($password);
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

    public function afterSave($insert, $changedAttributes)
    {
        return parent::afterSave($insert, $changedAttributes);
    }

    /**
     * Author relation
     *
     * @return \yii\db\ActiveQuery
     */
    //    public function getAuthor()
    //    {
    //        $module = Yii::$app->getModule(\yii2mod\comments\models\CommentModel::$name);
    //
    //        return $this->hasOne($module->userIdentityClass, ['id' => 'createdBy']);
    //    }
    //
    //    public function getUsername() {
    //        return $this->author->username;
    //    }

    function checkOtp($otp)
    {
        \Yii::$app->session->open();
        $_SESSION['check_success_otp'] = false;
        $otp_type = \common\components\ClaLid::getSiteinfo()->otp;
        switch ($otp_type) {
            case 1:
                $check_otp = ClaQrCode::checkOtp($this->phone, $otp);
                $check_otp = json_decode($check_otp);
                if ($check_otp->success) {
                    ClaQrCode::updateOtp($this->phone, $otp);
                    Yii::$app->session->remove('otp-convert');
                    $_SESSION['check_success_otp'] = time();
                    return true;
                } else {
                    $this->_error_opt = $check_otp->message;
                    return false;
                }
        }
        if ($this->validatePassword2($otp)) {
            $_SESSION['check_success_otp'] = time();
            return true;
        }
        $this->_error_opt = 'Mật khẩu cấp 2 không đúng';
        return false;
    }

    function createInfoOtp($id_bank, $xu)
    {
        return [
            'success' => true,
            'data' => [
                'xu' => $xu,
                'bank_id' => $id_bank,
            ]
        ];
        //
        $phone = $this->phone;
        $session = ClaQrCode::getSession('otp-convert');
        if (isset($session) && $session) {
            if ($session['time'] + 90 < time()) {
                Yii::$app->session->remove('otp-convert');
                ClaQrCode::setSession('otp-convert', true);
                $getOtp = ClaQrCode::getOtp($phone);
                $getOtp = json_decode($getOtp);
                if ($getOtp->success) {
                    $return = [
                        'success' => true,
                        'data' => [
                            'xu' => $xu,
                            'bank_id' => $id_bank,
                        ]
                    ];
                } else {
                    $return = [
                        'success' => false,
                        'errors' => [
                            'otp' => $getOtp->message
                        ]
                    ];
                }
            } else {
                $return = [
                    'success' => true,
                    'data' => [
                        'xu' => $xu,
                        'bank_id' => $id_bank,
                    ]
                ];
            }
        } else {
            ClaQrCode::setSession('otp-convert', true);
            $getOtp = ClaQrCode::getOtp($phone);
            $getOtp = json_decode($getOtp);
            if ($getOtp->success) {
                $return = [
                    'success' => true,
                    'data' => [
                        'xu' => $xu,
                        'bank_id' => $id_bank,
                    ]
                ];
            } else {
                $return = [
                    'success' => false,
                    'errors' => [
                        'otp' => ['' . $getOtp->message . '']
                    ]
                ];
            }
        }
        return $return;
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

    function transferV($user_receive, $xu)
    {
        $gcoin = \common\models\gcacoin\Gcacoin::findOne($this->id);
        $siteif = \common\models\gcacoin\Config::getConfig();
        $xu = (float) $xu;
        if ($gcoin) {
            $first_coin1 = $gcoin->getCoin();
            $u_c = self::findOne($user_receive);
            if ($u_c) {
                $xu_t = $siteif->getCoinTransferFee($xu);
                $coin_fee = $xu_t - $xu;
                if ($gcoin->addCoin(-$xu_t) &&  $gcoin->save(false)) {
                    $gcoin_r = \common\models\gcacoin\Gcacoin::getModel($user_receive);
                    $first_coin2 = $gcoin_r->getCoin();
                    if ($gcoin_r->addCoin($xu) && $gcoin_r->save(false)) {
                        $history = new \common\models\gcacoin\GcaCoinHistory();
                        $history->user_id = $gcoin->user_id;
                        $history->type = 'TRANSFER_COIN';
                        $history->data = 'Chuyển V thành công.';
                        $history->gca_coin = -$xu_t;
                        $history->first_coin = $first_coin1;
                        $history->last_coin = $gcoin->getCoin();
                        $history->save(false);

                        if ($coin_fee > 0) {
                            $text = 'Nhận thành công ' . __VOUCHER . ' từ giao dịch chuyển tiền ID' . $history->id;
                            \common\models\gcacoin\Gcacoin::addCoinFeeTran($coin_fee, ['note' => $text, 'type' => 'TRANV_AFFILIATE']);
                        }
                        //
                        $history = new \common\models\gcacoin\GcaCoinHistory();
                        $history->user_id = $gcoin_r->user_id;
                        $history->type = 'TRANSFER_COIN';
                        $history->data = 'Nhận V chuyển thành công.';
                        $history->gca_coin = $xu;
                        $history->first_coin = $first_coin2;
                        $history->last_coin = $gcoin_r->getCoin();
                        $history->save(false);
                        //
                        $text = 'Bạn nhận được <b style="color: green"> ' . formatMoney($history->gca_coin) . '</b> V chuyển từ tài khoản ID' . $this->id . '.  Số dư hiện tại: <b style="color: green">' . number_format($history->last_coin, 0, ',', '.') . '</b> V';
                        $tl = 'Nhận V chuyển thành công.';
                        if ($u_c && $u_c->email) {
                            \common\models\mail\SendEmail::sendMail([
                                'email' => $u_c->email,
                                'title' => $tl,
                                'content' => $text
                            ]);
                        }
                        $noti = new \common\models\notifications\Notifications();
                        $noti->title = $tl;
                        $noti->description = $text;
                        $noti->link = \common\components\ClaUrl::to(['/management/gcacoin/index']);
                        $noti->type = 3;
                        $noti->recipient_id = $gcoin_r->user_id;
                        $noti->unread = \common\components\ClaLid::STATUS_ACTIVED;
                        $noti->save();
                        return true;
                    } else {
                        $gcoin->addCoin($xu);
                        $gcoin->save(false);
                        $this->_error_opt = 'Chuyển V không thành công. Tài khoản của nhận không thể thực hiện được giao dịch này.';
                        return false;
                    }
                } else {
                    $this->_error_opt = 'Chuyển V không thành công. Tài khoản của quý khách không thể thực hiện được giao dịch này.';
                    return false;
                }
            } else {
                $this->_error_opt = 'Chuyển V không thành công. Tài khoản của nhận không thể thực hiện được giao dịch này!';
                return false;
            }
        } else {
            $this->_error_opt = 'Chuyển V không thành công. Tài khoản của quý khách không thể thực hiện được giao dịch này.';
            return false;
        }
    }

    function transferVr($xu)
    {
        $gcoin = \common\models\gcacoin\Gcacoin::findOne($this->id);
        $xu = (float) $xu;
        if ($gcoin) {
            $first_coinv = $gcoin->getCoin();
            $first_coinvr = $gcoin->getCoinRed();
            if ($gcoin->addCoinRed(-$xu) && $gcoin->addCoin(+$xu) &&  $gcoin->save(false)) {
                $history = new \common\models\gcacoin\GcaCoinHistory();
                $history->user_id = $gcoin->user_id;
                $history->type = 'TRANSFER_VRCOIN';
                $history->data = 'Chuyển đổi Vr thành V thành công.';
                $history->gca_coin = -$xu;
                $history->first_coin = $first_coinvr;
                $history->last_coin = $gcoin->getCoinRed();
                $history->type_coin = 1;
                $history->save(false);
                //
                $history = new \common\models\gcacoin\GcaCoinHistory();
                $history->user_id = $gcoin->user_id;
                $history->type = 'TRANSFER_VRCOIN';
                $history->data = 'Nhận V chuyển từ Vr thành công.';
                $history->gca_coin = $xu;
                $history->first_coin = $first_coinv;
                $history->last_coin = $gcoin->getCoin();
                $history->save(false);
                return true;
            } else {
                $this->_error_opt = 'Chuyển V không thành công. Tài khoản của quý khách không thể thực hiện được giao dịch này.';
                return false;
            }
        } else {
            $this->_error_opt = 'Chuyển V không thành công. Tài khoản của quý khách không thể thực hiện được giao dịch này.';
            return false;
        }
    }

    function successOtp()
    {
        \Yii::$app->session->open();
        if (isset($_SESSION['check_success_otp']) && $_SESSION['check_success_otp']) {
            $_SESSION['check_success_otp'] = false;
            return true;
        }
        return false;
    }

    function getGruopLabels()
    {
        $data = \common\models\user\UserGroup::find()->leftJoin('user_in_group', 'user_in_group.user_group_id = user_group.id')->where(['user_in_group.user_id' => $this->id, 'status' => 1])->all();
        $data = $data ? array_column($data, 'name') : [];
        return implode(', ', $data);
    }

    function getAllGruops()
    {
        return (new Query())->select('user_group.*, user_in_group.status, user_in_group.user_id, user_in_group.image,user_in_group.id as user_in_group_id')->from('user_group')->leftJoin('user_in_group', 'user_in_group.user_group_id = user_group.id')->where(['user_in_group.user_id' => $this->id])->all();
    }

    function addAffilliateApp()
    {
        if ($this->user_gt_app == 2) {
            $this->_error_opt = "Tài khoản đã hết quyền tham gia.";
            return false;
        }
        $aff = \common\models\affiliate\Affiliate::find()->one();
        if ($this->user_before && $this->user_before != $this->id && $user = self::findIdentity($this->user_before)) {
            $coin = ($aff->sale_befor_app_status == 1) ? $aff->sale_befor_app_value : 0;
            if ($coin > 0) {
                $gcoin = \common\models\gcacoin\Gcacoin::getModel($user->id);
                $first_coin = $gcoin->getCoinSale();
                if ($gcoin->addCoinSale($coin) && $gcoin->save(false)) {
                    $history = new \common\models\gcacoin\GcaCoinHistory();
                    $history->user_id = $gcoin->user_id;
                    $history->type = \common\models\gcacoin\GcaCoinHistory::AFFILLATE_APP;
                    $history->data = 'Tặng ' . __VOUCHER_SALE . ' giới thiệu tài khoản ID' . $this->id . ': ' . $this->username . ' đăng nhập App lần đầu tiên.';
                    $history->gca_coin = $coin;
                    $history->first_coin = $first_coin;
                    $history->last_coin = $gcoin->getCoinSale();
                    $history->type_coin = \common\models\gcacoin\GcaCoinHistory::TYPE_V_SALE;
                    $history->save(false);
                    $noti = new \common\models\notifications\Notifications();
                    $noti->title = $history->data;
                    $noti->description = 'Bạn nhận được ' . formatCoin($history->gca_coin) . ' ' . __VOUCHER_SALE . '. Số dư hiện tại: <b style="color: green">'  . formatCoin($history->last_coin) . ' ' . __VOUCHER_SALE . '</b>';
                    $noti->link = \common\components\ClaUrl::to(['/management/gcacoin/index']);
                    $noti->type = 3;
                    $noti->recipient_id = $gcoin->user_id;
                    $noti->unread = \common\components\ClaLid::STATUS_ACTIVED;
                    $noti->save();
                }
            }
            $this->user_gt_app = 2;
        } else if ($this->user_gt_app == 1) {
            $this->_error_opt = "Tài khoản đã hết quyền tham gia.";
            return false;
        }
        $coin = ($aff->sale_for_app_status == 1) ? $aff->sale_for_app_value : 0;
        if ($coin > 0) {
            $gcoin = \common\models\gcacoin\Gcacoin::getModel($this->id);
            $first_coin = $gcoin->getCoinSale();
            if ($gcoin->addCoinSale($coin) && $gcoin->save(false)) {
                $history = new \common\models\gcacoin\GcaCoinHistory();
                $history->user_id = $gcoin->user_id;
                $history->type = \common\models\gcacoin\GcaCoinHistory::AFFILLATE_APP;
                $history->data = 'Tặng ' . __VOUCHER_SALE . ' từ chương trình tặng ' . __VOUCHER_SALE . ' cho lần đăng nhập APP đầu tiên.';
                $history->gca_coin = $coin;
                $history->first_coin = $first_coin;
                $history->type_coin = \common\models\gcacoin\GcaCoinHistory::TYPE_V_SALE;
                $history->last_coin = $gcoin->getCoinSale();
                $history->save(false);

                $noti = new \common\models\notifications\Notifications();
                $noti->title = $history->data;
                $noti->description = 'Bạn nhận được ' . formatCoin($history->gca_coin) . ' ' . __VOUCHER_SALE . '. Số dư hiện tại: <b style="color: green">'  . formatCoin($history->last_coin) . ' ' . __VOUCHER_SALE . '</b>';
                $noti->link = \common\components\ClaUrl::to(['/management/gcacoin/index']);
                $noti->type = 3;
                $noti->recipient_id = $gcoin->user_id;
                $noti->unread = \common\components\ClaLid::STATUS_ACTIVED;
                $noti->save();
            }
        }
        $this->user_gt_app = ($this->user_gt_app > 1) ? $this->user_gt_app : 1;
        $this->save(false);
        return $coin;
        // return false;
    }

    function getKeyApp()
    {
        return self::PARDAM_CODE_APP . $this->id;
    }

    function getQrSendV()
    {
        $data = [
            'type' => 'user',
            'data' => [
                'user_id' => $this->id,
            ]
        ];
        return \common\components\ClaQrCode::GenQrCode($data);
    }

    function getQrSendService()
    {
        $shop = $this->getShop();
        if ($shop && $shop->affilliate_status_service) {
            $data = [
                'type' => 'user_service',
                'data' => [
                    'user_id' => $this->id,
                ]
            ];
            return \common\components\ClaQrCode::GenQrCode($data);
        }
        return '';
    }

    function getQrSendBeforeShop()
    {
        $url = __SERVER_NAME . '/dang-ky.html?user_id=' . $this->id;
        $token = md5($url);
        $file_name = $token . '.png';
        $src = '/static/media/images/qrcode/' . $file_name;
        if (is_file('../..' . $src)) {
            return __SERVER_NAME . $src;
        }
        $qrCode = (new \Da\QrCode\QrCode($url))
            ->setSize(150)
            ->setMargin(5)
            ->useForegroundColor(51, 153, 255);
        $qrCode->writeFile($file_name); // writer defaults to PNG when none is specified
        return  __SERVER_NAME . $src;
    }

    function getShop()
    {
        if ($this->_shop !== 0) {
            return $this->_shop;
        }
        $this->_shop = \common\models\shop\Shop::findOne($this->id);
        return $this->_shop;
    }
}
