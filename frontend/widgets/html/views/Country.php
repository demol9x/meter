<?php

namespace common\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "ward".
 *
 * @property string $id
 * @property string $name
 * @property string $type
 * @property string $latlng
 * @property integer $district_id
 */
class Country extends \common\models\ActiveRecordC
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'country';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Tên',
        ];
    }
}
