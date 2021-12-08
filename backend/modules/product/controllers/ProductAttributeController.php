<?php

namespace backend\modules\product\controllers;

use common\models\product\ProductAttributeItem;
use common\models\product\search\ProductAttributeItemSearch;
use Yii;
use common\models\product\ProductAttribute;
use common\models\product\ProductAttributeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductAttributeController implements the CRUD actions for ProductAttribute model.
 */
class ProductAttributeController extends Controller
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
     * Lists all ProductAttribute models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductAttributeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProductAttribute model.
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
     * Creates a new ProductAttribute model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProductAttribute();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                return $this->redirect(['index']);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ProductAttribute model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                return $this->redirect(['index']);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ProductAttribute model.
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
     * Finds the ProductAttribute model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ProductAttribute the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductAttribute::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionAdd($id)
    {
        $searchModel = new ProductAttributeItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);
        $attr = ProductAttribute::findOne($id);
        return $this->render('add', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'data' => $attr,
        ]);
    }

    public function actionCreateItem($id)
    {
        $model = new ProductAttributeItem();
        $data = ProductAttribute::findOne($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->attribute_id = $id;
            if($data->display_type == 2){
                if(!$model->value_option){
                    $model->addError('value_option','Giá trị tùy chọn cho bộ thuộc tính hiện tại không được bỏ trống');
                    return $this->render('item/create', [
                        'model' => $model,
                        'data' => $data,
                    ]);
                }
            }
            if ($model->save()) {
                return $this->redirect(['add', 'id' => $id]);
            }
        } else {
            return $this->render('item/create', [
                'model' => $model,
                'data' => $data,
            ]);
        }
    }

    public function actionUpdateItem($id)
    {
        $model = ProductAttributeItem::findOne($id);
        $data = ProductAttribute::findOne($model->attribute_id);

        if ($model->load(Yii::$app->request->post())) {
            if($data->display_type == 2){
                if(!$model->value_option){
                    $model->addError('value_option','Giá trị tùy chọn cho bộ thuộc tính hiện tại không được bỏ trống');
                    return $this->render('item/create', [
                        'model' => $model,
                        'data' => $data,
                    ]);
                }
            }
            if ($model->save()) {
                return $this->redirect(['add', 'id' => $model->attribute_id]);
            }
        } else {
            return $this->render('item/create', [
                'model' => $model,
                'data' => $data,
            ]);
        }
    }

    public function actionDeleteItem($id)
    {
        $model = ProductAttributeItem::findOne($id);
        if ($model->delete()) {
            return $this->redirect(['add', 'id' => $model->attribute_id]);
        }
    }
}
