<?php

namespace common\models\product\search;

use common\models\product\ProductAttributeItem;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\product\ProductAttribute;

/**
 * ProductAttributeSearch represents the model behind the search form about `common\models\product\ProductAttribute`.
 */
class ProductAttributeItemSearch extends ProductAttributeItem
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'attribute_id'], 'integer'],
            [['value'], 'safe'],
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
    public function search($params,$id)
    {
        $query = ProductAttributeItem::find()->where(['attribute_id' => $id]);

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
            'attribute_id' => $this->attribute_id,
        ]);

        $query->andFilterWhere(['like', 'value', $this->value]);

        return $dataProvider;
    }
}
