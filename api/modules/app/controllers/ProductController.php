<?php

namespace api\modules\app\controllers;

//
use common\components\ClaBds;
use common\components\ClaLid;
use common\models\product\Product;
use common\models\product\Project;
use common\models\Ward;

class ProductController extends AppController
{
    function actionGetProducts()
    {
        $options = $this->getDataPost();
        $resonse = $this->getResponse();
        $resonse['message'] = 'Lấy danh sách sản phẩm thàng công';
        $data = Product::getProduct($options);
        $datasave = [];
        $product = Product::loadShowAll();
        $user = false;
        if (isset($options['user_id']) && $options['user_id']) {
            $product->_wishs = \common\models\product\ProductWish::getWishAllByUser(['user_id' => $options['user_id']]);
            $user = true;
        }
        if ($data) foreach ($data as $item) {
            $product->setAttributeShow($item);
            // $item['url'] = $product->getLink();
            $item['price_market'] = $product->getPriceMarket(1);
            $item['text_price_market'] = $product->getPriceMarketText(1);
            $item['price'] = $product->getPrice(1);
            $item['text_price'] = $product->getPriceText(1);
            if (isset($product->_shops[$item['shop_id']]) && $product->_shops[$item['shop_id']]) {
                $shop = $product->_shops[$item['shop_id']];
                $item['shop']['name'] =  $shop['name'];
                $item['shop']['avatar_name'] = $shop['avatar_name'];
                $item['shop']['avatar_path'] = $shop['avatar_path'];
            } else {
                $item['shop']['name'] = '';
                $item['shop']['avatar_name'] = '';
                $item['shop']['avatar_path'] = '';
            }
            if ($user) {
                $item['in_wish'] = $product->inWish();
            } else {
                $item['in_wish'] = false;
            }
            $datasave[] = $item;
        }
        $resonse['data'] = $datasave;
        $resonse['code'] = 1;
        return $this->responseData($resonse);
    }

    function actionGetProductCategories()
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        $resonse['message'] = 'Lấy danh sách danh mục sản phẩm thàng công';
        $category_id = isset($post['category_id']) ? $post['category_id'] : 0;
        $category = new \common\components\ClaCategory(array('type' => \common\components\ClaCategory::CATEGORY_PRODUCT, 'create' => true));
        $resonse['data'] = $category->createArrayCategory($category_id);
        $resonse['code'] = 1;
        return $this->responseData($resonse);
    }

    function actionDataPageDetailProduct()
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        if (isset($post['product_id']) && $post['product_id']) {
            $mproduct = Product::find()->where(['id' => $post['product_id'], 'status' => 1])->one();
            if ($mproduct) {
                $product = $mproduct->attributes;
                $product['price_market'] = $mproduct->getPriceMarket(1);
                $product['text_price_market'] = $mproduct->getPriceMarketText(1);
                $product['price'] = $mproduct->getPrice(1);
                $product['text_price'] = $mproduct->getPriceText(1);
                $product['shop'] = \common\models\shop\Shop::findOne($mproduct->shop_id);
                $product['images'] = Product::getImages($mproduct->id);
                $product['ratings'] = \common\models\rating\Rating::getRatings(\common\models\rating\Rating::RATING_PRODUCT, $mproduct->id);
                $resonse['data'] = $product;
                $resonse['mesage'] = "Lấy thông tin thành công";
                $resonse['code'] = 1;
            } else {
                $resonse['error'] = "Không có tìm thấy sản phẩm với product_id = " . $post['product_id'];
            }
        } else {
            $resonse['error'] = "Không có product_id.";
        }
        return $this->responseData($resonse);
    }

    function actionGetProductPrice()
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        if (isset($post['product_id']) && isset($post['quantity']) && $post['product_id'] && $post['quantity'] > 0) {
            $mproduct = Product::findOne($post['product_id']);
            if ($mproduct) {
                if (isset($post['user_id']) && !$mproduct->canBuyFor($post['user_id'])) {
                    $resonse['error'] = $mproduct->_merrors;
                    return $this->responseData($resonse);
                }
                $product['price'] = $mproduct->getPrice($post['quantity']);
                $product['text_price'] = $mproduct->getTextByPrice($product['price']);
                $resonse['data'] = $product;
                $resonse['message'] = "Lấy giá sản phẩm thành công";
                $resonse['code'] = 1;
            } else {
                $resonse['error'] = "Không có tìm thấy sản phẩm với product_id = " . $post['product_id'];
                return $this->responseData($resonse);
            }
        } else {
            $resonse['error'] = "Không có product_id hoặc quantity.";
            return $this->responseData($resonse);
        }
        return $this->responseData($resonse);
    }

    function actionDataPageDetailShop()
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        if (isset($post['shop_id']) && $post['shop_id']) {
            $mshop = \common\models\shop\Shop::find()->where(['id' => $post['shop_id'], 'status' => 1])->one();
            if ($mshop) {
                $shop = $mshop->attributes;
                // $product['price_market'] = $mproduct->getPriceMarket(1);
                $resonse['data'] = $shop;
                if (isset($post['_qrimages']) && $post['_qrimages']) {
                    $user = \frontend\models\User::findOne($post['shop_id']);
                    $tg['qr_senv'] = $user->getQrSendV();
                    $tg['qr_service'] = $user->getQrSendService();
                    $tg['qr_gtshop'] = $user->getQrSendBeforeShop();
                    $resonse['data']['_qrimages'] = $tg;
                }
                if (isset($post['_products']) && $post['_products']) {
                    $options = $post;
                    $data = Product::getProduct($options);
                    $datasave = [];
                    $product = Product::loadShowAll();
                    $user = false;
                    if (isset($options['user_id']) && $options['user_id']) {
                        $product->_wishs = \common\models\product\ProductWish::getWishAllByUser(['user_id' => $options['user_id']]);
                        $user = true;
                    }
                    if ($data) foreach ($data as $item) {
                        $product->setAttributeShow($item);
                        // $item['url'] = $product->getLink();
                        $item['price_market'] = $product->getPriceMarket(1);
                        $item['text_price_market'] = $product->getPriceMarketText(1);
                        $item['price'] = $product->getPrice(1);
                        $item['text_price'] = $product->getPriceText(1);
                        if (isset($product->_shops[$item['shop_id']]) && $product->_shops[$item['shop_id']]) {
                            $shop = $product->_shops[$item['shop_id']];
                            $item['shop']['name'] =  $shop['name'];
                            $item['shop']['avatar_name'] = $shop['avatar_name'];
                            $item['shop']['avatar_path'] = $shop['avatar_path'];
                        } else {
                            $item['shop']['name'] = '';
                            $item['shop']['avatar_name'] = '';
                            $item['shop']['avatar_path'] = '';
                        }
                        if ($user) {
                            $item['in_wish'] = $product->inWish();
                        } else {
                            $item['in_wish'] = false;
                        }
                        $datasave[] = $item;
                    }
                    $resonse['data']['_products'] = $datasave;
                }
                $resonse['mesage'] = "Lấy thông tin thành công";
                $resonse['code'] = 1;
                return $this->responseData($resonse);
            } else {
                $resonse['error'] = "Không có tìm thấy doanh nghiệp.";
            }
        } else {
            $resonse['error'] = "Lỗi dữ liệu.";
        }
        return $this->responseData($resonse);
    }

    function actionGetShops()
    {
        $options = $this->getDataPost();
        $resonse = $this->getResponse();
        $resonse['message'] = 'Lấy danh sách doanh nghiệp thàng công';
        $data = \common\models\shop\Shop::getShop($options);
        // $datasave = [];
        // $shop = Shop::loadShowAll();
        // if ($data) foreach ($data as $item) {
        //     $shop->setAttributeShow($item);
        //     $datasave[] = $item;
        // }
        $resonse['data'] = $data;
        $resonse['code'] = 1;
        return $this->responseData($resonse);
    }

    public function actionSearch(){
        $get = $this->getDataPost();
        $resonse = $this->getResponse();


        $hinh_thuc = isset($get['hinh_thuc']) && $get['hinh_thuc'] ? $get['hinh_thuc'] : '';
        $category_id = isset($get['category_id']) && $get['category_id'] ? $get['category_id'] : '';
        $province_id = isset($get['province_id']) && $get['province_id'] ? $get['province_id'] : 1;
        $district_id = isset($get['district_id']) && $get['district_id'] ? $get['district_id'] : '';
        $ward_id = isset($get['ward_id']) && $get['ward_id'] ? $get['ward_id'] : '';
        $price_min = isset($get['price_min']) && $get['price_min'] ? $get['price_min'] : 0;
        $price_max = isset($get['price_max']) && $get['price_max'] ? $get['price_max'] : '';
        $dien_tich_min = isset($get['dien_tich_min']) && $get['dien_tich_min'] ? $get['dien_tich_min'] : 0;
        $dien_tich_max = isset($get['dien_tich_max']) && $get['dien_tich_max'] ? $get['dien_tich_max'] : '';
        $project = isset($get['project']) && $get['project'] ? $get['project'] : '';
        $so_phong = isset($get['so_phong']) && $get['so_phong'] ? $get['so_phong'] : '';
        $huong_nha = isset($get['huong_nha']) && $get['huong_nha'] ? $get['huong_nha'] : '';
        $user_id = isset($get['user_id']) && $get['user_id'] ? $get['user_id'] : '';
        $limit = isset($get['limit']) && $get['limit'] ? $get['limit'] : 20;
        $page = isset($get['page']) && $get['page'] ? $get['page'] : 1;
        $s = isset($get['s']) && $get['s'] ? $get['s'] : '';
        $options = [
            'hinh_thuc' => $hinh_thuc,
            'category_id' => $category_id,
            'province_id' => $province_id,
            'district_id' => $district_id,
            'ward_id' => $ward_id,
            'price_min' => $price_min,
            'price_max' => $price_max,
            'dien_tich_min' => $dien_tich_min,
            'dien_tich_max' => $dien_tich_max,
            'project' => $project,
            'so_phong' => $so_phong,
            'huong_nha' => $huong_nha,
            'limit' => $limit,
            'page' => $page,
            's' => $s,
            'user_id' => $user_id,
            'status' => ClaLid::STATUS_ACTIVED,
        ];
        $products = Product::getBds($options);
        $data = [];
        if(isset($products['data']) && $products['data']){
            foreach ($products['data'] as $product){
                $gia = 'Thỏa thuận';
                if (isset($product['price_type']) && $product['price_type']) {
                    if ($product['price_type'] != 1) {
                        $gia = $product['price'] . ' ' . \common\components\ClaBds::getBoDonVi($product['bo_donvi_tiente'])[$product['price_type']];
                    }
                };
                $product['price_text'] = $gia;
                $data[] = $product;
            }
        }


        $resonse['data'] = $data;
        $resonse['mesage'] = "Lấy thông tin thành công";
        $resonse['code'] = 1;
        return $this->responseData($resonse);
    }

    public function actionSearchAttribute(){
        $resonse = $this->getResponse();

        $product_category_type = [];
        $category_type = \common\models\product\ProductCategoryType::find()->where(['status' => 1])->asArray()->all();
        foreach ($category_type as $type) {
            $categories = \common\models\product\ProductCategory::getByType($type['id']);
            $type['categories'] = $categories;
            if ($type['bo_donvi_tiente'] == ClaBds::KEY_BOTIENTE_BAN) {
                $type['price_fillter'] = ClaBds::donvitiente_ban_filter();
            } else {
                $type['price_fillter'] = ClaBds::donvitiente_thue_fillter();
            }
            $type['dien_tich'] = ClaBds::dien_tich_fillter();
            $type['huong_nha'] = ClaBds::huong_nha();
            $product_category_type[] = $type;
        }

        $resonse['data'] = $product_category_type;
        $resonse['mesage'] = "Lấy thông tin thành công";
        $resonse['code'] = 1;
        return $this->responseData($resonse);
    }

    public function actionMoneyType(){
        $resonse = $this->getResponse();
        $resonse['data'] = ClaBds::getAllBoDonVi();
        $resonse['mesage'] = "Lấy thông tin thành công";
        $resonse['code'] = 1;
        return $this->responseData($resonse);
    }

    public function actionProject(){
        $get = $this->getDataPost();
        $resonse = $this->getResponse();


        $province_id = isset($get['province_id']) && $get['province_id'] ? $get['province_id'] : 1;
        $district_id = isset($get['district_id']) && $get['district_id'] ? $get['district_id'] : '';
        $project = [];
        if($district_id){
            $project = Project::find()->where(['district_id' => $district_id])->asArray()->all();
        }else if ($province_id){
            $project = Project::find()->where(['province_id' => $province_id])->asArray()->all();
        }

        $resonse['data'] = $project;
        $resonse['mesage'] = "Lấy thông tin thành công";
        $resonse['code'] = 1;
        return $this->responseData($resonse);
    }

    /**
     *
     * @return type
     */
    protected function verbs() {
        return [
            'search' => ['POST'],
        ];
    }
}
