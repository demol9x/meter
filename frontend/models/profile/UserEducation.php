<?php

namespace frontend\models\profile;

use Yii;

/**
 * This is the model class for table "user_education".
 *
 * @property string $id
 * @property string $user_id
 * @property string $subject
 * @property string $school
 * @property integer $qualification
 * @property string $month_from
 * @property string $month_to
 * @property string $description
 */
class UserEducation extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'user_education';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['user_id', 'subject', 'school', 'qualification'], 'required'],
            [['user_id', 'qualification'], 'integer'],
            [['subject', 'school'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 5000],
            [['month_from', 'month_to'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'subject' => 'Chuyên ngành',
            'school' => 'Trường',
            'qualification' => 'Bằng cấp',
            'month_from' => 'Từ tháng',
            'month_to' => 'Đến tháng',
            'description' => 'Thành tựu',
        ];
    }

    public static function arrayQualification() {
        return [
            1 => 'Trung học',
            2 => 'Trung cấp',
            3 => 'Cao đẳng',
            4 => 'Đại học',
            5 => 'Thạc sĩ',
            6 => 'Tiến sĩ',
            7 => 'Khác',
        ];
    }

    public static function getQualificationName($qualification) {
        $data = self::arrayQualification();
        return isset($data[$qualification]) ? $data[$qualification] : '';
    }

}
