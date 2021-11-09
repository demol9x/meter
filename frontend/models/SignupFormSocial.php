<?php

namespace frontend\models;

use yii\base\Model;
use frontend\models\User;
use frontend\models\UserSocial;

/**
 * Signup form
 */
class SignupFormSocial extends Model {

    public $username;
    public $email;
    public $phone;
    public $password;
    public $type_social;
    public $id_social;
    public $address;
    public $province_id;
    public $district_id;
    public $facebook;
    public $link_facebook;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['username', 'trim'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['phone', 'trim'],
            ['phone', 'integer'],
            ['phone', 'string' ,'min' => 10, 'max' => 11],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['phone', 'string', 'max' => 255],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            [['facebook', 'link_facebook', 'address'], 'string', 'max' => 255],
            ['province_id', 'integer']
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
            'link_facebook' => 'Link facebook'
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

        $user = new UserSocial();
        $user->username = $this->username;
        $user->phone = $this->phone;
        $user->email = $this->email;
        $user->address = $this->address;
        $user->facebook = $this->facebook;
        $user->link_facebook = $this->link_facebook;
        $user->province_id = $this->province_id;
        $user->type_social = $this->type_social;
        $user->id_social = $this->id_social;
        if($this->password != '111111111111111111111111111111111111111111111111111111111111') $user->setPassword($this->password);
        $user->generateAuthKey();
        return $user->save() ? $user : null;
    }

}
