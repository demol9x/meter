<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\OptionPrice;

/**
 * OptionPriceSE represents the model behind the search form about `common\models\OptionPrice`.
 */
class OptionPriceSE extends OptionPrice
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'price_min', 'price_max', 'created_at'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = OptionPrice::find();

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
            'price_min' => $this->price_min,
            'price_max' => $this->price_max,
            'created_at' => $this->created_at,
        ]);

        return $dataProvider;
    }
}
