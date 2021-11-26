<?php

namespace common\models\rating;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "product_image".
 *
 * @property string $id
 * @property integer $rating_id
 * @property string $path
 * @property string $name
 * @property string $display_name
 * @property string $height
 * @property string $width
 * @property integer $order
 * @property string $created_at
 * @property string $color
 * @property integer $is_avatar
 */
class RatingImage extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'rating_images';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['rating_id', 'path', 'name'], 'required'],
            [['rating_id', 'height', 'width', 'created_at', 'order', 'is_avatar','object_id','type'], 'integer'],
            [['path', 'name', 'display_name'], 'string', 'max' => 255],
            [['color'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'rating_id' => 'Album ID',
            'path' => 'Path',
            'name' => 'Name',
            'display_name' => 'Display Name',
            'height' => 'Height',
            'width' => 'Width',
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
