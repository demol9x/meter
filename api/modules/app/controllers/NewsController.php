<?php

namespace api\modules\app\controllers;

use common\models\news\News;

class NewsController extends LoginedController
{
    function actionGetNews()
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        $post['attr'] = $post;
        // $post['attr']['status'] = 1;
        if (isset($post['count']) && $post['count']) {
            $resonse['data']['total'] = (new \common\models\news\News())->getByAttr($post);
            $resonse['message'] = 'Lấy số lượng tin tức thành công.';
            $resonse['code'] = 1;
            return $this->responseData($resonse);
        }
        $resonse['data'] = (new \common\models\news\News())->getByAttr($post);
        $resonse['message'] = 'Lấy tin tức thành công.';
        $resonse['code'] = 1;
        return $this->responseData($resonse);
    }

    function actionGetDetailNews()
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        if (isset($post['id']) && $post['id'] && ($news = \common\models\news\News::findOne($post['id']))) {
            $resonse['data'] = $news;
            $resonse['message'] = 'Lấy chi tiết tin tức thành công.';
            $resonse['code'] = 1;
            return $this->responseData($resonse);
        }
        $resonse['error'] = 'Không tìm thấy bài tin.';
        return $this->responseData($resonse);
    }

    function actionAddNews()
    {
        $this->setTimeLoadOnce(10);
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        $model = new News();
        if ($model->load($post)) {
            $model->user_id = $this->user->id;
            $model->status = 2;
            $model->author = \common\models\User::findOne($this->user->id)->username;
            $model->publicdate = time();
            if ($model->avatar_name && $model->avatar_path) {
                $model->avatar = true;
            }
            if ($model->save()) {
                $resonse['data'] = $model;
                $resonse['message'] = 'Lưu thành công.';
                $resonse['code'] = 1;
                return $this->responseData($resonse);
            } else {
                $resonse['data'] = $model->errors;
                $resonse['error'] = 'Lỗi dữ liệu';
                return $this->responseData($resonse);
            }
        }
        $resonse['error'] = 'Lỗi dữ liệu';
        return $this->responseData($resonse);
    }

    function actionUpdateNews()
    {
        $this->setTimeLoadOnce(5);
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        if (isset($post['id']) && $post['id']) {
            $model = $this->findModel($post['id']);
            if ($model->load($post)) {
                $model->status = $model->status ? 2 : 0;
                $model->publicdate = time();
                if ($model->avatar_name && $model->avatar_path) {
                    $model->avatar = true;
                }
                if ($model->save()) {
                    $resonse['data'] = $model;
                    $resonse['message'] = 'Lưu thành công.';
                    $resonse['code'] = 1;
                    return $this->responseData($resonse);
                } else {
                    $resonse['data'] = $model->errors;
                    $resonse['error'] = 'Lỗi dữ liệu';
                    return $this->responseData($resonse);
                }
            }
        }
        $resonse['error'] = 'Lỗi dữ liệu';
        return $this->responseData($resonse);
    }

    function actionDelNews()
    {
        $this->setTimeLoadOnce(10);
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        if (isset($post['id']) && $post['id']) {
            $ids = is_array($post['id']) ? $post['id'] : [$post['id']];
            News::deleteAll(['id' => $ids, 'user_id' => $this->user->id]);
            $resonse['message'] = 'Xóa thành công.';
            $resonse['code'] = 1;
            $resonse['data'] = $ids;
            return $this->responseData($resonse);
        }
        $resonse['error'] = 'Lỗi dữ liệu';
        return $this->responseData($resonse);
    }

    function actionAddContactSell()
    {
        $this->setTimeLoadOnce(5);
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        if (isset($post['news_id']) && $post['news_id']) {
            $model = \common\models\form\FormRegisterSell::getOne(['news_id' => $post['news_id'], 'user_sell_id' => $this->user->id]);
            $notfy = ($model->id && $model->viewed == 2) ? false : true;
            $news = \common\models\form\FormRegisterSell::getNews($model->news_id);
            if ($news && $model->load($post)) {
                $model->user_news_id = $news->user_id;
                $model->news_title = $news->title;
                $model->status = 2;
                $model->price = str_replace('.', '', $model->price);
                if ($model->save()) {
                    if ($notfy) {
                        $title = "Tin rao <b>" . $model->news_title . "</b> đã có khách liên hệ bán.";
                        \common\models\notifications\Notifications::pushMessage([
                            'title' => $title,
                            'link' => \yii\helpers\Url::to(['/management/news/sell-index']),
                            'type' => \common\models\notifications\Notifications::UPDATE_SYSTEM,
                            'recipient_id' => $model->user_news_id,
                            'description' => $title
                        ]);
                    }
                    $resonse['data'] = $model;
                    $resonse['message'] = 'Đăng ký thành công.';
                    $resonse['code'] = 1;
                    return $this->responseData($resonse);
                } else {
                    $resonse['data'] = $model->errors;
                    $resonse['error'] = 'Lưu lỗi.';
                    return $this->responseData($resonse);
                }
            }
        }
        $resonse['error'] = 'Lỗi dữ liệu.';
        return $this->responseData($resonse);
    }

    function actionUpdateContactSell()
    {
        $this->setTimeLoadOnce(5);
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        if (isset($post['id']) && $post['id']) {
            $model = $this->findModelSell($post['id']);
            if ($model->load($post)) {
                if ($model->save()) {
                    $resonse['data'] = $model;
                    $resonse['message'] = 'Lưu thành công.';
                    $resonse['code'] = 1;
                    return $this->responseData($resonse);
                } else {
                    $resonse['data'] = $model->errors;
                    $resonse['error'] = 'Lỗi dữ liệu';
                    return $this->responseData($resonse);
                }
            }
        }
        $resonse['error'] = 'Lỗi dữ liệu';
        return $this->responseData($resonse);
    }

    function actionGetContactSells()
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        $post['attr'] = $post;
        if (isset($post['count']) && $post['count']) {
            $resonse['data']['total'] = (new \common\models\form\FormRegisterSell())->getByAttr($post);
            $resonse['message'] = 'Lấy số lượng liên hệ bán thành công.';
            $resonse['code'] = 1;
            return $this->responseData($resonse);
        }
        $resonse['data'] = (new \common\models\form\FormRegisterSell())->getByAttr($post);
        $resonse['message'] = 'Lấy danh sách liên hệ bán thành công.';
        $resonse['code'] = 1;
        return $this->responseData($resonse);
    }

    function actionDelContactSells()
    {
        $this->setTimeLoadOnce(5);
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        if (isset($post['id']) && $post['id']) {
            $ids = is_array($post['id']) ? $post['id'] : [$post['id']];
            \common\models\form\FormRegisterSell::deleteAll(['id' => $ids, 'user_news_id' => $this->user->id]);
            $resonse['message'] = 'Xóa thành công.';
            $resonse['code'] = 1;
            $resonse['data'] = $ids;
            return $this->responseData($resonse);
        }
        $resonse['error'] = 'Lỗi dữ liệu';
        return $this->responseData($resonse);
    }

    function actionAddContactBuy()
    {
        $this->setTimeLoadOnce(5);
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        if (isset($post['news_id']) && $post['news_id']) {
            $model = \common\models\form\FormRegisterBuy::getOne(['news_id' => $post['news_id'], 'user_buy_id' => $this->user->id]);
            $notfy = ($model->id && $model->viewed == 2) ? false : true;
            $news = \common\models\form\FormRegisterBuy::getNews($model->news_id);
            if ($news && $model->load($post)) {
                $model->user_news_id = $news->user_id;
                $model->news_title = $news->title;
                $model->status = 2;
                $model->price = str_replace('.', '', $model->price);
                if ($model->save()) {
                    if ($notfy) {
                        $title = "Tin rao <b>" . $model->news_title . "</b> đã có khách liên hệ mua.";
                        \common\models\notifications\Notifications::pushMessage([
                            'title' => $title,
                            'link' => \yii\helpers\Url::to(['/management/news/sell-index']),
                            'type' => \common\models\notifications\Notifications::UPDATE_SYSTEM,
                            'recipient_id' => $model->user_news_id,
                            'description' => $title
                        ]);
                    }
                    $resonse['data'] = $model;
                    $resonse['message'] = 'Đăng ký thành công.';
                    $resonse['code'] = 1;
                    return $this->responseData($resonse);
                } else {
                    $resonse['data'] = $model->errors;
                    $resonse['error'] = 'Lưu lỗi.';
                    return $this->responseData($resonse);
                }
            }
        }
        $resonse['error'] = 'Lỗi dữ liệu.';
        return $this->responseData($resonse);
    }

    function actionUpdateContactBuy()
    {
        $this->setTimeLoadOnce(5);
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        if (isset($post['id']) && $post['id']) {
            $model = $this->findModelBuy($post['id']);
            if ($model->load($post)) {
                if ($model->save()) {
                    $resonse['data'] = $model;
                    $resonse['message'] = 'Lưu thành công.';
                    $resonse['code'] = 1;
                    return $this->responseData($resonse);
                } else {
                    $resonse['data'] = $model->errors;
                    $resonse['error'] = 'Lỗi dữ liệu';
                    return $this->responseData($resonse);
                }
            }
        }
        $resonse['error'] = 'Lỗi dữ liệu';
        return $this->responseData($resonse);
    }

    function actionGetContactBuys()
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        $post['attr'] = $post;
        if (isset($post['count']) && $post['count']) {
            $resonse['data']['total'] = (new \common\models\form\FormRegisterBuy())->getByAttr($post);
            $resonse['message'] = 'Lấy số lượng liên hệ bán thành công.';
            $resonse['code'] = 1;
            return $this->responseData($resonse);
        }
        $resonse['data'] = (new \common\models\form\FormRegisterBuy())->getByAttr($post);
        $resonse['message'] = 'Lấy danh sách liên hệ bán thành công.';
        $resonse['code'] = 1;
        return $this->responseData($resonse);
    }

    function actionDelContactBuys()
    {
        $this->setTimeLoadOnce(5);
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        if (isset($post['id']) && $post['id']) {
            $ids = is_array($post['id']) ? $post['id'] : [$post['id']];
            \common\models\form\FormRegisterBuy::deleteAll(['id' => $ids, 'user_news_id' => $this->user->id]);
            $resonse['message'] = 'Xóa thành công.';
            $resonse['code'] = 1;
            $resonse['data'] = $ids;
            return $this->responseData($resonse);
        }
        $resonse['error'] = 'Lỗi dữ liệu';
        return $this->responseData($resonse);
    }

    protected function findModel($id)
    {
        if (($model = News::find()->where(['id' => $id, 'user_id' => $this->user->id])->one()) !== null) {
            return $model;
        } else {
            $resonse['code'] = 0;
            $resonse['error'] = 'Không tìm thấy bài tin.';
            echo json_encode($resonse);
            \Yii::$app->end();
        }
    }

    protected function findModelSell($id)
    {
        if (($model = \common\models\form\FormRegisterSell::find()->where(['id' => $id, 'user_news_id' => $this->user->id])->one()) !== null) {
            return $model;
        } else {
            $resonse['code'] = 0;
            $resonse['error'] = 'Không tìm thấy tin liên hệ.';
            echo json_encode($resonse);
            \Yii::$app->end();
        }
    }

    protected function findModelBuy($id)
    {
        if (($model = \common\models\form\FormRegisterBuy::find()->where(['id' => $id, 'user_news_id' => $this->user->id])->one()) !== null) {
            return $model;
        } else {
            $resonse['code'] = 0;
            $resonse['error'] = 'Không tìm thấy tin liên hệ.';
            echo json_encode($resonse);
            \Yii::$app->end();
        }
    }
}
