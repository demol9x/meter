<?php

namespace common\models\package;

use Yii;

/**
 * This is the model class for table "package_wish".
 *
 * @property string $id
 * @property integer $package_id
 * @property integer $user_id
 * @property integer $created_at
 */
class PackageWish extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'package_wish';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['package_id', 'user_id'], 'required'],
            [['package_id', 'user_id', 'created_at'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'package_id' => 'Package ID',
            'user_id' => 'User ID',
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
