<?php
namespace frontend\widgets\facebookcomment;

use Yii;
use yii\base\Widget;
class FacebookcommentWidget extends \frontend\components\CustomWidget {

    public $data = array();
    public $link = '';
    public $view = 'view';
    protected $name = 'facebookcomment';

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        // Load config
        if (!$this->link)
            $this->link = Yii::$app->request->hostInfo . Yii::$app->request->url;
        //
        if (!defined("SOCIAL_FACEBOOK")) {
            define("SOCIAL_FACEBOOK", true);
                echo '<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/vi_VI/sdk.js#xfbml=1&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, \'script\', \'facebook-jssdk\'));</script>';
        }

        //
        if (!defined("SOCIAL_GOOGLEPLUS")) {
            define('SOCIAL_GOOGLEPLUS', true);
            echo '<script src="https://apis.google.com/js/platform.js" async defer></script>';
        }
        parent::init();
    }

    public function run() {
        return $this->render($this->view, array(
            'data' => $this->data,
            'link' => $this->link,
        ));
    }

}
