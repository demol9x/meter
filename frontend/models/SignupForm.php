<?php

namespace frontend\models;

use common\models\shop\Shop;
use yii\base\Model;
use frontend\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{

    public $username;
    public $email;
    public $phone;
    public $password;
    public $terms_and_condition;
    public $tax_number;
    public $user_before;
    public $is_notification;
    public $type;
    public $number_auth;
    public $business;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['phone', 'trim'],
            ['phone', 'required'],
            ['username', 'required'],
            ['phone', 'integer'],
            ['user_before', 'integer'],
            ['phone', 'string', 'min' => 10, 'max' => 11],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\frontend\models\User', 'message' => 'Email đã tồn tại.'],
            ['email', 'string', 'max' => 255],
            ['phone', 'string', 'max' => 255],
            ['phone', 'unique', 'targetClass' => '\frontend\models\User', 'message' => 'Số điện thoại đã tồn tại.'],
            ['password', 'required'],
            ['password', 'string', 'min' => 6, 'max' => 100],
            ['terms_and_condition', 'integer'],
            ['terms_and_condition', 'required'],
            ['tax_number', 'string', 'max' => 255],
            [['tax_number', 'email'], 'required', 'on' => 'business'],
            ['type', 'required'],
            ['type', 'integer'],
            ['number_auth', 'string', 'max' => 255],
            ['business', 'string', 'max' => 500],
            [['number_auth', 'business', 'email'], 'required', 'on' => 'company']
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Họ và tên',
            'email' => 'Email',
            'phone' => 'Số điện thoại',
            'password' => 'Mật khẩu',
            'address' => 'Địa chỉ',
            'province_id' => 'Tỉnh/thành phố',
            'district_id' => 'Quận/huyện',
            'facebook' => 'Tên facebook',
            'user_before' => 'ID giới thiệu',
            'number_auth' => 'Mã số thuế',
            'business' => 'Ngành nghề kinh doanh',
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signupApi()
    {
        if ($this->type == User::TYPE_DOANH_NGHIEP) {
            $this->scenario = 'company';
        }
        if (!$this->validate()) {
            return [
                'success' => false,
                'errors' => $this->getErrors()
            ];
        }
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $user = new User();
            $user->username = $this->username;
            $user->phone = $this->phone;
            $user->email = $this->email;
            $user->type = $this->type;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            if ($user->save()) {
                if ($this->type == User::TYPE_DOANH_NGHIEP) {
                    $shop = new Shop();
                    $shop->name = $this->username;
                    $shop->user_id = $user->id;
                    $shop->phone = $this->phone;
                    $shop->email = $this->email;
                    $shop->number_auth = $this->number_auth;
                    $shop->business = $this->business;
                    if (!$shop->save()) {
                        $user->delete();
                        return [
                            'success' => false,
                            'errors' => $shop->getErrors()
                        ];
                    }
                }
            } else {
                return [
                    'success' => false,
                    'errors' => $user->getErrors()
                ];
            }
            $transaction->commit();
            return [
                'success' => true,
                'data' => $user
            ];
        } catch (Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->phone = $this->phone;
        $user->email = $this->email;
        $user->cmt = $this->cmt;
        $user->address = $this->address;
        $user->facebook = $this->facebook;
        $user->link_facebook = $this->link_facebook;
        $user->province_id = $this->province_id;
        $user->type_social = $this->type_social;
        $user->id_social = $this->id_social;
        $user->is_notification = $this->is_notification;
        $user->user_before = $this->user_before;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        return $user->save() ? $user : null;
    }

}
