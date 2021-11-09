<?php

namespace frontend\models\profile;

use Yii;

/**
 * This is the model class for table "user_info".
 *
 * @property string $user_id
 * @property string $expected_position
 * @property integer $new_graduate
 * @property integer $experience
 * @property string $description
 * @property string $skills
 * @property string $avatar_path
 * @property string $avatar_name
 */
class UserInfo extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'user_info';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['user_id', 'expected_position'], 'required'],
            [['user_id', 'new_graduate', 'experience'], 'integer'],
            [['description'], 'string'],
            [['expected_position', 'skills', 'avatar_path', 'avatar_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'user_id' => 'User ID',
            'expected_position' => 'Chức danh',
            'new_graduate' => 'Mới tốt nghiệp',
            'experience' => 'Số năm kinh nghiệm',
            'description' => 'Giới thiệu bản thân và miêu tả mục tiêu nghề nghiệp của bạn',
            'skills' => 'Kỹ năng',
            'avatar_path' => 'Avatar Path',
            'avatar_name' => 'Avatar Name',
        ];
    }

}
