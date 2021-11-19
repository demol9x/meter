<?php

namespace frontend\modules\package\controllers;

use Yii;
use frontend\controllers\CController;
use common\components\ClaLid;
use yii\helpers\Url;
use  common\models\package\Package;
use common\models\shop\Shop;

/**
 * News controller for the `news` module
 */
class PackageController extends CController
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = 'main';

        Yii::$app->params['breadcrumbs'] = [
            'Trang chủ' => Url::home(),
            'Gói thầu' => Url::to(['/package/package/index']),
        ];
        $pagesize = 24;
        $province_id = Yii::$app->request->get('p', 0);
        $keyword = Yii::$app->request->get('k', '');
        $page = Yii::$app->request->get('page', 1);


        $data = Package::getPackage(array_merge($_GET ,[
            'keyword'=>$keyword,
            'province_id'=>$province_id,
            'limit' => $pagesize,
            'page' => $page,
            ]));

        $totalitem =Package::getPackage(array_merge($_GET,[
            'keyword'=>$keyword,
            'count'=>1,
            'limit' => $pagesize,
            'page' => $page,
            'province_id'=>$province_id,
        ]));

        return $this->render('index', [
            'data' => $data,
            'totalitem' => $totalitem,
            'limit' => $pagesize,
        ]);
    }
    public  function  actionView(){
        $this->layout = 'main';

        Yii::$app->params['breadcrumbs'] = [
            'Trang chủ' => Url::home(),
            'Gói thầu' => Url::to(['/package/package/index']),
        ];
        $pagesize = 24;
        $province_id = Yii::$app->request->get('p', 0);
        $keyword = Yii::$app->request->get('k', '');
        $page = Yii::$app->request->get('page', 1);


        $data = Package::getPackage(array_merge($_GET ,[
            'keyword'=>$keyword,
            'province_id'=>$province_id,
            'limit' => $pagesize,
            'page' => $page,
        ]));

        $totalitem =Package::getPackage(array_merge($_GET,[
            'keyword'=>$keyword,
            'count'=>1,
            'limit' => $pagesize,
            'page' => $page,
            'province_id'=>$province_id,
        ]));

        return $this->render('view', [
            'data' => $data,
            'totalitem' => $totalitem,
            'limit' => $pagesize,
        ]);
    }
    public function actionDetail($id, $t = 0)
    {
        $_SESSION['url_back_login'] = 'http://' . \common\components\ClaSite::getServerName() . "$_SERVER[REQUEST_URI]";
        $this->layout = 'detail';
        $model = $this->addView($id);
        if (!$model) {
            $this->layout = '@frontend/views/layouts/error_layout';
            return $this->render('error');
        }
        $shop= Shop::findOne(['user_id'=>$model->shop_id]);
        if (!$shop) {
            $this->layout = '@frontend/views/layouts/error_layout';
            return $this->render('error');
        }
        Yii::$app->params['breadcrumbs'] = [
            Yii::t('app', 'home') => Url::home(),
            $model->name => Url::to(['/package/package/detail','alias' => $model->alias, 'id' => $model->id])
        ];
        return $this->render('detail', [
            't' => $t,
            'model' => $model,
            'shop'=>$shop,
        ]);
    }

    /**
     * Finds the News model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return News the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */

    protected function addView($id)
    {
        if (($model = Package::findOne($id)) !== null) {
            $key = 'package_viewed_' . $model->id;
            if (!isset($_COOKIE[$key])) {
                $model->viewed++;
                $connection = Yii::$app->db;
                $connection->createCommand()->update('package', ['viewed' => $model->viewed], 'id =' . $model->id)->execute();
                setcookie($key, "1", time() + (60), "/");
            }
            return $model;
        } else {
            return 0;
        }
    }
}
