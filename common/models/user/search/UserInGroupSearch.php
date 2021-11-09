<?php

namespace common\models\user\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\user\UserInGroup;

/**
 * UserInGroupSearch represents the model behind the search form about `common\models\user\UserInGroup`.
 */
class UserInGroupSearch extends UserInGroup
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'user_group_id', 'created_at', 'updated_at', 'agree_at', 'status', 'user_admin'], 'integer'],
            [['image'], 'safe'],
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
        $query = UserInGroup::find();

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
            'user_id' => $this->user_id,
            'user_group_id' => $this->user_group_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'agree_at' => $this->agree_at,
            'status' => $this->status,
            'user_admin' => $this->user_admin,
        ]);

        $query->andFilterWhere(['like', 'image', $this->image]);

        if(!isset($_GET['sort'])) {
            $query->orderBy('status DESC, id DESC');
        }

        return $dataProvider;
    }
}
