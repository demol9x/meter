<?php

namespace frontend\modules\device\controllers;


use Yii;
use frontend\controllers\CController;


class DeviceController extends CController
{
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
        return $this->render('index', [
        ]);
    }



    public function actionDetail()
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
