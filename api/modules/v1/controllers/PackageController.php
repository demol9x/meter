<?php
/**
 * Created by PhpStorm.
 * User: hungtm
 * Date: 11/17/2018
 * Time: 10:25 AM
 */

namespace api\modules\v1\controllers;

use common\components\ClaGenerate;
use common\components\ClaMeter;
use common\models\package\Package;
use common\models\package\PackageImage;
use common\models\package\PackageOrder;
use common\models\package\PackageWish;
use common\models\shop\Shop;
use frontend\models\User;
use Yii;
use api\components\RestController;
use yii\web\UploadedFile;


/**
 *
 */
class PackageController extends RestController
{

    public function actionIndex()
    {
        $request = Yii::$app->getRequest()->getBodyParams();
        $limit = isset($request['limit']) && $request['limit'] ? $request['limit'] : 20;
        $page = isset($request['page']) && $request['page'] ? $request['page'] : 1;
        $s = isset($request['s']) && $request['s'] ? $request['s'] : '';
        $user_id = isset($request['user_id']) && $request['user_id'] ? $request['user_id'] : '';
        $lat = isset($request['lat']) && $request['lat'] ? $request['lat'] : '';
        $lng = isset($request['lng']) && $request['lng'] ? $request['lng'] : '';
        $province_id = isset($request['province_id']) && $request['province_id'] ? $request['province_id'] : '';
        $price_min = isset($request['price_min']) && $request['price_min'] ? $request['price_min'] : '';
        $price_max = isset($request['price_max']) && $request['price_max'] ? $request['price_max'] : '';
        $distance = isset($request['distance']) && $request['distance'] ? $request['distance'] : '';
        $response = [];

        $packages = Package::getPackage([
            'limit' => $limit,
            'page' => $page,
            'lat' => $lat,
            'lng' => $lng,
            's' => $s,
            'province_id' => $province_id,
            'price_min' => $price_min,
            'price_max' => $price_max,
            'distance' => $distance,
        ]);

        if (isset($packages['data']) && $packages['data']) {
            $package_wish = PackageWish::find()->where(['user_id' => $user_id])->asArray()->all();
            $package_wish = array_column($package_wish, 'package_id', 'id');
            foreach ($packages['data'] as $package) {
                if (in_array($package['id'], $package_wish)) {
                    $package['is_wish'] = true;
                } else {
                    $package['is_wish'] = false;
                }
                if ($lat && $lng) {
                    $package['km'] = (int)ClaMeter::betweenTwoPoint($lat, $lng, $package['lat'], $package['long']) . 'km';
                } else {
                    $package['km'] = '';
                }
                $response[] = $package;
            }
        }


        return $this->responseData([
            'success' => true,
            'package' => $response
        ]);
    }

    public function actionDetail()
    {
        $message = '';
        $errors = [];
        $request = Yii::$app->getRequest()->getBodyParams();
        $user_id = isset($request['user_id']) && $request['user_id'] ? $request['user_id'] : '';
        $package_id = isset($request['package_id']) && $request['package_id'] ? $request['package_id'] : '';
        $lat = isset($request['lat']) && $request['lat'] ? $request['lat'] : '';
        $lng = isset($request['lng']) && $request['lng'] ? $request['lng'] : '';
        $package = Package::findOne($package_id);
        if ($package) {
            $data = $package->attributes;

            //Check ???? ????ng k?? d??? th???u hay ch??a
            if ($user_id) {
                $check = PackageOrder::find()->where(['shop_id' => $user_id,'package_id' => $package_id])->one();
                if ($check) {
                    $data['check_bid'] = true;
                } else {
                    $data['check_bid'] = false;
                }
            }

            //S?? ????ng k?? d??? th???u
            $count = PackageOrder::find()->where(['package_id' => $package_id])->count();
            $data['count'] = $count;

            //Kho???ng c??ch
            $data['km'] = '';
            if ($lat && $lng) {
                $data['km'] = (int)ClaMeter::betweenTwoPoint($lat, $lng, $package['lat'], $package['long']) . 'km';
            }
            //???nh
            $data['images'] = PackageImage::find()->where(['package_id' => $package_id])->asArray()->all();

            //Nh?? th???u
            $shop = Shop::find()->where(['user_id' => $package->shop_id])->joinWith(['province', 'district', 'ward'])->asArray()->one();
            $data['shop'] = $shop;

            //G??i th???u kh??c
            $package_related = Package::find()->where(['shop_id' => $package->shop_id, 'status' => 1])->andWhere(['<>', 'package.id', $package_id])->joinWith(['province'])->asArray()->all();
            $related = [];
            if ($package_related) {
                $package_wish = PackageWish::find()->where(['user_id' => $user_id])->asArray()->all();
                $package_wish = array_column($package_wish, 'package_id', 'id');
                foreach ($package_related as $value) {
                    if (in_array($value['id'], $package_wish)) {
                        $value['is_wish'] = true;
                    } else {
                        $value['is_wish'] = false;
                    }
                    if ($lat && $lng) {
                        $value['km'] = (int)ClaMeter::betweenTwoPoint($lat, $lng, $value['lat'], $value['long']) . 'km';
                    } else {
                        $value['km'] = '';
                    }
                    $related[] = $value;
                }
            }
            $data['related'] = $related;
            return $this->responseData([
                'success' => true,
                'data' => $data,
                'errors' => $errors,
                'message' => $message
            ]);
        } else {
            $message = 'G??i th???u kh??ng t???n t???i';
        }

        return $this->responseData([
            'success' => false,
            'errors' => $errors,
            'message' => $message
        ]);
    }

    public function actionBid()
    {
        $request = Yii::$app->getRequest()->getBodyParams();
        $user_id = isset($request['user_id']) && $request['user_id'] ? $request['user_id'] : '';
        $auth_key = isset($request['auth_key']) && $request['auth_key'] ? $request['auth_key'] : '';
        $package_id = isset($request['package_id']) && $request['package_id'] ? $request['package_id'] : '';
        $message = '';
        $errors = [];

        $user = User::findOne($user_id);
        if ($user && $user->auth_key == $auth_key) {
            if ($user->type == User::TYPE_DOANH_NGHIEP) {
                $package = Package::findOne($package_id);
                if ($package && $package->shop_id != $user_id) {
                    $check = PackageOrder::find()->where(['shop_id' => $user_id,'package_id' => $package_id])->one();
                    if (!$check) {
                        $order = new PackageOrder();
                        $order->load($request, '');
                        $order->shop_id = $user_id;
                        $order->shop_package_id = $package->shop_id;

                        $uploads = UploadedFile::getInstancesByName("attachment");
                        if (empty($uploads)) {
                        } else {
                            $file = $uploads[0];
                            $ext = pathinfo($file, PATHINFO_EXTENSION);
                            $path = Yii::getAlias('@rootpath') . '/static/media/files/package/' . ClaGenerate::getUniqueCode() . '.' . $ext;
                            $file->saveAs($path);
                            $order->attachment = '/media/files/tho/' . ClaGenerate::getUniqueCode() . '.' . $ext;
                        }

                        if ($order->save()) {
                            return $this->responseData([
                                'success' => true,
                                'data' => $order,
                                'errors' => $errors,
                                'message' => $message
                            ]);
                        } else {
                            $errors = $order->getErrors();
                        }
                    } else {
                        $message = 'B???n ???? ????ng k?? d??? th???u r???i';
                    }

                } else {
                    $message = 'B???n kh??ng th??? ?????u t?? g??i th???u c???a ch??nh m??nh ho???c g??i th???u kh??ng t???n t???i';
                }
            } else {
                $message = 'Ch??? c?? t??i kho???n doanh nghi???p m???i ???????c tham gia d??? th???u';
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

    public function actionLike()
    {
        $request = Yii::$app->getRequest()->getBodyParams();
        $user_id = isset($request['user_id']) && $request['user_id'] ? $request['user_id'] : '';
        $auth_key = isset($request['auth_key']) && $request['auth_key'] ? $request['auth_key'] : '';
        $package_id = isset($request['package_id']) && $request['package_id'] ? $request['package_id'] : '';
        $message = '';
        $errors = [];

        $user = User::findOne($user_id);
        if ($user && $user->auth_key == $auth_key) {
            $package_wish = PackageWish::find()->where(['user_id' => $user_id, 'package_id' => $package_id])->one();
            if ($package_wish) {
                if ($package_wish->delete()) {
                    return $this->responseData([
                        'success' => true,
                        'errors' => $errors,
                        'message' => 'B??? y??u th??ch th??nh c??ng'
                    ]);
                } else {
                    $errors = $package_wish->getErrors();
                }
            } else {
                $package_wish = new PackageWish();
                $package_wish->user_id = $user_id;
                $package_wish->package_id = $package_id;
                if ($package_wish->save()) {
                    return $this->responseData([
                        'success' => true,
                        'errors' => $errors,
                        'message' => 'Th??m v??o danh s??ch y??u th??ch th??nh c??ng'
                    ]);
                } else {
                    $errors = $package_wish->getErrors();
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

    /**
     * @return array
     */
    protected function verbs()
    {
        return [
            'index' => ['POST'],
            'like' => ['POST'],
        ];
    }
}