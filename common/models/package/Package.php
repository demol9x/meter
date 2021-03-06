<?php

namespace common\models\package;

use common\components\ClaLid;
use common\models\District;
use common\models\Province;
use common\models\Ward;
use frontend\models\User;
use Yii;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use  common\models\product\Product;

/**
 * This is the model class for table "package".
 *
 * @property string $id
 * @property string $name
 * @property integer $shop_id
 * @property string $alias
 * @property integer $status
 * @property string $avatar_path
 * @property string $avatar_name
 * @property string $avatar_id
 * @property integer $isnew
 * @property integer $ishot
 * @property string $address
 * @property integer $ward_id
 * @property string $ward_name
 * @property integer $district_id
 * @property string $district_name
 * @property integer $province_id
 * @property string $province_name
 * @property string $latlng
 * @property string $viewed
 * @property string $short_description
 * @property string $description
 * @property string $ho_so
 * @property integer $ckedit_desc
 * @property integer $order
 * @property double $lat
 * @property double $long
 * @property string $created_at
 * @property string $updated_at
 */
class Package extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_CLOSE = 0;
    public $file;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'package';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'shop_id', 'ward_id', 'district_id', 'province_id'], 'required'],
            [['shop_id', 'status', 'avatar_id', 'isnew', 'ishot', 'ward_id', 'district_id', 'province_id', 'viewed', 'ckedit_desc', 'order', 'created_at', 'updated_at', 'delete'], 'integer'],
            [['short_description', 'description'], 'string'],
            [['lat', 'long','price','rate','rate_count'], 'number'],
            [['file'], 'file'],
            [['status'], 'default', 'value' => self::STATUS_CLOSE],
            [['name', 'alias', 'avatar_path', 'avatar_name', 'address', 'ward_name', 'district_name', 'province_name', 'latlng', 'ho_so'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'price' => 'Gi?? kh???i ??i???m',
            'name' => 'T??n g??i th???u',
            'shop_id' => 'Nh?? th???u',
            'alias' => 'Alias',
            'status' => 'Tr???ng th??i',
            'avatar_path' => 'Avatar Path',
            'avatar_name' => 'Avatar Name',
            'avatar_id' => 'Avatar ID',
            'isnew' => 'Isnew',
            'ishot' => 'Ishot',
            'address' => '?????a ch???',
            'ward_id' => 'Ph?????ng/x??',
            'ward_name' => 'Ph?????ng/x??',
            'district_id' => 'Qu???n/huy???n',
            'district_name' => 'Qu???n/huy???n',
            'province_id' => 'T???nh/th??nh ph???',
            'province_name' => 'T???nh/th??nh ph???',
            'latlng' => 'Latlng',
            'viewed' => 'S??? l?????t xem',
            'short_description' => 'M?? t??? ng???n',
            'description' => 'M?? t???',
            'ho_so' => 'H??? s?? ????nh k??m',
            'ckedit_desc' => 'S??? d???ng tr??nh so???n th???o',
            'order' => 'S???p x???p',
            'lat' => 'V?? ?????',
            'long' => 'Kinh ?????',
            'created_at' => 'Th???i gian t???o',
            'updated_at' => 'Updated At',
            'file' => 'H??? s?? ????nh k??m',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->created_at = $this->updated_at = time();
            } else {
                $this->updated_at = time();
            }
            // Alias
            $this->alias = \common\components\HtmlFormat::parseToAlias($this->name);
            return true;
        } else {
            return false;
        }
    }

    static function getStatus()
    {
        return [
            self::STATUS_ACTIVE => 'Hi???n th???',
            self::STATUS_CLOSE => '???n'
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'shop_id'])->select('username');
    }

    public static function getImages($id)
    {
        $result = [];
        if (!$id) {
            return $result;
        }
        $result = (new \yii\db\Query())->select('*')
            ->from('package_image')
            ->where('package_id=:package_id', [':package_id' => $id])
            ->orderBy('order ASC, created_at DESC')
            ->all();
        return $result;
    }

    function getDistrict($model)
    {
        $district = [];
        if ($model->province_id) {
            $district = District::dataFromProvinceId($model->province_id);
        }
        return $district;
    }

    function getWard($model)
    {
        $ward = [];
        if ($model->district_id) {
            $ward = Ward::dataFromDistrictId($model->district_id);
        }
        return $ward;
    }

    public static function getProvince_1 ($options = [])
    {
        $condition = 'status=:status';
        $params = [
            ':status' => ClaLid::STATUS_ACTIVED
        ];
        $skills_temp = ArrayHelper::map(Province::find()->asArray()->all(), 'id', 'name');
        $results = [];
        $province = (new Query())->select('province_id')
            ->from('package')
            ->where($condition, $params)
            ->column();
        if (isset($province) && $province) {

            foreach ($province as $skill) {
                $skill_explode = explode(' ', $skill);
                foreach ($skill_explode as $skill_id) {
                    if (isset($results[$skill_id]['count_job'])) {
                        $results[$skill_id]['count_job']++;
                    } else {
                        $results[$skill_id]['count_job'] = 1;
                        $results[$skill_id]['name'] = $skills_temp[$skill_id];
                    }
                }
            }
        }
        return $results;
    }

    public function getProvince()
    {
        return $this->hasOne(Province::className(), ['id' => 'province_id'])->select('name,id');
    }

    public static function getPackage($options = [], $getdata = false)
    {
        $query = Package::find()->where(['status' => 1]);
        if (isset($options['s']) && $options['s']) {
            $query->andFilterWhere(['like', 'package.name', $options['s']]);
        }

        if (isset($options['province_id']) && $options['province_id']) {
            $query->andFilterWhere(['province_id' => $options['province_id']]);
        }

        if (isset($options['price_min']) && $options['price_min']) {
            $query->andFilterWhere(['>' ,'price', $options['price_min']-1]);
        }
        if (isset($options['price_max']) && $options['price_max']) {
            $query->andFilterWhere(['<' ,'price', $options['price_max']+1]);
        }

        if (isset($options['limit']) && $options['limit']) {
            $limit = $options['limit'];
        }
        if (isset($options['page'])) {
            $offset = ($options['page'] - 1) * $limit;
        } else {
            $offset = 0;
        }
        if(isset($options['ishot'])&&$options['ishot'] ){
            $query->andFilterWhere(['ishot' => $options['ishot']]);
        }
        if(isset($options['isnew'])&&$options['isnew'] ){
            $query->andFilterWhere(['isnew' => $options['isnew']]);
        }
        $order='order ASC, updated_at DESC';
        if(isset($options['order']) && $options['order']){
            $order=$options['order'];
        }
        if(isset($options['fitler']) && $options['fitler']){
            if($options['fitler'] == 'week'){
                $query->andFilterWhere(['>=','package.created_at',strtotime('curdate() - INTERVAL DAYOFWEEK(curdate())+6 DAY')]) ;
                $query->andFilterWhere(['<','package.created_at',strtotime('curdate() + 1')]);
            }
            if($options['fitler'] == 'month'){
                $query->andFilterWhere(['>=','package.created_at',strtotime(' curdate() - INTERVAL DAYOFWEEK(curdate())+30 DAY')]) ;
                $query->andFilterWhere(['<','package.created_at',strtotime('curdate() + 1')]);
            }
            if($options['fitler']== 'very_new'){
                $order = 'created_at DESC';
            }
        }
        $total= $query->count();
        $data= $query->joinWith(['province'])
        ->orderBy($order)
        ->limit($limit)->offset($offset)->asArray()->all();
        if (isset($getdata) && $getdata) {
            return $data;
        }
        return [
            'total' => $total,
            'data' => $data
        ];


    }
}
