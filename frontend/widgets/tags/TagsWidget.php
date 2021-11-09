<?php
namespace frontend\widgets\tags;

use Yii;
use yii\base\Widget;
class TagsWidget extends \frontend\components\CustomWidget {

    public $data = array();
    public $link = '';
    public $type = 0;
    public $view = 'view';

    public function init() {

        if (!$this->link)
            $this->link = \yii\helpers\Url::to(['/site/search']);
        //
        parent::init();
    }

    public function run() {
        return $this->render($this->view, array(
            'data' => $this->data,
            'link' => $this->link,
            'type' => $this->type,
        ));
    }

}
