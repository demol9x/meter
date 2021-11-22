<?php

namespace common\models\shop;

use Yii;

/**
 * This is the model class for table "{{%shop_level}}".
 *
 * @property string $id
 * @property string $shop_id
 * @property string $shop_name
 * @property string $link
 * @property integer $status
 * @property integer $created_time
 * @property integer $modified_time
 */
class BlockCheck extends \yii\db\ActiveRecord
{

    const STATUS_DEACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_WAIL = 2;
    public $method;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%block_check}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['shop_name'], 'required'],
            [['created_time', 'modified_time'], 'integer'],
            [['shop_name','link'], 'string', 'max' => 255],
            [['status', 'shop_id'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'shop_name' => 'Tên gian hàng',
            'shop_id' => 'Shop ID',
            'created_time' => 'Ngày tạo',
            'modified_time' => 'Ngày cập nhật',
            'status' => 'Trạng thái',
        ];
    }

    public static function optionBlockCheck()
    {
        $data = self::find()->asArray()->all();
        return array_column($data, 'shop_name', 'id');
    }

    public static function getchecked($id)
    {
        $data = self::findOne(['shop_id' => $id]);
        if (isset($data) && $data) {
            if ($data->status == BlockCheck::STATUS_WAIL) {
                return false;
            }
        }
        return true;
    }

    public static function getStatus()
    {
        return [
            self::STATUS_DEACTIVE => 'Chưa kích hoạt',
            self::STATUS_ACTIVE => 'Đã kích hoạt',
            self::STATUS_WAIL => 'Chờ kích hoạt'
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->created_time = time();
            }
            $this->modified_time = time();
            return true;
        }
        return false;
    }

    public function processResponse($response)
    {
        return json_decode($response, true);
    }

    public static function sendRequest($url = null, $data = null, $method = 'post')
    {
        if (!$url) {
            return false;
        }
        $ch = curl_init();
        //
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); //timeout in seconds
        $urlInfo = parse_url($url);
        if (isset($data['token']) && $data['token']) {
            $head[] = "x-token: ".$data['token'];
            unset($data['token']);
        }
        $head[] = "Host: {$urlInfo['host']}";

        if (isset($method) && $method == 'get') {
            curl_setopt($ch, CURLOPT_HTTPGET, true);
        } else {
            $head[] = "Content-Type: application/json";
            curl_setopt($ch, CURLOPT_POST, true);
            $data = json_encode($data);
            //
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }

        //
        curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //
        $response = curl_exec($ch);
        curl_close($ch);
        $result = self::processResponse($response);
        //
        return $result;
    }

}
