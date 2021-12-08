<?php

namespace common\models\form\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\form\Contact;

/**
 * formCategorySearch represents the model behind the search form about `common\models\formCategory`.
 */
class ContactSearch extends Contact
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'phone', 'address', 'email', 'viewed'], 'safe'],
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
        $query = Contact::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'viewed' => $this->viewed,
        ]);
        if(!isset($_GET['sort'])) {
            $query->orderBy('viewed, id DESC');
        }
        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'email', $this->email]);
        return $dataProvider;
    }
}
