<?php

namespace common\models\shop;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\shop\Shop;

/**
 * ShopSearch represents the model behind the search form about `common\models\shop\Shop`.
 */
class ShopSearch extends Shop
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'status', 'site_id', 'avatar_id', 'time_open', 'time_close', 'day_open', 'day_close', 'like', 'rate_count', 'viewed'], 'integer'],
            [['name', 'alias', 'address', 'province_id', 'province_name', 'district_id', 'district_name', 'ward_id', 'ward_name', 'image_path', 'image_name', 'avatar_path', 'avatar_name', 'phone', 'hotline', 'email', 'yahoo', 'skype', 'website', 'facebook', 'instagram', 'pinterest', 'twitter', 'field_business', 'short_description', 'description', 'meta_keywords', 'meta_description', 'meta_title', 'latlng', 'number_auth', 'lat', 'lng', 'business'], 'safe'],
            [['rate'], 'number'],
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
        $query = Shop::find();

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
            'status' => $this->status,
            'site_id' => $this->site_id,
            'avatar_id' => $this->avatar_id,
            'time_open' => $this->time_open,
            'time_close' => $this->time_close,
            'day_open' => $this->day_open,
            'day_close' => $this->day_close,
            'like' => $this->like,
            'rate' => $this->rate,
            'rate_count' => $this->rate_count,
            'viewed' => $this->viewed,
        ]);

        if($this->created_time) {
            if(!is_numeric($this->created_time)) {
                $tg = explode(' - ', $this->created_time);
                $created_time = strtotime($tg[0]);
                $created_time_to = strtotime($tg[1]) + 24*60*60;
                $query->andWhere(" (created_time <= $created_time_to AND  created_time >= $created_time)");
            } else {
                $query->andWhere("created_time = ".$this->created_time);
            }
        }

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'alias', $this->alias])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'province_id', $this->province_id])
            ->andFilterWhere(['like', 'province_name', $this->province_name])
            ->andFilterWhere(['like', 'district_id', $this->district_id])
            ->andFilterWhere(['like', 'district_name', $this->district_name])
            ->andFilterWhere(['like', 'ward_id', $this->ward_id])
            ->andFilterWhere(['like', 'ward_name', $this->ward_name])
            ->andFilterWhere(['like', 'image_path', $this->image_path])
            ->andFilterWhere(['like', 'image_name', $this->image_name])
            ->andFilterWhere(['like', 'avatar_path', $this->avatar_path])
            ->andFilterWhere(['like', 'avatar_name', $this->avatar_name])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'hotline', $this->hotline])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'yahoo', $this->yahoo])
            ->andFilterWhere(['like', 'skype', $this->skype])
            ->andFilterWhere(['like', 'website', $this->website])
            ->andFilterWhere(['like', 'facebook', $this->facebook])
            ->andFilterWhere(['like', 'instagram', $this->instagram])
            ->andFilterWhere(['like', 'pinterest', $this->pinterest])
            ->andFilterWhere(['like', 'twitter', $this->twitter])
            ->andFilterWhere(['like', 'field_business', $this->field_business])
            ->andFilterWhere(['like', 'short_description', $this->short_description])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'meta_keywords', $this->meta_keywords])
            ->andFilterWhere(['like', 'meta_description', $this->meta_description])
            ->andFilterWhere(['like', 'meta_title', $this->meta_title])
            ->andFilterWhere(['like', 'latlng', $this->latlng])
            ->andFilterWhere(['like', 'number_auth', $this->number_auth])
            ->andFilterWhere(['like', 'lat', $this->lat])
            ->andFilterWhere(['like', 'lng', $this->lng])
            ->andFilterWhere(['like', 'business', $this->business]);

        return $dataProvider;
    }
}
