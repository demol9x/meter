<?php

namespace common\models\recruitment;

use Yii;

/**
 * This is the model class for table "apply".
 *
 * @property string $id
 * @property string $recruitment_id
 * @property string $avatar_path
 * @property string $avatar_name
 * @property string $location_desire
 * @property string $user_id
 * @property string $name
 * @property integer $sex
 * @property string $birthday
 * @property string $birthplace
 * @property string $identity_card
 * @property integer $married_status
 * @property string $address
 * @property string $hotline
 * @property string $email
 * @property string $province_id
 * @property string $district_id
 * @property string $income_desire
 * @property integer $height
 * @property integer $weight
 * @property string $reason
 * @property string $certificate
 * @property string $created_at
 * @property string $updated_at
 */
class Apply extends \yii\db\ActiveRecord {

    public $day;
    public $month;
    public $year;
    //
    public $avatar;
    public $src_avatar;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'apply';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['recruitment_id', 'location_desire', 'name', 'birthday', 'birthplace', 'identity_card', 'address', 'hotline', 'email', 'province_id', 'income_desire', 'reason'], 'required'],
            [['recruitment_id', 'location_desire', 'user_id', 'sex', 'birthplace', 'married_status', 'province_id', 'district_id', 'income_desire', 'height', 'weight', 'created_at', 'updated_at'], 'integer'],
            [['birthday'], 'safe'],
            [['avatar_path', 'avatar_name', 'name', 'address', 'email'], 'string', 'max' => 255],
            [['identity_card', 'hotline'], 'string', 'max' => 20],
            [['reason'], 'string', 'max' => 1000],
            [['certificate'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'recruitment_id' => 'Recruitment ID',
            'avatar_path' => 'Avatar Path',
            'avatar_name' => 'Avatar Name',
            'location_desire' => 'Nguy???n v???ng l??m vi???c t???i',
            'user_id' => 'User ID',
            'name' => 'H??? t??n ???ng vi??n',
            'sex' => 'Gi???i t??nh',
            'birthday' => 'Ng??y sinh',
            'birthplace' => 'N??i sinh',
            'identity_card' => 'CMND',
            'married_status' => 'T??nh tr???ng h??n nh??n',
            'address' => '?????a ch???',
            'hotline' => '??i???n tho???i di ?????ng',
            'email' => 'Email',
            'province_id' => 'T??nh th??nh',
            'district_id' => 'Qu???n huy???n',
            'income_desire' => 'Thu nh???p mong mu???n',
            'height' => 'Chi???u cao (cm)',
            'weight' => 'C??n n???ng',
            'reason' => 'V?? sao b???n mu???n ???ng tuy???n v??? tr?? n??y?',
            'certificate' => 'Ch???ng ch??? kh??c',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getDays() {
        $days = [
            '' => 'Ng??y',
        ];
        for ($i = 1; $i <= 31; $i++) {
            $key = $i < 10 ? '0' . $i : $i;
            $days[$key] = $key;
        }
        return $days;
    }

    public function getMonths() {
        $months = [
            '' => 'Th??ng'
        ];
        for ($i = 1; $i <= 12; $i++) {
            $key = $i < 10 ? '0' . $i : $i;
            $months[$key] = $key;
        }
        return $months;
    }

    public function getYears() {
        $years = [
            '' => 'N??m'
        ];
        for ($i = 2000; $i >= 1950; $i--) {
            $years[$i] = $i;
        }
        return $years;
    }
    
    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->created_at = $this->updated_at = time();
            } else {
                $this->updated_at = time();
            }
            return true;
        } else {
            return false;
        }
    }

}
