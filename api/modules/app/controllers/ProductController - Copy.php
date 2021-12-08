<?php

namespace api\modules\app\controllers;

//
use common\models\product\Product;

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
        if ($data) foreach ($data as $item) {
            $product->setAttributeShow($item);
            // $item['url'] = $product->getLink();
            $item['price_market'] = $product->getPriceMarket(1);
            $item['text_price_market'] = $product->getPriceMarketText(1);
            $item['price'] = $product->getPrice(1);
            $item['text_price'] = $product->getPriceText(1);
            $item['check_in_cart'] = $product->checkInCart();
            $datasave[] = $item;
        }
        $resonse['data'] = $datasave;
        $resonse['code'] = 1;
        return $this->responseData($resonse);
    }

    function actionDataPageDetailProduct()
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        $resonse['message'] = 'Lấy danh sách sản phẩm thàng công';
        if (isset($post['product_id']) && $post['product_id']) {
            $mproduct = Product::findOne($post['product_id']);
            if ($mproduct) {
                $product = $mproduct->attributes;
                $product['price_market'] = $mproduct->getPriceMarket(1);
                $product['text_price_market'] = $mproduct->getPriceMarketText(1);
                $product['price'] = $mproduct->getPrice(1);
                $product['text_price'] = $mproduct->getPriceText(1);
                $product['check_in_cart'] = $mproduct->checkInCart();
                $product['shop'] = \common\models\shop\Shop::findOne($mproduct->shop_id);
                $product['images'] = Product::getImages($mproduct->id);
                $product['ratings'] = \common\models\rating\Rating::getRatings(1, $mproduct->shop_id);
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
}
