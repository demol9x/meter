<?php

namespace backend\modules\product\controllers;

use Yii;
use common\models\product\Product;
use common\models\product\ProductCategory;
use common\models\product\ProductAttributeSet;
use common\models\product\ProductAttributeOptionPrice;
use common\models\product\ProductAttribute;
use common\models\product\ProductRelation;
use common\models\product\ProductImage;
use common\models\product\ProductConfigurable;
use common\models\product\search\ProductSearch;
use keltstr\simplehtmldom\SimpleHTMLDom as SHD;
use common\components\ClaCategory;
use common\components\UploadLib;
use common\components\ClaLid;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use common\models\transport\Transport;
use common\models\transport\ShopTransport;
use common\models\transport\ProductTransport;
use common\models\product\CertificateProduct;
use common\models\product\CertificateProductItem;
use common\components\ClaHost;
use common\components\ClaGenerate;
use common\models\shop\Shop;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
{

    // public $category_name;
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
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        \common\models\NotificationAdmin::removeNotifaction('product');
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
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
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();

        if ($model->load(Yii::$app->request->post())) {
            $newimage = Yii::$app->request->post('newimage');
            $countimage = $newimage ? count($newimage) : 0;
            //
            $category = new ClaCategory();
            $category->type = ClaCategory::CATEGORY_PRODUCT;
            $category->generateCategory();
            //
            $categoryTrack = array_reverse($category->saveTrack($model->category_id));
            $model->list_category = $model->category_id;
            if (isset($_POST['product_rel_cal']) && $_POST['product_rel_cal']) {
                foreach ($_POST['product_rel_cal'] as $cid) {
                    $model->list_category .= ' ' . $cid;
                    $tg = array_reverse($category->saveTrack($cid));
                    $categoryTrack = array_merge($categoryTrack, $tg);
                }
            }
            $categoryTrack = implode(ClaCategory::CATEGORY_SPLIT, $categoryTrack);
            $shop = Shop::findOne($model->shop_id);
            $model->province_id = $shop->province_id;
            //
            $model->category_track = $categoryTrack;
            $model->start_time = $model->start_time ? strtotime($model->start_time) : 0;
            //
            if (isset($_POST['Attribute'])) {
                $attributes = $_POST['Attribute'];
                $this->_prepareAttribute($attributes, $model);
            }
            if ($model->quality_range && $model->price_range) {
                $tg = '';
                for ($i = 0; $i < count($model->quality_range); $i++) {
                    if ($model->quality_range[$i] != null) {
                        if ($i != count($model->quality_range) - 1) {
                            $tg .= $model->quality_range[$i] . ',';
                        } else {
                            $tg .= $model->quality_range[$i];
                        }
                    }
                }
                $model->quality_range = $tg;
                $tg = '';
                // print_r($model->price_range); die();
                for ($i = 0; $i < count($model->price_range); $i++) {
                    if ($model->price_range[$i] != null) {
                        $tgs = str_replace('.', '', $model->price_range[$i]);
                        if ($i != count($model->price_range) - 1) {
                            $tg .= $tgs . ',';
                        } else {
                            $tg .= $tgs;
                        }
                    }
                }
                $model->price_range = $tg;
            }
            //
            //video
            $videos = $model->videos;
            if (is_array($videos) && $videos) {
                for ($i = 0; $i < count($videos); $i++) {
                    if (!$videos[$i]) {
                        unset($videos[$i]);
                    }
                }
                $model->videos = $videos ? implode(',.,', $videos) : '';
            }
            if ($model->save()) {
                //
                $setava = Yii::$app->request->post('setava');
                $simg_id = str_replace('new_', '', $setava);
                //
                $avatar = [];
                $recount = 0;
                if ($newimage && $countimage > 0) {
                    foreach ($newimage as $image_code) {
                        $imgtem = \common\models\media\ImagesTemp::findOne($image_code);
                        if ($imgtem) {
                            $nimg = new \common\models\product\ProductImage();
                            $nimg->attributes = $imgtem->attributes;
                            $nimg->id = NULL;
                            unset($nimg->id);
                            $nimg->product_id = $model->id;
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

                ProductTransport::updateAll(
                    ['status' => 1, 'product_id' => $model->id],
                    [
                        'status' => 2,
                        'product_id' => Yii::$app->user->id
                    ]
                );

                ProductTransport::createdInShop($model->id, $model->shop_id);

                return $this->redirect(['index']);
            }
        }
        $images = [];
        $attributes_changeprice = [];
        return $this->render('create', [
            'model' => $model,
            'images' => $images,
            'attributes_changeprice' => $attributes_changeprice,
            'shop_transports' => [],
            'product_transports' => [],
        ]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $shop_old = $model->shop_id;
        if ($model->load(Yii::$app->request->post())) {
            //
            $newimage = Yii::$app->request->post('newimage');
            $countimage = $newimage ? count($newimage) : 0;
            //
            $orders_images = Yii::$app->request->post('order');
            //
            //
            $category = new ClaCategory();
            $category->type = ClaCategory::CATEGORY_PRODUCT;
            $category->generateCategory();
            //
            $categoryTrack = array_reverse($category->saveTrack($model->category_id));
            $model->list_category = $model->category_id;
            if (isset($_POST['product_rel_cal']) && $_POST['product_rel_cal']) {
                foreach ($_POST['product_rel_cal'] as $cid) {
                    $model->list_category .= ' ' . $cid;
                    $tg = array_reverse($category->saveTrack($cid));
                    $categoryTrack = array_merge($categoryTrack, $tg);
                }
            }
            $categoryTrack = implode(ClaCategory::CATEGORY_SPLIT, $categoryTrack);
            //
            $model->category_track = $categoryTrack;
            //
            if (isset($_POST['Attribute'])) {
                $attributes = $_POST['Attribute'];
                $this->_prepareAttribute($attributes, $model);
            }
            if ($model->quality_range && $model->price_range) {
                $tg = '';
                for ($i = 0; $i < count($model->quality_range); $i++) {
                    if ($model->quality_range[$i] != null) {
                        if ($i != count($model->quality_range) - 1) {
                            $tg .= $model->quality_range[$i] . ',';
                        } else {
                            $tg .= $model->quality_range[$i];
                        }
                    }
                }
                $model->quality_range = $tg;
                $tg = '';
                // print_r($model->price_range); die();
                for ($i = 0; $i < count($model->price_range); $i++) {
                    if ($model->price_range[$i] != null) {
                        $tgs = str_replace('.', '', $model->price_range[$i]);
                        if ($i != count($model->price_range) - 1) {
                            $tg .= $tgs . ',';
                        } else {
                            $tg .= $tgs;
                        }
                    }
                }
                $model->price_range = $tg;
            }
            //
            $model->start_time = $model->start_time ? strtotime($model->start_time) : 0;
            //video
            $videos = $model->videos;
            if (is_array($videos) && $videos) {
                for ($i = 0; $i < count($videos); $i++) {
                    if (!$videos[$i]) {
                        unset($videos[$i]);
                    }
                }
                $model->videos = $videos ? implode(',.,', $videos) : '';
            }
            $model->admin_update = Yii::$app->user->id;
            $model->admin_update_time = time();
            if ($model->save()) {

                if ($shop_old != $model->shop_id) {
                    if (ShopTransport::find()->where(['shop_id' => $model->shop_id])->one()) {
                        ProductTransport::deleteAll(['product_id' => $model->id, 'default' => 0]);
                    } else {
                        ProductTransport::deleteAll(['product_id' => $model->id]);
                    }
                    ProductTransport::updateAll(
                        ['status' => 1, 'product_id' => $model->id],
                        [
                            'status' => 2,
                            'product_id' => Yii::$app->user->id
                        ]
                    );
                }
                ProductTransport::createdInShop($model->id, $model->shop_id);
                //changprice save
                $attribute_changprice_value = (isset($_POST['attribute_changeprice'])) ? $_POST['attribute_changeprice'] : null;
                $this->saveChangeprice($attribute_changprice_value, $model);
                //
                if (isset($orders_images) && $orders_images) {
                    foreach ($orders_images as $stt => $img) {
                        $imag = ProductImage::findOne($img);
                        $imag->order = $stt;
                        $imag->save();
                    }
                }
                //
                $setava = Yii::$app->request->post('setava');
                $simg_id = str_replace('new_', '', $setava);
                //
                $setava2 = Yii::$app->request->post('setava2');
                $simg2_id = str_replace('new_', '', $setava2);
                //
                $avatar = array();
                if ($newimage && $countimage > 0) {
                    foreach ($newimage as $image_code) {
                        $imgtem = \common\models\media\ImagesTemp::findOne($image_code);
                        if ($imgtem) {
                            $nimg = new \common\models\product\ProductImage();
                            $nimg->attributes = $imgtem->attributes;
                            $nimg->id = NULL;
                            unset($nimg->id);
                            $nimg->product_id = $model->id;
                            if ($nimg->save()) {
                                if ($imgtem->id == $simg_id) {
                                    $avatar = $nimg->attributes;
                                }
                                $imgtem->delete();
                            }
                        } else {
                            if ($image_code == $simg_id) {
                                $avatar = \common\models\product\ProductImage::findOne($image_code);
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
                } else {
                    if ($simg_id != $model->avatar_id) {
                        $imgavatar = \common\models\product\ProductImage::findOne($simg_id);
                        if ($imgavatar) {
                            $model->avatar_path = $imgavatar->path;
                            $model->avatar_name = $imgavatar->name;
                            $model->avatar_id = $imgavatar->id;
                        }
                        $model->save();
                    }
                }
                //chứng thực
                $certificates = Yii::$app->request->post('certificate');
                $in = [-1];
                if (count($certificates)) {
                    for ($i = 0; $i < count($certificates); $i++) {
                        $cer = Yii::$app->request->post('certificate' . $certificates[$i]);
                        if ($cer) {
                            $img = Yii::$app->session[$cer];
                            $cer_item = CertificateProductItem::find()->where(['product_id' => $model->id, 'certificate_product_id' => $certificates[$i]])->one();
                            $cer_item = $cer_item ? $cer_item :  new CertificateProductItem();
                            if ($img) {
                                $cer_item->avatar_path = $img['baseUrl'];
                                $cer_item->avatar_name = $img['name'];
                            }
                            $cer_item->product_id = $model->id;
                            $cer_item->certificate_product_id = $certificates[$i];
                            if ($certificates[$i] == 4) {
                                $cer_item->link_certificate = (isset($_POST['link_certificate'])) ? $_POST['link_certificate'] : '';
                                $cer_item->code = (isset($_POST['code_certificate'])) ? $_POST['code_certificate'] : '';
                            }
                            if ($cer_item->save()) {
                                $in[] = $cer_item['id'];
                            }
                        }
                    }
                }
                CertificateProductItem::deleteAll("id NOT IN (" . implode(',', $in) . ") AND product_id = " . $model->id);
                return $this->redirect(['index']);
            }
        }
        //
        $images = Product::getImages($id);
        //
        $category = ProductCategory::findOne($model->category_id);
        $attribute_set_id = ($category) ? $category->attribute_set_id : 0;
        $attributes_changeprice = ProductAttributeSet::getAttributeChangePrice($attribute_set_id);
        //
        $certificates = CertificateProduct::find()->all();
        $certificate_items = CertificateProductItem::getUpdateProduct($model->id);
        $shop_transports = ShopTransport::getByShop($model->shop_id);
        $product_transports = ProductTransport::getByProduct($model->id);
        $model->videos = is_array($model->videos) ? $model->videos : explode(',.,', $model->videos);
        return $this->render('update', [
            'model' => $model,
            'images' => $images,
            'attributes_changeprice' => $attributes_changeprice,
            'certificates' => $certificates,
            'certificate_items' => $certificate_items,
            'shop_transports' => $shop_transports,
            'product_transports' => $product_transports,
        ]);
    }

    protected function saveChangeprice($attribute_changeprice_value, $model)
    {
        if ($attribute_changeprice_value) {
            if (isset($attribute_changeprice_value['delete']) && count($attribute_changeprice_value['delete'])) {
                foreach ($attribute_changeprice_value['delete'] as $k => $v) {
                    $model_change = ProductAttributeOptionPrice::findOne($v);
                    if ($model_change) {
                        $model_change->delete();
                    }
                }
            }
            if (isset($attribute_changeprice_value['update']) && count($attribute_changeprice_value['update'])) {
                foreach ($attribute_changeprice_value['update'] as $k1 => $v1) {
                    $row = array();
                    if (count($v1)) {
                        foreach ($v1 as $k2 => $v2) {
                            if (empty($v2)) {
                                $row = null;
                                break;
                            }
                            $row['product_id'] = $model->id;
                            $row['attribute_id'] = $k2;
                            $row['option_id'] = isset($v2['option']) ? $v2['option'] : null;
                            $row['change_price'] = isset($v2['price']) ? $v2['price'] : null;
                        }
                    }
                    if ($row) {
                        $model_change = ProductAttributeOptionPrice::findOne($k1);
                        if ($model_change) {
                            $model_change->attributes = $row;
                            try {
                                $model_change->save();
                            } catch (Exception $e) {
                            }
                        }
                    }
                }
            }
            if (isset($attribute_changeprice_value['new']) && count($attribute_changeprice_value['new'])) {
                foreach ($attribute_changeprice_value['new'] as $k1 => $v1) {
                    $row = array();
                    if (count($v1)) {
                        foreach ($v1 as $k2 => $v2) {
                            if (empty($v2)) {
                                $row = null;
                                break;
                            }
                            $row['product_id'] = $model->id;
                            $row['attribute_id'] = $k2;
                            $row['option_id'] = isset($v2['option']) ? $v2['option'] : null;
                            $row['change_price'] = isset($v2['price']) ? $v2['price'] : null;
                        }
                    }
                    if ($row) {
                        $model_change = new ProductAttributeOptionPrice();
                        $model_change->attributes = $row;
                        try {
                            $model_change->save();
                        } catch (Exception $e) {
                        }
                    }
                }
            }
        }
    }

    protected function _prepareAttribute($attributes, $model)
    {
        $attributeValue = array();
        if (!empty($attributes)) {
            foreach ($attributes as $key => $value) {
                if ($key == 'child') {
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
                    if ($modelAtt->field_product) {
                        $field = $modelAtt->field_product;
                        if ($field && ($modelAtt->frontend_input == 'textnumber' || $modelAtt->frontend_input == 'price' || $modelAtt->frontend_input == 'select' || $modelAtt->frontend_input == 'multiselect')) {
                            $field = "cus_field" . $field;
                            if ($modelAtt->frontend_input == 'multiselect') {
                                if (is_array($value) && count($value)) {
                                    $model->$field = array_sum($value);
                                } else {
                                    $model->$field = 0;
                                }
                            } elseif ($modelAtt->frontend_input == 'textnumber') {
                                $value = str_replace(array(".", ","), '.', $value);
                                $model->$field = is_numeric($value) ? $value : 0;
                            } elseif ($modelAtt->frontend_input == 'price') {
                                $value = str_replace(array(".", ","), '', $value);
                                $model->$field = is_numeric($value) ? $value : 0;
                            } else {
                                $model->$field = (int) $value;
                            }
                        }
                    }
                }
            }
        }
        if (!empty($attributeValue)) {
            $attributeValue = json_encode($attributeValue);
            $model->dynamic_field = $attributeValue;
        }
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionDeleteImage($id)
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $id = Yii::$app->request->get('id');
            $image = ProductImage::findOne($id);
            if ($image->delete()) {
                return ['code' => 200];
            }
        }
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDeleteRelation($product_id, $relation_id)
    {
        $relation = ProductRelation::findOne([
            'product_id' => $product_id,
            'relation_id' => $relation_id
        ]);
        $relation->delete();
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Cập nhật trạng thái sản phẩm
     * @return type
     * @throws NotFoundHttpException
     */
    public function actionChangeStatus()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $status = Yii::$app->request->get('status', 0);
            $pid = Yii::$app->request->get('pid');
            $product = Product::findOne($pid);
            if ($product) {
                $product->status = $status;
                $product->admin_update = Yii::$app->user->id;
                $product->admin_update_time = time();
                if ($product->save(false)) {
                    return ['code' => 200];
                } else {
                    throw new NotFoundHttpException('The requested page does not exist.');
                }
            }
        }
    }

    /**
     * Get sản phẩm
     * @return type
     * @throws NotFoundHttpException
     */
    public function actionGetProduct()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $id = Yii::$app->request->get('id', 0);
            $order_id = Yii::$app->request->get('order_id', 0);
            $product = Product::findOne($id);
            if ($product) {
                //
                $data_config = Product::getConfigurables($id);
                $colors = [];
                $first_color = '';
                $sizes = [];
                $configurables = [];
                if ($data_config) {
                    $i = 0;
                    foreach ($data_config as $item) {
                        $i++;
                        if ($i == 1) {
                            $first_color = $item['color'];
                        }
                        $colors[$item['color']] = $item['color'];
                        $sizes[$item['size']] = $item['out_of_stock'];
                        $key = $item['color'];
                        $configurables[$key][] = $item;
                    }
                }
                $html = $this->renderAjax('_html_select_product', [
                    'product' => $product,
                    'configurables' => $configurables,
                    'colors' => $colors,
                    'first_color' => $first_color,
                    'sizes' => $sizes,
                    'order_id' => $order_id
                ]);
                return [
                    'code' => 200,
                    'html' => $html
                ];
            }
        }
    }

    public function actionAddToRelation()
    {
        $isAjax = Yii::$app->request->isAjax;

        $product_id = Yii::$app->request->get('pid');

        if (!$product_id) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        //
        $model = Product::findOne($product_id);
        if (!$model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        //
        if (isset($_POST['rel_products'])) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $rel_products = $_POST['rel_products'];
            $rel_products = explode(',', $rel_products);
            if (count($rel_products)) {
                $list_rel_products = ProductRelation::getProductIdInRel($product_id);
                foreach ($rel_products as $product_rel_id) {
                    if (isset($list_rel_products[$product_rel_id])) {
                        continue;
                    }
                    $product = Product::findOne($product_rel_id);
                    if (!$product) {
                        continue;
                    }
                    Yii::$app->db->createCommand()->insert('product_relation', [
                        'product_id' => $product_id,
                        'relation_id' => $product_rel_id,
                        'created_at' => time(),
                        'type' => ClaLid::PRODUCT_RELATION
                    ])->execute();
                }
                //
                if ($isAjax) {
                    return [
                        'code' => 200,
                        'redirect' => \yii\helpers\Url::to(['/product/product/update', 'id' => $product_id]),
                    ];
                }
                //
            }
        }
        //
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if ($isAjax) {
            return $this->renderAjax('addproduct', [
                'model' => $model,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'isAjax' => $isAjax
            ]);
        }
    }

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionUpdateTransport($product_id, $transport_id, $status)
    {
        $product_ids = $product_id;
        $product_id = $product_id ? $product_id : Yii::$app->user->id;
        $transport = ProductTransport::getByProductAndTransport($product_id, $transport_id);
        if (!$status) {
            if ($transport) {
                $transport->status = $product_ids ? 1 : 2;
            } else {
                $transport = new ProductTransport();
                $transport->status = $product_ids ? 1 : 2;
                $transport->transport_id = $transport_id;
                $transport->product_id = $product_id;
            }
            $transport->default = 0;
        } else {
            if ($transport) {
                $transport->status = $product_ids ? 1 : 2;
            } else {
                $transport = new ProductTransport();
                $transport->status =  $product_ids ? 1 : 2;
                $transport->transport_id = $transport_id;
                $transport->product_id = $product_id;
            }
            $transport->default = 1;
            ProductTransport::setDefaultZero($product_id);
        }
        return $transport->save();
    }

    public function actionUploadproductfilecrop()
    {
        $data = $_POST['url_img'];

        $id = isset($_POST['id']) ? $_POST['id'] : 0;

        if (strpos($data, 'ata:image/png;base64')) {
            $data = str_replace('data:image/png;base64,', '', $data);
            $end = '.png';
        } else {
            $data = str_replace('data:image/jpeg;base64,', '', $data);
            $end = '.jpg';
        }
        $data = str_replace(' ', '+', $data);

        $data = base64_decode($data);

        $name = rand() . time() . $end;

        $file = '../../static/media/images/product/' . $name;

        $success = file_put_contents($file, $data);

        if ($avatartg = \common\models\product\ProductImage::findOne($id)) {
            $avatartg->path = '/media/images/product/';
            $avatartg->name = $name;
            $avatartg->save();
        } else {
            if ($avatartg = \common\models\media\ImagesTemp::findOne($id));
            $avatartg->path = '/media/images/product/';
            $avatartg->name = $name;
            $avatartg->save();
        }
        return ClaHost::getImageHost() . '/media/images/product/s200_200/' . $name;
    }

    public function actionUploadfilec()
    {
        if (isset($_FILES['file'])) {
            $file = $_FILES['file'];
            if ($file['size'] > 1024 * 1024 * 8) {
                Yii::$app->end();
            }
            $up = new UploadLib($file);
            $up->setPath(array('certificate', date('Y_m_d', time())));
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

    public function actionLoadTransport()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $shop_id = Yii::$app->request->get('shop_id', 0);
            $shop_transports = ShopTransport::getByShop($shop_id);
            if ($shop_transports) {
                $form = new \yii\widgets\ActiveForm();
                $model = new Product;
                $html = $this->renderAjax('partial/transport', [
                    'model' => $model,
                    'form' => $form,
                    'shop_transports' => $shop_transports,
                    'product_transports' => null,
                ]);
                return [
                    'code' => 200,
                    'html' => $html
                ];
            } else {
                return [
                    'code' => 200,
                    'html' => Yii::t('app', 'create_product_1') . '<a class="btn btn-primary" target="_bank" href="' . Url::to(['/user/shop/update', 'id' => $shop_id]) . '">' . Yii::t('app', 'click_here') . '</a> Và ' . '<a class="btn btn-primary" target="_bank" onclick="loadTranport(1)">' . Yii::t('app', 'reload') . '</a>'
                ];
            }
        }
    }

    // Nổi bật
    public function actionUpdatermthot($id)
    {
        $model = Product::findOne($id);
        $model->ishot = 0;
        if ($model->save()) {
            return \yii\helpers\Json::encode(array(
                'code' => 200,
                'html' => '<i class="fa fa-times" aria-hidden="true"></i>',
                'title' => Yii::t('app', 'click_to_on'),
                'link' => Url::to(['/product/product/updateaddhot', 'id' => $id])
            ));
        } else {
            return \yii\helpers\Json::encode(array('code' => 400));
        }
    }

    public function actionUpdateaddhot($id)
    {
        $model = Product::findOne($id);
        $model->ishot = 1;
        if ($model->save()) {
            return \yii\helpers\Json::encode(array(
                'code' => 200,
                'html' => '<i class="fa fa-check" aria-hidden="true"></i>',
                'title' => Yii::t('app', 'click_to_off'),
                'link' => Url::to(['/product/product/updatermthot', 'id' => $id])
            ));
        } else {
            return \yii\helpers\Json::encode(array('code' => 400));
        }
    }

    // NEWS
    public function actionUpdatermtnew($id)
    {
        $model = Product::findOne($id);
        $model->isnew = 0;
        if ($model->save()) {
            return \yii\helpers\Json::encode(array(
                'code' => 200,
                'html' => '<i class="fa fa-times" aria-hidden="true"></i>',
                'title' => Yii::t('app', 'click_to_on'),
                'link' => Url::to(['/product/product/updateaddnew', 'id' => $id])
            ));
        } else {
            return \yii\helpers\Json::encode(array('code' => 400));
        }
    }

    public function actionUpdateaddnew($id)
    {
        $model = Product::findOne($id);
        $model->isnew = 1;
        if ($model->save()) {
            return \yii\helpers\Json::encode(array(
                'code' => 200,
                'html' => '<i class="fa fa-check" aria-hidden="true"></i>',
                'title' => Yii::t('app', 'click_to_off'),
                'link' => Url::to(['/product/product/updatermtnew', 'id' => $id])
            ));
        } else {
            return \yii\helpers\Json::encode(array('code' => 400));
        }
    }
    // Vo so connect
    public function actionUpdatermtvscn($id)
    {
        $model = Product::findOne($id);
        $model->voso_connect = 0;
        if ($model->save()) {
            return \yii\helpers\Json::encode(array(
                'code' => 200,
                'html' => '<i class="fa fa-times" aria-hidden="true"></i>',
                'title' => Yii::t('app', 'click_to_on'),
                'link' => Url::to(['/product/product/updateaddvscn', 'id' => $id])
            ));
        } else {
            return \yii\helpers\Json::encode(array('code' => 400));
        }
    }

    public function actionUpdateaddvscn($id)
    {
        $model = Product::findOne($id);
        $model->voso_connect = 1;
        if ($model->save()) {
            return \yii\helpers\Json::encode(array(
                'code' => 200,
                'html' => '<i class="fa fa-check" aria-hidden="true"></i>',
                'title' => Yii::t('app', 'click_to_off'),
                'link' => Url::to(['/product/product/updatermtvscn', 'id' => $id])
            ));
        } else {
            return \yii\helpers\Json::encode(array('code' => 400));
        }
    }


    public function actionExelOld()
    {
        $data = Product::find()->select('product.*, c.name as category_name, sh.name as shop_name, pv.name as province_name')->leftJoin("product_category as c", "product.category_id = c.id")->leftJoin("shop as sh", "product.shop_id = sh.id")->leftJoin("province as pv", "product.province_id = pv.id")->orderBy('name ASC')->asArray()->all();

        $filename = "thongkesanpham.xls"; // File Name

        // Download file
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel;charset=UTF-8");

        // Write data to file
        $flag = false;
        $row = [];
        $table = '';
        foreach ($data as $value) {

            if (!$flag) {
                // display field/column names as first row
                $table .= '<tr>';
                $table .= '<td>ID</td>';
                $table .= '<td>Tên</td>';
                $table .= '<td>ID danh mục</td>';
                $table .= '<td>Danh mục</td>';
                $table .= '<td>Giá</td>';
                $table .= '<td>Nổi bật</td>';
                $table .= '<td>ID shop</td>';
                $table .= '<td>Tên Shop</td>';
                $table .= '<td>ID Tỉnh thành</td>';
                $table .= '<td>Tỉnh thành</td>';
                $table .= '</tr>';
                $flag = true;
                $row['price'] = $value['price'];
            }
            $table .= '<tr>';
            $table .= '<td>' . $value['id'] . '</td>';
            $table .= '<td>' . $value['name'] . '</td>';
            $table .= '<td>' . $value['category_id'] . '</td>';
            $table .= '<td>' . $value['category_name'] . '</td>';
            $table .= '<td>' . $value['price'] . '</td>';
            $table .= '<td>' . $value['ishot'] . '</td>';
            $table .= '<td>' . $value['shop_id'] . '</td>';
            $table .= '<td>' . $value['shop_name'] . '</td>';
            $table .= '<td>' . $value['province_id'] . '</td>';
            $table .= '<td>' . $value['province_name'] . '</td>';
            $table .= '</tr>';
        }
        // echo $this->renderAjax('exel',['body' => $table]);
        echo '<table>';
        echo $table;
        echo '</table>';
    }

    public function actionExel()
    {
        $data = Product::find()->select('product.*, sh.name as shop_name, sh.phone as shop_phone, sh.email as shop_email, sh.address as shop_address, sh.description as shop_description,  u.username, pv.name as province_name')->leftJoin("shop as sh", "product.shop_id = sh.id")->leftJoin("user as u", "product.shop_id = u.id")->leftJoin("province as pv", "product.province_id = pv.id")->orderBy('name ASC')->asArray()->all();
        $categorys = [];
        $tg = ProductCategory::find()->all();
        foreach ($tg as $category) {
            $categorys[$category->id] = $category;
        }
        $filename = "thongkesanpham.xls"; // File Name
        // Download file
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel;charset=UTF-8");

        // Write data to file
        $flag = false;
        $row = [];
        $table = '';
        $i = 1;
        foreach ($data as $value) {
            if (!$flag) {
                // display field/column names as first row
                $table .= '<tr>';
                $table .= '<td>STT</td>';
                $table .= '<td>Danh mục cha</td>';
                $table .= '<td>ID gian hàng</td>';
                $table .= '<td>Tên sản phẩm</td>';
                $table .= '<td>ID danh mục</td>';
                $table .= '<td>Danh mục sản phẩm</td>';
                $table .= '<td>Tên gian hàng</td>';
                $table .= '<td>Tên chủ gian hàng</td>';
                $table .= '<td>Số điện thoại</td>';
                $table .= '<td>Email</td>';
                $table .= '<td>Địa chỉ</td>';
                $table .= '<td>Chi chú</td>';
                $table .= '</tr>';
                $flag = true;
                $row['price'] = $value['price'];
            }
            $category = isset($categorys[$value['category_id']]) ? $categorys[$value['category_id']] : [];
            $category_parent = $category ? (isset($categorys[$category->parent]) ? $categorys[$category->parent] : []) : [];
            $table .= '<tr>';
            $table .= '<td>' . $i++ . '</td>';
            $table .= '<td>' . ($category_parent ? $category_parent['name'] : '') . '</td>';
            $table .= '<td>' . $value['shop_id'] . '</td>';
            $table .= '<td>' . $value['name'] . '</td>';
            $table .= '<td>' . $value['category_id'] . '</td>';
            $table .= '<td>' . ($category ? $category['name'] : '') . '</td>';
            $table .= '<td>' . $value['shop_name'] . '</td>';
            $table .= '<td>' . $value['username'] . '</td>';
            $table .= '<td>' . $value['shop_phone'] . '</td>';
            $table .= '<td>' . $value['shop_email'] . '</td>';
            $table .= '<td>' . $value['shop_address'] . '</td>';
            $table .= '<td></td>';
            $table .= '</tr>';
        }
        // echo $this->renderAjax('exel',['body' => $table]);
        echo '<table>';
        echo $table;
        echo '</table>';
    }
}
