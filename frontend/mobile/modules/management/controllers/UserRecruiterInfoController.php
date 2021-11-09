<?php

namespace frontend\mobile\modules\management\controllers;

use frontend\controllers\CController;
use Yii;
use frontend\models\UserRecruiterInfo;
use frontend\models\UserRecruiterInfoSearch;
use common\models\Province;
use common\models\District;
use common\models\Ward;
//
use common\components\UploadLib;
use common\components\ClaHost;
use common\components\ClaGenerate;
//
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserRecruiterInfoController implements the CRUD actions for UserRecruiterInfo model.
 */
class UserRecruiterInfoController extends CController {

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
     * Lists all UserRecruiterInfo models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new UserRecruiterInfoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserRecruiterInfo model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new UserRecruiterInfo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        //
        $id = Yii::$app->user->getId();
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            // upload avatar
            if ($model->avatar) {
                $avatar = Yii::$app->session[$model->avatar];
                if ($avatar) {
                    $model->avatar_path = $avatar['baseUrl'];
                    $model->avatar_name = $avatar['name'];
                }
                unset(Yii::$app->session[$model->avatar]);
            }
            //
            $model->user_id = $id;
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->user_id]);
            }
        }
        // Tỉnh/thành phố
        $provinces = Province::optionsProvince('Tỉnh/thành phố');

        // Quận/huyện
        $districts = District::dataFromProvinceId($model->province_id);

        // Phường/xã
        $wards = Ward::dataFromDistrictId($model->district_id);

        return $this->render('create', [
                    'model' => $model,
                    'provinces' => $provinces,
                    'districts' => $districts,
                    'wards' => $wards,
        ]);
    }

    /**
     * Updates an existing UserRecruiterInfo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate() {
        //
        $id = Yii::$app->user->getId();

        $user = \frontend\models\User::findIdentity($id);

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            // upload avatar
            if ($model->avatar) {
                $avatar = Yii::$app->session[$model->avatar];
                if ($avatar) {
                    $model->avatar_path = $avatar['baseUrl'];
                    $model->avatar_name = $avatar['name'];
                }
                unset(Yii::$app->session[$model->avatar]);
            }
            //
            $model->user_id = $id;
            if ($model->save()) {
                $user->username = Yii::$app->request->post('User')['username'];
                $user->save();
                return $this->redirect(['update']);
            }
        }
        // Tỉnh/thành phố
        $provinces = Province::optionsProvince('Tỉnh/thành phố');

        // Quận/huyện
        $districts = District::dataFromProvinceId($model->province_id);

        // Phường/xã
        $wards = Ward::dataFromDistrictId($model->district_id);

        return $this->render('update', [
                    'user' => $user,
                    'model' => $model,
                    'provinces' => $provinces,
                    'districts' => $districts,
                    'wards' => $wards,
        ]);
    }

    /**
     * Finds the UserRecruiterInfo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return UserRecruiterInfo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        $model = UserRecruiterInfo::findOne($id);
        if ($model === NULL) {
            $model = new UserRecruiterInfo();
        }
        return $model;
    }

    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    /**
     * upload file
     */
    public function actionUploadfile() {
        if (isset($_FILES['file'])) {
            $file = $_FILES['file'];
            if ($file['size'] > 1024 * 1000) {
                Yii::$app->end();
            }
            $up = new UploadLib($file);
            $up->setPath(array('user', date('Y_m_d', time())));
            $up->uploadImage();
            $return = array();
            $response = $up->getResponse(true);
            $return = array('status' => $up->getStatus(), 'data' => $response, 'host' => ClaHost::getImageHost(), 'size' => '');
            if ($up->getStatus() == '200') {
                $keycode = ClaGenerate::getUniqueCode();
                $return['data']['realurl'] = ClaHost::getImageHost() . $response['baseUrl'] . 's100_100/' . $response['name'];
                $return['data']['avatar'] = $keycode;
                Yii::$app->session[$keycode] = $response;
            }
            echo json_encode($return);
            Yii::$app->end();
        }
        //
    }

}
