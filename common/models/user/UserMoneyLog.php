<?php

namespace common\models\user;

use Yii;

/**
 * This is the model class for table "user_money_log".
 *
 * @property string $id
 * @property string $phone
 * @property string $money_before
 * @property string $money
 * @property string $money_after
 * @property string $order_id
 * @property string $note
 * @property string $user_id
 * @property integer $type
 * @property string $created_at
 * @property string $updated_at
 */
class UserMoneyLog extends \yii\db\ActiveRecord {

    const TYPE_PLUS = 1; // Cộng tiền vào tài khoản
    const TYPE_DEDUCT = 2; // Trừ tiền vào tài khoản
    
    /**
     * @inheritdoc
     */

    public static function tableName() {
        return 'user_money_log';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['phone', 'money_before', 'money', 'money_after'], 'required'],
            [['money_before', 'money', 'money_after', 'order_id', 'user_id', 'type', 'created_at', 'updated_at'], 'integer'],
            [['phone'], 'string', 'max' => 20],
            [['note'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'phone' => 'Số điện thoại',
            'money_before' => 'Tiền trước khi giao dịch',
            'money' => 'Tiền giao dịch',
            'money_after' => 'Tiền sau khi giao dịch',
            'order_id' => 'Mã đơn hàng',
            'note' => 'Ghi chú',
            'user_id' => 'Tài khoản cập nhật',
            'type' => 'Loại giao dịch',
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

    public static function getAllLogsByPhone($phone) {
        //
        $data = UserMoneyLog::find()->where('phone=:phone', [
                    ':phone' => $phone
                ])->asArray()->all();
        //
        return $data;
    }

}
