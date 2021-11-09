<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\UserRecruiterInfo;

/**
 * UserRecruiterInfoSearch represents the model behind the search form about `frontend\models\UserRecruiterInfo`.
 */
class UserRecruiterInfoSearch extends UserRecruiterInfo {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['user_id', 'scale', 'province_id', 'district_id', 'ward_id'], 'integer'],
            [['contact_name', 'phone', 'address', 'avatar_path', 'avatar_name'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
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
    public function search($params) {
        $query = UserRecruiterInfo::find();

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
            'user_id' => $this->user_id,
            'scale' => $this->scale,
            'province_id' => $this->province_id,
            'district_id' => $this->district_id,
            'ward_id' => $this->ward_id,
        ]);

        $query->andFilterWhere(['like', 'contact_name', $this->contact_name])
                ->andFilterWhere(['like', 'phone', $this->phone])
                ->andFilterWhere(['like', 'address', $this->address])
                ->andFilterWhere(['like', 'avatar_path', $this->avatar_path])
                ->andFilterWhere(['like', 'avatar_name', $this->avatar_name]);

        return $dataProvider;
    }

}
