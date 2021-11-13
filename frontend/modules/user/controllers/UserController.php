<?php

namespace frontend\modules\user\controllers;

use common\models\Province;
use Yii;
use frontend\controllers\CController;
use common\models\product\ProductCategory;
use common\models\shop\Shop;
use frontend\models\User;
use common\models\product\Product;
use common\models\product\ProductWish;
use common\components\ClaLid;
use common\components\ClaCategory;
use yii\helpers\Url;
use yii\web\Response;
use common\components\ClaHost;
use common\models\product\CertificateProduct;
use common\models\product\CertificateProductItem;
use common\models\affiliate\AffiliateLink;
use common\models\affiliate\AffiliateClick;

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
