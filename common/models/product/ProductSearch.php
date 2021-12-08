<?php

namespace common\models\product;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\product\Product;

/**
 * ProductSearch represents the model behind the search form about `common\models\product\Product`.
 */
class ProductSearch extends Product
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'brand', 'category_id', 'currency', 'quantity', 'status', 'avatar_id', 'isnew', 'ishot', 'viewed', 'status_quantity', 'rate_count', 'total_buy', 'flash_sale', 'province_id', 'weight', 'height', 'length', 'width', 'type', 'start_time', 'number_time', 'fee_ship', 'admin_update', 'admin_update_time', 'ckedit_desc', 'pay_coin', 'order', 'pay_servive', 'created_at', 'updated_at'], 'integer'],
            [['name', 'alias', 'category_track', 'code', 'barcode', 'product_attributes', 'avatar_path', 'avatar_name', 'short_description', 'description', 'meta_title', 'meta_description', 'meta_keywords', 'dynamic_field', 'price_range', 'quality_range', 'unit', 'note_fee_ship', 'videos', 'list_category', 'lat', 'long'], 'safe'],
            [['price', 'price_market', 'rate'], 'number'],
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
        $query = Product::find();

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

        $query->joinWith(['category']);

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'brand' => $this->brand,
            'category_id' => $this->category_id,
            'price' => $this->price,
            'price_market' => $this->price_market,
            'currency' => $this->currency,
            'quantity' => $this->quantity,
            'product.status' => $this->status,
            'avatar_id' => $this->avatar_id,
            'isnew' => $this->isnew,
            'ishot' => $this->ishot,
            'viewed' => $this->viewed,
            'status_quantity' => $this->status_quantity,
            'rate_count' => $this->rate_count,
            'rate' => $this->rate,
            'total_buy' => $this->total_buy,
            'flash_sale' => $this->flash_sale,
            'province_id' => $this->province_id,
            'weight' => $this->weight,
            'height' => $this->height,
            'length' => $this->length,
            'width' => $this->width,
            'type' => $this->type,
            'start_time' => $this->start_time,
            'number_time' => $this->number_time,
            'fee_ship' => $this->fee_ship,
            'admin_update' => $this->admin_update,
            'admin_update_time' => $this->admin_update_time,
            'ckedit_desc' => $this->ckedit_desc,
            'pay_coin' => $this->pay_coin,
            'order' => $this->order,
            'pay_servive' => $this->pay_servive,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'alias', $this->alias])
            ->andFilterWhere(['like', 'category_track', $this->category_track])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'barcode', $this->barcode])
            ->andFilterWhere(['like', 'product_attributes', $this->product_attributes])
            ->andFilterWhere(['like', 'avatar_path', $this->avatar_path])
            ->andFilterWhere(['like', 'avatar_name', $this->avatar_name])
            ->andFilterWhere(['like', 'short_description', $this->short_description])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'meta_title', $this->meta_title])
            ->andFilterWhere(['like', 'meta_description', $this->meta_description])
            ->andFilterWhere(['like', 'meta_keywords', $this->meta_keywords])
            ->andFilterWhere(['like', 'dynamic_field', $this->dynamic_field])
            ->andFilterWhere(['like', 'price_range', $this->price_range])
            ->andFilterWhere(['like', 'quality_range', $this->quality_range])
            ->andFilterWhere(['like', 'unit', $this->unit])
            ->andFilterWhere(['like', 'note_fee_ship', $this->note_fee_ship])
            ->andFilterWhere(['like', 'videos', $this->videos])
            ->andFilterWhere(['like', 'list_category', $this->list_category])
            ->andFilterWhere(['like', 'lat', $this->lat])
            ->andFilterWhere(['like', 'long', $this->long]);

        return $dataProvider;
    }
}
