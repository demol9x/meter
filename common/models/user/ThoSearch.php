<?php

namespace common\models\user;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\user\Tho;

/**
 * ThoSearch represents the model behind the search form about `common\models\user\Tho`.
 */
class ThoSearch extends Tho
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'kinh_nghiem', 'created_at', 'updated_at'], 'integer'],
            [['tot_nghiep', 'nghe_nghiep', 'chuyen_nganh', 'kinh_nghiem_description', 'description', 'attachment'], 'safe'],
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
        $query = Tho::find();

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
            'kinh_nghiem' => $this->kinh_nghiem,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'tot_nghiep', $this->tot_nghiep])
            ->andFilterWhere(['like', 'nghe_nghiep', $this->nghe_nghiep])
            ->andFilterWhere(['like', 'chuyen_nganh', $this->chuyen_nganh])
            ->andFilterWhere(['like', 'kinh_nghiem_description', $this->kinh_nghiem_description])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'attachment', $this->attachment]);

        return $dataProvider;
    }
}
