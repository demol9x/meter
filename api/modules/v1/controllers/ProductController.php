<?php
/**
 * Created by trungduc.vnu@gmail.com.
 */


namespace api\modules\v1\controllers;

use common\models\order\Order;
use common\models\order\OrderItem;
use common\models\product\Brand;
use common\models\product\Product;
use common\models\product\ProductAttribute;
use common\models\product\ProductAttributeItem;
use common\models\product\ProductImage;
use common\models\product\ProductTopsearch;
use common\models\product\ProductVariables;
use common\models\product\ProductWish;
use common\models\user\UserAddress;
use common\models\voucher\Voucher;
use frontend\models\User;
use Yii;
use api\components\RestController;
use common\models\product\ProductCategory;
use yii\db\Exception;

class ProductController extends RestController
{
    public function actionCategory()
    {
        $request = Yii::$app->getRequest()->get();
        $type = (isset($request['type']) && $request['type']) ? $request['type'] : '';
        if ($type == 'hot') {
            $data = ProductCategory::find()->where(['isnew' => 1, 'status' => 1])->orderBy('order, id desc')->all();
        } else {
            $data = ProductCategory::find()->where(['show_in_home' => 1])->orderBy('order ASC')->all();
        }
        return $this->responseData([
            'success' => true,
            'data' => $data
        ]);
    }

    public function actionTrademark()
    {
        $data = Brand::getListBrand();
        return $this->responseData([
            'success' => true,
            'data' => $data
        ]);
    }

    public function actionHome()
    {
        $request = Yii::$app->getRequest()->getBodyParams();
        $limit = (isset($request['limit']) && $request['limit']) ? $request['limit'] : 6;
        $user_id = (isset($request['user_id']) && $request['user_id']) ? $request['user_id'] : '';
        $products = Product::find()->where(['isnew' => 1, 'status' => 1])->limit($limit)->orderBy('order ASC')->asArray()->all();
        $data = [];
        if ($products) {
            if ($user_id) {
                $wishlist = ProductWish::find()->where(['user_id' => $user_id])->asArray()->all();
                $wishlist = array_column($wishlist, 'product_id', 'id');
            }
            foreach ($products as $product) {
                if (isset($wishlist) && $wishlist) {
                    if (in_array($product['id'], $wishlist)) {
                        $product['is_wish'] = true;
                    } else {
                        $product['is_wish'] = false;
                    }
                } else {
                    $product['is_wish'] = false;
                }
                $data[] = $product;
            }
        }
        return $this->responseData([
            'success' => true,
            'data' => $data
        ]);
    }

    public function actionIndex()
    {
        $request = Yii::$app->getRequest()->getBodyParams();
        $user_id = (isset($request['user_id']) && $request['user_id']) ? $request['user_id'] : '';
        $products = Product::getProduct($request);
        $data = [];
        if ($products) {
            if ($user_id) {
                $wishlist = ProductWish::find()->where(['user_id' => $user_id])->asArray()->all();
                $wishlist = array_column($wishlist, 'product_id', 'id');
            }
            foreach ($products as $product) {
                if (isset($wishlist) && $wishlist) {
                    if (in_array($product['id'], $wishlist)) {
                        $product['is_wish'] = true;
                    } else {
                        $product['is_wish'] = false;
                    }
                } else {
                    $product['is_wish'] = false;
                }
                $data[] = $product;
            }
        }
        return $this->responseData([
            'success' => true,
            'data' => $data
        ]);
    }

    public function actionDetail()
    {
        $request = Yii::$app->getRequest()->getBodyParams();
        $user_id = (isset($request['user_id']) && $request['user_id']) ? $request['user_id'] : '';
        $product_id = (isset($request['product_id']) && $request['product_id']) ? $request['product_id'] : '';
        $product = Product::findOne($product_id);
        $message = '';
        $errors = [];
        if ($product) {
            $data = $product->attributes;
            $attrs = [];
            if ($product->product_attributes) {
                $attributes = json_decode($product->product_attributes);
                foreach ($attributes as $key => $attribute) {
                    $product_attribute = ProductAttribute::findOne($key);
                    if ($product_attribute) {
                        $attr = $product_attribute->attributes;
                        $item_ids = [];
                        foreach ($attribute as $value) {
                            $item = explode('~', $value);
                            $item_ids[] = $item[1];
                        }
                        $attr['items'] = ProductAttributeItem::find()->where(['id' => $item_ids])->asArray()->all();
                        $attrs[] = $attr;
                    }
                }
            }
            $data['attributes'] = $attrs;

            $data['images'] = ProductImage::find()->where(['product_id' => $product_id])->asArray()->all();

            $related = Product::find()->where(['category_id' => $product->category_id, 'status' => 1])->andWhere(['<>', 'id', $product_id])->limit(12)->asArray()->all();

            if ($related) {
                if ($user_id) {
                    $wishlist = ProductWish::find()->where(['user_id' => $user_id])->asArray()->all();
                    $wishlist = array_column($wishlist, 'product_id', 'id');
                }

                foreach ($related as $rel) {
                    if (isset($wishlist) && $wishlist) {
                        if (in_array($rel['id'], $wishlist)) {
                            $rel['is_wish'] = true;
                        } else {
                            $rel['is_wish'] = false;
                        }
                    } else {
                        $rel['is_wish'] = false;
                    }
                    $data['related'][] = $rel;
                }
            }
            return $this->responseData([
                'success' => true,
                'data' => $data,
                'message' => $message,
                'errors' => $errors
            ]);

        } else {
            $message = 'S???n ph???m kh??ng t???n t???i';
        }
        return $this->responseData([
            'success' => false,
            'message' => $message,
            'errors' => $errors
        ]);
    }

    public function actionProductVariable()
    {
        $request = Yii::$app->getRequest()->getBodyParams();
        $product_id = (isset($request['product_id']) && $request['product_id']) ? $request['product_id'] : '';
        $attribute = (isset($request['attribute']) && $request['attribute']) ? $request['attribute'] : [];
        $product = Product::findOne($product_id);
        $message = '';
        $errors = [];
        if ($product) {
            $data = $product->attributes;
            $data['attributes'] = [];
            if ($attribute) {
                sort($attribute);
                $key = $product->setKeyVariable($attribute);
                $product_variable = ProductVariables::find()->where(['key' => $key, 'product_id' => $product_id])->one();
                $data['attributes'] = $product_variable;
            }

            return $this->responseData([
                'success' => true,
                'data' => $data,
                'message' => $message,
                'errors' => $errors
            ]);

        } else {
            $message = 'S???n ph???m kh??ng t???n t???i';
        }
        return $this->responseData([
            'success' => false,
            'message' => $message,
            'errors' => $errors
        ]);
    }

    public function actionVoucher()
    {
        $request = Yii::$app->getRequest()->getBodyParams();
        $product_ids = (isset($request['product_ids']) && $request['product_ids']) ? $request['product_ids'] : '';
        $code = (isset($request['code']) && $request['code']) ? $request['code'] : '';
        $user_id = isset($request['user_id']) && $request['user_id'] ? $request['user_id'] : '';
        $auth_key = isset($request['auth_key']) && $request['auth_key'] ? $request['auth_key'] : '';
        $money = isset($request['money']) && $request['money'] ? $request['money'] : 0;
        $message = '';
        $errors = [];
        $user = User::findOne($user_id);
        if ($user && $user->auth_key == $auth_key) {
            $check = Voucher::checkValidate($code, $money, $product_ids);
            if ($check) {
                return $this->responseData([
                    'success' => true,
                    'data' => $check->attributes,
                    'message' => 'M?? c??n hi???u l???c',
                    'errors' => $errors
                ]);
            } else {
                $message = 'M?? kh??ng c??n hi???u l???c s??? d???ng';
            }
        } else {
            $message = 'B???n ph???i ????ng nh???p ????? th???c hi???n h??nh ?????ng n??y';
        }


        return $this->responseData([
            'success' => false,
            'message' => $message,
            'errors' => $errors
        ]);
    }

    function actionGetTranposts()
    {
        $resonse = [];
        $transports = \common\models\transport\Transport::getAll();
        $resonse['data'] = $transports ? $transports : [];
        $resonse['message'] = "L???y danh s??ch ????n v??? giao h??ng th??nh c??ng.";
        $resonse['success'] = true;
        return $this->responseData($resonse);
    }

    function actionGetCostTranpostByProduct()
    {
//        $post = Yii::$app->getRequest()->getBodyParams();
//        $resonse = [
//            'success' => false
//        ];
//        if ($post) {
//            foreach ($post as $shop_id => $add) {
//                if (isset($add['f_district']) && $add['f_district']) {
//                    $cost = \frontend\components\Transport::getCostTransportApi($add);
//                    $resonse['data'][$shop_id] = $cost;
//                } else {
//                    $resonse['error'] = "L???i d??? li???u.";
//                    return $this->responseData($resonse);
//                }
//            }
//            $resonse['message'] = "L???y ph?? v???n chuy???n th??nh c??ng.";
//            $resonse['success'] = true;
//            return $this->responseData($resonse);
//        }
//        $resonse['error'] = "L???i d??? li???u.";
//        return $this->responseData($resonse);
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

    function actionGetOptionPayments()
    {
        $resonse['data'] = [
            '2' => 'Th??nh to??n b???ng ti???n m???t khi nh???n h??ng (COD)'
        ];
        $resonse['message'] = "L???y danh s??ch h??nh th???c thanh to??n th??nh c??ng";
        $resonse['success'] = true;
        return $this->responseData($resonse);
    }

    public function actionAddOrder()
    {
        $request = Yii::$app->getRequest()->getBodyParams();
        $products = (isset($request['products']) && $request['products']) ? $request['products'] : '';
        $user_id = isset($request['user_id']) && $request['user_id'] ? $request['user_id'] : '';
        $auth_key = isset($request['auth_key']) && $request['auth_key'] ? $request['auth_key'] : '';
        $address_id = isset($request['address_id']) && $request['address_id'] ? $request['address_id'] : '';
        $payment_method = isset($request['payment_method']) && $request['payment_method'] ? $request['payment_method'] : '';
        $discount_code = isset($request['discount_code']) && $request['discount_code'] ? $request['discount_code'] : '';

        $transaction = Yii::$app->db->beginTransaction();
        $total = 0;
        $product_ids = [];
        $message = '';
        $errors = [];
        try {
            $user = User::findOne($user_id);
            if ($user && $user->auth_key == $auth_key) {
                $model = new Order();
                if ($payment_method) {
                    $model->payment_method = $payment_method;
                } else {
                    return $this->responseData([
                        'success' => false,
                        'message' => 'H??nh th???c thanh to??n kh??ng ???????c b??? tr???ng',
                        'errors' => $errors
                    ]);
                }
                $model->payment_status = \common\components\payments\ClaPayment::PAYMENT_STATUS_WAITING;
                $address = UserAddress::findOne($address_id);
                if ($address) {
                    $model->user_id = $user_id;
                    $model->email = $address->email ? trim($address->email) : '';
                    $model->name = $address->name_contact;
                    $model->phone = $address->phone;
                    $model->address = $address->address . '(' . $address->ward_name . ', ' . $address->district_name . ', ' . $address->province_name . ')';
                    $model->province_id = $address->province_id;
                    $model->district_id = $address->district_id;
                    $model->ward_id = $address->ward_id;
                    $model->status = 1;
                } else {
                    return $this->responseData([
                        'success' => false,
                        'message' => '?????a ch??? giao h??ng kh??ng ???????c b??? tr???ng',
                        'errors' => $errors
                    ]);
                }

                $model->key = \common\components\ClaGenerate::getUniqueCode();
                if ($products) {
                    foreach ($products as $product) {
                        if (isset($product['id']) && isset($product['quantity']) && $product['id'] > 0 && $product['quantity'] > 0) {
                            $prd = Product::findOne($product['id']);
                            if (!$prd) {
                                return $this->responseData([
                                    'success' => false,
                                    'errors' => [],
                                    'message' => 'S???n ph???m kh??ng t???n t???i ho???c kh??ng c??n kinh doanh'
                                ]);
                            }
                            $product_ids[] = $product['id'];
                            $model_item = new OrderItem();
                            $model_item->price = $prd->price;
                            $model_item->name = $prd->name;
                            $model_item->avatar_path = $prd->avatar_path;
                            $model_item->avatar_name = $prd->avatar_name;
                            if (isset($product['variable_id']) && $product['variable_id']) {
                                $variable = ProductVariables::findOne($product['variable_id']);
                                if ($variable && $variable->product_id == $prd->id) {
                                    $model_item->product_variable_id = $product['variable_id'];
                                    $model_item->price = $variable->price ? $variable->price : $prd->price;
                                    $model_item->name = $variable->name ? $variable->name : $prd->name;
                                    $model_item->avatar_path = $variable->avatar_path ? $variable->avatar_path : $prd->avatar_path;
                                    $model_item->avatar_name = $variable->avatar_name ? $variable->avatar_name : $prd->avatar_name;
                                }
                            }
                            $model_item->product_id = $product['id'];
                            $model_item->quantity = $product['quantity'];
                            $model_item->status = 1;
                            if ($model->save()) {
                                $model_item->order_id = $model->id;
                                if ($model_item->save()) {
                                    $total += $model_item->quantity * $model_item->price;
                                } else {
                                    return $this->responseData([
                                        'success' => false,
                                        'errors' => $model_item->getErrors(),
                                        'message' => 'T???o ????n h??ng th???t b???i'
                                    ]);
                                }

                            } else {
                                return $this->responseData([
                                    'success' => false,
                                    'errors' => $model->getErrors(),
                                    'message' => 'T???o ????n h??ng th???t b???i'
                                ]);
                            }

                        } else {
                            return $this->responseData([
                                'success' => false,
                                'message' => 'L???i th??ng tin s???n ph???m',
                                'errors' => $errors
                            ]);
                        }
                    }
                    $model->order_total = $total;
                    if ($discount_code) {
                        $voucher = Voucher::checkValidate($discount_code, $total, implode(',', $product_ids));
                        if ($voucher) {
                            $model->discount_code_id = $voucher->id;
                        } else {
                            OrderItem::deleteAll(['order_id' => $model->id]);
                            return $this->responseData([
                                'success' => false,
                                'message' => 'M?? gi???m gi?? kh??ng c??n hi???u l???c s??? d???ng',
                                'errors' => $errors
                            ]);
                        }
                    }
                    $model->save();

                } else {
                    return $this->responseData([
                        'success' => false,
                        'message' => 'Kh??ng c?? th??ng tin s???n ph???m',
                        'errors' => $errors
                    ]);
                }


            } else {
                $message = 'B???n ph???i ????ng nh???p ????? th???c hi???n h??nh ?????ng n??y';
            }
            $transaction->commit();
            return $this->responseData([
                'success' => true,
                'data' => $model->attributes,
                'errors' => [],
                'message' => 'T???o ????n h??ng th??nh c??ng'
            ]);

        } catch (Exception $e) {
            $transaction->rollBack();
//            return $this->responseData([
//                'success' => false,
//                'message' => $message,
//                'errors' => $errors
//            ]);
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
//            return $this->responseData([
//                'success' => false,
//                'message' => $message,
//                'errors' => $errors
//            ]);
            throw $e;
        }

    }

    public function actionOrder()
    {
        $request = Yii::$app->getRequest()->getBodyParams();
        $user_id = isset($request['user_id']) && $request['user_id'] ? $request['user_id'] : '';
        $auth_key = isset($request['auth_key']) && $request['auth_key'] ? $request['auth_key'] : '';
        $limit = isset($request['limit']) && $request['limit'] ? $request['limit'] : 20;
        $page = isset($request['page']) && $request['page'] ? $request['page'] : 1;
        $status = isset($request['status']) && $request['status'] ? $request['status'] : Order::ORDER_WAITING_PROCESS;
        $user = User::findOne($user_id);
        $errors = [];
        $message = '';
        if ($user && $user->auth_key == $auth_key) {
            $response = [];
            $orders = Order::find()->where(['order.status' => $status, 'order.user_id' => $user_id])
                ->joinWith(['items','voucher'])
                ->limit($limit)
                ->offset(($page - 1) * $limit)->asArray()->all();
            return $this->responseData([
                'success' => true,
                'data' => $orders,
                'errors' => [],
                'message' => 'L???y danh s??ch ????n h??ng th??nh c??ng'
            ]);
        } else {
            $message = 'B???n ph???i ????ng nh???p ????? th???c hi???n h??nh ?????ng n??y';
        }

        return $this->responseData([
            'success' => false,
            'message' => $message,
            'errors' => $errors
        ]);

    }

    public function actionTopSearch()
    {
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

    public function actionLike()
    {
        $request = Yii::$app->getRequest()->getBodyParams();
        $user_id = isset($request['user_id']) && $request['user_id'] ? $request['user_id'] : '';
        $auth_key = isset($request['auth_key']) && $request['auth_key'] ? $request['auth_key'] : '';
        $product_id = isset($request['product_id']) && $request['product_id'] ? $request['product_id'] : '';
        $message = '';
        $errors = [];

        $user = User::findOne($user_id);
        if ($user && $user->auth_key == $auth_key) {
            $product_wish = ProductWish::find()->where(['user_id' => $user_id, 'product_id' => $product_id])->one();
            if ($product_wish) {
                if ($product_wish->delete()) {
                    return $this->responseData([
                        'success' => true,
                        'errors' => $errors,
                        'message' => 'B??? y??u th??ch th??nh c??ng'
                    ]);
                } else {
                    $errors = $product_wish->getErrors();
                }
            } else {
                $product_wish = new ProductWish();
                $product_wish->user_id = $user_id;
                $product_wish->product_id = $product_id;
                if ($product_wish->save()) {
                    return $this->responseData([
                        'success' => true,
                        'errors' => $errors,
                        'message' => 'Th??m v??o danh s??ch y??u th??ch th??nh c??ng'
                    ]);
                } else {
                    $errors = $product_wish->getErrors();
                }
            }
        } else {
            $message = 'B???n ph???i ????ng nh???p ????? th???c hi???n h??nh ?????ng n??y.';
        }

        return $this->responseData([
            'success' => false,
            'errors' => $errors,
            'message' => $message
        ]);
    }

    protected function verbs()
    {
        return [
            'category' => ['get'],
            'trademark' => ['get'],
            'home' => ['post'],
            'detail' => ['post'],
            'product-variable' => ['post'],
            'get-tranposts' => ['get'],
            'get-cost-tranpost-by-product' => ['post'],
        ];
    }
}