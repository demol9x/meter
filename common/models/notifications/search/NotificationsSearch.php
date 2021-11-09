<?php

namespace common\models\notifications\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\notifications\Notifications;

/**
 * NotificationsSearch represents the model behind the search form about `common\models\notifications\Notifications`.
 */
class NotificationsSearch extends Notifications
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type', 'sender_id', 'unread', 'created_at', 'updated_at'], 'integer'],
            [['title', 'description', 'link', 'recipient_id'], 'safe'],
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
        $query = Notifications::find();

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
            'type' => $this->type,
            // 'recipient_id' => [self::TYPE_USER_ALL, self::TYPE_WAITING_SEND],
            'sender_id' => $this->sender_id,
            'unread' => $this->unread,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        if (!is_numeric($this->recipient_id)) {
            $query->andFilterWhere([
                'recipient_id' => [self::TYPE_USER_ALL, self::TYPE_WAITING_SEND],
            ]);
        } else {
            $query->andFilterWhere([
                'recipient_id' => $this->recipient_id,
            ]);
        }

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'link', $this->link]);

        $query->orderBy('id DESC');

        return $dataProvider;
    }
}
