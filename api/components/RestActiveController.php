<?php

namespace api\components;
use Yii;
use yii\rest\ActiveController;

/**
 * Description of RestController
 *
 * @author Admin
 */
class RestActiveController extends ActiveController {

    //
    public $success = null;
    public $message = '';

    //
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
