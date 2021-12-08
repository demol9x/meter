<?php

namespace common\models\product;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Query;

/**
 * This is the model class for table "product_variables".
 *
 * @property string $id
 * @property integer $product_id
 * @property string $key
 * @property string $name
 * @property string $price
 * @property integer $status
 * @property integer $quantity
 * @property string $avatar_path
 * @property string $avatar_name
 * @property string $code
 * @property integer $default
 * @property string $alias
 * @property integer $created_at
 * @property integer $updated_at
 */
class ProductVariables extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_attribute_variables';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'key'], 'required'],
            [['product_id', 'status', 'quantity', 'default', 'created_at', 'updated_at'], 'integer'],
            [['key'], 'string'],
            [['price'], 'number'],
            [['name', 'avatar_path', 'avatar_name', 'alias'], 'string', 'max' => 250],
            [['code'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'key' => 'Key',
            'name' => 'Name',
            'price' => 'Price',
            'status' => 'Status',
            'quantity' => 'Quantity',
            'avatar_path' => 'Avatar Path',
            'avatar_name' => 'Avatar Name',
            'code' => 'Code',
            'default' => 'Default',
            'alias' => 'Alias',
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

    static function getVarable($options = []) {
        $condition = 'id <> 0';
        $params = [];
        if (isset($options['id']) && $options['id']) {
            $condition .= " AND id = :id";
            $params[':id'] = $options['id'];
        }
        if (isset($options['product_id']) && $options['product_id']) {
            $condition .= " AND product_id = :product_id";
            $params[':product_id'] = $options['product_id'];
        }
        if (isset($options['key']) && $options['key']) {
            $options['key'] = (string)$options['key'];
            $condition .= " AND `key` = :key";
            $params[':key'] = $options['key'];
        }
        if (isset($options['default']) && $options['default']) {
            $condition .= " AND `default` = :default";
            $params[':default'] = $options['default'];
        }
        $data = (new Query())->select('*')
            ->from(self::tableName())
            ->where($condition,$params)
            ->one();
        return $data;
    }
}
