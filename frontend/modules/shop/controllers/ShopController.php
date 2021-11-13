<?php

namespace frontend\modules\shop\controllers;

use Yii;
use yii\web\Controller;
use common\models\product\ProductCategory;
use common\models\shop\Shop;
use common\models\shop\ShopImages;
use common\models\product\Product;
use common\models\product\ProductWish;
use common\models\product\ProductAttributeSet;
use common\components\ClaLid;
use common\components\ClaCategory;
use common\components\ClaArray;
use frontend\components\FilterHelper;
use yii\helpers\Url;
use yii\web\Response;
use common\components\ClaHost;
use frontend\models\User;

;

/**
 * Shop controller for the `product` module
 */
class ShopController extends Controller {

    public $layout = 'main';
    /**
     * Renders the index view for the module
     * @return string
     */
    public function beforeAction($event) {
        Yii::$app->session->open();
        return parent::beforeAction($event);
    }
    public function  actionIndex(){
        $_SESSION['url_back_login'] = 'http://'.\common\components\ClaSite::getServerName()."$_SERVER[REQUEST_URI]";

        return $this->render('index',[]);
    }
    public function actionDetail($id) {
        //
        $_SESSION['url_back_login'] = 'http://'.\common\components\ClaSite::getServerName()."$_SERVER[REQUEST_URI]";
        $model = $this->findModel($id);
        if(!$model) {
            return $this->goHome();
        }
        $user  = User::findOne($id);
        $pagesize = 20;

        $products = Product::getProduct(array_merge($_GET, [
                    'shop_id' => $id,
                    'limit' => $pagesize,
        ]));
        
        $totalitem = Product::getProduct(array_merge($_GET, [
                    'shop_id' => $id,
                    'count' => 1,
                    'limit' => $pagesize,
        ]));
        $shopadd = \common\models\shop\ShopAddress::find()->where(['shop_id'=>$model->id, 'isdefault' => 0])->all();
        //
        $img_auth = ShopImages::find()->where(['shop_id' => $model->id, 'type' => 2])->all();
        $img_shop = ShopImages::find()->where(['shop_id' => $model->id, 'type' => 1])->all();
        return $this->render('detail', [
            'model' => $model,
            'user' => $user,
            'totalitem' => $totalitem,
            'limit' => $pagesize,
            'products' => $products,
            'shopadd' => $shopadd,
            'img_auth' => $img_auth,
            'img_shop' => $img_shop,
        ]);
    }

    /**
     * Finds the Shop model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Shop the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Shop::findOne($id)) !== null) {
            $name_shop_ck = 'view_shop_'.$model->id;
            if (!isset($_COOKIE[$name_shop_ck])) {
                $model->viewed++;
                $connection = Yii::$app->db;
                $connection->createCommand()->update('shop', ['viewed' => $model->viewed], 'id =' . $model->id)->execute();
                setcookie($name_shop_ck, "1", time() + (60), "/");
            }
            return $model;
        } else {
            return 0;
        }
    }



}
