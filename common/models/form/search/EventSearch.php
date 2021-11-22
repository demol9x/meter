<?php

namespace common\models\form\search;

use common\models\form\FormEvent;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ContentPageSearch represents the model behind the search form about `common\models\ContentPage`.
 */
class EventSearch extends FormEvent {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'created_at', 'updated_at','type'], 'integer'],
            [['user_name', 'phone', 'email', 'news_id', 'link'], 'safe'],
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
        $query = FormEvent::find();

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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'type' => $this->type,
        ]);

        $query->andFilterWhere(['like', 'user_name', $this->user_name])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'link', $this->link])
            ->andFilterWhere(['like', 'news_id', $this->news_id]);

        $query->orderBy('id DESC');

        return $dataProvider;
    }

}
