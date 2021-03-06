<?php

namespace frontend\models;

use common\models\OptionPrice;
use common\models\shop\Shop;
use common\models\user\Tho;
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

    const TYPE_CA_NHAN = 1;
    const TYPE_DOANH_NGHIEP = 2;
    const TYPE_THO = 3;

    public $_error_opt;
    public $_shop = 0;
    public $cover;
    public $avatar;

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
            ['status', 'default', 'value' => self::STATUS_DELETED],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            [['email', 'address', 'facebook', 'link_facebook', 'id_social'], 'string', 'max' => 255],
            [['type_social', 'image_path', 'image_name', 'avatar_path', 'avatar_name', 'avatar', 'cover'], 'safe'],
            [['type'], 'integer'],
            ['birthday', 'safe']

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
            'created_at' => 'Ng??y t???o',
            'user_before' => 'M?? gi???i thi???u',
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

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
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
        $this->_error_opt = 'M???t kh???u c???p 2 kh??ng ????ng';
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
                    0 => 'Nh???p m?? OTP ???? ???????c g???i ?????n s??? ??i???n tho???i m?? qu?? kh??ch ???? ????ng k?? t??i kho???n',
                    1 => 'M?? OTP',
                ];
        }
        return [
            0 => 'X??c nh???n b???ng m???t kh???u c???p 2' . ($this->password_hash2 ? '' : '<br><a href="' . \yii\helpers\Url::to(['/management/profile/change-password2']) . '">Qu?? kh??ch ch??a c?? m???t kh???u c???p 2 <b style="color: red">?????n thi???t l???p ngay</b></a>'),
            1 => 'M???t kh???u c???p 2',
        ];
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

    function getKeyApp()
    {
        return self::PARDAM_CODE_APP . $this->id;
    }

    static function getShop()
    {
        $shop = self::find()->where(['type' => self::TYPE_DOANH_NGHIEP, 'status' => self::STATUS_ACTIVE])->asArray()->all();
        return array_column($shop, 'username', 'id');
    }

    public function getTho()
    {
        return $this->hasOne(Tho::className(), ['user_id' => 'id']);
    }

    public static function getCompany($options = [])
    {
        $query = Shop::find()->where(['status' => 1]);
        if (isset($options['s']) && $options['s']) {
            $query->andFilterWhere(['like', 'user.name', $options['s']]);
        }

        if (isset($options['province_id']) && $options['province_id']) {
            $query->andFilterWhere(['province_id' => $options['province_id']]);
        }

        if (isset($options['price_min']) && $options['price_min']) {
            $query->andFilterWhere(['>', 'price', $options['price_min'] - 1]);
        }
        if (isset($options['price_max']) && $options['price_max']) {
            $query->andFilterWhere(['<', 'price', $options['price_max'] + 1]);
        }

        if (isset($options['limit']) && $options['limit']) {
            $limit = $options['limit'];
        }
        if (isset($options['page'])) {
            $offset = ($options['page'] - 1) * $limit;
        } else {
            $offset = 0;
        }
        return $query->joinWith(['province'])
            ->orderBy('order ASC, updated_at DESC')
            ->limit($limit)->offset($offset)->asArray()->all();
    }

    public static function getS($options = [], $getdata = false)
    {
        $query = Shop::find()->where(['shop.status' => 1]);
        if (isset($options['s']) && $options['s']) {
            $query->andFilterWhere(['like', 'shop.name', $options['s']]);
        }
        if (isset($options['province_id']) && $options['province_id']) {
            $query->andFilterWhere(['shop.province_id' => $options['province_id']]);
        }



        if (isset($options['id_price']) && $options['id_price']) {
            $pr = OptionPrice::findOne($options['id_price']);
            $query->andFilterWhere(['>', 'price', $pr['price_min'] - 1]);
            $query->andFilterWhere(['<', 'price', $pr['price_max'] + 1]);
        }
        if (isset($options['limit']) && $options['limit']) {
            $limit = $options['limit'];
        }
        if (isset($options['page'])) {
            $offset = ($options['page'] - 1) * $limit;
        } else {
            $offset = 0;
        }
        $order = [];

        if (isset($options['sort']) && $options['sort']) {
            if($options['sort'] == 'new'){
                $order['created_at'] = SORT_DESC;
            }
            if($options['sort'] == 'rate'){
                $order['rate'] = SORT_DESC;
            }
            if($options['sort'] == 'name'){
                $order['name'] = SORT_ASC;
            }
        }

        $total = $query->count();
        $data = $query->joinWith(['province', 'user'])
            ->orderBy($order)
            ->limit($limit)->offset($offset)->asArray()->all();
        if (isset($getdata) && $getdata) {
            return $data;
        }
        return [
            'total' => $total,
            'data' => $data
        ];

    }

    public static function getT($options = [])
    {
        $query = Tho::find()->where(['tho.status' => 1]);
        if (isset($options['s']) && $options['s']) {
            $query->andFilterWhere(['like', 'tho.name', $options['s']]);
        }

        if (isset($options['province_id']) && $options['province_id']) {
            $query->andFilterWhere(['tho.province_id' => $options['province_id']]);
        }

        if (isset($options['job_id']) && $options['job_id']) {
            $query->andFilterWhere(['nghe_nghiep' => $options['job_id']]);
        }

        if (isset($options['kn']) && $options['kn']) {
            $query->andFilterWhere(['kinh_nghiem' => $options['kn']]);
        }

        if (isset($options['time']) && $options['time']) {
        }
        if (isset($options['sort']) && $options['sort']) {
            if($options['sort'] == 'new'){
                $order['created_at'] = SORT_DESC;
            }
            if($options['sort'] == 'rate'){
                $order['rate'] = SORT_DESC;
            }
            if($options['sort'] == 'name'){
                $order['name'] = SORT_ASC;
            }
        }
        $order = [];
        if (isset($options['sort']) && $options['sort']) {
            if($options['sort'] == 'new'){
                $order['created_at'] = SORT_DESC;
            }
            if($options['sort'] == 'rate'){
                $order['rate'] = SORT_DESC;
            }
            if($options['sort'] == 'name'){
                $order['name'] = SORT_ASC;
            }
        }

        if (isset($options['limit']) && $options['limit']) {
            $limit = $options['limit'];
        }
        if (isset($options['page'])) {
            $offset = ($options['page'] - 1) * $limit;
        } else {
            $offset = 0;
        }
        $total = $query->count();
        $data = $query->joinWith(['province', 'job', 'user'])
            ->orderBy($order)
            ->limit($limit)->offset($offset)->asArray()->all();
        return [
            'total' => $total,
            'data' => $data
        ];
    }
}
