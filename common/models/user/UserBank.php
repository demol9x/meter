<?php

namespace common\models\user;

use yii\db\Query;
use Yii;

/**
 * This is the model class for table "{{%user_bank}}".
 *
 * @property string $id
 * @property string $user_id
 * @property integer $bank_type
 * @property string $number
 * @property string $name
 * @property string $phone
 */
class UserBank extends \common\models\ActiveRecordC
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_bank}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bank_type', 'number', 'name', 'phone', 'user_id', 'isdefault', 'address'], 'required'],
            [['bank_type', 'user_id', 'isdefault'], 'integer'],
            [['number', 'name'], 'string', 'max' => 255],
            [['address'], 'string', 'max' => 500],
            [['phone'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'ID',
            'isdefault' => Yii::t('app', 'default'),
            'bank_type' =>  Yii::t('app', 'bank'),
            'number' =>  Yii::t('app', 'user_bank_number'),
            'name' =>  Yii::t('app', 'user_bank'),
            'phone' => 'Phone',
            'address' => Yii::t('app', 'address_bank'),
        ];
    }
    public static function getAllBank($user_id)
    {
        return (new Query())->select('user_bank.*, bank.name as bank_name')
            ->from('user_bank')
            ->leftJoin('bank', 'user_bank.bank_type = bank.id')
            ->where(['user_id' => $user_id])
            ->orderBy('isdefault DESC, user_bank.id DESC')
            ->all();
    }

    public function beforeAttr($query, &$options)
    {
        $query->select('b.name as bank_name, user_bank.*')->leftJoin('bank b', 'user_bank.bank_type = b.id');
        return $query;
    }
}
