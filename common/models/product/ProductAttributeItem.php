<?php

namespace common\models\product;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "product_attribute_item".
 *
 * @property string $id
 * @property integer $attribute_id
 * @property string $value
 * @property string $value_option
 */
class ProductAttributeItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_attribute_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['attribute_id', 'value'], 'required'],
            [['attribute_id'], 'integer'],
            [['value','value_option'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'attribute_id' => 'Attribute ID',
            'value_option' => 'Giá trị tùy chọn (ví dụ mã màu v...v)',
            'value' => 'Value',
        ];
    }


    public static function getItemByAttribute($id) {
        if (isset($id) && $id) {
            $data = (new Query())->select('*')
                ->from(self::tableName())
                ->where(['id' => $id])
                ->one();
            return $data;
        }
        return [];
    }
}
