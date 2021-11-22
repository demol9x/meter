<?php

namespace backend\modules\product\controllers;

use Yii;
use common\models\product\DiscountCode;
use common\models\product\DiscountShopCode;
use common\models\product\search\DiscountCodeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DiscountCodeController implements the CRUD actions for DiscountCode model.
 */
class DiscountCodeController extends Controller
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
     * Lists all DiscountCode models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DiscountCodeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DiscountCode model.
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
     * Creates a new DiscountCode model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DiscountShopCode();
        $model->all = 1;
        if ($model->load(Yii::$app->request->post())) {
            $model->time_start = strtotime($model->time_start);
            $model->time_end = strtotime($model->time_end);
            $model->status = 1;
            if ($model->all != 1) {
                if (isset($_POST['add']) && $_POST['add']) {
                    $model->products = implode(' ', $_POST['add']);
                } else {
                    $model->addError('all', 'Vui lòng chọn sản phẩm.');
                    return $this->render('create', [
                        'model' => $model,
                    ]);
                }
            }
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Lưu thành công.');
                return $this->redirect(['index']);
            } else {
                $model->time_start = date('d-m-Y H:i', $model->time_start);
                $model->time_end = date('d-m-Y H:i', $model->time_end);
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    function actionLoadProduct($shop_id)
    {
        $product_ns = \common\models\product\Product::find()->where(['shop_id' => $shop_id])->all();
        return $this->renderAjax('load_product', [
            'product_ns' => $product_ns,
        ]);
    }

    /**
     * Updates an existing DiscountCode model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Sửa thành công.');
                return $this->redirect(['index']);
            }
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing DiscountCode model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Xóa thành công.');
        return $this->redirect(['index']);
    }

    /**
     * Finds the DiscountCode model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return DiscountCode the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DiscountCode::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
}
