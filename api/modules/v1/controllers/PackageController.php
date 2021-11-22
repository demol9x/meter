<?php
/**
 * Created by PhpStorm.
 * User: hungtm
 * Date: 11/17/2018
 * Time: 10:25 AM
 */

namespace api\modules\v1\controllers;

use common\components\ClaLid;
use common\components\ClaMeter;
use common\models\package\Package;
use common\models\package\PackageWish;
use common\models\sms\SmsOtp;
use common\models\sms\SmsOtpLog;
use common\models\sms\SmsOtpLogApi;
use frontend\models\User;
use Yii;
use api\components\RestController;


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
        $response = [];

        $packages = Package::find()->where(['status' => 1])
            ->andFilterWhere(['like', 'package.name', $s])
            ->joinWith(['province'])
            ->orderBy('order ASC, updated_at DESC')
            ->limit($limit)->offset(($page - 1) * $limit)->asArray()->all();

        if ($packages) {
            $package_wish = PackageWish::find()->where(['user_id' => $user_id])->asArray()->all();
            $package_wish = array_column($package_wish, 'package_id', 'id');
            foreach ($packages as $package) {
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
                        'message' => 'Bỏ yêu thích thành công'
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
                        'message' => 'Thêm vào danh sách yêu thích thành công'
                    ]);
                } else {
                    $errors = $package_wish->getErrors();
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