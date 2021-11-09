<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "user_recruiter_info".
 *
 * @property string $user_id
 * @property string $contact_name
 * @property string $phone
 * @property integer $scale
 * @property string $address
 * @property string $province_id
 * @property string $district_id
 * @property string $ward_id
 * @property string $avatar_path
 * @property string $avatar_name
 * @property string $description
 */
class UserRecruiterInfo extends \yii\db\ActiveRecord {

    public $avatar = '';

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'user_recruiter_info';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['user_id', 'contact_name', 'phone', 'address', 'province_id', 'district_id', 'ward_id', 'scale', 'description'], 'required'],
            [['user_id', 'scale', 'province_id', 'district_id', 'ward_id'], 'integer'],
            [['contact_name', 'address', 'avatar_path', 'avatar_name'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 50],
            [['avatar', 'description'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'user_id' => 'User ID',
            'contact_name' => 'Tên người liên hệ',
            'phone' => 'Số điện thoại',
            'scale' => 'Qui mô công ty',
            'address' => 'Địa chỉ',
            'province_id' => 'Tỉnh/thành phố',
            'district_id' => 'Quận/huyện',
            'ward_id' => 'Phường/xã',
            'avatar_path' => 'Avatar Path',
            'avatar_name' => 'Avatar Name',
            'description' => 'Mô tả công ty'
        ];
    }

    public static function optionsScale() {
        return [
            1 => '1 - 50 người',
            2 => '50 - 100 người',
            3 => '100 - 200 người',
            4 => '200 - 300 người',
            5 => '300 - 400 người',
            6 => '400 - 500 người',
            7 => '> 500 người',
        ];
    }

    public static function getScaleName($scale) {
        $data = self::optionsScale();
        return isset($data[$scale]) ? $data[$scale] : '';
    }

}
