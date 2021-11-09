<?php

namespace backend\modules\product\controllers;

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
class ProductCategoryController extends Controller {

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
     * Lists all ProductCategory models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new ProductCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 100;
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all ProductCategory models.
     * @return mixed
     */
    public function actionIndexPoint() {
        $searchModel = new ProductCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 100;
        return $this->render('index_point', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProductCategory model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ProductCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new ProductCategory();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->parent) {
                $category_parent = $this->findModel($model->parent);
                $model->level = $category_parent->level++;
            } else {
                $model->parent = 0;
            }
            // upload avatar
            if ($model->avatar) {
                $avatar = Yii::$app->session[$model->avatar];
                if ($avatar) {
                    $model->avatar_path = $avatar['baseUrl'];
                    $model->avatar_name = $avatar['name'];
                }
                unset(Yii::$app->session[$model->avatar]);
            }
            if ($model->avatar2) {
                $avatar2 = Yii::$app->session[$model->avatar2];
                if ($avatar2) {
                    $model->icon_path = $avatar2['baseUrl'];
                    $model->icon_name = $avatar2['name'];
                }
                unset(Yii::$app->session[$model->avatar2]);
            }
            if ($model->avatar3) {
                $avatar3 = Yii::$app->session[$model->avatar3];
                if ($avatar3) {
                    $model->bgr_path = $avatar3['baseUrl'];
                    $model->bgr_name = $avatar3['name'];
                }
                unset(Yii::$app->session[$model->avatar3]);
            }
            if (isset($_POST['Attribute'])) {
                $attributes = $_POST['Attribute'];
                $this->_prepareAttribute($attributes, $model);
            } else {
                $model->dynamic_field = NULL;
            }
            if ($model->save()) {
                return $this->redirect(['index']);
            }
        }
        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing ProductCategory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->parent) {
                $category_parent = $this->findModel($model->parent);
                $model->level = $category_parent->level + 1;
            } else {
                $model->parent = 0;
            }
            // upload avatar
            if ($model->avatar) {
                $avatar = Yii::$app->session[$model->avatar];
                if ($avatar) {
                    $model->avatar_path = $avatar['baseUrl'];
                    $model->avatar_name = $avatar['name'];
                }
                unset(Yii::$app->session[$model->avatar]);
            }
            if ($model->avatar2) {
                $avatar2 = Yii::$app->session[$model->avatar2];
                if ($avatar2) {
                    $model->icon_path = $avatar2['baseUrl'];
                    $model->icon_name = $avatar2['name'];
                }
                unset(Yii::$app->session[$model->avatar2]);
            }
            if ($model->avatar3) {
                $avatar3 = Yii::$app->session[$model->avatar3];
                if ($avatar3) {
                    $model->bgr_path = $avatar3['baseUrl'];
                    $model->bgr_name = $avatar3['name'];
                }
                unset(Yii::$app->session[$model->avatar3]);
            }
            if (isset($_POST['Attribute'])) {
                $attributes = $_POST['Attribute'];
                $this->_prepareAttribute($attributes, $model);
            } else {
                $model->dynamic_field = NULL;
            }
            if ($model->save()) {
                return $this->redirect(['index']);
            }
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    public function actionUpdatePoint($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->parent) {
                $category_parent = $this->findModel($model->parent);
                $model->level = $category_parent->level + 1;
            } else {
                $model->parent = 0;
            }
            // upload avatar
            if ($model->avatar) {
                $avatar = Yii::$app->session[$model->avatar];
                if ($avatar) {
                    $model->avatar_path = $avatar['baseUrl'];
                    $model->avatar_name = $avatar['name'];
                }
                unset(Yii::$app->session[$model->avatar]);
            }
            if ($model->avatar2) {
                $avatar2 = Yii::$app->session[$model->avatar2];
                if ($avatar2) {
                    $model->icon_path = $avatar2['baseUrl'];
                    $model->icon_name = $avatar2['name'];
                }
                unset(Yii::$app->session[$model->avatar2]);
            }
            if ($model->avatar3) {
                $avatar3 = Yii::$app->session[$model->avatar3];
                if ($avatar3) {
                    $model->bgr_path = $avatar3['baseUrl'];
                    $model->bgr_name = $avatar3['name'];
                }
                unset(Yii::$app->session[$model->avatar3]);
            }
            if (isset($_POST['Attribute'])) {
                $attributes = $_POST['Attribute'];
                $this->_prepareAttribute($attributes, $model);
            } else {
                $model->dynamic_field = NULL;
            }
            if ($model->save()) {
                return $this->redirect(['index-point']);
            }
        } else {
            return $this->render('update_point', [
                        'model' => $model,
            ]);
        }
    }

    protected function _prepareAttribute($attributes, $model) {
        $attributeValue = array();
        if (!empty($attributes)) {
            foreach ($attributes as $key => $value) {
                if ($key == 'child' || !$value) {
                    continue;
                }
                $modelAtt = ProductAttribute::findOne($key);
                if ($modelAtt) {
                    $keyR = count($attributeValue);
                    $attributeValue[$keyR] = array();
                    $attributeValue[$keyR]['id'] = $key;
                    $attributeValue[$keyR]['name'] = $modelAtt->name;
                    $attributeValue[$keyR]['code'] = $modelAtt->code;
                    $attributeValue[$keyR]['index_key'] = ($modelAtt->frontend_input == 'select' || $modelAtt->frontend_input == 'multiselect') ? $value : 0;
                    $attributeValue[$keyR]['value'] = $value;
                }
            }
        }
        $attributeValue = json_encode($attributeValue);
        $model->dynamic_field = $attributeValue;
    }

    /**
     * Deletes an existing ProductCategory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionSaveOrder($id, $order) {
        $model = $this->findModel($id);
        if($model) {
            $model->order = $order;
            $model->save();
        }
        return '1';
    }

    /**
     * Finds the ProductCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ProductCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = ProductCategory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
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
            $up->setPath(array('product-category', date('Y_m_d', time())));
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

    public function actionExel() {
        $data = ProductCategory::find()->select('product_category.*, c.name as prarent_name')->leftJoin("product_category as c", "product_category.parent = c.id")->orderBy('parent ASC')->asArray()->all();
         
        $filename = "thongkedanhmuc.xls"; // File Name
        // Download file
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel;charset=UTF-8");

        // Write data to file
        $flag = false;
        $row = [];
        $table = '';
        foreach ($data as $value) {
           
            if(!$flag) {
              // display field/column names as first row
                $table .= '<tr>';
                $table .= '<td>ID</td>';
                $table .= '<td>Danh mục</td>';
                $table .= '<td>ID Danh mục chứa</td>';
                $table .= '<td>Danh mục chứa</td>';
                $table .= '</tr>';
                $flag = true;
            }
            $table .= '<tr>';
            $table .= '<td>'.$value['id'].'</td>';
            $table .= '<td>'.$value['name'].'</td>';
            $table .= '<td>'.$value['parent'].'</td>';
            $table .= '<td>'.$value['prarent_name'].'</td>';
            $table .= '</tr>';
        }
        // echo $this->renderAjax('exel',['body' => $table]);
        echo '<table>';
        echo $table;
        echo '</table>';  
    }

    /**
     * 
     */
    public function actionGetNhvtFinal() {
        echo "<pre>";
        print_r(987);
        echo "</pre>";
        die();
        $categories = ProductCategory::find()->all();
        foreach ($categories as $category) {
            $ids = explode(' ', $category->map_nhvt2);
            $codes_string = '';
            foreach ($ids as $id) {
                $cats = \common\models\product\ProductAttributeOption::find()
                        ->where('attribute_id = 22 AND code_app LIKE :code_app', [':code_app' => $id . '%'])
                        ->asArray()
                        ->all();
                $codes = array_column($cats, 'code_app');
                $string = implode(' ', $codes);
                if ($codes_string != '') {
                    $codes_string .= ' ';
                }
                $codes_string .= $string;
            }
            $category->map_nhvt2_final = $codes_string;
            $category->save();
        }
        echo "<pre>";
        print_r('DONE');
        echo "</pre>";
        die();
    }

}
