<?php
/**
 * Created by PhpStorm.
 * User: hungtm
 * Date: 11/17/2018
 * Time: 10:25 AM
 */

namespace api\modules\v1\controllers;

use common\models\rating\Rating;
use common\models\rating\RatingImage;
use common\models\rating\RatingLike;
use common\models\shop\Shop;
use common\models\user\Tho;
use frontend\models\User;
use Yii;
use api\components\RestController;
use yii\web\UploadedFile;


/**
 *
 */
class RatingController extends RestController
{

    public function actionIndex()
    {
        $request = Yii::$app->getRequest()->getBodyParams();
        $user_id = isset($request['user_id']) && $request['user_id'] ? $request['user_id'] : '';
        $object_id = isset($request['object_id']) && $request['object_id'] ? $request['object_id'] : '';
        $type = isset($request['type']) && $request['type'] ? $request['type'] : '';
        $limit = isset($request['limit']) && $request['limit'] ? $request['limit'] : 10;
        $page = isset($request['page']) && $request['page'] ? $request['page'] : 1;
        $order = isset($request['order']) && $request['order'] ? $request['order'] : '';
        $is_image = isset($request['is_image']) && $request['is_image'] ? $request['is_image'] : '';
        $rating_value = isset($request['rating']) && $request['rating'] ? $request['rating'] : '';
        $message = '';
        $errors = [];
        $data = [];
        if ($object_id && $type) {
            $rating = Rating::getRating([
                'object_id' => $object_id,
                'type' => $type,
                'limit' => $limit,
                'page' => $page,
                'order' => $order,
                'is_image' => $is_image,
                'rating' => $rating_value,
            ]);
            if ($rating['data']) {
                foreach ($rating['data'] as $rt) {
                    if ($user_id) {
                        $rating_like = RatingLike::find()->where(['rating_id' => $rt['id'], 'user_id' => $user_id])->one();
                        if ($rating_like) {
                            $rt['is_like'] = true;
                        } else {
                            $rt['is_like'] = false;
                        }
                    }else{
                        $rt['is_like'] = false;
                    }
                    $data[] = $rt;
                }
            }
            return $this->responseData([
                'success' => true,
                'data' => $data,
                'errors' => $errors,
                'message' => $message
            ]);
        } else {
            $message = 'Không tìm thấy dữ liệu';
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
        $id = isset($request['id']) && $request['id'] ? $request['id'] : '';
        $user_id = isset($request['user_id']) && $request['user_id'] ? $request['user_id'] : '';
        $auth_key = isset($request['auth_key']) && $request['auth_key'] ? $request['auth_key'] : '';
        $message = '';
        $errors = [];

        $user = User::findOne($user_id);
        if ($user && $user->auth_key == $auth_key) {
            $rating = Rating::findOne($id);
            if ($rating) {
                $like = RatingLike::find()->where(['rating_id' => $id, 'user_id' => $user_id])->one();
                if ($like) {
                    if ($like->delete()) {
                        $rating = Rating::findOne($id);
                        $rating->count_like -= 1;
                        $rating->save();
                        return $this->responseData([
                            'success' => true,
                            'errors' => $errors,
                            'message' => 'Bỏ like'
                        ]);
                    } else {
                        $errors = $like->getErrors();
                    }
                } else {
                    $like = new RatingLike();
                    $like->rating_id = $id;
                    $like->user_id = $user_id;
                    if ($like->save()) {
                        $rating = Rating::findOne($id);
                        $rating->count_like += 1;
                        $rating->save();
                        return $this->responseData([
                            'success' => true,
                            'errors' => $errors,
                            'message' => 'Đã like'
                        ]);
                    } else {
                        $errors = $like->getErrors();
                    }
                }
            } else {
                $message = 'Bài đánh giá không tồn tại';
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

    public function actionCreate()
    {
        $request = Yii::$app->getRequest()->getBodyParams();
        $user_id = isset($request['user_id']) && $request['user_id'] ? $request['user_id'] : '';
        $auth_key = isset($request['auth_key']) && $request['auth_key'] ? $request['auth_key'] : '';
        $type = isset($request['type']) && $request['type'] ? $request['type'] : '';
        $object_id = isset($request['object_id']) && $request['object_id'] ? $request['object_id'] : '';
        $message = '';
        $errors = [];
        $data = [];

        $user = User::findOne($user_id);
        if ($user && $user->auth_key == $auth_key) {
            $rating = new Rating();
            if ($rating->load($request, '')) {
                $rating->name = $user->username;
                $rating->status = 1;
                $rating->count_like = 0;

                if ($rating->save()) {
                    if ($rating->rating) {
                        if ($type == Rating::TYPE_SHOP) {
                            $shop = Shop::findOne($object_id);
                            if ($shop) {
                                $total = $shop->rate_count * $shop->rate;
                                $shop->rate_count += 1;
                                $shop->rate = ($total + $rating->rating) / $shop->rate_count;
                                $shop->save();
                            }
                        }
                        if ($type == Rating::TYPE_THO) {
                            $tho = Tho::findOne($object_id);
                            if ($tho) {
                                $total = $tho->rate_count * $tho->rate;
                                $tho->rate_count += 1;
                                $tho->rate = ($total + $rating->rating) / $tho->rate_count;
                                $tho->save();
                            }
                        }
                    }
                    //ảnh bình luận
                    $images = UploadedFile::getInstancesByName("images");
                    foreach ($images as $fl) {
                        $file = (array)$fl;
                        if ($file) {
                            $file['tmp_name'] = $file['tempName'];
                            unset($file['tempName']);
                            $data = $this->uploadImage($file, 'rating');
                            if ($data['code'] == 1) {
                                $nimg = new RatingImage();
                                $nimg->attributes = $data['data'];
                                $nimg->rating_id = $rating->id;
                                $nimg->type = $rating->type;
                                $nimg->object_id = $rating->object_id;
                                $nimg->save();
                                $rating->is_image = 1;
                                $rating->save();
                            } else {
                                print_r('<pre>');
                                print_r($data);
                                die;
                            }
                        } else {
                            break;
                        }
                    }
                    return $this->responseData([
                        'success' => true,
                        'errors' => $errors,
                        'message' => $message
                    ]);
                } else {
                    $errors = $rating->getErrors();
                }
            }
        } else {
            $message = 'Bạn phải đăng nhập để thực hiện hành động này.';
        }


        return $this->responseData([
            'success' => false,
            'data' => $data,
            'errors' => $errors,
            'message' => $message
        ]);
    }

    public function actionImages()
    {
        $request = Yii::$app->getRequest()->getBodyParams();
        $object_id = isset($request['object_id']) && $request['object_id'] ? $request['object_id'] : '';
        $type = isset($request['type']) && $request['type'] ? $request['type'] : '';

        $images = RatingImage::find()->where(['object_id' => $object_id, 'type' => $type])->all();

        return $this->responseData([
            'success' => true,
            'data' => $images,
            'errors' => [],
            'message' => ''
        ]);
    }

    function uploadImage($file, $path = 'rating')
    {
        $path = [$path, date('Y_m_d', time())];
        if ($file) {
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
        return [
            'code' => 0,
            'data' => [],
            'message' => '',
            'error' => 'Up ảnh lỗi.'
        ];
    }

    /**
     * @return array
     */
    protected function verbs()
    {
        return [
            'index' => ['POST'],
        ];
    }
}