<?php

namespace frontend\widgets\notifications;

use common\models\notifications\Notifications;
use yii\base\Widget;

class NotificationsWidget extends \frontend\components\CustomWidget
{

    public $view = 'view';
    public $limit = 4;
    public $data = [];

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        //
        $this->data = Notifications::getAllNotifications(['limit' => 10]);
        $countUnread = 0;
        if (count($this->data)) {
            foreach ($this->data as $item) {
                if ($item['unread']) {
                    $countUnread++;
                }
            }
        }
        //
        return $this->render($this->view, [
            'data' => $this->data,
            'countUnread' => $countUnread
        ]);
    }
}
