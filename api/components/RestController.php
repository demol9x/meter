<?php

namespace api\components;

use Yii;
use yii\rest\Controller;
use api\components\AuthToken;

/**
 * Description of RestController
 *
 * @author minhbn
 */
class RestController extends Controller {

    //
    public $success = null;
    public $message = '';

    //
    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => AuthToken::className(),
        ];
        return$behaviors;
    }

    public function responseData($data = array()) {
        $data = is_array($data) ? $data : array();
        if (!isset($data['success'])) {
            $data['success'] = $this->getSuccess();
        }
        if (!isset($data['message'])) {
            $data['message'] = $this->getMessage();
        }
        return $data;
    }

    public function jsonResponse($data = array()) {
        $data = is_array($data) ? $data : array();
        if (!isset($data['success'])) {
            $data['success'] = $this->getSuccess();
        }
        if (!isset($data['message'])) {
            $data['message'] = $this->getMessage();
        }
        return json_encode($data);
    }

    function getSuccess() {
        return $this->success;
    }

    function getMessage() {
        return $this->message;
    }

    function setSuccess($success) {
        $this->success = $success;
    }

    function setMessage($message) {
        $this->message = $message;
    }

}
