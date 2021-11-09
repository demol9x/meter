<?php

namespace frontend\modules\search\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use common\models\product\Product;
use common\components\ClaLid;
use yii\helpers\Url;
use common\models\product\ProductTopsearch;
use common\components\ClaGenerate;

/**
 * Search controller
 */
class SearchController extends Controller {

    public function actionIndex() {
        Yii::$app->view->title = 'Trang tìm kiếm';
        //
        Yii::$app->params['breadcrumbs'] = [
            'Trang chủ' => Url::home(),
            'Tìm kiếm' => Url::current(),
        ];
        //
        $this->layout = 'search';
        //
        $pagesize = ClaLid::DEFAULT_LIMIT;
        $page = Yii::$app->request->get('page', 1);
        //
        $data = $_GET;
        //
        $products = Product::getProduct(array_merge($data, [
                    'limit' => $pagesize,
                    'page' => $page,
        ]));
        //
        $totalitem = Product::getProduct(array_merge($data, [
                    'count' => 1,
        ]));
        // statistics
        if (isset($data['keyword']) && $data['keyword']) {
            
        }
        if ($totalitem && isset($data['keyword']) && $data['keyword']) {
            $first = $products[0];
            $session_id = ClaLid::getSessionId();
            $keyword = $data['keyword'];
            $time = time();
            $this->getView()->registerJs('jQuery(document).ready(function() {setTimeout(function() { $("body").append("<img style=\"display: none; width: 0px; height: 0px;\" rel=\"nofollow\" src=\"' . Url::to(['/search/search/update-search', 'keyword' => $keyword, 'time' => $time, 'avatar_name' => $first['avatar_name'], 'avatar_path' => $first['avatar_path'], 'totalitem' => $totalitem, 'key' => ClaGenerate::encrypPassword($keyword . $time . $session_id)]) . '\" />") }, 1000)})');
            //
        }
        //
        return $this->render('index', [
                    'data' => $products,
                    'totalitem' => $totalitem,
                    'limit' => $pagesize
        ]);
    }

    public function actionUpdateSearch() {
        $keyword = Yii::$app->request->get('keyword');
        $time = Yii::$app->request->get('time');
        $session_id = ClaLid::getSessionId();
        $key = Yii::$app->request->get('key');
        $avatar_path = Yii::$app->request->get('avatar_path');
        $avatar_name = Yii::$app->request->get('avatar_name');
        $totalitem = Yii::$app->request->get('totalitem');
        if ($key != ClaGenerate::encrypPassword($keyword . $time . $session_id)) {
            // 400
            throw new BadRequestHttpException('Tham số không hợp lệ');
        }
        //
        $productSearch = ClaLid::getCookie(Product::PRODUCT_SEARCH);
        $data_searched = [];
        //

        if ($productSearch == '') {
            $data_searched = json_encode([$keyword]);
            // 30p
            ClaLid::setCookie(Product::PRODUCT_SEARCH, $data_searched, 0.02);
            ProductTopsearch::statistics([
                'keyword' => $keyword,
                'totalitem' => $totalitem,
                'avatar_path' => $avatar_path,
                'avatar_name' => $avatar_name,
            ]);
        } else {
            $data_searched = json_decode($productSearch);
            if (!in_array($keyword, $data_searched)) {
                $data_searched[] = $keyword;
                $data_searched = json_encode($data_searched);
                ClaLid::setCookie(Product::PRODUCT_VIEWED, $data_searched, 0.02);
                ProductTopsearch::statistics([
                    'keyword' => $keyword,
                    'totalitem' => $totalitem,
                    'avatar_path' => $avatar_path,
                    'avatar_name' => $avatar_name,
                ]);
            }
        }
        Yii::$app->response->statusCode = 200;
    }

}
