<?php

namespace frontend\mobile\modules\product\controllers;

use common\components\ClaQrCode;
use Yii;
use yii\web\Controller;
use common\models\product\ProductCategory;
use common\models\shop\Shop;
use frontend\models\User;
use common\models\product\Product;
use common\models\promotion\Promotions;
use common\components\ClaLid;
use common\components\ClaCategory;
use common\components\ClaArray;
use frontend\components\FilterHelper;
use yii\helpers\Url;
use yii\web\Response;
use common\components\ClaHost;
use common\models\product\CertificateProduct;
use common\models\product\CertificateProductItem;
use Da\QrCode\QrCode;

/**
 * Product controller for the `product` module
 */
class ProductPromotionController extends Controller
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

    public function actionDetail($id, $hour = null)
    {
        $pagesize = isset($_GET['per-page']) ? $_GET['per-page'] : ClaLid::DEFAULT_LIMIT;
        $page = Yii::$app->request->get('page', 1);
        $promotion = Promotions::findOne($id);
        $hour = $hour != null ? $hour : $promotion->getHourNow();
        Yii::$app->view->title = $promotion->name;
        $productdes = $promotion->sortdesc;
        // add meta description
        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => $productdes
        ]);
        // add meta keywords
        Yii::$app->view->registerMetaTag([
            'name' => 'keywords',
            'content' => $productdes
        ]);
        //
        Yii::$app->params['breadcrumbs'] = [
            Yii::t('app', 'home') => Url::home(),
        ];
        Yii::$app->params['breadcrumbs'][$promotion->name] = Url::to(['/product/product-promotion/detail', 'id' => $promotion->id, 'alias' => $promotion->alias]);
        //
        $promotion_id =  $promotion->id;
        $data = \common\models\promotion\ProductToPromotions::getProductByAttr([
                    'attr' => [
                        't.id' => $promotion_id,
                        'hour_space_start' => $hour,
                    ],
                    'order' => 'u.last_request_time desc, pt.id desc',
                    'limit' => '40'
                ]);
       
        $totalitem = 50;
        return $this->render('detail', [
            'promotion' => $promotion,
            'data' => $data,
            'totalitem' => $totalitem,
            'limit' => $pagesize,
        ]);
    }

    public function actionLangdingpage($id, $hour = null)
    {
        $pagesize = isset($_GET['per-page']) ? $_GET['per-page'] : ClaLid::DEFAULT_LIMIT;
        $page = Yii::$app->request->get('page', 1);
        $promotion = Promotions::findOne($id);
        $hour = $hour != null ? $hour : $promotion->getHourNow();
        Yii::$app->view->title = $promotion->name;
        $productdes = $promotion->sortdesc;
        // add meta description
        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => $productdes
        ]);
        // add meta keywords
        Yii::$app->view->registerMetaTag([
            'name' => 'keywords',
            'content' => $productdes
        ]);
        //
        Yii::$app->params['breadcrumbs'] = [
            Yii::t('app', 'home') => Url::home(),
        ];
        Yii::$app->params['breadcrumbs'][$promotion->name] = Url::to(['/product/product-promotion/detail', 'id' => $promotion->id, 'alias' => $promotion->alias]);
        //
        $promotion_id =  $promotion->id;
        $data = \common\models\promotion\ProductToPromotions::getProductByAttr([
                    'attr' => [
                        't.id' => $promotion_id,
                        'hour_space_start' => $hour,
                    ],
                    'order' => 'u.last_request_time desc, pt.id desc',
                    'limit' => '1000'
                ]);
       
        $totalitem = 50;
        return $this->render('langdingpage', [
            'promotion' => $promotion,
            'data' => $data,
            'totalitem' => $totalitem,
            'limit' => $pagesize,
        ]);
    }
}
