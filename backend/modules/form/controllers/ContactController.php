<?php

namespace backend\modules\form\controllers;

use Yii;
use common\models\form\Contact;
use common\models\form\search\ContactSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ContactController implements the CRUD actions for Contact model.
 */
class ContactController extends Controller {

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
     * Lists all Contact models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new ContactSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Contact model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionFinish($id) {
        $model = $this->findModel($id);
        if($model && !$model->viewed) {
            $model->viewed = 1;
            $model->user_id = Yii::$app->user->identity->id;
            if($model->save( false)) {
                Yii::$app->session->setFlash('success', 'Đã lưu.');
            } else {
                Yii::$app->session->setFlash('success', 'Lưu lỗi.');
                print_r($model->errors);
                die();
            }
        }
        return $this->redirect(['index']);
    }

    /**
     * Deletes an existing Contact model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Đã xóa');
        return $this->redirect(['index']);
    }

    /**
     * Finds the Contact model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Contact the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Contact::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
