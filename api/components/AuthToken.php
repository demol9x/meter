<?php

/**
 * Description of AuthToken
 *
 * @author minhbn
 */

namespace api\components;

use yii\filters\auth\AuthMethod;

class AuthToken extends AuthMethod {

    public $tokenParam = 'token';
    protected $accessToken = '';

    //
    public function authenticate($user, $request, $response) {
        $headers = $request->getHeaders();
        $accessToken = $request->get($this->tokenParam, '');
        if (isset($headers[$this->tokenParam])) {
            $accessToken = $headers[$this->tokenParam];
        }
        if (!$accessToken) {
            $accessToken = $request->post($this->tokenParam, '');
        }
        $this->setAccessToken($accessToken);
        if (!$this->checkAccess()) {
            $this->handleFailure($response);
            return false;
        }
        return true;
    }

    /**
     * 
     */
    function checkAccess() {
        $accessToken = $this->getAccessToken();
        if (!in_array($accessToken, array(
                    'meter_nanoweb_2021',
                ))) {
            return false;
        }
        //
        return true;
    }

    //--------------------------------------------------------------------------------------------------------
    function getTokenParam() {
        return $this->tokenParam;
    }

    function getAccessToken() {
        return $this->accessToken;
    }

    function setTokenParam($tokenParam) {
        $this->tokenParam = $tokenParam;
    }

    function setAccessToken($accessToken) {
        $this->accessToken = $accessToken;
    }

}

function getallheaders() {
    $headers = [];
    foreach ($_SERVER as $name => $value) {
        if (substr($name, 0, 5) == 'HTTP_') {
            $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
        }
    }
    return $headers;
}
