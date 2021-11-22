<?php

namespace common\models\form;

use Yii;

/**
 * This is the model class for table "{{%form_event}}".
 *
 * @property integer $id
 * @property string $user_name
 * @property string $email
 * @property string $src
 * @property string $link
 * @property string $note
 * @property integer $phone
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $type
 * @property integer $news_id
 */
class FormEvent extends \common\models\ActiveRecordC
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%form_event}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_name', 'phone', 'email'], 'required'],
            [['phone', 'created_at', 'updated_at','type'], 'integer'],
            [['src', 'link', 'type_price','note','news_id'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_name' => 'Họ và tên',
            'phone' => 'Số điện thoại',
            'email' => 'Email',
            'src' => 'File',
            'link' => 'Link bài viết',
            'created_at' => 'Ngày tạo',
            'updated_at' => 'Ngày cập nhật',
            'note' => 'Ghi chú',
            'type' => 'Loại',
            'news_id' => 'Bài viết',
        ];
    }
    static function allowExtensions()
    {
        return array(
            'image/jpeg' => 'image/jpeg',
            'image/gif' => 'image/gif',
            'image/png' => 'image/png',
            'image/bmp' => 'image/bmp',
            'application/x-shockwave-flash' => 'application/x-shockwave-flash',
        );
    }


    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->created_at = time();
            }
            $this->updated_at = time();
            return true;
        }
        return false;
    }

}
