<?php

namespace common\models\product;

use Yii;
use yii\db\Query;
use common\components\ClaLid;
use common\models\rating\Rating;


/**
 * This is the model class for table "product".
 *
 * @property integer $id
 * @property integer $brand
 * @property string $name
 * @property string $alias
 * @property string $category_id
 * @property string $category_track
 * @property string $code
 * @property string $barcode
 * @property string $price
 * @property string $price_market
 * @property string $product_attributes
 * @property integer $currency
 * @property string $quantity
 * @property integer $status
 * @property string $avatar_path
 * @property string $avatar_name
 * @property string $avatar_id
 * @property integer $isnew
 * @property integer $ishot
 * @property string $viewed
 * @property string $short_description
 * @property string $description
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_keywords
 * @property string $dynamic_field
 * @property integer $status_quantity
 * @property integer $rate_count
 * @property double $rate
 * @property integer $total_buy
 * @property integer $flash_sale
 * @property string $price_range
 * @property string $quality_range
 * @property integer $province_id
 * @property string $unit
 * @property integer $weight
 * @property integer $height
 * @property integer $length
 * @property integer $width
 * @property integer $type
 * @property integer $start_time
 * @property integer $number_time
 * @property integer $fee_ship
 * @property string $note_fee_ship
 * @property string $videos
 * @property string $note
 * @property integer $admin_update
 * @property integer $admin_update_time
 * @property integer $ckedit_desc
 * @property string $list_category
 * @property integer $pay_coin
 * @property integer $order
 * @property integer $pay_servive
 * @property string $lat
 * @property string $long
 * @property string $created_at
 * @property string $updated_at
 */
class Product extends \yii\db\ActiveRecord
{
    const DEFAULT_ORDER = 'id DESC';

    public $_price = null;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'category_id'], 'required'],
            [['brand', 'category_id', 'currency', 'quantity', 'status', 'avatar_id', 'isnew', 'ishot', 'viewed', 'status_quantity', 'rate_count', 'total_buy', 'flash_sale', 'province_id', 'weight', 'height', 'length', 'width', 'type', 'start_time', 'number_time', 'fee_ship', 'admin_update', 'admin_update_time', 'ckedit_desc', 'pay_coin', 'order', 'pay_servive', 'created_at', 'updated_at'], 'integer'],
            [['price', 'price_market', 'rate'], 'number'],
            [['product_attributes', 'short_description', 'description', 'dynamic_field', 'note_fee_ship','specifications'], 'string'],
            [['name', 'alias', 'barcode', 'avatar_path', 'avatar_name', 'meta_title', 'meta_description', 'meta_keywords', 'lat', 'long'], 'string', 'max' => 255],
            [['category_track', 'code'], 'string', 'max' => 68],
            [['price_range', 'quality_range', 'videos'], 'string', 'max' => 500],
            [['unit'], 'string', 'max' => 30],
            [['note'], 'string', 'max' => 3000],
            [['list_category'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'brand' => 'Thương hiệu',
            'name' => 'Tên sản phẩm',
            'alias' => 'Alias',
            'category_id' => 'Danh mục',
            'category_track' => 'Category Track',
            'code' => 'Code',
            'barcode' => 'Barcode',
            'price' => 'Giá',
            'price_market' => 'Giá thị trường',
            'product_attributes' => 'Product Attribute',
            'currency' => 'Currency',
            'quantity' => 'Quantity',
            'status' => 'Trạng thái',
            'avatar_path' => 'Avatar Path',
            'avatar_name' => 'Avatar Name',
            'avatar_id' => 'Avatar ID',
            'isnew' => 'Hiển thị trang chủ',
            'ishot' => 'Sản phẩm hot',
            'viewed' => 'Viewed',
            'short_description' => 'Mô tả ngắn',
            'description' => 'Mô tả',
            'meta_title' => 'Meta Title',
            'meta_description' => 'Meta Description',
            'meta_keywords' => 'Meta Keywords',
            'dynamic_field' => 'Dynamic Field',
            'status_quantity' => 'Status Quantity',
            'rate_count' => 'Rate Count',
            'rate' => 'Rate',
            'total_buy' => 'Total Buy',
            'flash_sale' => 'Flash Sale',
            'price_range' => 'Price Range',
            'quality_range' => 'Quality Range',
            'province_id' => 'Province ID',
            'unit' => 'Unit',
            'weight' => 'Weight',
            'height' => 'Height',
            'length' => 'Length',
            'width' => 'Width',
            'type' => 'Type',
            'start_time' => 'Start Time',
            'number_time' => 'Number Time',
            'fee_ship' => 'Miễn phí vận chuyển',
            'note_fee_ship' => 'Note Fee Ship',
            'videos' => 'Videos',
            'admin_update' => 'Admin Update',
            'admin_update_time' => 'Admin Update Time',
            'ckedit_desc' => 'Ckedit Desc',
            'list_category' => 'List Category',
            'pay_coin' => 'Pay Coin',
            'order' => 'Order',
            'pay_servive' => 'Pay Servive',
            'lat' => 'Lat',
            'long' => 'Long',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'note' => 'Ghi chú',
            'specifications' => 'Thông số kỹ thuật',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->updated_at = time();
            if ($this->isNewRecord) {
                $this->created_at = time();
            }
            // Alias
            $this->alias = \common\components\HtmlFormat::parseToAlias($this->name);
            return true;
        }
        return false;
    }

    public function getCategory()
    {
        return $this->hasOne(ProductCategory::className(), ['id' => 'category_id'])->select('name,id');
    }

    static function getImages($id)
    {
        $images = ProductImage::find()->where(['product_id' => $id])->all();
        return $images;
    }

    function setKeyVariable($attr)
    {
        sort($attr);
        return json_encode($attr);
    }

    function saveVariable($data, $product)
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $variable = ProductVariables::find()->where(['product_id' => $product['id'], 'key' => $value['key']])->one();
                if (!$variable) {
                    $variable = new ProductVariables();
                }
                $variable->product_id = $product['id'];
                $variable->key = $value['key'];
                $variable->name = $value['name'] ? $value['name'] : $product['name'];
                $variable->price = $value['price'] ? $value['price'] : $product['price'];
                $variable->status = isset($value['status']) && $value['status'] ? 1 : 0;
                $variable->quantity = $value['quantity'];
                $variable->avatar_path = '';
                $variable->avatar_name = '';
                $variable->default = isset($data['default']) && $data['default'] == $key ? 1 : 0;
                $variable->save();
            }
        }
    }

    function getVariable($key_variables, $product_id)
    {
        $response = [];
        $product = self::findOne($product_id);
        foreach ($key_variables as $value) {
            $key = self::setKeyVariable($value);
            $variable = ProductVariables::find()->where(['product_id' => $product_id, 'key' => $key])->one();
            if ($variable) {
                $response[] = $variable->attributes;
            } else {
                $response[] = [
                    'key' => $key,
                    'name' => $product ? $product->name : '',
                    'price' => $product ? $product->price : '',
                    'quantity' => 0,
                    'avatar_path' => '',
                    'avatar_name' => '',
                    'default' => '',
                    'status' => '',
                ];
            }
        }
        return $response;
    }

    function loadAttrs($attrs = [])
    {
        $chang = [];
        if ($attrs) foreach ($attrs as $key1 => $vl1) {
            if (is_array($vl1)) foreach ($vl1 as $vl2) {
                $chang[$key1][] = $key1 . '~' . ($vl2);
            }
        }
        return json_encode($chang);
    }


    function getAttrs($attrs = [])
    {
        $attr = [];
        if ($attrs) foreach ($attrs as $key1 => $vl1) {
            foreach ($vl1 as $key2 => $vl2) {
                $attr[$key1][$key2] = str_replace($key1.'~','',$vl2);

            }
        }
        return $attr;
    }


    public static function getProduct($options = [])
    {
        $condition = '1 = 1';
        $params = [];
        if (!isset($options['status'])) {
            $condition = 't.status=:status';
            $params = [
                ':status' => ClaLid::STATUS_ACTIVED,
            ];
            $condition .= ' AND pc.status=:status';
        }
//        if (isset($options['category_id']) && $options['category_id']) {
//            $cats = is_array($options['category_id']) ? implode(' ', $options['category_id']) : $options['category_id'];
//            $condition .= " AND MATCH (t.category_track) AGAINST ('" . __removeDF($cats) . "' IN BOOLEAN MODE)";
//        }

        if (isset($options['category_id']) && $options['category_id']) {
            $condition .= " AND t.category_id = :category_id";
            $params[':category_id'] = $options['category_id'];
        }

        if (isset($options['province_id']) && $options['province_id']) {
            $condition .= " AND t.province_id = :province_id";
            $params[':province_id'] = $options['province_id'];
        }
        if (isset($options['price_min']) && $options['price_min']) {
            $condition .= " AND t.price >= :price_min";
            $params[':price_min'] = $options['price_min'];
        }
        if (isset($options['price_max']) && $options['price_max']) {
            $condition .= " AND t.price <= :price_max";
            $params[':price_max'] = $options['price_max'];
        }
        if (isset($options['brand']) && $options['brand']) {
            $condition .= ' AND t.brand=:brand';
            $params[':brand'] = $options['brand'];
        }
        //
        if (isset($options['ishot']) && $options['ishot']) {
            $condition .= ' AND t.ishot=:ishot';
            $params[':ishot'] = $options['ishot'];
        }

        if (isset($options['isnew']) && $options['isnew']) {
            $condition .= ' AND t.isnew=:isnew';
            $params[':isnew'] = $options['isnew'];
        }


        //
        $limit = ClaLid::DEFAULT_LIMIT;
        if (isset($options['limit']) && $options['limit'] >= 1) {
            $limit = $options['limit'];
        }
        //
        if (isset($options['page'])) {
            $offset = ($options['page'] - 1) * $limit;
        } else {
            $offset = 0;
        }
        $order = Product::DEFAULT_ORDER;
        if (isset($options['order']) && $options['order']) {
            $order = __removeDF($options['order']);
        }

        if (isset($options['sort']) && $options['sort']) {
            if($options['sort'] == 'new'){
                $order = 'created_at DESC';
            }
            if($options['sort'] == 'rate'){
                $order = 'rate DESC';
            }
            if($options['sort'] == 'name'){
                $order = 'name ASC';
            }
        }

//        if (isset($options['type']) && $options['type']) {
//            $condition .= ' AND r.type=:type';
//            $params[':type'] = $options['type'];
//        }
        if (isset($options['id']) && $options['id'] && is_array($options['id'])) {
            $ids_strings = implode(',', __removeDF($options['id']));
            $condition .= " AND t.id IN ($ids_strings)";
        }

        if (isset($options['_id']) && $options['_id']) {
            if (is_array($options['_id'])) {
                $ids_strings = __removeDF(implode(',', $options['_id']));
                $condition .= " AND t.id NOT IN ($ids_strings)";
            } else {
                $ids_strings = __removeDF($options['_id']);
                $condition .= " AND t.id <> $ids_strings";
            }
        }
        if(isset($options['fitler']) && $options['fitler']){
            if($options['fitler'] == 'week'){
                $condition .= ' AND FROM_UNIXTIME(admin_update_time) >= curdate() - INTERVAL DAYOFWEEK(curdate())+6 DAY AND FROM_UNIXTIME(admin_update_time) < curdate() + 1';
            }
            if($options['fitler'] == 'month'){
                $condition.= ' AND FROM_UNIXTIME(admin_update_time) >= curdate() - INTERVAL DAYOFWEEK(curdate())+30 DAY AND FROM_UNIXTIME(admin_update_time) < curdate() + 1';
            }
            if($options['fitler']== 'very_new'){
                $order = 'created_at DESC';
            }
        }
        $select = 't.*';
        $query = (new Query())->select($select)
            ->from('product AS t')
            ->rightJoin('product_category pc', "pc.id = t.category_id")
            ->where($condition, $params);

        if (isset($options['id_price']) && $options['id_price']) {
            $pr = OptionPriceProduct::findOne($options['id_price']);
            $query->andFilterWhere(['>', 'price', $pr['price_min'] - 1]);
            if ($pr['price_max']) { //Nếu không có max thì chỉ chạy điều kiện min
                $query->andFilterWhere(['<', 'price', $pr['price_max'] + 1]);
            }
        }
        if (isset($options['keyword']) && $options['keyword']) {
            $tag = $options['keyword'];
            $tag = str_replace(',', ' ', $tag);
            if ($tag) {
                $query->select($select . ", ((1.8 * (MATCH(t.name) AGAINST (:tag IN BOOLEAN MODE)))) as score ");
                $query->andWhere("(MATCH(t.name) AGAINST (:tag IN BOOLEAN MODE))", [':tag' => $tag]);
                $query->having('score > 1');
                $order = 'score DESC, ' . $order;
            }
        }

        if (isset($options['count'])) {
            $total = $query->count();
            return $total;
        }
        $data = $query->orderBy($order)
            ->limit($limit)
            ->offset($offset)
            ->all();

        return $data;
    }

    public static function getTextByPriceCustom($price, $show_unit = true)
    {
        if ($price <= 0) {
            return 'Liện hệ';
        }
        return number_format($price, 0, ',', '.') . ($show_unit ? '' . Yii::t('app', 'currency') : '');
    }

    public static function inWish2($id)
    {
        $wishs = \common\models\product\ProductWish::getWishAllByUser();
        if ($wishs) {
            return in_array($id, $wishs);
        }
        return false;
    }

    function getData()
    {
        $data = [];
        if ($this->product_attributes) {
            $dt = json_decode($this->product_attributes, true);
            if (is_array($dt)) {
                foreach ($dt as $key => $value) {
                    if (is_array($value)) foreach ($value as $val) {
                        $tach = explode('~', $val);
                        $data[$key][] = $tach[1];
                    }
                }
            }
        }
        return $data;
    }

    static function getKeyVariable($atrrs)
    {
        {
            $data = [];
            $attr_m = [];
            $attr_o = [];
            if ($atrrs) foreach ($atrrs as $id => $values) {
                if (is_array($values) && count($values) >= 1) {
                    $attr_m[] = $values;
                } else {
                    $attr_o[] = $values;
                }
            }
            if ($attr_m) foreach ($attr_m as $values) {
                self::addItem($data, $values);
            }
            $return = [];
            if ($data) {
                if ($attr_o) {
                    foreach ($data as $item) {
                        $return[] = array_merge($item, $attr_o);
                    }
                } else {
                    $return = $data;
                }
            } else {
                $return = $attr_o;
            }
            return $return;
        }
    }

    static function addItem(&$data, $values)
    {
        $return = [];
        if ($values) {
            foreach ($values as $key => $value) {
                if ($data) foreach ($data as $item) {
                    $return[] = array_merge($item, [$key => $value]);
                }
                else {
                    $return[] = [$key => $value];
                }
            }
        }
        $data = $return;
    }

    public static function getRelationProducts($options = [])
    {
        $cat_id = (int)$options['category_id'];
        $product_id = (int)$options['product_id'];
        if (!$cat_id || !$product_id) {
            return [];
        }
        $condition = 'status=:status';
        $params = [
            ':status' => ClaLid::STATUS_ACTIVED
        ];
        $condition .= " AND (MATCH (category_track) AGAINST ('" . $cat_id . "' IN BOOLEAN MODE) OR category_id=".$cat_id." )";
        //
        $condition .= ' AND id<>:id';
        $params[':id'] = $product_id;
        //
        $limit = ClaLid::DEFAULT_LIMIT;
        if (isset($options['limit']) && $options['limit']) {
            $limit = $options['limit'];
        }
        //
        $products = (new Query())->select('*')
            ->from('product')
            ->where($condition, $params)
            ->orderBy("ABS(id - $product_id)")
            ->limit($limit)
            ->all();
        return $products;
    }
    public function getQuatityOrder($quantity)
    {
        $quantity_min = $this->getQuantityMin();
        $quantity_max = $this->getQuantityMax();
        if ($quantity_min <= $quantity && $quantity <= $quantity_max) {
            return $quantity;
        } else {
            if ($quantity_min <= $quantity) {
                return $quantity_max;
            } else {
                return $quantity_min;
            }
        }
    }
    public function getQuantityMin()
    {
        return $this->quality_range ? explode(',', $this->quality_range)[0] : 1;
    }

    public function getQuantityMax()
    {
        $quantity_max = MAX_QUANTITY_PRODUCT;
        $promotion = \common\models\promotion\Promotions::getPromotionNow();
        if ($promotion) {
            $promotion_item = $this->getPromotionItemNow();
            if ($promotion_item) {
                $quantity_max = ($promotion_item->quantity - $promotion_item->quantity_selled) > 0 ? ($promotion_item->quantity - $promotion_item->quantity_selled) : $quantity_max;
            }
        }
        return $quantity_max;
    }
    public function getPromotionItemNow()
    {
        return \common\models\promotion\ProductToPromotions::getPromotionItemNowByProduct($this->id);
    }

    public function getPriceC1($quantity)
    {
        if ($this->price_range && $this->quality_range && $quantity) {
            $price_range = explode(',', $this->price_range);
            $quality_range = explode(',', $this->quality_range);
            for ($i = count($quality_range) - 1; $i > 0; $i--) {
                if ($quality_range[$i] <= $quantity && $quality_range[$i] > 0) {
                    return (isset($price_range[$i]) && $price_range[$i]) ? $price_range[$i] : $price_range[$i - 1];
                }
            }
            return $price_range[0];
        }
        return $this->price;
    }
    public function getPrice($quantity)
    {
        $price = $this->getPriceC1($quantity);
        return $this->_price = intval($price);
    }
}
