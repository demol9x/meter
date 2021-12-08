<?php

namespace api\modules\blockcheck\controllers;

use Yii;

class BlockcheckController extends \yii\web\Controller
{
    const KEY_API_TOKEN_LIST = 'KEY_API_TOKEN_LIST';

    public $token = 'key_nanoweb_vzoneland_2021_real';
    public $method = 'GET';
    protected $_check_time_load_one = 0;
    protected $_token;

    const KEY_TOKEN = 'vzone123@abc321';

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        $this->_token = Yii::$app->request->getHeaders()->get('token');
        if (!$this->checkApi()) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            Yii::$app->response->data = [
                'code' => 0,
                'data' => [],
                'message' => '',
                'error' => 'Api không hợp lệ.',
            ];
            Yii::$app->end();
        }
        return parent::beforeAction($action);
    }

    function getResponse()
    {
        return [
            'code' => 0,
            'data' => [],
            'message' => '',
            'error' => '',
        ];
    }

    function responseData($data)
    {
        if ($this->_check_time_load_one > 0 && $data['code'] == 1) {
            $name = $this->getNameCache();
            Yii::$app->cache->set($name, time(), $this->_check_time_load_one + 2);
        }
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $data;
        // return json_encode($data);
    }

    function checkApi()
    {
        if ($this->_token) {
            $cache = Yii::$app->cache;
            $lists = $cache->get(self::KEY_API_TOKEN_LIST);
            if ($lists === false) {
                $lists = (new \yii\db\Query())->select('token')->from('tokens')->all();
                $lists = $lists ? array_column($lists, 'token') : [];
                $cache->set(self::KEY_API_TOKEN_LIST, $lists);
            }
            $lists += ['' => self::KEY_TOKEN];
            if (in_array($this->_token, $lists)) {
                return true;
            }
        }
        return false;
    }

    function getDataPost()
    {
        // return \Yii::$app->getRequest()->getBodyParams();
        $data = file_get_contents("php://input");
        if ($data) {
            return json_decode($data, true);
        } else {
            return $_POST;
        }
        // return json_decode($data, true);
    }

    function setTimeLoadOnce($time)
    {
        // return true;
        $this->_check_time_load_one = $time;
        if ($this->checkLoadOne()) {
            return true;
        } else {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            Yii::$app->response->data = [
                'code' => 0,
                'data' => [],
                'message' => '',
                'error' => 'Thao tác quá nhanh. Vui lòng thao tác lại sau giây lát.',
            ];
            Yii::$app->end();
        }
    }

    function checkLoadOne()
    {
        $time = Yii::$app->cache->get($this->getNameCache());
        $time = $time ? $time : 0;
        if (time() - $time >= $this->_check_time_load_one) {
            return true;
        }
        return false;
    }

    function getNameCache()
    {
        return $this->_token . '_' . Yii::$app->controller->module->id . '_' . Yii::$app->controller->id . '_' . Yii::$app->controller->action->id;
    }
}
