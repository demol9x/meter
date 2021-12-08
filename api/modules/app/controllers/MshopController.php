<?php

namespace api\modules\app\controllers;

use common\components\shipping\ClaShipping;
use common\models\order\Order;
use common\models\order\OrderItem;
use common\models\product\DiscountCode;
use common\models\product\DiscountShopCode;
use common\models\product\Product;
use common\models\product\ProductImage;
use common\models\shop\Shop;
use common\models\shop\ShopAddress;
use Yii;

class MshopController extends AppController
{
    public $user;
    public $shop;

    function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            $post = $this->getDataPost();
            if (isset($post['user_id']) && $post['user_id'] && $this->logined($post['user_id'])) {
                return true;
            }
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            Yii::$app->response->data = [
                'code' => 0,
                'data' => [],
                'message' => '',
                'error' => 'Vui lòng đăng nhập để có thể thực hiện hành động này.',
            ];
            Yii::$app->end();
        }
    }

    function logined($user_id)
    {
        if ($user_id) {
            $this->user = \frontend\models\User::findIdentity($user_id);
            if ($this->user && $this->user->token_app == $this->_token) {
                $this->shop = \common\models\shop\Shop::findOne($user_id);
                if (!$this->shop) {
                    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    Yii::$app->response->data = [
                        'code' => 0,
                        'data' => [],
                        'message' => '',
                        'error' => 'Vui lòng đăng ký doanh nghiệp trước khi thực hiện chức năng này.',
                    ];
                    return false;
                }
                return true;
            }
        }
        return false;
    }

    function uploadImage($name, $path = 'shop')
    {
        $resonse = $this->getResponse();
        $path = [$path, date('Y_m_d', time())];
        if (isset($_FILES[$name])) {
            $file = $_FILES[$name];
            $up = new \common\components\UploadLib($file);
            $up->setPath($path);
            $up->uploadImage();
            $responseimg = $up->getResponse(true);
            if ($up->getStatus() == '200') {
                $resonse['data']['path'] = $responseimg['baseUrl'];
                $resonse['data']['name'] = $responseimg['name'];
                $resonse['code'] = 1;
                $resonse['message'] = 'Up ảnh thành công.';
                return $resonse;
            }
        }
        $resonse['error'] = 'Up ảnh lỗi.';
        return $resonse;
    }

    protected function findModelProduct($id)
    {
        if (($model = \common\models\product\Product::find()->where(['id' => $id, 'shop_id' => $this->shop->id])->one()) !== null) {
            return $model;
        } else {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            \Yii::$app->response->data = [
                'code' => 0,
                'data' => [],
                'message' => '',
                'error' => 'Không tìm thấy sản phẩm.',
            ];
            \Yii::$app->end();
        }
    }

    protected function findModelAddress($id)
    {
        if (($model = \common\models\shop\ShopAddress::find()->where(['id' => $id, 'shop_id' => $this->shop->id])->one()) !== null) {
            return $model;
        } else {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            \Yii::$app->response->data = [
                'code' => 0,
                'data' => [],
                'message' => '',
                'error' => 'Không tìm thấy địa chỉ.',
            ];
            \Yii::$app->end();
        }
    }

    //Lưu ảnh doanh nghiệp
    function actionSaveImagesShop()
    {
        $resonse = $this->getResponse();
        $post = $this->getDataPost();
        $shop_id = $this->shop->id;
        if (isset($post['dels']) && $post['dels']) {
            $imgs = \common\models\shop\ShopImages::find()->where(['shop_id' => $shop_id, 'id' => $post['dels']])->all();
            if ($imgs) foreach ($imgs as $img) {
                $img->delete();
            }
        }
        $images = \common\models\shop\ShopImages::getImages($shop_id);
        $tol = 20 - count($images);
        for ($i = 0; $i < $tol; $i++) {
            $name = 'image' . $i;
            if (isset($_FILES[$name])) {
                $data = $this->uploadImage($name, 'shop');
                if ($data['code'] == 1) {
                    $nimg = new \common\models\shop\ShopImages();
                    $nimg->attributes = $data['data'];
                    $nimg->shop_id = $shop_id;
                    $nimg->type = 1;
                    $nimg->save();
                }
            } else {
                break;
            }
        }
        $resonse['code'] = 1;
        $resonse['message'] = "Lưu thành công.";
        return $this->responseData($resonse);
    }


//    function actionUpdateShopAddress()
//    {
//        $model = $this->findModelAddress($id);
//        $isdefault = $model->isdefault;
//        if ($model->load(Yii::$app->request->post())) {
//            $model->shop_id = $this->shop->id;
//            $model->province_name = ($tg = \common\models\Province::findOne($model->province_id)) ? $tg['name'] : '';
//            $model->district_name = ($tg = \common\models\District::findOne($model->district_id)) ? $tg['name'] : '';
//            $model->ward_name = ($tg = \common\models\Ward::findOne($model->ward_id)) ? $tg['name'] : '';
//            if ($model->phone_add) {
//                if (is_array($model->phone_add)) {
//                    $model->phone_add = implode(',', $model->phone_add);
//                } else {
//                    $model->phone_add = '';
//                }
//            } else {
//                $model->phone_add = '';
//            }
//            if (!$isdefault && $model->isdefault) {
//                \common\models\shop\ShopAddress::updateAll(
//                    ['isdefault' => 0,],
//                    [
//                        'isdefault' => 1,
//                        'shop_id' => Yii::$app->user->id
//                    ]
//                );
//                if ($model->save() && \common\models\shop\Shop::updateAddress($model)) {
//                    $resonse['code'] = 1;
//                    $resonse['message'] = "Lưu thành công.";
//                    return $this->responseData($resonse);
//                }
//            } else {
//                if ($isdefault) {
//                    if ($model->save() && \common\models\shop\Shop::updateAddress($model)) {
//                        $resonse['code'] = 1;
//                        $resonse['message'] = "Lưu thành công.";
//                        return $this->responseData($resonse);
//                    }
//                } else {
//                    if ($model->save()) {
//                        $resonse['code'] = 1;
//                        $resonse['message'] = "Lưu thành công.";
//                        return $this->responseData($resonse);
//                    }
//                }
//            }
//            $resonse['data'] = $model->errors;
//        }
//        $resonse['error'] = "Lỗi dữ liệu.";
//        return $this->responseData($resonse);
//    }


    //Đức viết

    static function statusTextOrder($status)
    {
        switch ($status) {
            case Order::ORDER_CANCEL:
                return 'order_cancel';
                break;
            case Order::ORDER_WAITING_PROCESS:
                return 'order_waiting_process';
                break;
            case Order::ORDER_WAITING_IMPORT_PRODUCT:
                return 'order_waiting_import_product';
                break;
            case Order::ORDER_WAITING_ADD_MORE:
                return 'order_waiting_add_more';
                break;
            case Order::ORDER_DELIVERING:
                return 'order_delivering';
                break;
        }
    }

    static function statusKeyOrder($status)
    {
        switch ($status) {
            case 'order_cancel':
                return Order::ORDER_CANCEL;
                break;
            case 'order_waiting_process':
                return Order::ORDER_WAITING_PROCESS;
                break;
            case 'order_waiting_import_product':
                return Order::ORDER_WAITING_IMPORT_PRODUCT;
                break;
            case 'order_waiting_add_more':
                return Order::ORDER_WAITING_ADD_MORE;
                break;
            case 'order_delivering':
                return Order::ORDER_DELIVERING;
                break;
        }
    }

    static function checkStatus($status)
    {
        $arr = [
            'order_cancel',
            'order_waiting_process',
            'order_waiting_import_product',
            'order_waiting_add_more',
            'order_delivering',
        ];
        if (in_array($status, $arr)) {
            return true;
        }
        return false;
    }

    //update doanh nghiệp
    function actionUpdate()
    {
        $request = $this->getDataPost();
        $resonse = $this->getResponse();
        $user_id = isset($request['user_id']) && $request['user_id'] ? $request['user_id'] : '';
        $model = Shop::findOne($user_id);
        if ($model->load($request, '')) {

            if (isset($_FILES['image'])) {
                $data = $this->uploadImage('image');
                if ($data['code'] == 1) {
                    $model->image_path = $data['data']['path'];
                    $model->image_name = $data['data']['name'];
                }
            }
            if (isset($_FILES['avatar'])) {
                $data = $this->uploadImage('avatar');
                if ($data['code'] == 1) {
                    $model->avatar_path = $data['data']['path'];
                    $model->avatar_name = $data['data']['name'];
                }
            }

            if ($model->save()) {
                $resonse['data'] = $model;
                $resonse['code'] = 1;
                $resonse['message'] = "Cập nhật thông tin doanh nghiệp thành công.";
                return $this->responseData($resonse);
            } else {
                $resonse['data'] = $model->errors;
            }
        }
        $resonse['error'] = "Lỗi dữ liệu.";
        return $this->responseData($resonse);
    }

    //Danh sách order
    function actionOrder()
    {
        $options = $this->getDataPost();
        $user_id = isset($options['user_id']) && $options['user_id'] ? $options['user_id'] : '';
        $status = isset($options['status']) && $options['status'] ? $options['status'] : '';
        $resonse = $this->getResponse();
        if ($user_id == '' || $status == '' || self::checkStatus($status) == false) {
            $resonse['code'] = 0;
            $resonse['message'] = "Dữ liệu không hợp lệ";
        } else {
            $orders = Order::getInShopByStatus($options['user_id'], self::statusKeyOrder($options['status']));
            $products = [];
            $res = [];
            foreach ($orders as $order) {
                $order['products'] = OrderItem::getByShopOrder($order['id']);
                $res[] = $order;
                $products[$order['id']] = OrderItem::getByShopOrder($order['id']);
            }
            for ($i = 0; $i < 5; $i++) {
                $count_status[self::statusTextOrder($i)] = Order::getInShopByStatus($options['user_id'], $i, ['count' => 1]);
            }
            $resonse['code'] = 1;
            $resonse['orders'] = $res;
            $resonse['count_status'] = $count_status;
            $resonse['message'] = "Lấy thông tin thành công.";
        }
        return $this->responseData($resonse);
    }

    public static function getInShopById($id,$user_id)
    {
        return Order::find()->where(['id' => $id, 'shop_id' => $user_id])->one();
    }

    //Chuyển trạng thái đơn hàng
    function actionUpdateOrder(){
        $request = $this->getDataPost();
        $resonse = $this->getResponse();
        $user_id = isset($request['user_id']) && $request['user_id'] ? $request['user_id'] : '';
        $order_id = isset($request['order_id']) && $request['order_id'] ? $request['order_id'] : '';


        if ($order = self::getInShopById($order_id,$user_id)) {
            if ($order->status == 1) {
                $order->status = 2;
                if ($order->save()) {
                    $order->setPromotion();
                    $data = [
                        'order_id' => $order_id,
                        'time' => time(),
                        'status' => $order->status,
                        'type' => $order->transport_type,
                        'content' => Yii::t('app', 'update_to_shop'),
                        'created_at' => time()
                    ];
                    $kt = \common\models\order\OrderShopHistory::saveData($data);
                    $sve = \common\models\notifications\Notifications::updateStatusOrderApi($order,$user_id);
                    $resonse['code'] = 1;
                    return $this->responseData($resonse);
                }
            }

            if ($order->status == 2) {
                $order->status = 3;
                if ($order->save()) {
                    $data = [
                        'order_id' => $order_id,
                        'time' => time(),
                        'status' => $order->status,
                        'type' => $order->transport_type,
                        'content' => Yii::t('app', 'update_to_shop'),
                        'created_at' => time()
                    ];
                    $kt = \common\models\order\OrderShopHistory::saveData($data);
                    $sve = \common\models\notifications\Notifications::updateStatusOrderApi($order,$user_id);
                    $resonse['code'] = 1;
                    return $this->responseData($resonse);
                }
            }

            if ($order->status == 3) {
                $order->status = 4;
                if ($order->save()) {
                    $data = [
                        'order_id' => $order_id,
                        'time' => time(),
                        'status' => $order->status,
                        'type' => $order->transport_type,
                        'content' => Yii::t('app', 'update_to_user'),
                        'created_at' => time()
                    ];
                    $kt = \common\models\order\OrderShopHistory::saveData($data);
                    $sve = \common\models\notifications\Notifications::updateStatusOrderApi($order,$user_id);
                    $resonse['code'] = 1;
                    return $this->responseData($resonse);
                }
            }
        }

        $resonse['error'] = "Lỗi dữ liệu.";
        return $this->responseData($resonse);
    }

    //Hủy đơn hàng
    public function actionCancerOrder()
    {
        $request = $this->getDataPost();
        $resonse = $this->getResponse();
        $user_id = isset($request['user_id']) && $request['user_id'] ? $request['user_id'] : '';
        $order_id = isset($request['order_id']) && $request['order_id'] ? $request['order_id'] : '';
        $tru_product = 0;
        $order = self::getInShopById($order_id,$user_id);
        if ($order) {
            if ($order->transport_id) {
                $claShipping = new ClaShipping();
                $claShipping->loadVendor(['method' => $order->transport_type]);
                switch ($order->transport_type) {
                    case ClaShipping::METHOD_GHN:
                        $options['data'] = array(
                            'OrderCode' => $order->transport_id
                        );
                        break;
                    default:
                        $options['data'] = array(
                            'OrderCode' => $order->transport_id
                        );
                        break;
                }
                $data = $claShipping->cancerOrder($options);
                if (isset($data['success']) && $data['success']) {
                    $status_old = $order->status;
                    if ($order->status > 1) {
                        $tru_product = true;
                    }
                    $order->status = 0;
                    if ($order->save()) {
                        if (\common\models\gcacoin\CoinConfinement::cancerShopOrder($order)) {
                            if ($tru_product) {
                                $order->setPromotion(0);
                            }
                            $data = [
                                'order_id' => $order_id,
                                'time' => time(),
                                'status' => 0,
                                'type' => $order->transport_type,
                                'content' => Yii::t('app', 'update_to_shop'),
                                'created_at' => time()
                            ];
                            $kt = \common\models\order\OrderShopHistory::saveData($data);
                            $sve = \common\models\notifications\Notifications::updateStatusOrderApi($order,$user_id);
                            $resonse['code'] = 1;
                            return $this->responseData($resonse);
                        } else {
                            $order->status = $status_old;
                            $order->save(false);
                            $resonse['code'] = 1;
                            return $this->responseData($resonse);
                        }
                    }
                }
            } else {
                if ($order->status == 1 || $order->status == 2 || $order->status == 3) {
                    $status_old = $order->status;
                    if ($order->status > 1) {
                        $tru_product = true;
                    }
                    $order->status = 0;
                    if ($order->save()) {
                        if (\common\models\gcacoin\CoinConfinement::cancerShopOrder($order)) {
                            if ($tru_product) {
                                $order->setPromotion(0);
                            }
                            $data = [
                                'order_id' => $order_id,
                                'time' => time(),
                                'status' => 0,
                                'type' => $order->transport_type,
                                'content' => Yii::t('app', 'update_to_shop'),
                                'created_at' => time()
                            ];
                            $kt = \common\models\order\OrderShopHistory::saveData($data);
                            $sve = \common\models\notifications\Notifications::updateStatusOrderApi($order,$user_id);
                            $resonse['code'] = 1;
                            return $this->responseData($resonse);
                        } else {
                            $order->status = $status_old;
                            $order->save(false);
                        }
                    }
                }
            }
        }

        $resonse['error'] = "Lỗi dữ liệu.";
        return $this->responseData($resonse);
    }

    //Danh sách, tìm kiếm sản phẩm
    function actionGetProducts()
    {
        $request = $this->getDataPost();
        $user_id = isset($request['user_id']) && $request['user_id'] ? $request['user_id'] : '';
        $limit = isset($request['limit']) && $request['limit'] ? $request['limit'] : 19;
        $page = isset($request['page']) && $request['page'] ? $request['page'] : 1;
        $status_quantity = isset($request['status_quantity']) && $request['status_quantity'] ? $request['status_quantity'] : '';
        $s = isset($request['s']) && $request['s'] ? $request['s'] : '';
        $resonse = $this->getResponse();
        if ($user_id != '') {
            $arr = [
                'shop_id' => $user_id,
                'limit' => $limit,
                'page' => $page,
                'status' => 0,
                'province_id' => '',
                'keyword' => $s,
            ];
            if ($status_quantity) {
                if ($status_quantity == 2) {
                    $status_quantity = 0;
                }
                $arr['status_quantity'] = $status_quantity;
            }
            $products = Product::getProduct(array_merge($_GET, $arr));

            $resonse['code'] = 1;
            $resonse['products'] = $products;
            $resonse['message'] = "Lấy thông tin thành công.";
        } else {
            $resonse['code'] = 0;
            $resonse['message'] = "Dữ liệu không hợp lệ";
        }
        return $this->responseData($resonse);
    }


    //Danh sách ảnh sản phẩm
    function actionGetProductImages()
    {
        $request = $this->getDataPost();
        $product_id = isset($request['product_id']) && $request['product_id'] ? $request['product_id'] : '';
        $resonse = $this->getResponse();
        $productImages = ProductImage::find()->where(['product_id' => $product_id])->all();
        if (!$product_id) {
            $resonse['code'] = 0;
            $resonse['message'] = "Dữ liệu không hợp lệ";
        } else {
            $resonse['code'] = 1;
            $resonse['data'] = $productImages;
        }

        return $this->responseData($resonse);
    }

    //Thêm mới sản phẩm
    function actionAddProduct()
    {
        $resonse = $this->getResponse();
        $post = $this->getDataPost();
        $model = new \common\models\product\Product();
        if ($model->load($post, '')) {
            $model->shop_id = $post['user_id'];
            if (!isset($_FILES['image0'])) {
                $model->validate();
                $resonse['error'] = "Lỗi dữ liệu.";
                $resonse['data'] = $model->errors;
                $resonse['data']['image'][] = 'Ảnh không được phép trống';
                return $this->responseData($resonse);
            }
            if ($model->save()) {
                \common\models\NotificationAdmin::addNotifcation('product');
                $avatar = null;
                $setavtar = isset($post['is_avatar']) ? $post['is_avatar'] : 0;
                $kt = 1;
                for ($i = 0; $i < 8; $i++) {
                    $name = 'image' . $i;
                    if (isset($_FILES[$name])) {
                        $data = $this->uploadImage($name, 'product');
                        if ($data['code'] == 1) {
                            $nimg = new \common\models\product\ProductImage();
                            $nimg->product_id = $model->id;
                            $nimg->attributes = $data['data'];
                            if ($setavtar == $i) {
                                $nimg->is_avatar = 1;
                            }
                            if ($nimg->save()) {
                                if ($setavtar) {
                                    if ($nimg->is_avatar == 1) {
                                        $avatar = $nimg->attributes;
                                    }
                                } else {
                                    if ($kt) {
                                        $avatar = $nimg->attributes;
                                        $kt = 0;
                                    }
                                }
                            }
                        }
                    }
                }
                if ($avatar) {
                    $model->avatar_path = $avatar['path'];
                    $model->avatar_name = $avatar['name'];
                    $model->avatar_id = $avatar['id'];
                    $model->save();
                }
                $resonse['data'] = $model;
                $resonse['code'] = 1;
                $resonse['message'] = "Lưu sản phẩm thành công.";
                return $this->responseData($resonse);
            } else {
                $resonse['data'] = $model->errors;
            }
        }
        $resonse['error'] = "Lỗi dữ liệu.";
        return $this->responseData($resonse);
    }

    //Cập nhật sản phẩm
    function actionUpdateProduct()
    {
        $resonse = $this->getResponse();
        $post = $this->getDataPost();
        if (isset($post['id']) && $post['id']) {
            $model = $this->findModelProduct($post['id']);
            if ($model->load($post, '')) {
                if ($model->save()) {
                    $avatar = null;
                    $setavtar = isset($post['is_avatar']) ? $post['is_avatar'] : 0;
                    $kt = 1;
                    if (isset($post['delava']) && $post['delava']) {
                        $imgs = \common\models\product\ProductImage::find()->where(['product_id' => $model->id, 'id' => $post['delava']])->all();
                        if ($imgs) foreach ($imgs as $img) {
                            $img->delete();
                        }
                    }
                    $images = ProductImage::find()->where(['product_id' => $model->id])->all();
                    $tol = 8 - count($images);
                    for ($i = 0; $i < $tol; $i++) {
                        $name = 'image' . $i;
                        if (isset($_FILES[$name])) {
                            $data = $this->uploadImage($name, 'product');
                            if ($data['code'] == 1) {
                                $nimg = new \common\models\product\ProductImage();
                                $nimg->attributes = $data['data'];
                                $nimg->product_id = $model->id;
                                if ($setavtar) {
                                    if ($setavtar == $i) {
                                        $nimg->is_avatar = 1;
                                    }
                                }
                                if ($nimg->save()) {
                                    $model->status = 2;
                                    \common\models\NotificationAdmin::addNotifcation('product');
                                    if ($setavtar) {
                                        if ($nimg->is_avatar) {
                                            $avatar = $nimg->attributes;
                                        }
                                    } else {
                                        if ($kt) {
                                            $avatar = $nimg->attributes;
                                            $kt = 0;
                                        }
                                    }
                                }
                            }
                        }
                    }


                    if ($avatar) {
                        $model->avatar_path = $avatar['path'];
                        $model->avatar_name = $avatar['name'];
                        $model->avatar_id = $avatar['id'];
                        $model->save();
                    } else {
                        if ($avatartg = \common\models\product\ProductImage::findOne($setavtar)) {
                            $model->avatar_path = $avatartg['path'];
                            $model->avatar_name = $avatartg['name'];
                            $model->avatar_id = $avatartg['id'];
                            $model->save();
                        } else {
                            if ($avatartg = \common\models\product\ProductImage::find()->where(['product_id' => $model->id])->one()) {
                                $model->avatar_path = $avatartg['path'];
                                $model->avatar_name = $avatartg['name'];
                                $model->avatar_id = $avatartg['id'];
                                $model->save();
                            }
                        }
                    }
                    $resonse['data'] = $model;
                    $resonse['code'] = 1;
                    $resonse['message'] = "Lưu sản phẩm thành công.";
                    return $this->responseData($resonse);
                } else {
                    $resonse['data'] = $model->errors;
                }
            }
        }
        $resonse['error'] = "Lỗi dữ liệu.";
        return $this->responseData($resonse);
    }

    //Xóa sản phẩm
    function actionDeleteProduct()
    {
        $resonse = $this->getResponse();
        $request = $this->getDataPost();
        $user_id = isset($request['user_id']) && $request['user_id'] ? $request['user_id'] : '';
        $product_id = isset($request['product_id']) && $request['product_id'] ? $request['product_id'] : '';
        $product = Product::findOne($product_id);
        if ($product && $product->shop_id == $user_id) {
            ProductImage::deleteAll(['product_id' => $product_id]);
            if ($product->delete()) {
                $resonse['code'] = 1;
            }
        }
        return $this->responseData($resonse);
    }

    //Danh sách, tìm kiếm mã giảm giá
    function actionCoupon()
    {
        $model = new DiscountCode();
        $resonse = $this->getResponse();
        $post = $this->getDataPost();
        $limit = isset($post['limit']) && $post['limit'] ? $post['limit'] : $model->default_limit;
        $page = isset($post['page']) && $post['page'] ? $post['page'] : 1;
        $user_id = isset($post['user_id']) && $post['user_id'] ? $post['user_id'] : '';
        $s = isset($post['s']) && $post['s'] ? $post['s'] : '';
        $get['status'] = '';
        $arr = [
            'shop_id' => $user_id,
            'status' => '',
            'keyword' => $s,
        ];
        $data = $model->getByAttr([
            'page' => $page,
            'limit' => $limit,
            'attr' => $arr,
            'order' => 'time_end DESC'
        ]);
        $item = \common\models\product\DiscountCode::loadShowAllApi($user_id);
        $res = [];

        foreach ($data as $tg) {
            $item->setAttributeShow($tg);
            $tg['products'] = $item->showProducts();
            $res[] = $tg;
        }


        $resonse['data'] = $res;
        if ($data) {
            $resonse['code'] = 1;
        }

        return $this->responseData($resonse);
    }

    //Thêm mã giảm giá
    function actionCreateCoupon()
    {
        $post = $this->getDataPost();
        $model = new DiscountShopCode();
        $resonse = $this->getResponse();
        if ($model->load($post, '')) {
            $model->time_start = strtotime($model->time_start);
            $model->time_end = strtotime($model->time_end);
            $model->status = 1;
            $model->shop_id = $post['user_id'];
            if ($model->all != 1) {
                if (isset($post['add']) && $post['add']) {
                    $model->products = implode(' ', $post['add']);
                } else {
                    $resonse['code'] = 0;
                }
            }
            if ($model->save()) {
                $resonse['code'] = 1;
            } else {
                $resonse['code'] = 0;
                $model->time_start = date('d-m-Y H:i', $model->time_start);
                $model->time_end = date('d-m-Y H:i', $model->time_end);
            }
        }


        return $this->responseData($resonse);
    }

    //Xóa mã giảm giá
    function actionDeleteCoupon()
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        $id = isset($post['id']) && $post['id'] ? $post['id'] : '';
        $user_id = isset($post['user_id']) && $post['user_id'] ? $post['user_id'] : '';
        $model = DiscountCode::find()->where(['id' => $id, 'shop_id' => $user_id])->one();
        if ($model) {
            $model->delete();
            $resonse['code'] = 1;
        } else {
            $resonse['code'] = 0;
        }
        return $this->responseData($resonse);
    }

    //Chi tiết shop
    function actionIndex()
    {
        $resonse = $this->getResponse();
        $resonse['code'] = 1;
        $request = $this->getDataPost();
        $user_id = isset($request['user_id']) && $request['user_id'] ? $request['user_id'] : '';
        //chi tiết shop
        $model = Shop::findOne($user_id);
        $res = $model->attributes;
        $res['type'] = Shop::getType($model->type);


        //tổng số sản phẩm shop
        $sum_product = \common\models\product\Product::find()->where(['shop_id' => $user_id])->count();

        //quy mô doanh nghiệp
        $scales = \common\models\shop\Shop::getScale();

        //Loại tài khoản gian hàng
        $tp = \common\models\shop\Shop::getOptionsTypeAcount();

        $resonse['data'] = $res;
        $resonse['total_products'] = $sum_product;
        $resonse['scales'] = $scales;
        $resonse['type_accounts'] = $tp;
        return $this->responseData($resonse);
    }

    //Danh sách ảnh của doanh nghiệp
    function actionImages()
    {
        $resonse = $this->getResponse();
        $resonse['code'] = 1;
        $request = $this->getDataPost();
        $user_id = isset($request['user_id']) && $request['user_id'] ? $request['user_id'] : '';
        $images = \common\models\shop\ShopImages::getImages($user_id);
        $resonse['data'] = $images;
        return $this->responseData($resonse);
    }

    //Cập nhật CHứng thực doanh nghiệp
    function actionUpdateShopAuth()
    {
        $resonse = $this->getResponse();
        $resonse['code'] = 1;
        $request = $this->getDataPost();
        $user_id = isset($request['user_id']) && $request['user_id'] ? $request['user_id'] : '';
        $model = Shop::findOne($user_id);
        if ($model->load($request, '')) {
            if ($model->save()) {
                if (isset($request['dels']) && $request['dels']) {
                    $imgs = \common\models\shop\ShopImages::find()->where(['shop_id' => $user_id, 'id' => $request['dels']])->all();
                    if ($imgs) foreach ($imgs as $img) {
                        $img->delete();
                    }
                }
                $images = \common\models\shop\ShopImages::getImageAuths($user_id);
                $tol = 10 - count($images);
                for ($i = 0; $i < $tol; $i++) {
                    $name = 'image' . $i;
                    if (isset($_FILES[$name])) {
                        $data = $this->uploadImage($name, 'shop');
                        if ($data['code'] == 1) {
                            $nimg = new \common\models\shop\ShopImages();
                            $nimg->attributes = $data['data'];
                            $nimg->shop_id = $user_id;
                            $nimg->type = \common\models\shop\Shop::IMG_AUTH;
                            $nimg->save();
                        }
                    } else {
                        break;
                    }
                }
                $resonse['code'] = 1;
                $resonse['message'] = "Lưu thành công.";
            } else {
                $resonse['data'] = $model->errors;
                $resonse['error'] = "Lỗi dữ liệu.";
            }
        }
        return $this->responseData($resonse);
    }

    //Chứng thực doanh nghiệp
    function actionShopAuth()
    {
        $resonse = $this->getResponse();
        $resonse['code'] = 1;
        $request = $this->getDataPost();
        $user_id = isset($request['user_id']) && $request['user_id'] ? $request['user_id'] : '';
        $model = Shop::findOne($user_id);
        $images = \common\models\shop\ShopImages::getImageAuths($user_id);
        $res = $model->attributes;
        $res['images'] = $images;
        $resonse['data'] = $res;
        return $this->responseData($resonse);
    }

    //Danh sách địa chỉ
    function actionAddress()
    {
        $resonse = $this->getResponse();
        $resonse['code'] = 1;
        $resonse['message'] = "Lấy thông tin thành công.";
        $resonse['data'] = \common\models\shop\ShopAddress::getByShop($this->shop->id);
        return $this->responseData($resonse);
    }

    //thêm, sửa địa chỉ
    function actionShopAddress()
    {
        $resonse = $this->getResponse();
        $request = $this->getDataPost();
        $user_id = isset($request['user_id']) && $request['user_id'] ? $request['user_id'] : '';
        $address_id = isset($request['address_id']) && $request['address_id'] ? $request['address_id'] : '';
        if ($address_id) {
            $model = ShopAddress::findOne($address_id);
            if (!$model || $model->shop_id != $user_id) {
                $resonse['error'] = "Lỗi dữ liệu.";
                return $this->responseData($resonse);
            }
        } else {
            $model = new \common\models\shop\ShopAddress();
        }
        if ($model->load($request, '')) {
            $model->shop_id = $user_id;
            $model->province_name = ($tg = \common\models\Province::findOne($model->province_id)) ? $tg['name'] : '';
            $model->district_name = ($tg = \common\models\District::findOne($model->district_id)) ? $tg['name'] : '';
            $model->ward_name = ($tg = \common\models\Ward::findOne($model->ward_id)) ? $tg['name'] : '';
            if ($model->phone_add) {
                if (is_array($model->phone_add)) {
                    $model->phone_add = implode(',', $model->phone_add);
                }
            }
            if ($model->isdefault) {
                \common\models\shop\ShopAddress::updateAll(
                    ['isdefault' => 0,],
                    [
                        'isdefault' => 1,
                        'shop_id' => $this->shop->id
                    ]
                );
                if ($model->save() && \common\models\shop\Shop::updateAddress($model)) {
                    $resonse['code'] = 1;
                    $resonse['message'] = "Lưu thành công.";
                    return $this->responseData($resonse);
                }
            } else {
                if ($model->save()) {
                    $resonse['code'] = 1;
                    $resonse['message'] = "Lưu thành công.";
                    return $this->responseData($resonse);
                }
            }
            $resonse['data'] = $model->errors;
        }
        $resonse['error'] = "Lỗi dữ liệu.";
        return $this->responseData($resonse);
    }

    //Xóa địa chỉ
    function actionDeleteAddress()
    {
        $resonse = $this->getResponse();
        $request = $this->getDataPost();
        $user_id = isset($request['user_id']) && $request['user_id'] ? $request['user_id'] : '';
        $address_id = isset($request['address_id']) && $request['address_id'] ? $request['address_id'] : '';
        if ($model = ShopAddress::findOne($address_id)) {
            if (!$model->isdefault && $model->shop_id == $user_id) {
                $model->delete();
                $resonse['code'] = 1;
                $resonse['message'] = 'Xóa thành công';
            } else {
                $resonse['code'] = 0;
                $resonse['error'] = "Lỗi dữ liệu.";
            }
        }
        return $this->responseData($resonse);
    }

    //Affiliate
    function actionAffiliate()
    {
        $resonse = $this->getResponse();
        $request = $this->getDataPost();
        $user_id = isset($request['user_id']) && $request['user_id'] ? $request['user_id'] : '';
        $model = Shop::find()->where(['user_id' => $user_id])->asArray()->one();
        $productalls = Product::find()->where(['shop_id' => $user_id])->all();
        $products = [];
        $product_ns = [];
        if ($productalls) foreach ($productalls as $item) {
            if ($item->status_affiliate == 1) {
                $products[] = $item;
            } else {
                $product_ns[] = $item;
            }
        }
        $model['products'] = $products;
        $model['product_no_affiliate'] = $product_ns;
        $resonse['data'] = $model;
        $resonse['code'] = 1;
        return $this->responseData($resonse);
    }

    //Cập nhật affiliate
    function actionUpdateAffiliate()
    {
        $resonse = $this->getResponse();
        $request = $this->getDataPost();
        $user_id = isset($request['user_id']) && $request['user_id'] ? $request['user_id'] : '';
        $list = isset($request['product_ids']) && $request['product_ids'] ? $request['product_ids'] : [];
        $model = Shop::findOne($user_id);
        if ($model->load($request, '')) {
            if ($model->status_affiliate != $model->status_affiliate_waitting || $model->affiliate_admin != $model->affiliate_admin_waitting || $model->affiliate_gt_shop != $model->affiliate_gt_shop_waitting || $model->affilliate_status_service != $model->affilliate_status_service_waitting) {
                $model->affiliate_waitting = 1;
            }
            if ($model->affiliate_waitting) {
                if ($model->save()) {
                    $resonse['code'] = 1;
                } else {
                    $resonse['code'] = 0;
                    $resonse['error'] = $model->getErrors();
                }
            }

            //Lưu sản phẩm
            $datas = [];
            foreach ($list as $key => $item) {
                if (isset($item['id']) && $item['id'] == 1) {
                    $product = \common\models\product\Product::find()->where(['id' => $key, 'shop_id' => $user_id])->one();
                    if ($product) {
                        $product->status_affiliate = 1;
                        $product->affiliate_gt_product = isset($item['affiliate_gt_product']) && $item['affiliate_gt_product'] ? $item['affiliate_gt_product'] : 0;
                        $product->affiliate_m_v = isset($item['affiliate_m_v']) && $item['affiliate_m_v'] ? $item['affiliate_m_v'] : 0;
                        $product->affiliate_charity = isset($item['affiliate_charity']) && $item['affiliate_charity'] ? $item['affiliate_charity'] : 0;
                        $product->affiliate_safe = isset($item['affiliate_safe']) && $item['affiliate_safe'] ? $item['affiliate_safe'] : 0;
                        if ($product->checkAffiliate()) {
                            $datas[] = $product;
                        } else {
                            $resonse['code'] = 0;
                        }
                    } else {
                        $resonse['code'] = 0;
                        $resonse['error'] = "Lỗi dữ liệu.";
                    }
                }
            }
            if ($datas) {
                foreach ($datas as $item) {
                    $item->save();
                }
                $resonse['code'] = 1;
            }
        }
        return $this->responseData($resonse);
    }

    //Cập nhật chi tiết sản phẩm trong affiliate
    function actionUpdateProductAffiliate()
    {
        $resonse = $this->getResponse();
        $request = $this->getDataPost();
        $user_id = isset($request['user_id']) && $request['user_id'] ? $request['user_id'] : '';
        $product_id = isset($request['product_id']) && $request['product_id'] ? $request['product_id'] : '';
        $delete = isset($request['delete']) && $request['delete'] ? $request['delete'] : '';

        if ($product_id) {
            $product = \common\models\product\Product::find()->where(['id' => $product_id, 'shop_id' => $user_id])->one();
            if ($product) {
                if ($delete == 1) {
                    $product->status_affiliate = 0;
                } else {
                    $product->status_affiliate = 1;
                }
                $product->affiliate_gt_product = isset($request['affiliate_gt_product']) && $request['affiliate_gt_product'] ? $request['affiliate_gt_product'] : $product->affiliate_gt_product;
                $product->affiliate_m_v = isset($request['affiliate_m_v']) && $request['affiliate_m_v'] ? $request['affiliate_m_v'] : $product->affiliate_m_v;
                $product->affiliate_charity = isset($request['affiliate_charity']) && $request['affiliate_charity'] ? $request['affiliate_charity'] : $product->affiliate_charity;
                $product->affiliate_safe = isset($request['affiliate_safe']) && $request['affiliate_safe'] ? $request['affiliate_safe'] : $product->affiliate_safe;
                if ($product->save()) {
                    $resonse['code'] = 1;
                    return $this->responseData($resonse);
                } else {
                    $resonse['code'] = 0;
                    $resonse['error'] = $product->getErrors();
                }
            }
        }
        $resonse['error'] = 'Dữ liệu không hợp lệ';
        return $this->responseData($resonse);
    }

    //Hủy cập nhật affiliate
    public function actionCancerChange()
    {
        $resonse = $this->getResponse();
        $request = $this->getDataPost();
        $user_id = isset($request['user_id']) && $request['user_id'] ? $request['user_id'] : '';
        $model = Shop::findOne($user_id);
        if ($model) {
            $model->affiliate_waitting = 0;
            $model->affiliate_gt_shop_waitting = 0;
            $model->affiliate_admin_waitting = 0;
            $model->status_affiliate_waitting = 0;
            if ($model->save(false)) {
                $resonse['code'] = 1;
            } else {
                $resonse['code'] = 0;
            }
        }

        return $this->responseData($resonse);
    }

    //QrCode dịch vụ affiliate
    function actionService(){
        $resonse = $this->getResponse();
        $request = $this->getDataPost();
        $user_id = isset($request['user_id']) && $request['user_id'] ? $request['user_id'] : '';
        $model = Shop::find()->where(['user_id' => $user_id])->asArray()->one();
        $productalls = Product::find()->where(['shop_id' => $user_id])->all();
        $products = [];
        $product_ns = [];
        if ($productalls) foreach ($productalls as $item) {
            if ($item->status_affiliate == 1) {
                $products[] = $item;
            } else {
                $product_ns[] = $item;
            }
        }

        $src = '';
        if ($model['affilliate_status_service']) {
            $data = [
                'type' => 'user_service',
                'data' => [
                    'user_id' => $user_id
                ]
            ];
            $src = \common\components\ClaQrCode::GenQrCode($data);
        }

        $model['products'] = $products;
        $model['product_no_service'] = $product_ns;
        $resonse['data'] = $model;
        $resonse['code'] = 1;
        $resonse['src'] = $src;
        return $this->responseData($resonse);
    }

    public function actionSaveService()
    {
        $resonse = $this->getResponse();
        $request = $this->getDataPost();
        $user_id = isset($request['user_id']) && $request['user_id'] ? $request['user_id'] : '';
        if (isset($request['product_ids'])) {
            $list = $request['product_ids'];
            $status = isset($request['status']) && $request['status'] ? 1 : 0;
            foreach ($list as $key => $item) {
                if (isset($item['id']) && $item['id'] == 1) {
                    $product = \common\models\product\Product::find()->where(['id' => $key, 'shop_id' => $user_id])->one();
                    $shop = \common\models\shop\Shop::findOne($user_id);
                    if ($product && $shop) {
                        if ($product->pay_servive != 1) {
                            $product->affiliate_charity = $item['affiliate_charity'];
                            $product->affiliate_safe = $item['affiliate_safe'];
                        }
                        $product->status_affiliate = 1;
                        $product->pay_servive = 1;
                        $product->affiliate_gt_product = $item['affiliate_gt_product'];
                        $product->affiliate_m_v = $item['affiliate_m_v'];
                        if ($shop->affilliate_status_service != $status) {
                            $shop->affilliate_status_service = $status;
                            if (!$shop->save()) {
                                return $this->responseData($resonse);
                            }
                        }
                        if ($product->checkAffiliate() && $product->save()) {
                            $pr = \common\models\product\Product::updateAll(['pay_servive' => 0], "pay_servive = 1 AND shop_id = " . $user_id . ' AND id !=' . $product->id);
                            $src = '';
                            if ($shop->affilliate_status_service) {
                                $data = [
                                    'type' => 'user_service',
                                    'data' => [
                                        'user_id' => $user_id
                                    ]
                                ];
                                $src = \common\components\ClaQrCode::GenQrCode($data);
                            }
                            $resonse['code'] = 1;
                            $resonse['src'] = $src;
                            return $this->responseData($resonse);
                        }
                    }
                }
            }
        }
        return $this->responseData($resonse);
    }
}
