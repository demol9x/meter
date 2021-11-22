<?php

namespace common\components;
use Yii;
use yii\helpers\Url;

class ClaUrl extends \yii\helpers\Url
{

    static function to($url = '', $scheme = false)
    {
        if (\Yii::$app->id != 'app-frontend') {
            if (is_array($url)) {
                $options[] = '/site/router-url';
                foreach ($url as $key => $value) {
                    $options[$key ? $key : 'url'] = $value;
                }
            } else {
                $options = ['/site/router-url', 'url' => $url];
            }
            return \yii\helpers\Url::to(\Yii::$app->urlManagerFrontEnd->createUrl($options));
        }
        return parent::to($url, $scheme);
    }

    static function setLink($value,$field_name){
        if($field_name){
            $url = strtok($_SERVER["REQUEST_URI"], '?');
        }else{
            return Yii::$app->request->url;
        }
        $params = Yii::$app->request->get();
        if(isset($params[$field_name]) && $params[$field_name]){
            if($params[$field_name] == $value){
                unset($params[$field_name]);
            }else{
                $params[$field_name] = $value;
            }
        }else{
            $params = array_merge($params, array($field_name=>$value));
        }
        $url .= '?'.http_build_query($params);
        return $url;
    }

    static function getValueFieldToUrl($field_name){
        $params = Yii::$app->request->get();
        if(isset($params[$field_name]) && $params[$field_name]){
            return $params[$field_name];
        }else{
            return '';
        }
    }
}
