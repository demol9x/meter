<?php

namespace frontend\widgets\shareSocial;

use yii\base\Widget;

class ShareSocialWidget extends \frontend\components\CustomWidget {

    public $view = 'view';
    public $url = '';

    public function init() {
        parent::init();
    }

    public function run() {
        return $this->render($this->view, array(
        	'url' => $this->url
        ));
    }

}
