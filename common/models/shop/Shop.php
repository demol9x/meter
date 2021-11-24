<?php

namespace common\models\shop;

use common\models\District;
use common\models\general\ChucDanh;
use common\models\Province;
use common\models\Ward;
use frontend\models\User;
use yii\db\Query;
use Yii;
use common\components\ClaLid;

/**
 * This is the model class for table "{{%shop}}".
 *
 * @property string $id
 * @property string $name
 * @property string $alias
 * @property integer $type
 * @property integer $user_id
 * @property string $address
 * @property string $province_id
 * @property string $province_name
 * @property string $district_id
 * @property string $district_name
 * @property string $ward_id
 * @property string $ward_name
 * @property string $image_path
 * @property string $image_name
 * @property string $avatar_path
 * @property string $avatar_name
 * @property string $phone
 * @property string $hotline
 * @property string $email
 * @property string $yahoo
 * @property string $skype
 * @property string $website
 * @property string $facebook
 * @property string $instagram
 * @property string $pinterest
 * @property string $twitter
 * @property string $field_business
 * @property integer $status
 * @property integer $created_time
 * @property integer $modified_time
 * @property integer $site_id
 * @property integer $allow_number_cat
 * @property string $short_description
 * @property string $description
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $meta_title
 * @property integer $avatar_id
 * @property integer $time_open
 * @property integer $time_close
 * @property integer $day_open
 * @property integer $day_close
 * @property integer $type_sell
 * @property integer $like
 * @property string $policy
 * @property string $contact
 * @property string $latlng
 * @property string $payment_transfer
 * @property string $category_track
 * @property integer $level
 * @property string $number_auth
 * @property string $date_auth
 * @property string $address_auth
 * @property string $number_paper_auth
 */
class Shop extends \common\models\ActiveRecordC
{
    const ONE_MEMBER = 1;
    const MANY_MEMBER = 2;
    const IMG_AUTH = 2;
    const DEFAULT_LIMIT = 12;
    const DEFAULT_ORDER = 'id DESC ';

    const ID_SHOP_BQT = 2041;
    const ID_SHOP_CHARITY = 3300;
    const ID_SHOP_FEETRAN = 3298;

    public $avatar1 = '';
    public $avatar2 = '';
    public $time_limit_type_term;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shop}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'phone', 'email','number_auth'], 'required'],
            [['user_id', 'status', 'created_time', 'modified_time', 'site_id', 'avatar_id', 'time_open', 'time_close', 'day_open', 'day_close', 'like', 'rate_count', 'viewed','founding'], 'integer'],
            [['description'], 'string'],
            [['rate','price'], 'number'],
            [['name', 'alias', 'address', 'image_name', 'avatar_path', 'avatar_name', 'email', 'yahoo', 'skype', 'website', 'facebook', 'instagram', 'pinterest', 'twitter', 'field_business', 'meta_keywords', 'meta_description', 'meta_title'], 'string', 'max' => 250],
            [['province_id', 'district_id'], 'string', 'max' => 4],
            [['province_name', 'district_name', 'ward_name'], 'string', 'max' => 100],
            [['ward_id', 'number_auth'], 'string', 'max' => 20],
            [['image_path'], 'string', 'max' => 200],
            [['phone'], 'string', 'max' => 15],
            [['hotline'], 'string', 'max' => 50],
            [['short_description'], 'string', 'max' => 1000],
            [['latlng'], 'string', 'max' => 255],
            [['lat', 'lng'], 'string', 'max' => 30],
            [['business'], 'string', 'max' => 500],
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'alias' => 'Alias',
            'founding' => 'Ngày thành lập',
            'user_id' => 'User ID',
            'address' => 'Address',
            'province_id' => 'Province ID',
            'province_name' => 'Province Name',
            'district_id' => 'District ID',
            'district_name' => 'District Name',
            'ward_id' => 'Ward ID',
            'ward_name' => 'Ward Name',
            'image_path' => 'Image Path',
            'image_name' => 'Image Name',
            'avatar_path' => 'Avatar Path',
            'avatar_name' => 'Avatar Name',
            'phone' => 'Phone',
            'hotline' => 'Hotline',
            'email' => 'Email',
            'yahoo' => 'Yahoo',
            'skype' => 'Skype',
            'website' => 'Website',
            'facebook' => 'Facebook',
            'instagram' => 'Instagram',
            'pinterest' => 'Pinterest',
            'twitter' => 'Twitter',
            'field_business' => 'Field Business',
            'status' => 'Status',
            'created_time' => 'Created Time',
            'modified_time' => 'Modified Time',
            'site_id' => 'Site ID',
            'short_description' => 'Short Description',
            'description' => 'Description',
            'meta_keywords' => 'Meta Keywords',
            'meta_description' => 'Meta Description',
            'meta_title' => 'Meta Title',
            'avatar_id' => 'Avatar ID',
            'time_open' => 'Time Open',
            'time_close' => 'Time Close',
            'day_open' => 'Day Open',
            'day_close' => 'Day Close',
            'like' => 'Like',
            'latlng' => 'Latlng',
            'number_auth' => 'Number Auth',
            'rate' => 'Rate',
            'rate_count' => 'Rate Count',
            'lat' => 'Lat',
            'lng' => 'Lng',
            'viewed' => 'Viewed',
            'business' => 'Business',
            'price'=>'Vốn điều lệ'
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->created_time = time();
                if (!$this->avatar_name && !$this->avatar_path) {
                    $this->avatar_path = '/media/images/shop/2019_01_02/';
                    $this->avatar_name = 'df-1546395774.png';
                }
                if (!$this->image_name && !$this->image_path) {
                    $this->image_path = '/media/images/shop/2019_01_02/';
                    $this->image_name = 'df-1546395774.png';
                }
                \common\models\NotificationAdmin::addNotifcation('shop');
            }
            $this->modified_time = time();
            $this->alias = \common\components\HtmlFormat::parseToAlias($this->name);
            return true;
        } else {
            return false;
        }
    }

    function user()
    {
        return \frontend\models\User::findOne($this->user_id);
    }

    public static function updateAddress($address)
    {
        // echo "<pre>";
        // print_r($address);
        if ($model = Shop::findOne($address->shop_id)) {
            $model->province_id = $address->province_id;
            $model->province_name = $address->province_name;
            $model->district_id = $address->district_id;
            $model->district_name = $address->district_name;
            $model->ward_id = $address->ward_id;
            $model->ward_name = $address->ward_name;
            $model->latlng = $address->latlng;
            $model->address = $address->address;
            $model->name_contact = $address->name_contact;
            $model->phone = $address->phone;
            $model->phone_add = $address->phone_add;
            if ($model->latlng) {
                $tgss = explode(',', $model->latlng);
                if (count($tgss) > 1) {
                    $model->lat = $tgss[0];
                    $model->lng = $tgss[1];
                }
            }
            return $model->save();
        }
        return 0;
    }

    public static function optionsShop()
    {
        $shops = (new Query())->select('*')
            ->from('shop')
            ->all();
        $data = [];
        foreach ($shops as $shop) {
            $data[$shop['id']] = $shop;
        }
        return $data;
    }

    public static function optionShop()
    {
        $shops = Shop::find()->all();
        $data = ['' => Yii::t('app', 'select_shop')];
        if ($shops) {
            foreach ($shops as $shop) {
                $data[$shop['id']] = $shop['name'];
            }
        }
        return $data;
    }

    public static function getShop($options = [])
    {
        $condition = '1 = 1';
        $params = '';
        if (!isset($options['status'])) {
            $condition = 's.status=:status';
            $params = [
                ':status' => ClaLid::STATUS_ACTIVED,
            ];
        }

        $query = (new Query());
        //
        if (isset($options['province_id']) && $options['province_id']) {
            $condition .= " AND s.province_id = :province_id";
            $params[':province_id'] = $options['province_id'];
        }

        if (isset($options['category_id']) && $options['category_id']) {
            $condition .= " AND MATCH (t.category_track) AGAINST ('" . __removeDF($options['category_id']) . "' IN BOOLEAN MODE)";
        }
        if (isset($options['type_gold']) && !isset($options['type_rate'])) {
            $condition .= " AND s.level > 1";
            $options['order'] = ' s.level DESC, t.ishot DESC, t.id DESC';
        }
        if (isset($options['type_rate']) && !isset($options['type_gold'])) {
            $condition .= " AND s.rate > 1";
            $options['order'] = ' s.rate DESC, t.ishot DESC, t.id DESC';
        }

        if (isset($options['type_rate']) && isset($options['type_gold'])) {
            $condition .= " AND (s.rate > 1 OR s.level > 1) ";
            $options['order'] = ' s.level DESC, s.rate DESC, t.ishot DESC, t.id DESC';
        }

        if (isset($options['address']) && $options['address']) {
            $condition .= " AND s.address LIKE :address";
            $params[':address'] = '%' . $options['address'] . '%';
        }
        //
        if (isset($options['ishot']) && $options['ishot']) {
            $condition .= ' AND s.ishot=:ishot';
            $params[':ishot'] = $options['ishot'];
        }
        //
        $limit = 's.' . Shop::DEFAULT_LIMIT;
        if (isset($options['limit']) && $options['limit']) {
            $limit = $options['limit'];
        }
        //
        if (isset($options['page'])) {
            $offset = ($options['page'] - 1) * $limit;
        } else {
            $offset = 0;
        }
        $order = Shop::DEFAULT_ORDER;
        if (isset($options['order']) && $options['order']) {
            $order = __removeDF($options['order']);
        }
        if (isset($options['level']) && $options['level']) {
            $condition .= ' AND s.level=:level';
            $params[':level'] = $options['level'];
        }
        if (isset($options['type']) && $options['type']) {
            $condition .= ' AND s.type=:type';
            $params[':type'] = $options['type'];
        }
        if (isset($options['count'])) {
            $select = 's.*';
        } else {
            $select = 's.*, COUNT(t.id) as count_product';
        }
        if (isset($options['keyword']) && $options['keyword']) {
            $tag = $options['keyword'];
            $tag = str_replace(',', ' ', $tag);
            if ($tag) {
                $select = $select . ", ((1.8 * (MATCH(s.name) AGAINST (:tag IN BOOLEAN MODE)))) as score ";
                // $query->select($select . ", ((1.8 * (MATCH(s.name) AGAINST (:tag IN BOOLEAN MODE)))) as score ");
                $query->andWhere("(MATCH(s.name) AGAINST (:tag IN BOOLEAN MODE))");
                $query->having('score > 1');
                $order = 'score DESC, ' . $order;
                $params[':tag'] = $tag;
            }
        }
        //
        if (isset($options['count'])) {
            $total = $query->select($select)
                ->from('shop AS s')
                ->leftJoin('product AS t', 't.shop_id = s.id')
                ->where($condition, $params)
                ->distinct('s.id')
                ->count();
            return $total;
        }
        $data = (new Query())->select($select)
            ->from('shop AS s')
            ->leftJoin('product AS t', 't.shop_id = s.id')
            ->andWhere($condition, $params)
            ->orderBy($order)
            ->limit($limit)
            ->offset($offset)
            ->distinct('s.name')
            ->groupBy('s.id')
            ->all();
        return $data;
    }

    public static function updateRating($id)
    {
        $shop = self::findOne($id);
        if ($shop) {
            $list_product = \common\models\product\Product::find()->where(['shop_id' => $id])->andWhere(' rate_count > 0 ')->all();
            $shop->rate = 0;
            $shop->rate_count = 0;
            if ($list_product) {
                foreach ($list_product as $product) {
                    $shop->rate += $product->rate;
                    $shop->rate_count += $product->rate_count;
                }
                $shop->rate =  round($shop->rate / count($list_product), 2);
                $shop->save(false);
            }
        }
    }

    public function afterSave($insert, $changedAttributes)

    {
        if ($this->email && isset($changedAttributes['status']) && $this->status == 1) {
            \common\models\mail\SendEmail::sendMail([
                'title' => '[Thông báo] Gian hàng đã được duyệt',
                'content' => '<p>Gian hàng <b>' . $this->name . '</b> của quý khách đã được duyệt.</p><p>Quý khách có thể sử dụng những tính năng của gian hàng và đăng bán sản phẩm trên ocopmart.org ngay từ bây giờ</p><p><a href="<?= __SERVER_NAME ?>/quan-ly-san-pham.html">Đăng sản phẩm</a></p>',
                'email' => $this->email,
            ]);
        }
        return parent::afterSave($insert, $changedAttributes);
    }

    static function checkAccountStatus($user_id)
    {
        $shop = $user_id ? \common\models\shop\Shop::findOne($user_id) : 0;
        if ($shop && $shop->account_status == 1) {
            return true;
        }
        return false;
    }
    public function getProvince(){
        return $this->hasOne(Province::className(),['id' => 'province_id'])->select('name,id');
    }

    public function getDistrict(){
        return $this->hasOne(District::className(),['id' => 'district_id'])->select('name,id');
    }

    public function getWard(){
        return $this->hasOne(Ward::className(),['id' => 'ward_id'])->select('name,id');
    }

    public function getJob(){
        return $this->hasOne(ChucDanh::className(),['id' => 'nghe_nghiep'])->select('name,id');
    }

    public function getUser(){
        return $this->hasOne(User::className(),['id' => 'user_id'])->select('avatar_path,avatar_name,id');
    }
}
