<?php

namespace frontend\models;

use yii\base\Model;
use frontend\models\User;

/**
 * Signup form
 */
class SignupForm extends Model {

    public $username;
    public $email;
    public $phone;
    public $password;
    public $terms_and_condition;
    public $tax_number;
    public $user_before;
    public $is_notification;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['username', 'trim'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['phone', 'trim'],
            ['phone', 'required'],
            ['username', 'required'],
            ['phone', 'integer'],
            ['user_before', 'integer'],
            ['phone', 'string' ,'min' => 10, 'max' => 11],
            ['email', 'email'],
            ['email', 'required'],
            ['email', 'unique', 'targetClass' => '\frontend\models\User', 'message' => 'Email đã tồn tại.'],
            ['email', 'string', 'max' => 255],
            ['phone', 'string', 'max' => 255],
            ['phone', 'unique', 'targetClass' => '\frontend\models\User', 'message' => 'Số điện thoại đã tồn tại.'],
            ['password', 'required'],
            ['password', 'string', 'min' => 6, 'max' => 100],
            ['terms_and_condition', 'integer'],
            ['terms_and_condition', 'required'],
            ['tax_number', 'string', 'max' => 255],
            [['tax_number','email'], 'required', 'on' => 'business']
        ];
    }

    public function attributeLabels() {
        return [
            'username' => 'Họ và tên',
            'email' => 'Email',
            'phone' => 'Số điện thoại',
            'password' => 'Mật khẩu',
            'address' => 'Địa chỉ',
            'province_id' => 'Tỉnh/thành phố',
            'district_id' => 'Quận/huyện',
            'facebook' => 'Tên facebook',
            'user_before' => 'ID giới thiệu'
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup() {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->phone = $this->phone;
        $user->email = $this->email;
        $user->address = $this->address;
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
