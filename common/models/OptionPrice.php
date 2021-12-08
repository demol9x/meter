<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "option_price".
 *
 * @property integer $id
 * @property integer $price_min
 * @property integer $price_max
 * @property integer $created_at
 */
class OptionPrice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'option_price';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['price_min', 'price_max'], 'required'],
            [['id', 'price_min', 'price_max', 'created_at'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'price_min' => 'Khoảng nhỏ nhất (Triệu)',
            'price_max' => 'Khoảng lớn nhất (Triệu)',
            'created_at' => 'Ngày tạo',
        ];
    }
    public function beforeSave($insert) {
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
