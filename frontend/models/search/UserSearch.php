<?php

namespace frontend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\User;

/**
 * UserSearch represents the model behind the search form about `frontend\models\User`.
 */
class UserSearch extends User {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'status', 'province_id', 'district_id'], 'integer'],
            [['username', 'auth_key', 'password_hash', 'password_reset_token', 'phone', 'email', 'address', 'facebook', 'link_facebook', 'created_at', 'updated_at'], 'safe'],
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
        $query = User::find()->where(['type' => User::TYPE_CA_NHAN]);

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
            'status' => $this->status,
            // 'created_at' => $this->created_at,
            // 'updated_at' => $this->updated_at,
            'province_id' => $this->province_id,
            'district_id' => $this->district_id,
        ]);

        if($this->created_at) {
            if(!is_numeric($this->created_at)) {
                $tg = explode(' - ', $this->created_at);
                $created_at = strtotime($tg[0]);
                $created_at_to = strtotime($tg[1]) + 24*60*60;
                $query->andWhere(" (created_at <= $created_at_to AND  created_at >= $created_at)");
            } else {
                $query->andWhere("created_at = ".$this->created_at);
            }
        }

        $query->andFilterWhere(['like', 'username', $this->username])
                ->andFilterWhere(['like', 'auth_key', $this->auth_key])
                ->andFilterWhere(['like', 'password_hash', $this->password_hash])
                ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
                ->andFilterWhere(['like', 'phone', $this->phone])
                ->andFilterWhere(['like', 'email', $this->email])
                ->andFilterWhere(['like', 'address', $this->address])
                ->andFilterWhere(['like', 'facebook', $this->facebook])
                ->andFilterWhere(['like', 'link_facebook', $this->link_facebook]);
        
        $query->orderBy('id DESC');

        return $dataProvider;
    }

}
