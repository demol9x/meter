<?php

namespace frontend\mobile\modules\management\controllers;

use Yii;
use common\models\product\Product;
use common\models\promotion\Promotions;
use common\models\promotion\ProductToPromotions;
use yii\helpers\Url;
use yii\web\Response;
use frontend\components\FilterHelper;
/**
 * ProductController implements the CRUD actions for Product model.
 */
class PromotionController extends \yii\web\Controller
{
    protected function findModel($id) {
        if (($model = Promotions::findOne($id)) !== null) {
            return $model;
        } else {
            die();
        }
    }

    /**
     * delete a product in group
     * @param type $id
     */
    public function actionDeleteProduct($id) {
        $productpromotion = ProductToPromotions::findOne($id);
        return $productpromotion->delete();
    }

    public function actionGetProductSpace($promotion_id = '',$hour = null,$page = 1, $keyword='') {
        $promotion_id = $promotion_id == '' ? \common\models\promotion\Promotions::getPromotionNow()->id : '';
        \Yii::$app->session->open();
        if($hour != null) {
            $_SESSION['hour_promotion'] = $hour;
        } else {
            $hour = isset($_SESSION['hour_promotion']) ? $_SESSION['hour_promotion'] : '';
        }
        $limit = 10;
        $product = Product::getProductPromotionShop([
                                'page' => $page, 
                                'limit' => $limit,
                                'keyword' => $keyword,
                                'promotion_id' => $promotion_id,
                                'hour' => $hour,
                            ]);
        $count = Product::getProductPromotionShop([
                                'keyword' => $keyword,
                                'page' => $page,
                                'promotion_id' => $promotion_id,
                                'hour' => $hour,
                                'count' => 1
                            ]);
        $count_page = ceil($count/$limit);
        return $this->renderAjax('partial/productaddspace', [
                    'product_add' => $product,
                    'count_page' => $count_page,
                    'page' => $page,
        ]);
    }

    public function actionAddProductSpace($id = null, $hour= 0,$page = 1, $keyword='') {
        // $this->layout = 'empty';
        $limit = 10;
        $model = Promotions::getPromotionNow();
        $id = $model->id;
        if(!$model) {
            return "Chương trình khuyến mãi đã kết thúc!!!";
        }
        \Yii::$app->session->open();
        // $hour = $_SESSION['hour_promotion'] = $model->getHourNow();
        $product = Product::getProductPromotionShop([
                                'page' => $page, 
                                'limit' => $limit,
                                'keyword' => $keyword,
                                'promotion_id' => $id,
                                // 'hour' => $hour,
                            ]);
        $count = Product::getProductPromotionShop([
                                'keyword' => $keyword,
                                'page' => $page,
                                'promotion_id' => $id,
                                // 'hour' => $hour,
                                'count' => 1
                            ]);
        $count_page = ceil($count/$limit);
        $hour = $hour ? $hour : $model->getHourNow();
        $products = ProductToPromotions::getProductByAttr([
                    'attr' => [
                        't.id' => $id,
                        'p.shop_id' => Yii::$app->user->id,
                        // 'hour_space_start' => $hour,
                    ],
                    'order' => 'id desc',
                    'limit' => '100000'
                ]);
        return $this->render('addproductspace', [
                    'id' => $id,
                    'product_add' => $product,
                    'count_page' => $count_page,
                    'page' => $page,
                    'products' => $products,
                    'model' => $model,
                    'hour' => $hour
        ]);
    }

    public function actionLoadProduct($id, $hour, $day) {
        \Yii::$app->session->open();
        $_SESSION['hour_promotion'] =  $hour;
        $products = ProductToPromotions::getProductByAttr([
                    'attr' => [
                        't.id' => $id,
                        'p.shop_id' => Yii::$app->user->id,
                        // 'hour_space_start' => $hour,
                    ],
                    'order' => 'id desc',
                    'limit' => '100000'
                ]);
        return $this->renderAjax('partial/loadproduct', [
            'products' => $products,
            'promotion' => Promotions::findOne($id)
        ]);
    }

    public function actionSaveProductSpace($promotion_id, $val,$price, $quantity, $hour, $day){
        if($val) {
            $list = explode(',', $val);
            $prices = explode(' ', $price);
            $quantitys = explode(' ', $quantity);
            $hours = explode(' ', $hour);
            for ($i=0; $i < count($list); $i++) { 
                $time_start =ProductToPromotions::getTimeSpaceStart($hour, $day);
                if($list[$i]) {
                    $promotion = ($promotion = ProductToPromotions::find()->where(['product_id' => $list[$i], 'promotion_id' => $promotion_id])->one()) ? $promotion : new ProductToPromotions();
                    $promotion->product_id = $list[$i];
                    $promotion->promotion_id = $promotion_id;
                    $promotion->created_time = $promotion->created_time ? $promotion->created_time : time();
                    $promotion->time_space_start = $time_start;
                    $promotion->hour_space_start = $hours[$i];
                    $promotion->price = $prices[$i];
                    $promotion->quantity = $quantitys[$i];
                    if(!$promotion->save()) {
                        print_r($promotion->errors) ;
                        return Yii::t('app', 'error_when_save');
                    }
                }
            }
            
        }
        $this->layout = 'empty';
        $products = ProductToPromotions::getByPromotionId($promotion_id);
        return '<script>alert("Lưu thành công.");</script>';
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Promotions the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Promotions::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Promotions $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'promotions-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
}
