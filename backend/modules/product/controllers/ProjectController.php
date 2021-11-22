<?php

namespace backend\modules\product\controllers;

use common\models\product\ProductCategoryType;
use common\models\product\Project;
use Yii;
use common\models\product\ProductCategory;
use common\models\product\ProductAttribute;
use common\models\product\search\ProductCategorySearch;
use common\components\UploadLib;
use common\components\ClaHost;
use common\components\ClaGenerate;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductCategoryController implements the CRUD actions for ProductCategory model.
 */
class ProjectController extends Controller
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
     * Lists all ProductCategory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = Project::find()->all();
        return $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionCreate()
    {
        $model = new Project();
        $provinces = (new \common\models\Province())->optionsCache();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                return $this->redirect(['index']);
            }
        }
        return $this->render('create', [
            'model' => $model,
            'provinces' => $provinces,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $provinces = (new \common\models\Province())->optionsCache();
        $districts = \common\models\District::dataFromProvinceId($model->province_id);
        $wards = \common\models\Ward::dataFromDistrictId($model->district_id);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                return $this->redirect(['index']);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
                'provinces' => $provinces,
                'districts' => $districts,
                'wards' => $wards,
            ]);
        }
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Project::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGetDistrict()
    {
        $req = Yii::$app->request;
        if ($req->isAjax) {
            $request = $_GET;
            $data = \common\models\District::dataFromProvinceId($request['province_id']);
            return $this->renderPartial('district_view', [
                'data' => $data,
            ]);
        } else {
            return false;
        }
    }

    public function actionGetWard()
    {
        $req = Yii::$app->request;
        if ($req->isAjax) {
            $request = $_GET;
            $data = \common\models\Ward::dataFromDistrictId($request['district_id']);
            return $this->renderPartial('ward_view', [
                'data' => $data,
            ]);
        } else {
            return false;
        }
    }

}
