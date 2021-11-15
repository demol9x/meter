<?php

namespace common\models\package;

use common\models\District;
use common\models\Ward;
use frontend\models\User;
use Yii;

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
            [['name', 'shop_id','ward_id', 'district_id', 'province_id'], 'required'],
            [['shop_id', 'status', 'avatar_id', 'isnew', 'ishot', 'ward_id', 'district_id', 'province_id', 'viewed', 'ckedit_desc', 'order', 'created_at', 'updated_at','delete'], 'integer'],
            [['short_description', 'description'], 'string'],
            [['lat', 'long'], 'number'],
            [['file'], 'file'],
            [['status'], 'default','value' => self::STATUS_CLOSE],
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
            'name' => 'Tên gói thầu',
            'shop_id' => 'Nhà thầu',
            'alias' => 'Alias',
            'status' => 'Trạng thái',
            'avatar_path' => 'Avatar Path',
            'avatar_name' => 'Avatar Name',
            'avatar_id' => 'Avatar ID',
            'isnew' => 'Isnew',
            'ishot' => 'Ishot',
            'address' => 'Địa chỉ',
            'ward_id' => 'Phường/xã',
            'ward_name' => 'Phường/xã',
            'district_id' => 'Quận/huyện',
            'district_name' => 'Quận/huyện',
            'province_id' => 'Tỉnh/thành phố',
            'province_name' => 'Tỉnh/thành phố',
            'latlng' => 'Latlng',
            'viewed' => 'Số lượt xem',
            'short_description' => 'Mô tả ngắn',
            'description' => 'Mô tả',
            'ho_so' => 'Hồ sơ đính kèm',
            'ckedit_desc' => 'Sử dụng trình soạn thảo',
            'order' => 'Sắp xếp',
            'lat' => 'Vĩ độ',
            'long' => 'Kinh độ',
            'created_at' => 'Thời gian tạo',
            'updated_at' => 'Updated At',
            'file' => 'Hồ sơ đính kèm',
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

    static function getStatus(){
        return [
            self::STATUS_ACTIVE => 'Hiển thị',
            self::STATUS_CLOSE => 'Ẩn'
        ];
    }

    public function getUser(){
        return $this->hasOne(User::className(),['id' => 'shop_id'])->select('username');
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

    function getDistrict($model){
        $district = [];
        if($model->province_id){
            $district = District::dataFromProvinceId($model->province_id);
        }
        return $district;
    }

    function getWard($model){
        $ward = [];
        if($model->district_id){
            $ward = Ward::dataFromDistrictId($model->district_id);
        }
        return $ward;
    }
}
