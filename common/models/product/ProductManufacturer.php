<?php

namespace common\models\product;

use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;

/**
 * This is the model class for table "product_manufacturer".
 *
 * @property integer $id
 * @property string $name
 * @property integer $created_time
 * @property integer $updated_time
 */
class ProductManufacturer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_manufacturer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_time', 'updated_time'], 'integer'],
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
            'name' => 'Tên thương hiệu',
            'created_time' => 'Ngày tạo',
            'updated_time' => 'Ngày cập nhật',
        ];
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            $this->updated_time = time();
            if ($this->isNewRecord) {
                $this->created_time = time();
            }
            return true;
        }
        return false;
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
            'created_time' => $this->created_time,
            'updated_time' => $this->updated_time,
        ]);

        return $dataProvider;
    }


    public static function optionsManufacturer()
    {
        $data = (new Query())->select('id, name')
            ->from(self::tableName())
            ->all();
        return array_column($data, 'name', 'id');
    }
}
