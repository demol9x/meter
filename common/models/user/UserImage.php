<?php

namespace common\models\user;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "product_image".
 *
 * @property string $id
 * @property integer $user_id
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
class UserImage extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'user_image';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['user_id', 'path', 'name'], 'required'],
            [['user_id', 'height', 'width', 'created_at', 'order', 'is_avatar'], 'integer'],
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
            'user_id' => 'Album ID',
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

    static function getImages($user_id){
        $data = self::find()->where(['user_id' => $user_id])->asArray()->all();
        return $data;
    }

    /**
     * get all images by color
     * @param type $user_id
     * @param type $color
     * @return type
     */
    public static function getImagesByColor($user_id, $color) {
        $data = (new Query())->select('*')
                ->from('user_image')
                ->where('user_id=:user_id AND color=:color', [':user_id' => $user_id, ':color' => $color])
                ->all();
        return $data;
    }
    
    public static function getImagesById($user_id) {
        $data = (new Query())->select('*')
                ->from('user_image')
                ->where('user_id=:user_id ', [':user_id' => $user_id])
                ->one();
        return $data;
    }
    /**
     * get only image by color
     * @param type $user_id
     * @param type $color
     * @return type
     */
    public static function getImageByColor($user_id, $color) {
        $color = str_replace(' ', '', $color);
        $data = (new Query())->select('*')
                ->from('user_image')
                ->where('user_id=:user_id AND color=:color', [':user_id' => $user_id, ':color' => $color])
                ->one();
        return $data;
    }

}
