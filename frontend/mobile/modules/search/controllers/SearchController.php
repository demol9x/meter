<?php

namespace frontend\mobile\modules\search\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use common\models\product\Product;
use common\models\shop\Shop;
use common\components\ClaLid;
use yii\helpers\Url;
use common\models\product\ProductTopsearch;
use common\components\ClaGenerate;
use common\components\ClaSearch;


/**
 * Search controller
 */
class SearchController extends Controller
{

    public function actionRouter()
    {
        $get = $_GET;
        $type_search = 1;
        if (isset($get['type_search'])) {
            $type_search = $get['type_search'];
        }
        $link = ClaSearch::optionlinkType($type_search);
        return $this->redirect(array_merge([$link], $get));
    }

    public function actionSearchAjax()
    {
        $pagesize = ClaLid::DEFAULT_LIMIT;
        $page = Yii::$app->request->get('page', 1);
        $get = $_GET;
        $type = (isset($get['type']) && $get['type']) ? $get['type'] : ClaSearch::TYPE_PRODUCT;
        $latlng = isset($get['latlng']) ? $get['latlng'] : 0;
        $data = [];
        switch ($type) {
            case ClaSearch::TYPE_PRODUCT:
                if ($latlng) {
                    $tg = explode(',', $latlng);
                    $lats =  $tg[0];
                    $lngs =  $tg[1];
                    $data = ClaSearch::findNearLocations(array_merge($get, [
                        'lat' => $lats,
                        'lng' => $lngs,
                        'limit' => $pagesize,
                        'page' => $page,
                    ]));
                    if (!$data) {
                        $data  =  ClaSearch::findNearLocationsSearchTD(array_merge($get, [
                            'lat' => $lats,
                            'lng' => $lngs,
                            'limit' => $pagesize,
                            'page' => $page,
                        ]));
                    }
                } else {
                    $data = Product::getProduct(array_merge($get, [
                        'limit' => $pagesize,
                        'page' => $page,
                    ]));
                    if (!$data) {
                        $data  = Product::getProductSearchTD(array_merge($get, [
                            'limit' => $pagesize,
                            'page' => $page,
                        ]));
                    }
                }
                break;
            case ClaSearch::TYPE_SHOP:
                if ($latlng) {
                    $tg = explode(',', $latlng);
                    $lats =  $tg[0];
                    $lngs =  $tg[1];
                    $data = ClaSearch::findNearLocationsShop(array_merge($get, [
                        'lat' => $lats,
                        'lng' => $lngs,
                        'limit' => $pagesize,
                        'page' => $page,
                    ]));
                    if (!$data) {
                        $data  =  ClaSearch::findNearLocationsSearchTD(array_merge($get, [
                            'lat' => $lats,
                            'lng' => $lngs,
                            'limit' => $pagesize,
                            'page' => $page,
                        ]));
                    }
                } else {
                    $data = Shop::getShop(array_merge($get, [
                        'limit' => $pagesize,
                        'page' => $page,
                    ]));
                }
                break;
        }
        return $this->renderAjax('result_' . $type, [
            'data' => $data,
            'type' => $type,
        ]);
    }

    public function actionIndex()
    {
        Yii::$app->view->title = 'Trang tìm kiếm';
        //
        Yii::$app->params['breadcrumbs'] = [
            'Trang chủ' => Url::home(),
            'Tìm kiếm' => Url::current(),
        ];
        //
        $this->layout = 'search-mobile';
        //
        $page = Yii::$app->request->get('page', 1);
        //
        $data = $_GET;
        $view = 'index';
        $center = ClaLid::getLatlngDefault();
        $pagesize = 30;
        $get_range = 0;
        //
        if (isset($data['keyword'])) {
            if (isset($data['latlng']) && $data['latlng']) {
                $center = $data['latlng'];
                $tg = explode(',', $center);
                $lats =  $tg[0];
                $lngs =  $tg[1];
                $products = ClaSearch::findNearLocations(array_merge($data, [
                    'lat' => $lats,
                    'lng' => $lngs,
                    'limit' => $pagesize,
                    'page' => $page,
                ]));

                $totalitem = ClaSearch::findNearLocations(array_merge($data, [
                    'count' => 1,
                    'lat' => $lats,
                    'lng' => $lngs,
                ]));
                if (!$products) {
                    $products  =  ClaSearch::findNearLocationsSearchTD(array_merge($data, [
                        'lat' => $lats,
                        'lng' => $lngs,
                        'limit' => $pagesize,
                        'page' => $page,
                    ]));
                    $totalitem = ClaSearch::findNearLocationsSearchTD(array_merge($data, [
                        'count' => 1,
                        'lat' => $lats,
                        'lng' => $lngs,
                    ]));
                }
                $view = 'product_map';
                $pagesize = 100;
                $get_range = 1;
            } else {
                $products = Product::getProduct(array_merge($data, [
                    'limit' => $pagesize,
                    'page' => $page,
                ]));
                $totalitem = Product::getProduct(array_merge($data, [
                    'count' => 1
                ]));
                if (!$products) {
                    $products = Product::getProductSearchTD(array_merge($data, [
                        'limit' => $pagesize,
                        'page' => $page,
                    ]));
                    $totalitem = Product::getProductSearchTD(array_merge($data, [
                        'count' => 1
                    ]));
                }
                $view = 'product_map';
                $pagesize = 100;
            }
        } else {
            $products = [];
            $totalitem = 0;
            $view = 'product_map';
            $pagesize = 100;
        }

        if ($totalitem && isset($data['keyword']) && $data['keyword']) {
            $first = $products[0];
            $session_id = ClaLid::getSessionId();
            $keyword = $data['keyword'];
            $time = time();
            $this->getView()->registerJs('jQuery(document).ready(function() {setTimeout(function() { $("body").append("<img style=\"display: none; width: 0px; height: 0px;\" rel=\"nofollow\" src=\"' . Url::to(['/search/search/update-search', 'keyword' => $keyword, 'time' => $time, 'avatar_name' => $first['avatar_name'], 'avatar_path' => $first['avatar_path'], 'totalitem' => $totalitem, 'key' => ClaGenerate::encrypPassword($keyword . $time . $session_id)]) . '\" />") }, 1000)})');
            //
        }
        return $this->render($view, [
            'totalitem' => $totalitem,
            'limit' => $pagesize,
            'center' => $center,
            'products' => $products,
            'get_range' => $get_range
        ]);
    }

    public function actionIndexAjax()
    {
        //
        $this->layout = 'search-mobile';
        //
        $page = Yii::$app->request->get('page', 1);
        //
        $get = $_GET;
        $view = 'index';
        $center = ClaLid::getLatlngDefault();
        $pagesize = 30;
        $get_range = 0;
        //
        if (isset($get['keyword'])) {
            $type = (isset($get['type']) && $get['type']) ? $get['type'] : ClaSearch::TYPE_PRODUCT;
            $latlng = isset($get['latlng']) ? $get['latlng'] : 0;
            $data = [];
            switch ($type) {
                case ClaSearch::TYPE_PRODUCT:
                    $view = 'product_nomap';
                    if ($latlng) {
                        $view = 'product_map_ajax';
                        $tg = explode(',', $latlng);
                        $lats =  $tg[0];
                        $lngs =  $tg[1];
                        $data = ClaSearch::findNearLocations(array_merge($get, [
                            'lat' => $lats,
                            'lng' => $lngs,
                            'limit' => $pagesize,
                            'page' => $page,
                        ]));
                        if (!$data) {
                            $data  =  ClaSearch::findNearLocationsSearchTD(array_merge($get, [
                                'lat' => $lats,
                                'lng' => $lngs,
                                'limit' => $pagesize,
                                'page' => $page,
                            ]));
                            $totalitem  =  ClaSearch::findNearLocationsSearchTD(array_merge($get, [
                                'lat' => $lats,
                                'lng' => $lngs,
                                'count' => 1,
                            ]));
                        } else {
                            $totalitem = ClaSearch::findNearLocations(array_merge($get, [
                                'lat' => $lats,
                                'lng' => $lngs,
                                'count' => 1,
                            ]));
                        }
                        $get_range = 1;
                    } else {
                        $data = Product::getProduct(array_merge($get, [
                            'limit' => $pagesize,
                            'page' => $page,
                        ]));
                        if (!$data) {
                            $data  = Product::getProductSearchTD(array_merge($get, [
                                'limit' => $pagesize,
                                'page' => $page,
                            ]));
                            $totalitem  = Product::getProductSearchTD(array_merge($get, [
                                'count' => 1,
                            ]));
                        } else {
                            $totalitem = Product::getProduct(array_merge($get, [
                                'count' => 1,
                            ]));
                        }
                    }
                    
                    break;
                case ClaSearch::TYPE_SHOP:
                    $view = 'shop_nomap';
                    if ($latlng) {
                        $view = 'shop_map_ajax';
                        $tg = explode(',', $latlng);
                        $lats =  $tg[0];
                        $lngs =  $tg[1];
                        $data = ClaSearch::findNearLocationsShop(array_merge($get, [
                            'lat' => $lats,
                            'lng' => $lngs,
                            'limit' => $pagesize,
                            'page' => $page,
                        ]));
                        if (!$data) {
                            $data  =  ClaSearch::findNearLocationsSearchTD(array_merge($get, [
                                'lat' => $lats,
                                'lng' => $lngs,
                                'limit' => $pagesize,
                                'page' => $page,
                            ]));
                            $totalitem  =  ClaSearch::findNearLocationsSearchTD(array_merge($get, [
                                'lat' => $lats,
                                'lng' => $lngs,
                                'count' => 1,
                            ]));
                        } else {
                            $totalitem = ClaSearch::findNearLocationsShop(array_merge($get, [
                                'lat' => $lats,
                                'lng' => $lngs,
                                'count' => 1,
                            ]));
                        }
                        $get_range = 1;
                    } else {
                        $data = Shop::getShop(array_merge($get, [
                            'limit' => $pagesize,
                            'page' => $page,
                        ]));
                        $totalitem = Shop::getShop(array_merge($get, [
                            'count' => 1,
                        ]));
                    }
                    break;
            }
        } else {
            $data = [];
            $totalitem = 0;
            $view = 'product_map_ajax';
            $pagesize = 100;
        }
        return $this->renderAjax($view, [
            'totalitem' => $totalitem,
            'limit' => $pagesize,
            'center' => $center,
            'data' => $data,
            'get_range' => $get_range
        ]);
    }

    public function actionShop()
    {
        Yii::$app->view->title = 'Trang tìm kiếm';
        //
        Yii::$app->params['breadcrumbs'] = [
            'Trang chủ' => Url::home(),
            'Tìm kiếm' => Url::current(),
        ];
        //
        $this->layout = 'search';
        //
        $pagesize = 100;
        $page = Yii::$app->request->get('page', 1);
        //
        $data = $_GET;
        //
        $view = 'shop';
        $center = ClaLid::getLatlngDefault();
        $pagesize = 30;
        $products = [];
        $get_range = 0;
        //
        if (isset($data['latlng']) && $data['latlng']) {
            $center = $data['latlng'];
            $tg = explode(',', $center);
            $lats =  $tg[0];
            $lngs =  $tg[1];
            $shops = ClaSearch::findNearLocationsShop(array_merge($data, [
                'lat' => $lats,
                'lng' => $lngs,
                'limit' => $pagesize,
                'page' => $page,
            ]));

            $totalitem = ClaSearch::findNearLocationsShop(array_merge($data, [
                'count' => 1,
                'lat' => $lats,
                'lng' => $lngs,
            ]));
            $view = 'shop_map';
            $this->layout = 'map';
            $pagesize = 100;
            $get_range = 1;
        } else {
            $shops = Shop::getShop(array_merge($data, [
                'limit' => $pagesize,
                'page' => $page,
                'order' => ' count_product DESC '
            ]));
            $totalitem = Shop::getShop(array_merge($data, [
                'count' => 1
            ]));
            $view = 'shop_map';
            $this->layout = 'map';
        }
        //
        return $this->render($view, [
            'totalitem' => $totalitem,
            'limit' => $pagesize,
            'center' => $center,
            'shops' => $shops,
            'products' => $products,
            'get_range' => $get_range
        ]);
    }

    public function actionAjax()
    {
        \Yii::$app->session->open();
        $pagesize = ClaLid::DEFAULT_LIMIT;
        $page = Yii::$app->request->get('page', 1);
        $data = $_GET;
        $data_add = isset($_SESSION['search_ajax']) ? $_SESSION['search_ajax'] : [];
        $data = array_merge($data_add, $data);
        if (isset($_POST) && $_POST) {
            foreach ($_POST as $key => $value) {
                $data[$key] = $value;
            }
        }
        // print_r($data);
        $products = Product::getProduct(array_merge($data, [
            'limit' => $pagesize,
            'page' => $page,
        ]));
        $totalitem = Product::getProduct(array_merge($data, [
            'count' => 1,
        ]));
        if (!$products) {
            $products = Product::getProductSearchTD(array_merge($data, [
                'limit' => $pagesize,
                'page' => $page,
            ]));
            $totalitem = Product::getProductSearchTD(array_merge($data, [
                'count' => 1
            ]));
        }

        if (isset($data['type_gold'])) {
            unset($data['type_gold']);
        }
        if (isset($data['type_rate'])) {
            unset($data['type_rate']);
        }
        if (isset($data['address'])) {
            unset($data['address']);
        }

        $_SESSION['search_ajax'] = $data;
        return $this->renderAjax('ajax', [
            'data' => $products,
            'totalitem' => $totalitem,
            'limit' => $pagesize
        ]);
    }

    public function actionAjaxShop()
    {
        \Yii::$app->session->open();
        $pagesize = ClaLid::DEFAULT_LIMIT;
        $page = Yii::$app->request->get('page', 1);
        $data = $_GET;
        $data_add = isset($_SESSION['search_ajax']) ? $_SESSION['search_ajax'] : [];
        $data = array_merge($data_add, $data);

        $shops = Shop::getShop(array_merge($data, [
            'limit' => $pagesize,
            'page' => $page,
        ]));
        $products = [];
        if ($shops) {
            foreach ($shops as $shop) {
                $products[$shop['id']] = Product::getProduct([
                    'shop_id' => $shop['id'],
                    'limit' => 5,
                ]);
                $products[$shop['id']]['count_product'] = Product::getProduct([
                    'shop_id' => $shop['id'],
                    'count' => 1,
                ]);
            }
        }
        //
        $totalitem = Shop::getShop(array_merge($data, [
            'count' => 1,
        ]));

        if (isset($data['type_gold'])) {
            unset($data['type_gold']);
        }
        if (isset($data['type_rate'])) {
            unset($data['type_rate']);
        }
        if (isset($data['address'])) {
            unset($data['address']);
        }

        $_SESSION['search_ajax'] = $data;
        return $this->renderAjax('ajax-shop', [
            'data' => $shops,
            'products' => $products,
            'totalitem' => $totalitem,
            'limit' => $pagesize
        ]);
    }

    public function actionUpdateSearch()
    {
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
