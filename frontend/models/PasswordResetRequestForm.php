<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use frontend\models\User;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model {

    public $email;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\frontend\models\User',
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => 'Email chưa được đăng ký.'
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool whether the email was send
     */
    public function sendEmail() {
        /* @var $user User */
        $user = User::findOne([
                    'status' => User::STATUS_ACTIVE,
                    'email' => $this->email,
        ]);

        if (!$user) {
            return false;
        }

        if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            $user->cmt = '123456789';
            if (!$user->save()) {
                return false;
            }
        }

        return Yii::$app ->mailer
                        ->compose(
                                ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'], ['user' => $user]
                        )
                        ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
                        ->setTo($this->email)
                        ->setSubject('Thiết lập lại mật khẩu cho tài khoản ' . Yii::$app->name)
                        ->send();
    }

}
