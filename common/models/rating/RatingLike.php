<?php

namespace common\models\rating;

use common\models\package\PackageImage;
use Yii;

/**
 * This is the model class for table "rating_like".
 *
 * @property string $id
 * @property integer $rating_id
 * @property integer $user_id
 * @property integer $created_at
 */
class RatingLike extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rating_like';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rating_id', 'user_id'], 'required'],
            [['rating_id', 'user_id', 'created_at'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'rating_id' => 'Rating ID',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
        ];
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->created_at = time();
            }
            return true;
        } else {
            return false;
        }
    }
}
