<?php

namespace backend\modules\user\controllers;

use Yii;
use common\models\user\UserInGroup;
use common\models\user\search\UserInGroupSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserInGroupController implements the CRUD actions for UserInGroup model.
 */
class UserInGroupController extends Controller
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
     * Lists all UserInGroup models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserInGroupSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 50;
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAgree($id)
    {
        $model = UserInGroup::findOne($id);
        if ($model) {
            $model->status = 1;
            if($model->save()) {
                if (Yii::$app->request->isAjax) {
                    return 'Đã xác nhận.';
                }
                Yii::$app->session->setFlash('success', 'Xác nhận thành công.');
            } else {
                if (Yii::$app->request->isAjax) {
                    return 'Xác nhận lỗi.';
                }
                Yii::$app->session->setFlash('error', 'Xác nhận lỗi.');
            }
        }
        return $this->redirect(['index']);
    }

    public function actionLock($id)
    {
        $model = UserInGroup::findOne($id);
        if ($model) {
            $model->status = 0;
            if($model->save()) {
                if (Yii::$app->request->isAjax) {
                    return 'Đã khóa yêu cầu.';
                }
                Yii::$app->session->setFlash('success', 'Đã khóa yêu cầu thành công.');
            } else {
                if (Yii::$app->request->isAjax) {
                    return 'Khóa lỗi.';
                }
                Yii::$app->session->setFlash('error', 'Khóa lỗi.');
            }
        }
        return $this->redirect(['index']);
    }

    /**
     * Creates a new UserInGroup model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UserInGroup();
        $model->scenario = 'backend';
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing UserInGroup model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        // $model->scenario = 'backend';
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Cập nhật thành công');
                return $this->redirect(['update', 'id' => $model->id]);
            }
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing UserInGroup model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the UserInGroup model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return UserInGroup the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserInGroup::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
