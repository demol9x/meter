<?php

namespace common\models\product;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "product_attribute".
 *
 * @property string $id
 * @property string $name
 * @property integer $type
 * @property integer $show_filter
 * @property string $data
 * @property string $data_option
 * @property string $display_type
 */
class ProductAttribute extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_attribute';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','type'],'required'],
            [['type','display_type'], 'integer'],
            [['data_option'], 'string'],
            [['name'], 'string', 'max' => 250],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Tên thuộc tính',
            'type' => 'Type',
            'data_option' => 'Data Option',
            'display_type' => 'Display Type',
        ];
    }

    static function getType(){
        return [
            1 => 'Chọn một giá trị',
            2 => 'Chọn nhiều giá trị'
        ];
    }

    static function getDisplayType(){
        return [
            1 => 'Tùy chọn',
            2 => 'Màu sắc'
        ];
    }

    function getData()
    {
        $attrs = ProductAttributeItem::find()->where(['attribute_id' => $this->id])->asArray()->all();
        return $attrs ? $attrs : [];
    }
    static function getName($id) {
        if (isset($id) && $id) {
            $data = (new Query())->select('name')
                ->from('product_attribute')
                ->where(['id' => $id])
            ->one();
            return $data['name'];
        }

        return [];
    }

    public function getItems(){
        return $this->hasMany(ProductAttributeItem::className(),['attribute_id' => 'id']);
    }
}
