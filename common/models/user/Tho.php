<?php

namespace common\models\user;

use common\models\District;
use common\models\general\ChucDanh;
use common\models\Province;
use common\models\Ward;
use frontend\models\User;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "tho".
 *
 * @property integer $user_id
 * @property string $tot_nghiep
 * @property string $nghe_nghiep
 * @property string $chuyen_nganh
 * @property integer $kinh_nghiem
 * @property string $kinh_nghiem_description
 * @property string $description
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $rate_count
 * @property number $rate
 * @property number $status
 */
class Tho extends \yii\db\ActiveRecord
{
    public $file;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tho';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'kinh_nghiem', 'created_at', 'updated_at','nghe_nghiep','ward_id','district_id','province_id','rate_count','is_hot','status'], 'integer'],
            [['kinh_nghiem_description', 'description'], 'string'],
            [['tot_nghiep', 'chuyen_nganh','attachment','address','name'], 'string', 'max' => 255],
            ['file','file'],
            [['rate'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'Họ và tên',
            'name' => 'Họ và tên',
            'tot_nghiep' => 'Tốt nghiệp trường',
            'nghe_nghiep' => 'Nghề nghiệp',
            'chuyen_nganh' => 'Chuyên ngành',
            'kinh_nghiem' => 'Số năm kinh nghiệm',
            'kinh_nghiem_description' => 'Kinh nghiệm làm việc',
            'description' => 'Giới thiệu',
            'attachment' => 'CV',
            'is_hot' => 'Nổi bật',
            'created_at' => 'Thời gian tạo',
            'updated_at' => 'Updated At',
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    static function numberKn(){
        return [
            1 => 'Dưới 1 năm',
            2 => '1-2 năm',
            3 => '2-3 năm',
            4 => '3-4 năm',
            5 => 'Trên 5 năm',
        ];
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
        return $this->hasOne(User::className(),['id' => 'user_id'])->select('avatar_path,avatar_name,id,phone,email,username,birthday');
    }
}
