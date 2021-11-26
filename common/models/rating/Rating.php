<?php

namespace common\models\rating;

use frontend\models\User;
use Yii;

/**
 * This is the model class for table "rating".
 *
 * @property string $id
 * @property string $user_id
 * @property string $name
 * @property string $address
 * @property string $email
 * @property integer $rating
 * @property integer $type
 * @property string $object_id
 * @property string $content
 * @property integer $status
 * @property integer $parent_id
 * @property integer $count_like
 * @property string $created_at
 * @property integer $updated_at
 */
class Rating extends \yii\db\ActiveRecord
{
    const TYPE_THO = 1; //Thợ
    const TYPE_SHOP = 2; //Doanh nghiệp
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rating';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'rating', 'object_id', 'content','type'], 'required'],
            [['user_id', 'type', 'object_id', 'status', 'parent_id', 'count_like', 'created_at', 'updated_at','is_image'], 'integer'],
            [['content'], 'string'],
            [['rating'], 'number'],
            [['name', 'address', 'email'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Họ tên',
            'name' => 'Họ tên',
            'address' => 'Địa chỉ',
            'email' => 'Email',
            'rating' => 'Điểm vote',
            'type' => 'Loại',
            'object_id' => 'Object ID',
            'content' => 'Nội dung',
            'status' => 'Trạng thái',
            'parent_id' => 'Parent ID',
            'count_like' => 'Count Like',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->created_at = $this->updated_at = time();
            }else{
                $this->updated_at = time();
            }
            return true;
        } else {
            return false;
        }
    }

    public function getUser(){
        return $this->hasOne(User::className(),['id' => 'user_id'])->select('id,username,avatar_path,avatar_name');
    }

    public function getImages(){
        return $this->hasMany(RatingImage::className(),['rating_id' => 'id']);
    }

    public static function getRating($options = [])
    {
        $query = self::find()->where(['rating.status' => 1,'rating.object_id' => $options['object_id'],'rating.type' => $options['type']]);

        if (isset($options['is_image']) && $options['is_image']) {
            $query->andFilterWhere(['is_image' => 1]);
        }

        if (isset($options['rating']) && $options['rating']) {
            $query->andFilterWhere(['rating' => $options['rating']]);
        }

        $limit = 15;
        if (isset($options['limit']) && $options['limit']) {
            $limit = $options['limit'];
        }
        if (isset($options['page'])) {
            $offset = ($options['page'] - 1) * $limit;
        } else {
            $offset = 0;
        }
        $order='created_at DESC';
        if(isset($options['order']) && $options['order']){
            $order = $options['order'];
        }

        $total= $query->count();
        $data= $query->joinWith(['user','images'])
            ->orderBy($order)
            ->limit($limit)->offset($offset)->asArray()->all();
        return [
            'total' => $total,
            'data' => $data
        ];


    }
}
