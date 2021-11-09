<?php

namespace common\models\user;

use common\components\ClaGenerate;
use common\components\ClaLid;
use common\models\product\ProductCategory;
use Yii;

/**
 * This is the model class for table "user_point".
 *
 * @property string $user_id
 * @property string $point
 * @property string $point_hash
 * @property string $point_error
 * @property integer $created_at
 * @property integer $updated_at
 */
class UserPoint extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_point';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'point_hash'], 'required'],
            [['user_id', 'point', 'point_error', 'created_at', 'updated_at'], 'integer'],
            [['point_hash'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'point' => 'Điểm',
            'point_hash' => 'Điểm mã hóa',
            'point_error' => 'Điểm đang bị lỗi',
            'created_at' => 'Thời gian tích điểm',
            'updated_at' => 'Thời gian cập nhật',
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
