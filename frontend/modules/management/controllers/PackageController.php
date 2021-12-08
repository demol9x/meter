<?php

namespace frontend\modules\management\controllers;


use common\components\ClaGenerate;
use common\models\District;
use common\models\package\PackageImage;
use common\models\package\PackageOrder;
use common\models\Ward;
use frontend\modules\shop\Shop;
use Yii;
use common\models\package\Package;
use yii\db\Expression;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;


class PackageController extends Controller
{


    public function actionIndex()
    {
        $this->layout = 'main';
        $packages = Package::find()->where(['shop_id' => Yii::$app->user->id])->joinWith(['province'])->asArray()->all();
        return $this->render('index', [
            'packages' => $packages,
        ]);
    }

    public function actionCreate()
    {
        $model = new Package();
        $images = [];
        if ($model->load(Yii::$app->request->post())) {
            $newimage = Yii::$app->request->post('newimage');
            $countimage = $newimage ? count($newimage) : 0;

            $ward = Ward::findOne($model->ward_id);
            $latlng = explode(',', $ward->latlng);
            $model->latlng = $ward->latlng;
            $model->lat = $latlng[0];
            $model->long = $latlng[1];

            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->file) {
                $model->file->saveAs(Yii::getAlias('@rootpath') . '/static/media/files/package/' . ClaGenerate::getUniqueCode() . '.' . $model->file->extension);
                $model->ho_so = '/media/files/package/' . ClaGenerate::getUniqueCode() . '.' . $model->file->extension;
            }
            if ($model->save()) {
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
            $latlng = explode(',', $ward->latlng);
            $model->latlng = $ward->latlng;
            $model->lat = $latlng[0];
            $model->long = $latlng[1];

            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->file) {
                $model->file->saveAs(Yii::getAlias('@rootpath') . '/static/media/files/package/' . ClaGenerate::getUniqueCode() . '.' . $model->file->extension);
                $model->ho_so = '/media/files/package/' . ClaGenerate::getUniqueCode() . '.' . $model->file->extension;
            }

            if ($model->save()) {
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

    public function actionDeleteImage($id)
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $id = Yii::$app->request->get('id');
            $image = PackageImage::findOne($id);
            if ($image->delete()) {
                return ['code' => 200];
            }
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

    public function actionOrder()
    {
        $orders = PackageOrder::find()
            ->select(['COUNT(*) AS count', 'package_order.*'])
            ->where(['shop_package_id' => Yii::$app->user->id])
            ->joinWith(['package'])
            ->groupBy('package_id')->asArray()->all();
        return $this->render('order', ['orders' => $orders]);
    }


    public function actionDetail($id)
    {
        $shop_oder = PackageOrder::find()->where(['package_id' => $id])->asArray()->all();

        return $this->render('detail', ['shop_oder' => $shop_oder]);

    }


    public function actionViewpopup()
    {
        $data_id = Yii::$app->request->get('data_id', 0);
        $mess = '';
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $shop_oder = PackageOrder::find()->where(['id' => $data_id])->asArray()->One();
            if ($shop_oder) {
                $html = $this->renderAjax('viewpopup', [
                    'shop_oder' => $shop_oder
                ]);
                return [
                    'code' => 200,
                    'html' => $html,
                ];
            } else {
                $mess = 'lỗi rồi';
                return
                    [
                        'code' => 400,
                        'mess' => $mess
                    ];
            }
        }

    }

}
