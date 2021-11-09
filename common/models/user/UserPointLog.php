<?php

namespace common\models\user;

use Yii;

/**
 * This is the model class for table "user_point_log".
 *
 * @property string $id
 * @property integer $user_id
 * @property integer $point_before
 * @property integer $point_change
 * @property integer $point_after
 * @property integer $type
 * @property string $reason
 * @property integer $order_id
 * @property string $data
 * @property integer $created_at
 * @property integer $updated_at
 */
class UserPointLog extends \yii\db\ActiveRecord
{

    const TYPE_PLUS = 1; // Cộng điểm vào tài khoản
    const TYPE_DEDUCT = 2; // Trừ điểm vào tài khoản

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_point_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'reason'], 'required'],
            [['user_id', 'point_before', 'point_change', 'point_after', 'type', 'order_id', 'created_at', 'updated_at'], 'integer'],
            [['reason'], 'string', 'max' => 255],
            [['data'], 'safe']
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
            'point_before' => 'Điểm trước',
            'point_change' => 'Điểm thay đổi',
            'point_after' => 'Điểm sau',
            'type' => 'Loại',
            'reason' => 'Lý do',
            'order_id' => 'Đơn hàng',
            'created_at' => 'Ngày tạo',
            'updated_at' => 'Ngày cập nhật',
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
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
}
