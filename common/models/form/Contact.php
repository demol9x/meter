<?php

namespace common\models\form;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */

class Contact extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'contact';
    }


    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            // name, email, address and body are required
            [['name', 'email', 'phone', 'address', 'body'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],

            [['phone', 'address', 'body', 'created_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'name' => 'Họ và tên',
            'email' => 'Email',
            'phone' => 'Điện thoại',
            'address' => 'Địa chỉ',
            'body' => 'Nhập nội dung',
            'viewed' => 'Xử lý',
            'created_at' => 'Ngày tạo',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param string $email the target email address
     * @return bool whether the email was sent
     */
    public function sendEmail($email) {
        return Yii::$app->mailer->compose()
                        ->setTo($email)
                        ->setFrom([$this->email => $this->name])
                        ->setSubject('Liên hệ')
                        ->setTextBody($this->body)
                        ->send();
    }

}
