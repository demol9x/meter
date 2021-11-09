<?php

namespace common\models\news\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\news\ContentPage;

/**
 * ContentPageSearch represents the model behind the search form about `common\models\ContentPage`.
 */
class ContentPageSearch extends ContentPage {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'created_at', 'updated_at', 'status'], 'integer'],
            [['title', 'alias', 'short_description', 'description', 'avatar_path', 'avatar_name', 'meta_title', 'meta_keywords', 'meta_description'], 'safe'],
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
        $query = ContentPage::find();

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
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
                ->andFilterWhere(['like', 'alias', $this->alias])
                ->andFilterWhere(['like', 'short_description', $this->short_description])
                ->andFilterWhere(['like', 'description', $this->description])
                ->andFilterWhere(['like', 'avatar_path', $this->avatar_path])
                ->andFilterWhere(['like', 'avatar_name', $this->avatar_name])
                ->andFilterWhere(['like', 'meta_title', $this->meta_title])
                ->andFilterWhere(['like', 'meta_keywords', $this->meta_keywords])
                ->andFilterWhere(['like', 'meta_description', $this->meta_description]);
        
        $query->orderBy('id DESC');

        return $dataProvider;
    }

}
