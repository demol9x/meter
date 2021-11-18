<?php

namespace common\models\user;

use Yii;

/**
 * This is the model class for table "{{%shop_address}}".
 *
 * @property string $id
 * @property string $shop_id
 * @property string $name_contact
 * @property string $phone
 * @property string $email
 * @property integer $province_id
 * @property integer $district_id
 * @property integer $ward_id
 * @property string $address
 * @property integer $isdefault
 */
class UserAddress extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'name_contact', 'phone', 'email', 'province_id', 'district_id', 'ward_id', 'address'], 'required'],
            [['user_id', 'province_id', 'phone', 'district_id', 'ward_id', 'isdefault'], 'integer'],
            [['name_contact', 'address', 'email'], 'string', 'max' => 255],
            [['phone'], 'integer'],
            [['phone'], 'string', 'min' => 10, 'max' => 13],
            [['province_name', 'district_name', 'ward_name', 'latlng'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'name_contact' => Yii::t('app', 'name_contact'),
            'phone' => Yii::t('app', 'phone'),
            'province_id' => Yii::t('app', 'province'),
            'district_id' => Yii::t('app', 'district'),
            'ward_id' => Yii::t('app', 'ward'),
            'address' => Yii::t('app', 'address'),
            'isdefault' => Yii::t('app', 'default'),
        ];
    }

    public static function addAddress($address)
    {
        $model = new UserAddress();
        $model->user_id = $address->id;
        $model->province_id = $address->province_id;
        $model->province_name = $address->province_name;
        $model->district_id = $address->district_id;
        $model->district_name = $address->district_name;
        $model->ward_id = $address->ward_id;
        $model->ward_name = $address->ward_name;
        $model->latlng = $address->latlng;
        $model->address = $address->address;
        $model->name_contact = $address->name_contact;
        $model->phone = $address->phone;
        $model->isdefault = 1;
        return $model->save();
    }

    public static function getAddressUserCurrent($user_id = null)
    {
        $user_id = $user_id ? $user_id : Yii::$app->user->id;
        if (isset($user_id) && $user_id) {
            $condition = 'user_id=:user_id';
            $params = [':user_id' => $user_id];
            $data = UserAddress::find()->where($condition, $params)->asArray()->all();
            return $data;
        }
        return [];
    }

    public static function getDefaultAddress()
    {
        $user_id = Yii::$app->user->id;
        $address = [];
        if (isset($user_id) && $user_id) {
            $condition = 'user_id=:user_id AND isdefault=:isdefault';
            $params = [
                ':user_id' => $user_id,
                ':isdefault' => \common\components\ClaLid::STATUS_ACTIVED
            ];
            $address = UserAddress::find()->where($condition, $params)->asArray()->one();
        }
        return $address;
    }

    public static function getDefaultAddressByUserId($user_id)
    {
        $address = [];
        if (isset($user_id) && $user_id) {
            $condition = 'user_id=:user_id AND isdefault=:isdefault';
            $params = [
                ':user_id' => $user_id,
                ':isdefault' => \common\components\ClaLid::STATUS_ACTIVED
            ];
            $address = UserAddress::find()->where($condition, $params)->asArray()->one();
        }
        return $address;
    }

    public static function getDefaultAddressOject()
    {
        $user_id = Yii::$app->user->id;
        $address = [];
        if (isset($user_id) && $user_id) {
            $condition = 'user_id=:user_id AND isdefault=:isdefault';
            $params = [
                ':user_id' => $user_id,
                ':isdefault' => \common\components\ClaLid::STATUS_ACTIVED
            ];
            $address = UserAddress::find()->where($condition, $params)->one();
        }
        return $address;
    }

    function beforeSave($insert)
    {
        $this->province_name = ($tg = \common\models\Province::findOne($this->province_id)) ? $tg['name'] : '';
        $this->district_name = ($tg = \common\models\District::findOne($this->district_id)) ? $tg['name'] : '';
        $this->ward_name = ($tg = \common\models\Ward::findOne($this->ward_id)) ? $tg['name'] : '';
        $this->latlng = $this->latlng ? $this->latlng : ($tg ? $tg->latlng : '');
        return parent::beforeSave($insert);
    }
    public function getUnsetDefaul($id){
        $data = Self::find()
            ->select('card_id')
            ->where('is')
            ->column();
        

    }
}

