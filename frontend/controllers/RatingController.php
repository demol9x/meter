<?php

namespace frontend\controllers;

use common\models\product\Product;
use common\models\rating\RatingImage;
use common\models\rating\RatingLike;
use common\models\shop\Shop;
use common\models\user\Tho;
use Yii;
use common\models\rating\Rating;
use frontend\models\User;

class RatingController extends CController
{

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionRating()
    {
        $message = '';
        $errors = [];
        if (Yii::$app->request->isAjax) {
            $request = Yii::$app->request->post();
            if (Yii::$app->user->id) {
                $user = User::findOne(Yii::$app->user->id);
                $rating = new Rating();
                $rating->user_id = Yii::$app->user->id;
                if ($rating->load($request)) {
                    if ($rating->type == User::TYPE_DOANH_NGHIEP) {
                        $rating->type == Rating::TYPE_SHOP;
                    }
                    if ($rating->type == User::TYPE_THO) {
                        $rating->type == Rating::TYPE_THO;
                    }
                    $rating->name = $user->username;
                    $rating->status = 1;
                    $rating->count_like = 0;

                    if ($rating->save()) {
                        if ($rating->rating) {
                            if ($rating->type == Rating::TYPE_SHOP) {
                                $shop = Shop::findOne($rating->object_id);
                                if ($shop) {
                                    $total = $shop->rate_count * $shop->rate;
                                    $shop->rate_count += 1;
                                    $shop->rate = ($total + $rating->rating) / $shop->rate_count;
                                    $shop->save();
                                }
                            }
                            if ($rating->type == Rating::TYPE_THO) {
                                $tho = Tho::findOne($rating->object_id);
                                if ($tho) {
                                    $total = $tho->rate_count * $tho->rate;
                                    $tho->rate_count += 1;
                                    $tho->rate = ($total + $rating->rating) / $tho->rate_count;
                                    $tho->save();
                                }
                            }
                            if ($rating->type == Rating::TYPE_PRODUCT) {
                                $product = Product::findOne($rating->object_id);
                                if ($product) {
                                    $total = $product->rate_count * $product->rate;
                                    $product->rate_count += 1;
                                    $product->rate = ($total + $rating->rating) / $product->rate_count;
                                    $product->save();
                                }
                            }
                        }

                        //ảnh bình luận
                        $newimage = Yii::$app->request->post('newimage');
                        $countimage = $newimage ? count($newimage) : 0;
                        if ($newimage && $countimage > 0) {
                            foreach ($newimage as $image_code) {
                                $imgtem = \common\models\media\ImagesTemp::findOne($image_code);
                                if ($imgtem) {
                                    $nimg = new RatingImage();
                                    $nimg->attributes = $imgtem->attributes;
                                    $nimg->rating_id = $rating->id;
                                    $nimg->type = $rating->type;
                                    $nimg->object_id = $rating->object_id;
                                    if ($nimg->save()) {
                                        $rating->is_image = 1;
                                        $rating->save();
                                        $imgtem->delete();
                                    }
                                }
                            }
                        }

                        return json_encode([
                            'success' => true,
                            'message' => 'Đánh giá thành công'
                        ]);
                    } else {
                        $errors = $rating->getErrors();
                    }
                }
            } else {
                $message = 'Bạn phải đăng nhập để thực hiện hành động này.';
            }
        }
        return json_encode([
            'success' => false,
            'message' => $message,
            'errors' => $errors
        ]);
    }

    public function actionLike()
    {
        $message = '';
        $errors = [];
        if (Yii::$app->request->isAjax) {
            $request = Yii::$app->request->post();
            $id = isset($request['id']) && $request['id'] ? $request['id'] : '';
            if (Yii::$app->user->id) {
                $user_id = Yii::$app->user->id;
                $rating = Rating::findOne($id);
                if ($rating) {
                    $like = RatingLike::find()->where(['rating_id' => $id, 'user_id' => $user_id])->one();
                    if ($like) {
                        if ($like->delete()) {
                            $rating = Rating::findOne($id);
                            $rating->count_like -= 1;
                            $rating->save();
                            return json_encode([
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
        }
        return json_encode([
            'success' => false,
            'errors' => $errors,
            'message' => $message
        ]);
    }

    public function actionImages()
    {
        $request = Yii::$app->request->get();
        $object_id = isset($request['object_id']) && $request['object_id'] ? $request['object_id'] : '';
        $type = isset($request['type']) && $request['type'] ? $request['type'] : '';

        $images = RatingImage::find()->where(['object_id' => $object_id, 'type' => $type])->all();

        return json_encode([
            'success' => true,
            'data' => $images,
            'errors' => [],
            'message' => ''
        ]);
    }

    public function actionLoadComment(){
        if (Yii::$app->request->isAjax) {
            $data = [];
            if ($_POST['object_id'] && $_POST['type']) {
                $rating = Rating::getRating([
                    'object_id' => $_POST['object_id'],
                    'type' => $_POST['type'],
                    'limit' => $_POST['limit'],
                    'page' => $_POST['page'],
                ]);
                if ($rating['data']) {
                    foreach ($rating['data'] as $rt) {
                        if (Yii::$app->user->id) {
                            $rating_like = RatingLike::find()->where(['rating_id' => $rt['id'], 'user_id' => Yii::$app->user->id])->one();
                            if ($rating_like) {
                                $rt['is_like'] = true;
                            } else {
                                $rt['is_like'] = false;
                            }
                        } else {
                            $rt['is_like'] = false;
                        }
                        $data[] = $rt;
                    }
                }

            }
            return $this->renderPartial('rating',['data' => $data]);
        }
        return '';
    }

    public function actionRepComment(){
        if (Yii::$app->request->isAjax) {
            if ($_POST['id'] && $_POST['id']) {
                $rating = new Rating();
                $rating->parent_id = $_POST['id'];
                $rating->content = $_POST['content'];
                $rating->user_id = Yii::$app->user->id;
                $rating->rating = 0;
                $rating->object_id = $_POST['object_id'];
                $rating->type = $_POST['type'];
                if($rating->save()){
                    return $this->renderPartial('partial/rating_item',['rating_id' => $_POST['id'],'id' => $rating->id]);
                }
            }
        }
        return '';
    }
}
