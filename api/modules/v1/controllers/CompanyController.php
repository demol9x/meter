<?php
/**
 * Created by PhpStorm.
 * User: hungtm
 * Date: 11/17/2018
 * Time: 10:25 AM
 */

namespace api\modules\v1\controllers;

use common\components\ClaMeter;
use common\models\general\UserWish;
use common\models\package\Package;
use common\models\package\PackageWish;
use common\models\Province;
use common\models\shop\Shop;
use common\models\user\UserImage;
use frontend\models\User;
use Yii;
use api\components\RestController;


/**
 *
 */
class CompanyController extends RestController
{

    public function actionIndex()
    {
        $request = Yii::$app->getRequest()->getBodyParams();
        $limit = isset($request['limit']) && $request['limit'] ? $request['limit'] : 20;
        $page = isset($request['page']) && $request['page'] ? $request['page'] : 1;
        $s = isset($request['s']) && $request['s'] ? $request['s'] : '';
        $user_id = isset($request['user_id']) && $request['user_id'] ? $request['user_id'] : '';
        $province_id = isset($request['province_id']) && $request['province_id'] ? $request['province_id'] : '';
        $id_price = isset($request['id_price']) && $request['id_price'] ? $request['id_price'] : '';
        $response = [];

        $shops = User::getS([
            'limit' => $limit,
            'page' => $page,
            's' => $s,
            'province_id' => $province_id,
            'id_price' => $id_price,
        ]);
        if (isset($shops['data']) && $shops['data']) {
            $shop_wish = UserWish::find()->where(['user_id_from' => $user_id])->asArray()->all();
            $shop_wish = array_column($shop_wish, 'user_id', 'id');
            foreach ($shops['data'] as $value) {
                if (in_array($value['user_id'], $shop_wish)) {
                    $value['is_wish'] = true;
                } else {
                    $value['is_wish'] = false;
                }
                $response[] = $value;
            }
        }


        return $this->responseData([
            'success' => true,
            'data' => $response
        ]);
    }

    public function actionLike()
    {
        $request = Yii::$app->getRequest()->getBodyParams();
        $user_id = isset($request['user_id']) && $request['user_id'] ? $request['user_id'] : '';
        $auth_key = isset($request['auth_key']) && $request['auth_key'] ? $request['auth_key'] : '';
        $shop_id = isset($request['shop_id']) && $request['shop_id'] ? $request['shop_id'] : '';
        $message = '';
        $errors = [];

        $user = User::findOne($user_id);
        if ($user && $user->auth_key == $auth_key) {
            $user_wish = UserWish::find()->where(['user_id_from' => $user_id, 'user_id' => $shop_id])->one();
            if ($user_wish) {
                if ($user_wish->delete()) {
                    return $this->responseData([
                        'success' => true,
                        'errors' => $errors,
                        'message' => 'Bỏ yêu thích thành công'
                    ]);
                } else {
                    $errors = $user_wish->getErrors();
                }
            } else {
                $user_wish = new UserWish();
                $user_wish->user_id_from = $user_id;
                $user_wish->user_id = $shop_id;
                $user_wish->type = User::TYPE_DOANH_NGHIEP;
                if ($user_wish->save()) {
                    return $this->responseData([
                        'success' => true,
                        'errors' => $errors,
                        'message' => 'Thêm vào danh sách yêu thích thành công'
                    ]);
                } else {
                    $errors = $user_wish->getErrors();
                }
            }
        } else {
            $message = 'Bạn phải đăng nhập để thực hiện hành động này.';
        }

        return $this->responseData([
            'success' => false,
            'errors' => $errors,
            'message' => $message
        ]);
    }

    public function actionDetail(){
        $message = '';
        $errors = [];
        $request = Yii::$app->getRequest()->getBodyParams();
        $user_id = isset($request['user_id']) && $request['user_id'] ? $request['user_id'] : '';
        $shop_id = isset($request['shop_id']) && $request['shop_id'] ? $request['shop_id'] : '';
        $lat = isset($request['lat']) && $request['lat'] ? $request['lat'] : '';
        $lng = isset($request['lng']) && $request['lng'] ? $request['lng'] : '';
        $shop = Shop::findOne($shop_id);
        if($shop){
            $data = $shop->attributes;

            //Ảnh nhà thầu
            $images = UserImage::getImages($shop_id);
            $data['images'] = $images;

            //Gói thầu chào bán
            $package_related = Package::find()->where(['shop_id' => $shop_id, 'status' => 1])->joinWith(['province'])->asArray()->all();
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

            $max = Shop::find()->count();

            $offset = rand(0,$max);

            $shop_more = Shop::find()->select(['user_id','name','avatar_path','avatar_name','province_name','rate'])->limit(10)->offset($offset)->all();

            $data['shop_more'] = $shop_more;

            return $this->responseData([
                'success' => true,
                'data' => $data,
                'errors' => $errors,
                'message' => $message
            ]);

        }else{
            $message = 'Nhà thầu không tồn tại';
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