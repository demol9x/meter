<?php

namespace common\models\user;

use Yii;

/**
 * This is the model class for table "{{%user_group}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $product_categorys
 * @property integer $created_at
 * @property integer $updated_at
 */
class UserGroup extends \common\models\ActiveRecordC
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_group}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'integer'],
            [['name', 'product_categorys'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Tên',
            'product_categorys' => 'Danh mục',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
