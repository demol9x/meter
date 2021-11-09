<?php

namespace frontend\mobile\modules\management\controllers;

use frontend\controllers\CController;
use Yii;
use common\models\notifications\Notifications;
use yii\web\Response;

class NotificationsController extends CController {
    
    public $layout = 'main_user';

    public function actionIndex() {
        $type = \Yii::$app->request->get('type', 0);

        $data = Notifications::getAllNotifications([
                    'type' => $type
        ]);

        return $this->render('index', [
                    'data' => $data,
                    'type' => $type
        ]);
    }

    /**
     * @return type
     */
    public function actionMarkerReadNotify() {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $notify_id = Yii::$app->request->get('notify_id', 0);
            $notification = Notifications::findOne($notify_id);
            if (isset($notification) && $notification) {
                $notification->unread = \common\components\ClaLid::STATUS_DEACTIVED;
                $notification->save();
                return [
                    'code' => 200,
                ];
            } else {
                Yii::$app->response->statusCode = 400;
            }
        }
    }

    /**
     * @return type
     */
    public function actionDeleteNotify() {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $notify_id = Yii::$app->request->get('notify_id', 0);
            $notification = Notifications::findOne($notify_id);
            if (isset($notification) && $notification) {
                if ($notification->recipient_id == Yii::$app->user->id) {
                    $notification->delete();
                    return [
                        'code' => 200,
                    ];
                } else {
                    Yii::$app->response->statusCode = 401;
                }
            } else {
                Yii::$app->response->statusCode = 400;
            }
        }
    }

}
