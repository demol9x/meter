<?php
/**
 * Created by trungduc.vnu@gmail.com.
 */


namespace api\modules\v1\controllers;

use common\models\product\ProductTopsearch;
use Yii;
use api\components\RestController;
use common\models\product\ProductCategory;

class ProductController extends RestController
{
    public function actionGetCategory()
    {
        $request = Yii::$app->getRequest()->get();
        $type = (isset($request['type']) && $request['type']) ? $request['type'] : '';
        if($type == 'hot'){
            $data = ProductCategory::find()->where(['isnew' => 1, 'status' => 1])->orderBy('order, id desc')->all();
        }else{
            $data = ProductCategory::find()->where(['show_in_home' => 1])->orderBy('order ASC')->all();
        }
        return $this->responseData([
            'success' => true,
            'data' => $data
        ]);
    }



    public function actionGetProductByCategory()
    {
        $request = Yii::$app->getRequest()->get();
        $category_id = (isset($request['category_id']) && $request['category_id']) ? $request['category_id'] : -1;
        $limit = (isset($request['limit']) && $request['limit']) ? $request['limit'] : 18;
        $page = (isset($request['page']) && $request['page']) ? $request['page'] : 1;
        $products = \common\models\product\Product::getProduct([
            'category_id' => $category_id,
            'limit' => $limit,
            'order' => 'ishot DESC, id DESC ',
            'page' => $page,
        ]);
        return $this->responseData([
            'success' => true,
            'data' => $products
        ]);
    }

    public function actionCategoryShowHome()
    {
        $categories = ProductCategory::find()->where(['show_in_home_2' => 1])->orderBy('order ASC')->asArray()->all();
        $data = [];
        if($categories){
            foreach ($categories as $category){
                $dt['category'] = $category;
                $products = \common\models\product\Product::getProduct([
                    'category_id' => $category['id'],
                    'limit' => 4,
                    'page' => 1,
                    'order' => 'ishot DESC, id DESC'
                ]);
                $dt['products'] = $products;
                $data[] = $dt;
            }
        }
        return $this->responseData([
            'success' => true,
            'data' => $data
        ]);
    }

    public function actionTopSearch(){
        $request = Yii::$app->getRequest()->get();
        $limit = (isset($request['limit']) && $request['limit']) ? $request['limit'] : 10;
        $data = ProductTopsearch::getTopsearch([
            'limit' => $limit
        ]);
        return $this->responseData([
            'success' => true,
            'data' => $data
        ]);
    }

    protected function verbs()
    {
        return [
            'get-category' => ['get'],
            'get-product-by-category' => ['get'],
            'category-show-home' => ['get'],
            'top-search' => ['get'],
        ];
    }
}