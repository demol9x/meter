<?php

namespace backend\modules\product\controllers;

use Yii;
use common\models\product\ProductAttribute;
use common\models\product\ProductAttributeOption;
use common\models\product\search\ProductAttributeSearch;
use common\components\UploadLib;
use common\components\ClaHost;
use common\components\ClaGenerate;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\HtmlFormat;

/**
 * ProductAttributeController implements the CRUD actions for ProductAttribute model.
 */
class ProductAttributeController extends Controller {

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
     * Lists all ProductAttribute models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new ProductAttributeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 100;
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
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ProductAttribute model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new ProductAttribute();
        $model->sort_order = (int) $model->getMaxOrder() + 2;
        if ($model->load(Yii::$app->request->post())) {
            //
            $model->code = ($model->code) ? HtmlFormat::parseToAlias($model->code) : HtmlFormat::parseToAlias($model->name);
            //
            $model->field_product = $model->generateFieldProduct($model->attribute_set_id, $model->frontend_input, $model->is_system);
            //
            $model->field_configurable = $model->generateFieldConfigurable($model->attribute_set_id, $model->is_configurable, $model->frontend_input, $model->is_system);
            //
            // upload avatar
            if ($model->avatar) {
                $avatar = Yii::$app->session[$model->avatar];
                if ($avatar) {
                    $model->avatar_path = $avatar['baseUrl'];
                    $model->avatar_name = $avatar['name'];
                }
                unset(Yii::$app->session[$model->avatar]);
            }
            if ($model->save()) {
                $options = Yii::$app->request->post('ProductAttributeOption');
                $this->saveAttributeOption($model, $options);
                return $this->redirect(['index']);
            }
        }
        //
        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing ProductAttribute model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            //
            $model->code = ($model->code) ? HtmlFormat::parseToAlias($model->code) : HtmlFormat::parseToAlias($model->name);
            //
            if ((int) $model->is_configurable && !(int) $model->field_configurable) {
                $model->field_configurable = $model->generateFieldConfigurable($model->attribute_set_id, $model->is_configurable, $model->frontend_input);
            }
            //
            // upload avatar
            if ($model->avatar) {
                $avatar = Yii::$app->session[$model->avatar];
                if ($avatar) {
                    $model->avatar_path = $avatar['baseUrl'];
                    $model->avatar_name = $avatar['name'];
                }
                unset(Yii::$app->session[$model->avatar]);
            }
            if ($model->save()) {
                $options = Yii::$app->request->post('ProductAttributeOption');
                $this->saveAttributeOption($model, $options);
                return $this->redirect(['index']);
            }
        }
        //
        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ProductAttribute model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id) {
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
    protected function findModel($id) {
        if (($model = ProductAttribute::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function saveAttributeOption($attribute, $options_post, $files = null) {
        if (count($options_post)) {
            $default_value = isset($options_post['default_value']) ? $options_post['default_value'] : null;
            foreach ($options_post as $key => $oplist) {
                if ($key == 'new') {
                    foreach ($oplist as $key1 => $opitem) {
                        if ($opitem['value']) {
                            $modelOp = new ProductAttributeOption();
                            $modelOp->attribute_id = $attribute->id;
                            $modelOp->value = trim($opitem['value']);
                            $modelOp->sort_order = $opitem['sort_order'];
                            $modelOp->ext = $opitem['ext'];
                            $modelOp->code_app = $opitem['code_app'];
                            if ($modelOp->save()) {
                                $modelOp->index_key = ($attribute->frontend_input == 'multiselect') ? $modelOp->generateKeyMulti($modelOp->attribute_id) : $modelOp->id;
                                $modelOp->save();
                                if ($default_value == 'n-' . $key1) {
                                    $default_value = $modelOp->index_key;
                                }
                            }
                        }
                    }
                } else if ($key == 'update') {
                    foreach ($oplist as $key1 => $opitem) {
                        if ($opitem['value']) {
                            $modelOp = ProductAttributeOption::findOne($key1);
                            if ($modelOp) {
                                $modelOp->value = trim($opitem['value']);
                                $modelOp->sort_order = $opitem['sort_order'];
                                $modelOp->ext = $opitem['ext'];
                                $modelOp->code_app = $opitem['code_app'];
                                if ($modelOp->save()) {
                                    if ($default_value == 'u-' . $key1) {
                                        $default_value = $modelOp->index_key;
                                    }
                                }
                            }
                        }
                    }
                } else if ($key == 'delete') {
                    foreach ($oplist as $key1 => $opitem) {
                        $modelOp = ProductAttributeOption::findOne($key1);
                        $modelOp->delete();
                    }
                }
            }
            if (is_numeric($default_value) && $default_value != $attribute->default_value) {
                $attribute->default_value = $default_value;
                $attribute->save();
            }
        }
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
            $up->setPath(array('attribute', date('Y_m_d', time())));
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
