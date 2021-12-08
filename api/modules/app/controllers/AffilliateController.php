<?php

namespace api\modules\app\controllers;

use common\models\affiliate\AffiliateClick;
use common\models\affiliate\AffiliateLink;
use common\models\order\Order;

class AffilliateController extends LoginedController
{
    function actionGetListManager()
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        $limit = isset($post['limit']) && $post['limit'] > 0 ? $post['limit'] : 12;
        $page = isset($post['page']) && $post['page'] > 0 ? $post['page'] : 1;
        $keyword = isset($post['keyword']) && $post['keyword'] ? $post['keyword'] : '';
        $links = AffiliateLink::getAllLink($this->user->id);
        $affLinkIds = array_column($links, 'id');
        $allClick = AffiliateClick::getClickByAffiliateIds($affLinkIds);
        $allOrder = \common\models\order\OrderItem::getOrderByAffiliateIds(array_column($links, 'object_id'));
        $affOjectIds = array_column($links, 'object_id');
        $affOjectIds = count($affOjectIds) > 0 ? $affOjectIds : [-1];
        $ids = array_column($links, 'object_id');
        $product = new  \common\models\product\Product();
        $tg = \common\models\product\Product::getProduct([
            'limit' => $limit,
            'page' => $page,
            'id' => $affOjectIds,
            'keyword' => $keyword,
            'status_affiliate' => 1,
        ]);
        $datasave = [];
        $product->_shops = \common\models\shop\Shop::optionsShop();
        if ($tg) foreach ($tg as $item) {
            $product->setAttributeShow($item);
            $item['price'] = $product->getPriceC1(1);
            $item['text_price'] = number_format($item['price'], 0, ',', '.') . \Yii::t('app', 'currency');
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
            if (in_array($product['id'], $ids)) {
                $affiliate_id = $links[$product['id']]['id'];
                if (isset($allClick[$affiliate_id]) && $allClick[$affiliate_id]) {
                    $item['count_click'] = count($allClick[$affiliate_id]);
                } else {
                    $item['count_click'] = 0;
                }
            }
            $item['count_order'] = isset($allOrder[$product['id']]) ? $allOrder[$product['id']] : 0;
            $item['link_affilliate'] = $links[$product['id']]['link'];
            $datasave[] = $item;
        }
        $resonse['code'] = 1;
        $resonse['message'] = "Lấy danh sách sản phẩm affillate đang quản lý thành công.";
        $resonse['data'] = $datasave;
        return $this->responseData($resonse);
    }

    function actionGetProducts()
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        $resonse['message'] = 'Lấy danh sách sản phẩm thàng công';
        $limit = isset($post['limit']) && $post['limit'] > 0 ? $post['limit'] : 12;
        $page = isset($post['page']) && $post['page'] > 0 ? $post['page'] : 1;
        $keyword = isset($post['keyword']) && $post['keyword'] ? $post['keyword'] : '';
        $links = AffiliateLink::getAllLink($this->user->id);
        $affOjectIds = array_column($links, 'object_id');
        $affOjectIds = count($affOjectIds) > 0 ? $affOjectIds : [-1];
        $data = \common\models\product\Product::getProduct([
            'limit' => $limit,
            'page' => $page,
            '_id' => $affOjectIds,
            'keyword' => $keyword,
            'status_affiliate' => 1,
        ]);
        $datasave = [];
        $product = new  \common\models\product\Product();
        $product->_shops = \common\models\shop\Shop::optionsShop();
        if ($data) foreach ($data as $item) {
            $product->setAttributeShow($item);
            $item['price'] = $product->getPriceC1(1);
            $item['text_price'] = number_format($item['price'], 0, ',', '.') . \Yii::t('app', 'currency');
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
            $datasave[] = $item;
        }
        $resonse['data'] = $datasave;
        $resonse['code'] = 1;
        return $this->responseData($resonse);
    }

    function actionAddProductToListManager()
    {
        $this->setTimeLoadOnce(5);
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        $model = new AffiliateLink();
        if ($model->load($post)) {
            $model->type = 1;
            $model->user_id = $this->user->id;
            if ($model->isHas()) {
                $resonse['error'] = "Link afilliate tồn tại.";
                return $this->responseData($resonse);
            }
            $model->url = file_get_contents(__SERVER_NAME . '/gapi/get-link-product.html?id=' . $model->object_id);
            if (!$model->url) {
                $resonse['error'] = "Sản phẩm không tồn tại trong hệ thống.";
                return $this->responseData($resonse);
            }
            $model->url = __SERVER_NAME . $model->url;
            if ($model->save()) {
                $resonse['code'] = 1;
                $resonse['message'] = "Thêm thành công.";
                $resonse['data'] = $model;
            } else {
                $resonse['error'] = "Lỗi dữ liệu.";
                $resonse['data'] = $model->errors;
                return $this->responseData($resonse);
            }
        }
        $resonse['error'] = "Lỗi dữ liệu.";
        return $this->responseData($resonse);
    }

    function actionGetInfoAffilliateProducts()
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        $resonse['message'] = 'Lấy thông tin thành công';
        $options = [];
        $start_date = isset($post['start_date']) ? $post['start_date'] : NULL;
        $end_date = isset($post['end_date']) ? $post['end_date'] : NULL;
        if ($start_date === NULL) {
            $start_date = date('d-m-Y', strtotime('-30 days'));
        }
        $options['start_date'] = $start_date;
        if ($end_date === NULL) {
            $end_date = date('d-m-Y');
        }
        $options['end_date'] = $end_date;
        // get date ranges
        list($sd, $sm, $sy) = explode('-', $start_date);
        list($ed, $em, $ey) = explode('-', $end_date);
        $stemp = implode('-', [$sy, $sm, $sd]);
        $etemp = implode('-', [$ey, $em, $ed]);
        $dateRanges = \common\components\ClaDateTime::date_range($stemp, $etemp, '+1 day', 'd-m-Y');
        $user_id = $this->user->id;
        $clickCount = AffiliateClick::countClick($user_id, $options);
        $orderWaitingCount = Order::countOrder([1, 2, 3], $user_id, $options);
        $orderCompleteCount = Order::countOrder([Order::ORDER_DELIVERING], $user_id, $options);
        $orderDestroyCount = Order::countOrder([Order::ORDER_CANCEL], $user_id, $options);
        if (($orderWaitingCount + $orderCompleteCount) >= 1 && $clickCount) {
            $rate = ($orderWaitingCount + $orderCompleteCount) / ($clickCount / 100);
        } else {
            $rate = 0;
        }
        $data = [];
        foreach ($dateRanges as $date) {
            $data[$date]['click'] = 0;
            $data[$date]['order'] = 0;
        }
        $dataClick = AffiliateClick::getClick($user_id, $options);
        foreach ($dataClick as $click) {
            $day = date('d-m-Y', $click['created_at']);
            $data[$day]['click']++;
        }
        $dataOrder = Order::getAllOrder($user_id, $options);
        foreach ($dataOrder as $order) {
            $day = date('d-m-Y', $order['created_at']);
            $data[$day]['order']++;
        }
        // Get commission order success
        $order_items = \common\models\order\OrderItem::getAllOrderItem($user_id, $options);
        $commission = \common\models\order\OrderItem::calculatorCommission($order_items);
        $resonse['data']['count_click'] = $clickCount;
        $resonse['data']['count_order_waiting'] = $orderWaitingCount;
        $resonse['data']['count_order_complete'] = $orderCompleteCount;
        $resonse['data']['count_order_cancer'] = $orderDestroyCount;
        $resonse['data']['order_per_click'] =  $rate;
        $resonse['data']['coin_success'] = $commission[Order::ORDER_DELIVERING];
        $resonse['data']['coin_success_text'] = formatCoin($resonse['data']['coin_success']) . ' ' . __VOUCHER_RED;
        $resonse['data']['coin_waiting'] = $commission[Order::ORDER_WAITING_PROCESS];
        $resonse['data']['coin_waiting_text'] = formatCoin($resonse['data']['coin_waiting']) . ' ' . __VOUCHER_RED;
        $resonse['data']['coin_cancer'] = $commission[Order::ORDER_CANCEL];
        $resonse['data']['coin_cancer_text'] = formatCoin($resonse['data']['coin_cancer']) . ' ' . __VOUCHER_RED;
        $resonse['data']['statical'] = $data;
        $resonse['data']['order_items'] = $order_items;
        $resonse['code'] = 1;
        return $this->responseData($resonse);
    }

    function actionGetLinkAffilliateShop()
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        $resonse['message'] = 'Lấy link giới thiệu gian thành công';
        $resonse['data']['link'] = __SERVER_NAME . file_get_contents(__SERVER_NAME . '/gapi/get-link-frontend.html?url=/login/login/signup' . '&user_id=' . $this->user->id);
        $resonse['code'] = 1;
        return $this->responseData($resonse);
    }

    function actionGetListAffilliateShops()
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        $resonse['message'] = 'Lấy link giới thiệu gian thành công';
        $resonse['data'] = \common\models\shop\Shop::getAfterAffiliate($this->user->id);
        $resonse['code'] = 1;
        return $this->responseData($resonse);
    }

    function actionGetInfoAffilliateShops()
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        $resonse['message'] = 'Lấy thông tin thành công';
        $user_id = $this->user->id;
        $options = [];
        $start_date = isset($post['start_date']) ? $post['start_date'] : NULL;
        $end_date = isset($post['end_date']) ? $post['end_date'] : NULL;
        if ($start_date === NULL) {
            $start_date = date('d-m-Y', strtotime('-30 days'));
        }
        $options['start_date'] = $start_date;
        if ($end_date === NULL) {
            $end_date = date('d-m-Y');
        }
        $options['end_date'] = $end_date;
        // Get commission order success
        $order_items = \common\models\order\OrderItem::getAllOrderItemIsShop($user_id, $options);
        $commission = \common\models\order\OrderItem::calculatorCommissionIsShop($order_items);
        $hour_confinement = \common\models\gcacoin\Config::getHourConfinement();
        $change = [];
        if ($order_items) foreach ($order_items as $item) {
            $item['text_status'] = Order::getOrderStatusName($item['status']);
            $return = '';
            $order_status = $item['status'];
            if ($order_status == Order::ORDER_DELIVERING) {
                if ($item['status_check_cancer'] == \common\components\ClaLid::STATUS_ACTIVED) {
                    $return = 'Hoàn thành';
                } else {
                    $time = ($item['updated_at'] + $hour_confinement) - time();
                    $time = $time > 0 ? $time / (60 * 60) : 0;
                    if ($time) {
                        $return = 'Gần ' . (($time / 24 > 1) ? CEIL($time / 24) . ' ngày' : CEIL($time) . ' giờ');
                    } else {
                        $return = 'Hoàn thành';
                    }
                }
            } else if ($order_status == Order::ORDER_CANCEL) {
                $return = '';
            } else {
                $return = 'Hơn 3 ngày';
            }
            $item['text_coin'] = formatMoney($item['sale_before_shop']) . ' ' . __VOUCHER_RED;
            $item['time_waiting'] = $return;
            $change[] = $item;
        }

        $resonse['data']['coin_success'] = $commission[Order::ORDER_DELIVERING];
        $resonse['data']['coin_success_text'] = formatCoin($resonse['data']['coin_success']) . ' ' . __VOUCHER_RED;
        $resonse['data']['coin_waiting'] = $commission[Order::ORDER_WAITING_PROCESS];
        $resonse['data']['coin_waiting_text'] = formatCoin($resonse['data']['coin_waiting']) . ' ' . __VOUCHER_RED;
        $resonse['data']['coin_cancer'] = $commission[Order::ORDER_CANCEL];
        $resonse['data']['coin_cancer_text'] = formatCoin($resonse['data']['coin_cancer']) . ' ' . __VOUCHER_RED;
        $resonse['data']['order_items'] = $change;
        $resonse['code'] = 1;
        return $this->responseData($resonse);
    }

    function actionGetKeyAffilliateApp()
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        $resonse['message'] = 'Lấy key thành công';
        $resonse['data'] = ['key' => $this->user->getKeyApp()];
        $resonse['code'] = 1;
        return $this->responseData($resonse);
    }
}
