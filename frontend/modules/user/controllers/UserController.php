<?php

namespace frontend\modules\user\controllers;

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

        $this->layout='main';
        $data= Tho::find()->all();
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        die();
        return $this->render('index', [

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
