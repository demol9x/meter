<?php

namespace common\models\product;
use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "option_price".
 *
 * @property integer $id
 * @property integer $price_min
 * @property integer $price_max
 * @property integer $created_at
 * @property string $name
 */
class OptionPriceProduct extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_option_price';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['price_min', 'price_max','name'], 'required'],
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
            'name' => 'Tên hiển thị',
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

    public function search($params)
    {
        $query = self::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'name' => $this->name,
            'price_min' => $this->price_min,
            'price_max' => $this->price_max,
            'created_at' => $this->created_at,
        ]);

        return $dataProvider;
    }
}
