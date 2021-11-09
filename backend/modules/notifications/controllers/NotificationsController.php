<?php

namespace backend\modules\notifications\controllers;

use Yii;
use common\models\notifications\Notifications;
use common\models\notifications\search\NotificationsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * NotificationsController implements the CRUD actions for Notifications model.
 */
class NotificationsController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Notifications models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NotificationsSearch();
        $re = Yii::$app->request->queryParams;
        $user = Yii::$app->user->identity;
        if (!$user->isAllRuleNotify()) {
            $re['NotificationsSearch']['sender_id'] = $user->id;
        }
        // echo "<pre>";
        // print_r($re);
        // die();
        $dataProvider = $searchModel->search($re);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Notifications model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Notifications model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Notifications();
        if ($model->load(Yii::$app->request->post())) {
            $time = strtotime($model->updated_at);
            if ($time <= time()) {
                Notifications::pushMessageAllUsers($model->attributes);
                Yii::$app->session->setFlash('Thông báo gửi thành công.');
                return $this->redirect(['index']);
            } else {
                $model->sender_id = Yii::$app->user->id;
                $model->updated_at = $time;
                $model->created_at = time();
                $model->recipient_real_id = $model->recipient_id;
                $model->recipient_id = Notifications::TYPE_WAITING_SEND;
                // echo "<pre>";
                // print_r($model);
                // die();
                if ($model->save()) {
                    Yii::$app->session->setFlash('Tạo thông báo gửi thành công.');
                    return $this->redirect(['index']);
                }
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Notifications model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    // public function actionUpdate($id) {
    //     $model = $this->findModel($id);

    //     if ($model->load(Yii::$app->request->post())) {
    //         if ($model->save()) {
    //             return $this->redirect(['index']);
    //         }
    //     }
    //     return $this->render('update', [
    //                 'model' => $model,
    //     ]);
    // }

    /**
     * Deletes an existing Notifications model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model) {
            Notifications::deleteAll(['created_at' => $model->created_at, 'sender_id' => $model->sender_id]);
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Notifications model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Notifications the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Notifications::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
