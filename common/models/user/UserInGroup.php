<?php

namespace common\models\user;

use Codeception\Lib\Generator\Group;
use Yii;

/**
 * This is the model class for table "{{%user_in_group}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $user_group_id
 * @property string $image
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $agree_at
 * @property integer $status
 * @property integer $user_admin
 */
class UserInGroup extends \common\models\ActiveRecordC
{
    public $avatar;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_in_group}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'user_group_id', 'created_at', 'updated_at', 'agree_at', 'status', 'user_admin'], 'integer'],
            [['image'], 'string', 'max' => 250],
            [['avatar'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Người dùng',
            'user_group_id' => 'Nhóm người dùng',
            'image' => 'Ảnh xác thực',
            'created_at' => 'Ngày tạo',
            'updated_at' => 'Updated At',
            'agree_at' => 'Agree At',
            'status' => 'Trạng thái',
            'user_admin' => 'User Admin',
        ];
    }

    function getListCatAllow($user_id)
    {
        $data = UserGroup::find()->leftJoin('user_in_group', 'user_in_group.user_group_id = user_group.id')->where(['user_in_group.user_id' => $user_id, 'user_in_group.status' => 1])->all();
        $list = '-1';
        if ($data) {
            foreach ($data as $item) {
                $list .= $item->product_categorys ? ',' . $item->product_categorys : '';
            }
        }
        return explode(',', $list);
    }

    function show($attr)
    {
        switch ($attr) {
            case 'user_id':
                $model = \frontend\models\User::findOne($this->$attr);
                return $model ? $model->username : $this->$attr;
            case 'user_group_id':
                $model = \common\models\user\UserGroup::findOne($this->$attr);
                return $model ? $model->name : $this->$attr;
            case 'image':
                return \common\components\ClaHost::getLinkImage('', $this->$attr);
        }
        return parent::show($attr);
    }

    function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->created_at = $this->updated_at = time();
        } else {
            $this->updated_at = time();
        }
        return parent::beforeSave($insert);
    }

    static function getModel($options)
    {
        $model = self::findOne($options);
        if (!$model) {
            $model = new self();
            $model->attributes = $options;
        }
        return $model;
    }

    public static function getAllUserId($user_group_id)
    {
        $data = self::find()->select('user_id')->where(['user_group_id' => $user_group_id, 'status' => 1])->asArray()->column();
        return $data;
    }
}
