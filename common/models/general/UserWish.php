<?php

namespace common\models\general;

use Yii;

/**
 * This is the model class for table "user_wish".
 *
 * @property string $id
 * @property integer $user_id_from
 * @property integer $user_id
 * @property integer $type
 * @property integer $created_at
 */
class UserWish extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_wish';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id_from', 'user_id'], 'required'],
            [['user_id_from', 'user_id', 'type', 'created_at'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id_from' => 'User Id From',
            'user_id' => 'User ID',
            'type' => 'Type',
            'created_at' => 'Created At',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->created_at = time();
            }
            return true;
        } else {
            return false;
        }
    }
}
