<?php

namespace frontend\modules\user\controllers;

use backend\modules\auth\models\searchs\User;
use common\components\ClaGenerate;
use common\components\ClaUrl;
use common\models\general\ChucDanh;
use common\models\general\UserWish;
use common\models\Province;
use Yii;
use frontend\controllers\CController;
use common\models\user\Tho;
use common\models\product\ProductWish;

class UserController extends CController
{

    public $view_for_action = '';
    public $asset = 'AppAsset';

    /**
     * Renders the index view for the module
     * @return string
     */
    public function beforeAction($event)
    {
        Yii::$app->session->open();
        return parent::beforeAction($event);
    }

    public function actionIndex()
    {
        $this->layout = 'main';
        $page = Yii::$app->request->get('page', 1);
        $users = \frontend\models\User::getT(array_merge(Yii::$app->request->get(),[
            'limit' => 4,
            'page' => $page,
        ]));

        $us_wish = UserWish::find()->where(['user_id_from' => Yii::$app->user->id,'type' => \frontend\models\User::TYPE_THO])->asArray()->all();
        $us_wish = array_column($us_wish, 'user_id', 'id');
        $provinces = Province::find()->asArray()->all();
        $jobs = ChucDanh::getJob();
        $kns = Tho::numberKn();
        return $this->render('index', [
            'users' => $users['data'],
            'us_wish' => $us_wish,
            'provinces' => array_column($provinces,'name','id'),
            'jobs' => $jobs,
            'kns' => $kns,
            'limit' => 4,
            'totalitem' => $users['total'],
        ]);
    }


    public function actionDetail($id, $t = 0)
    {

        return $this->render('detail', [

        ]);
    }

    protected function addView($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            $key = 'product_viewed_' . $model->id;
            if (!isset($_COOKIE[$key])) {
                $model->viewed++;
                $connection = Yii::$app->db;
                $connection->createCommand()->update('product', ['viewed' => $model->viewed], 'id =' . $model->id)->execute();
                setcookie($key, "1", time() + (60), "/");
            }
            return $model;
        } else {
            return 0;
        }
    }
}
