<?php

namespace common\models\user;

use Yii;
use common\components\ClaGenerate;

/**
 * This is the model class for table "user_money".
 *
 * @property string $id
 * @property string $phone
 * @property string $money
 * @property string $money_hash
 * @property string $created_at
 * @property string $updated_at
 */
class UserMoney extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'user_money';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['phone', 'money'], 'required'],
            [['money', 'created_at', 'updated_at'], 'integer'],
            [['phone'], 'string', 'max' => 20],
            [['money_hash'], 'string', 'max' => 255],
            [['phone'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'phone' => 'Số điện thoại',
            'money' => 'Tiền',
            'money_hash' => 'Money Hash',
            'created_at' => 'Ngày tạo',
            'updated_at' => 'Ngày cập nhật',
        ];
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->created_at = $this->updated_at = time();
            } else {
                $this->updated_at = time();
            }
            return true;
        } else {
            return false;
        }
    }

    public static function getCurrentMoney($phone) {
        $money = 0;
        $model = UserMoney::find()->where('phone=:phone', [':phone' => $phone])->one();
        if ($model) {
            $money_decrypt = ClaGenerate::decrypt($model->money_hash);
            if ($money_decrypt == $model->money) {
                $money = $model->money;
            }
        }
        return $money;
    }

}
