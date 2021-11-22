<?php

namespace backend\modules\package\controllers;

use common\components\ClaGenerate;
use common\models\District;
use common\models\package\PackageImage;
use common\models\Ward;
use Yii;
use common\models\package\Package;
use common\models\package\PackageSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * PackageController implements the CRUD actions for Package model.
 */
class PackageController extends Controller
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
     * Lists all Package models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PackageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Package model.
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
     * Creates a new Package model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Package();
        $images = [];
        if ($model->load(Yii::$app->request->post())) {
            $newimage = Yii::$app->request->post('newimage');
            $countimage = $newimage ? count($newimage) : 0;

            $ward = Ward::findOne($model->ward_id);
            $latlng = explode(',',$ward->latlng);
            $model->latlng = $ward->latlng;
            $model->lat = $latlng[0];
            $model->long = $latlng[1];

            $model->file = UploadedFile::getInstance($model,'file');
            if($model->file){
                $model->file->saveAs(Yii::getAlias('@rootpath').'/static/media/files/package/'.ClaGenerate::getUniqueCode().'.'.$model->file->extension);
                $model->ho_so = '/media/files/package/'.ClaGenerate::getUniqueCode().'.'.$model->file->extension;
            }
            if($model->save()){
                $setava = Yii::$app->request->post('setava');
                $simg_id = str_replace('new_', '', $setava);

                $avatar = [];
                $recount = 0;
                if ($newimage && $countimage > 0) {
                    foreach ($newimage as $image_code) {
                        $imgtem = \common\models\media\ImagesTemp::findOne($image_code);
                        if ($imgtem) {
                            $nimg = new PackageImage();
                            $nimg->attributes = $imgtem->attributes;
                            $nimg->id = NULL;
                            unset($nimg->id);
                            $nimg->package_id = $model->id;
                            if ($nimg->save()) {
                                if ($recount == 0) {
                                    $avatar = $nimg->attributes;
                                    $recount = 1;
                                }
                                if ($imgtem->id == $simg_id) {
                                    $avatar = $nimg->attributes;
                                }
                                $imgtem->delete();
                            }
                        }
                    }
                }
                // set avatar
                if ($avatar && count($avatar)) {
                    $model->avatar_path = $avatar['path'];
                    $model->avatar_name = $avatar['name'];
                    $model->avatar_id = $avatar['id'];
                    $model->save();
                }
            }
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'images' => $images,
            ]);
        }
    }

    /**
     * Updates an existing Package model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $images = Package::getImages($id);
        if ($model->load(Yii::$app->request->post())) {
            $newimage = Yii::$app->request->post('newimage');
            $countimage = $newimage ? count($newimage) : 0;

            $ward = Ward::findOne($model->ward_id);
            $latlng = explode(',',$ward->latlng);
            $model->latlng = $ward->latlng;
            $model->lat = $latlng[0];
            $model->long = $latlng[1];

            $model->file = UploadedFile::getInstance($model,'file');
            if($model->file){
                $model->file->saveAs(Yii::getAlias('@rootpath').'/static/media/files/package/'.ClaGenerate::getUniqueCode().'.'.$model->file->extension);
                $model->ho_so = '/media/files/package/'.ClaGenerate::getUniqueCode().'.'.$model->file->extension;
            }

            if($model->save()){
                $setava = Yii::$app->request->post('setava');
                $simg_id = str_replace('new_', '', $setava);

                $avatar = [];
                $recount = 0;
                if ($newimage && $countimage > 0) {
                    foreach ($newimage as $image_code) {
                        $imgtem = \common\models\media\ImagesTemp::findOne($image_code);
                        if ($imgtem) {
                            $nimg = new PackageImage();
                            $nimg->attributes = $imgtem->attributes;
                            $nimg->id = NULL;
                            unset($nimg->id);
                            $nimg->package_id = $model->id;
                            if ($nimg->save()) {
                                if ($recount == 0) {
                                    $avatar = $nimg->attributes;
                                    $recount = 1;
                                }
                                if ($imgtem->id == $simg_id) {
                                    $avatar = $nimg->attributes;
                                }
                                $imgtem->delete();
                            }
                        }
                    }
                }
                // set avatar
                if ($avatar && count($avatar)) {
                    $model->avatar_path = $avatar['path'];
                    $model->avatar_name = $avatar['name'];
                    $model->avatar_id = $avatar['id'];
                    $model->save();
                }
            }
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'images' => $images,
            ]);
        }
    }

    /**
     * Deletes an existing Package model.
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
     * Finds the Package model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Package the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Package::findOne($id)) !== null) {
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
            $dt = District::dataFromProvinceId($request['province_id']);
            return json_encode($dt);
        } else {
            return false;
        }
    }

    public function actionGetWard()
    {
        $req = Yii::$app->request;
        if ($req->isAjax) {
            $request = $_GET;
            $data = Ward::dataFromDistrictId($request['district_id']);
            return json_encode($data);
        } else {
            return false;
        }
    }
}
