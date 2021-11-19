<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 * @property int $phone
 * @property string $email
 * @property string $password
 */
class LoginForm extends Model
{
    public $email;
    public $phone;
    public $password;
    public $rememberMe = true;
    private $_user;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // email and password are both required
            [['phone', 'password'], 'required'],
            ['phone','integer'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'rememberMe' => 'Nhớ đăng nhập',
            'phone'=>'Số điện thoại',
            'password'=>'Mật khẩu'
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Số điện thoại hoặc mật khẩu không chính xác');
            }
        }
    }

    /**
     * Logs in a user using the provided email and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            if (Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0)) {
//                 $connection = Yii::$app->db;
//                 $connection->createCommand()->update('user', 'phone ="'.$this->phone.'"')->execute();
                return true;
            }
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[email]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            if (($this->_user = User::findByPhone($this->phone))) {
                $this->_user =  User::findByPhone($this->phone);
            }
            else
            { $this->_user =  User::findByEmail($this->email);}
        }
        // print_r($this->_user);
        return $this->_user;
    }
}
