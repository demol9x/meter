<?php

namespace backend\modules\user\controllers;

use Yii;
use common\models\user\UserMoney;
use common\models\user\search\UserMoneySearch;
use common\components\ClaGenerate;
use common\models\user\UserMoneyLog;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserMoneyController implements the CRUD actions for UserMoney model.
 */
class UserMoneyController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
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
     * Lists all UserMoney models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new UserMoneySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 50;
        //
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserMoney model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new UserMoney model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new UserMoney();

        if ($model->load(Yii::$app->request->post())) {
            $model->money_hash = ClaGenerate::encrypt($model->money);
            if ($model->save()) {
                $log = new UserMoneyLog();
                $log->phone = $model->phone;
                $log->money_before = $model->money;
                $log->money = $model->money;
                $log->money_after = $model->money;
                $log->note = 'Khởi tạo ban đầu';
                $log->user_id = Yii::$app->user->getId();
                $log->type = UserMoneyLog::TYPE_PLUS;
                $log->save();
                return $this->redirect(['index']);
            }
        }
        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing UserMoney model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $money_before = $model->money;
        $log = new UserMoneyLog();

        if ($model->load(Yii::$app->request->post())) {
            $money_after = $model->money;
            $money = abs($money_after - $money_before);
            $type = 0;
            if ($money_after > $money_before) {
                $type = UserMoneyLog::TYPE_PLUS;
            } else if ($money_after < $money_before) {
                $type = UserMoneyLog::TYPE_DEDUCT;
            }
            $model->money_hash = ClaGenerate::encrypt($model->money);
            if ($model->save()) {
                $log->load(Yii::$app->request->post());
                $log->phone = $model->phone;
                $log->money_before = $money_before;
                $log->money = $money;
                $log->money_after = $money_after;
                $log->user_id = Yii::$app->user->getId();
                $log->type = $type;
                $log->save();
                return $this->redirect(['index']);
            }
        }
        return $this->render('update', [
                    'model' => $model,
                    'log' => $log
        ]);
    }

    /**
     * Deletes an existing UserMoney model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the UserMoney model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return UserMoney the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = UserMoney::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
