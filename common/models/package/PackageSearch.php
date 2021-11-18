<?php

namespace common\models\package;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\package\Package;

/**
 * PackageSearch represents the model behind the search form about `common\models\package\Package`.
 */
class PackageSearch extends Package
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'avatar_id', 'isnew', 'ishot', 'ward_id', 'district_id', 'province_id', 'viewed', 'ckedit_desc', 'order'], 'integer'],
            [['name', 'alias', 'avatar_path', 'avatar_name', 'address', 'ward_name', 'district_name', 'province_name', 'latlng', 'short_description', 'description', 'ho_so'], 'safe'],
            [['lat', 'long'], 'number'],
            [['shop_id'], 'safe'],
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
        $query = Package::find();

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
        $query->joinWith(['user']);

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'package.status' => $this->status,
            'avatar_id' => $this->avatar_id,
            'isnew' => $this->isnew,
            'ishot' => $this->ishot,
            'ward_id' => $this->ward_id,
            'district_id' => $this->district_id,
            'province_id' => $this->province_id,
            'viewed' => $this->viewed,
            'ckedit_desc' => $this->ckedit_desc,
            'order' => $this->order,
            'lat' => $this->lat,
            'long' => $this->long,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'user.username', $this->shop_id])
            ->andFilterWhere(['like', 'avatar_path', $this->avatar_path])
            ->andFilterWhere(['like', 'avatar_name', $this->avatar_name])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'ward_name', $this->ward_name])
            ->andFilterWhere(['like', 'district_name', $this->district_name])
            ->andFilterWhere(['like', 'province_name', $this->province_name])
            ->andFilterWhere(['like', 'latlng', $this->latlng])
            ->andFilterWhere(['like', 'short_description', $this->short_description])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'ho_so', $this->ho_so]);

        return $dataProvider;
    }
}
