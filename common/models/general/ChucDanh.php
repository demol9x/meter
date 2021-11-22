<?php

namespace common\models\general;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "chuc_danh".
 *
 * @property string $id
 * @property string $name
 * @property integer $created_at
 * @property integer $updated_at
 */
class ChucDanh extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'chuc_danh';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Nghề nghiệp',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }
}
