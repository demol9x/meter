<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class SocialLoginForm extends Model {

    public $email; // user email
    public $name; // user name
    public $type; // social type (fb, google...)
    public $id; // social user id

    /**
     * @inheritdoc
     */

    public function rules() {
        return [
            // email and password are both required
            [['email', 'name', 'type', 'id'], 'required'],
        ];
    }

}
