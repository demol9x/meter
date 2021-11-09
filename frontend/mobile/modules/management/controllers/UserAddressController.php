<?php

namespace frontend\mobile\modules\management\controllers;

use Yii;
use common\models\user\UserAddress;
use common\models\shop\Shop;
use common\models\Province;
use common\models\District;
use common\models\Ward;
use common\models\shop\ShopSearch;
use common\components\UploadLib;
use common\components\ClaHost;
use common\components\ClaGenerate;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\shop\ShopImages;
use common\components\ClaLid;

/**
 * ShopController implements the CRUD actions for Shop model.
 */
class UserAddressController extends Controller
{
    public $layout = 'main_user';
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

    public function actionIndex()
    {
        $model = new UserAddress();
        $shops = UserAddress::find()->where(['user_id' => Yii::$app->user->id])->orderBy('isdefault DESC, id DESC')->all();
        $list_district = District::dataFromProvinceId($model->province_id);
        $list_ward = Ward::dataFromDistrictId($model->district_id);
        $list_province = Province::optionsProvince(); 
        return $this->render('index', [
            'model' => $model,
            'address' => $shops,
            'list_district' => $list_district,
            'list_ward' => $list_ward,
            'list_province' => $list_province,
        ]);
    }

    /**
     * Creates a new Shop model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UserAddress();
        if ($model->load(Yii::$app->request->post())) {
            $model->user_id = Yii::$app->user->id;
            //
            $model->province_name = ($tg = Province::findOne($model->province_id)) ? $tg['name'] : '';
            $model->district_name = ($tg = District::findOne($model->district_id)) ? $tg['name'] : '';
            $model->ward_name = ($tg = Ward::findOne($model->ward_id)) ? $tg['name'] : '';
            $addtg = UserAddress::getDefaultAddress();
            if($model->isdefault) {
                UserAddress::updateAll(
                    ['isdefault' => 0,], [ 
                    'isdefault' => 1, 
                    'user_id' => Yii::$app->user->id
                ]);
                if($model->save()) {
                    ClaLid::resetLocaltionDefault();
                    return $this->redirect(['index']);
                }
            } else {
                if(!$addtg) {
                    $model->isdefault =1;
                }
                if($model->save()) {
                    ClaLid::resetLocaltionDefault();
                    return $this->redirect(['index']);
                }
            }
        }
        $list_district = District::dataFromProvinceId(0);
        $list_ward = Ward::dataFromDistrictId(0);
        $list_province = Province::optionsProvince(); 
        return $this->render('create', [
            'model' => $model,
            'list_district' => $list_district,
            'list_ward' => $list_ward,
            'list_province' => $list_province,
        ]);
    }

    

    /**
     * Updates an existing Shop model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $isdefault = $model->isdefault;
        if ($model->load(Yii::$app->request->post())) {
            $model->user_id = Yii::$app->user->id;
            //
            $model->province_name = ($tg = Province::findOne($model->province_id)) ? $tg['name'] : '';
            $model->district_name = ($tg = District::findOne($model->district_id)) ? $tg['name'] : '';
            $model->ward_name = ($tg = Ward::findOne($model->ward_id)) ? $tg['name'] : '';
            if(!$isdefault && $model->isdefault) {
                UserAddress::updateAll(
                    ['isdefault' => 0,], [ 
                    'isdefault' => 1, 
                    'user_id' => Yii::$app->user->id
                ]);
                if($model->save()) {
                    ClaLid::resetLocaltionDefault();
                    return $this->redirect(['index']);
                }
            } else {
                if($model->save()) {
                    return $this->redirect(['index']);
                }
            }
        } 
        $list_district = District::dataFromProvinceId($model->province_id);
        $list_ward = Ward::dataFromDistrictId($model->district_id);
        $list_province = Province::optionsProvince(); 
         return $this->render('update', [
            'model' => $model,
            'list_district' => $list_district,
            'list_ward' => $list_ward,
            'list_province' => $list_province,
        ]);
    }

    public function actionUpdatedf($id)
    {
        $model = $this->findModel($id);
        UserAddress::updateAll(
            ['isdefault' => 0,], [ 
            'isdefault' => 1, 
            'user_id' => Yii::$app->user->id
        ]);
        $model->isdefault =1;
        if($model->save()) {
            ClaLid::resetLocaltionDefault();
            Yii::$app->session->setFlash('success', Yii::t('app', 'update_success'));
        } else {
            Yii::$app->session->setFlash('error',  Yii::t('app', 'update_eror'));
        }
        return $this->redirect(['index']);
    }

    public function actionDel($id)
    {
        if($model = $this->findModel($id)) {
            if(!$model->isdefault) {
                $model->delete();
                Yii::$app->session->setFlash('success', Yii::t('app', 'delete_success'));
            } else {
                Yii::$app->session->setFlash('error',  Yii::t('app', 'error_delete_address_default'));
            }
        }
        return $this->redirect(['index']);
    }


    /**
     * Finds the Shop model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Shop the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserAddress::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

}
