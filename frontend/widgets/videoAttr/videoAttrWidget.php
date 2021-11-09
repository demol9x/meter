<?php

namespace frontend\widgets\videoAttr;

use Yii;
use yii\base\Widget;

class VideoAttrWidget extends \frontend\components\CustomWidget {

    public $view = 'view';
    public $attr = '';
    public $limit = 16;
    public $order = "id DESC";
    public $title = "";
    public $_video = "";
    protected $videos = [];

    public function init() {
        $this->videos = \common\models\media\Video::getVideoByAttr([
                    'attr' => $this->attr,
                    'order' => $this->order,
                    'limit' => $this->limit,
                    '_video' => $this->_video
        ]);
        //
        parent::init();
    }

    public function run() {
        //
        return $this->render($this->view, [
                    'title' => $this->title,
                    'videos' => $this->videos
        ]);
    }

}

?>