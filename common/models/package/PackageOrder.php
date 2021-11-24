<?php

namespace common\models\package;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "package_order".
 *
 * @property string $id
 * @property integer $shop_id
 * @property integer $package_id
 * @property string $name
 * @property integer $founding
 * @property string $number_auth
 * @property string $business
 * @property string $phone
 * @property string $email
 * @property string $website
 * @property string $address
 * @property double $price
 * @property string $attachment
 * @property string $description
 * @property integer $created_at
 * @property integer $updated_at
 */
class PackageOrder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'package_order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['shop_id', 'package_id', 'name', 'founding', 'number_auth', 'business', 'phone', 'email', 'address', 'price', 'attachment'], 'required'],
            [['shop_id', 'package_id', 'founding', 'created_at', 'updated_at'], 'integer'],
            [['price'], 'number'],
            [['description'], 'string'],
            [['name', 'attachment'], 'string', 'max' => 255],
            [['number_auth'], 'string', 'max' => 50],
            [['business'], 'string', 'max' => 500],
            [['phone'], 'string', 'max' => 15],
            [['email', 'website', 'address'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'shop_id' => 'Shop ID',
            'package_id' => 'Package ID',
            'name' => 'Tên công ty',
            'founding' => 'Ngày thành lập',
            'number_auth' => 'Mã số thuế',
            'business' => 'Ngành nghề kinh doanh',
            'phone' => 'Số điện thoại',
            'email' => 'Email',
            'website' => 'Website',
            'address' => 'Địa chỉ',
            'price' => 'Vốn điều lệ',
            'attachment' => 'Tài liệu đính kèm',
            'description' => 'Mô tả',
            'created_at' => 'Thời gian',
            'updated_at' => 'Updated At',
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }
}
