<?php

namespace frontend\widgets\user;

use common\models\general\UserWish;
use yii;
use yii\base\Widget;
use common\models\user\Tho;

class UserWidget extends \frontend\components\CustomWidget {

    public $view = 'view';
    public $limit = 0;
    public $data = [];
    public $us_wish=[];

    public function init() {

        $this->data = \frontend\models\User::getT(array_merge(Yii::$app->request->get(),[
            'limit' => $this->limit,
        ]));
        $this->us_wish = UserWish::find()->where(['user_id_from' => Yii::$app->user->id,'type' => \frontend\models\User::TYPE_THO])->asArray()->all();
        $this->us_wish = array_column($this->us_wish, 'user_id', 'id');
        parent::init();
    }

    public function run() {

        return $this->render($this->view, [
            'us_wish'=>$this->us_wish,
            'data'=>$this->data['data'],
        ]);
    }

}

?>