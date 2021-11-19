<?php

namespace common\models\user;

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
            [['user_id', 'kinh_nghiem', 'created_at', 'updated_at'], 'integer'],
            [['kinh_nghiem_description', 'description'], 'string'],
            [['tot_nghiep', 'nghe_nghiep', 'chuyen_nganh','attachment'], 'string', 'max' => 255],
            ['file','file']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'tot_nghiep' => 'Tốt nghiệp trường',
            'nghe_nghiep' => 'Nghề nghiệp',
            'chuyen_nganh' => 'Chuyên ngành',
            'kinh_nghiem' => 'Số năm kinh nghiệm',
            'kinh_nghiem_description' => 'Kinh nghiệm làm việc',
            'description' => 'Giới thiệu',
            'attachment' => 'CV',
            'created_at' => 'Created At',
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
}
