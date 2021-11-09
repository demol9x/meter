<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\db\Query;
use common\components\ClaHost;

class FormController extends Controller
{

    public function actionSaveSell()
    {
        $model = \common\models\form\FormRegisterSell::getOne(['news_id' => $_POST['FormRegisterSell']['news_id'], 'user_sell_id' => Yii::$app->user->id]);
        $notfy = ($model->id && $model->viewed == 2) ? false : true;
        $news = \common\models\news\News::findOne($model->news_id);
        if ($model->load(Yii::$app->request->post()) && $news) {
            $model->user_news_id = $news->user_id;
            $model->news_title = $news->title;
            $model->status = 2;
            $model->price = str_replace('.', '', $model->price);
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Đăng ký thành công.');
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
                return 'success';
            } else {
                $errs = 'Lưu lỗi. Vui lòng tải lại trang và thử lại.';
                if ($model->errors) {
                    $errs = '<ul>';
                    foreach ($model->errors as $item) {
                        foreach ($item as $er) {
                            $errs .= "<li>$er</li>";
                        }
                    }
                    $errs .= '</ul>';
                }
                return $errs;
            }
        }
    }

    public function actionSaveBuy()
    {
        $model = \common\models\form\FormRegisterBuy::getOne(['news_id' => $_POST['FormRegisterBuy']['news_id'], 'user_buy_id' => Yii::$app->user->id]);
        $notfy = ($model->id && $model->viewed == 2) ? false : true;
        $news = \common\models\news\News::findOne($model->news_id);
        if ($model->load(Yii::$app->request->post())) {
            $model->user_news_id = $news->user_id;
            $model->news_title = $news->title;
            $model->status = 2;
            $model->price = str_replace('.', '', $model->price);
            if ($model->validate()) {
                if ($model->type_price) {
                    $model->price = '';
                    $model->save(false);
                } else {
                    $model->save();
                }
                if ($notfy) {
                    $title = "Tin rao <b>" . $model->news_title . "</b> đã có khách liên hệ mua.";
                    \common\models\notifications\Notifications::pushMessage([
                        'title' => $title,
                        'link' => \yii\helpers\Url::to(['/management/news/buy-index']),
                        'type' => \common\models\notifications\Notifications::UPDATE_SYSTEM,
                        'recipient_id' => $model->user_news_id,
                        'description' => $title
                    ]);
                }
                Yii::$app->session->setFlash('success', 'Đăng ký thành công.');
                return 'success';
            } else {
                $errs = 'Lưu lỗi. Vui lòng tải lại trang và thử lại.';
                if ($model->errors) {
                    $errs = '<ul>';
                    foreach ($model->errors as $item) {
                        foreach ($item as $er) {
                            $errs .= "<li>$er</li>";
                        }
                    }
                    $errs .= '</ul>';
                }
                return $errs;
            }
        }
    }
}
