<?php

namespace frontend\modules\management\controllers;

use Yii;
use common\models\product\Product;
use common\components\UploadLib;
use common\components\ClaHost;
use common\components\ClaGenerate;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\product\ProductImage;
use common\models\product\CertificateProduct;
use common\models\product\CertificateProductItem;
use common\models\product\ProductCategory;
use common\models\shop\Shop;
use frontend\models\User;
use common\components\ClaCategory;
use yii\helpers\Url;
use common\models\transport\ShopTransport;
use common\models\transport\ProductTransport;

class ProductController extends Controller
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
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $pagesize = isset($_GET['per-page']) ? $_GET['per-page'] : 19;
        $page = Yii::$app->request->get('page', 1);
        $products = Product::getProduct(array_merge($_GET, [
            'shop_id' => Yii::$app->user->id,
            'limit' => $pagesize,
            'page' => $page,
            'status' => 0,
            // 'province_id' => '',
        ]));

        $totalitem = Product::getProduct(array_merge($_GET, [
            'shop_id' => Yii::$app->user->id,
            'count' => 1,
            'status' => 0,
            // 'province_id' => '',
        ]));

        return $this->render('index', [
            'products' => $products,
            'totalitem' => $totalitem,
            'limit' => $pagesize,
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
        Yii::$app->view->dynamicPlaceholders = [
            'asset' => 'AppAssetManagement'
        ];
        $model = new Product();
        if ($model->load(Yii::$app->request->post())) {
            $model->shop_id = Yii::$app->user->id;
            $model->status = 2;
            $model->price = str_replace('.', '', $model->price);
            // echo $model->price; die();
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
            $shop = Shop::findOne(Yii::$app->user->id);
            $model->province_id = $shop->province_id;
            //type
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
            $model->ishot = 0;

            if ($model->save()) {
                \common\models\NotificationAdmin::addNotifcation('product');
                if ($model->height > 0 && $model->width > 0 && $model->length > 0 && $model->weight > 0) {
                    ProductTransport::updateAll(
                        ['status' => 1, 'product_id' => $model->id],
                        [
                            'status' => 2,
                            'product_id' => Yii::$app->user->id
                        ]
                    );
                    ProductTransport::createdInShop($model->id, $model->shop_id);
                } else {
                    ProductTransport::updateAll(
                        ['status' => 1, 'product_id' => $model->id],
                        [
                            'status' => 2,
                            'product_id' => Yii::$app->user->id,
                            'transport_id' => 0,
                            'default' => 1
                        ]
                    );
                }

                $avatar = null;
                $setavtar = Yii::$app->request->post('setava');
                $newimage = Yii::$app->request->post('newimage');
                $countimage = $newimage ? count($newimage) : 0;
                $kt = 1;
                $coun = 1;
                if ($newimage && $countimage > 0) {
                    foreach ($newimage as $image_code) {
                        $imgtem = \common\models\media\ImagesTemp::findOne($image_code);
                        if ($imgtem) {
                            $nimg = new ProductImage();
                            $nimg->attributes = $imgtem->attributes;
                            $nimg->product_id = $model->id;
                            if ($setavtar) {
                                if ($setavtar == $image_code) {
                                    $nimg->is_avatar = 1;
                                }
                            } else {
                                if ($coun) {
                                    $nimg->is_avatar = 1;
                                    $coun = 0;
                                }
                            }
                            if ($nimg->save()) {
                                $imgtem->delete();
                                if ($setavtar) {
                                    if ($setavtar == $image_code) {
                                        $avatar = $nimg->attributes;
                                    }
                                } else {
                                    if ($kt) {
                                        $avatar = $nimg->attributes;
                                        $kt = 0;
                                    }
                                }
                            }
                        }
                    }
                    if ($avatar) {
                        $model->avatar_path = $avatar['path'];
                        $model->avatar_name = $avatar['name'];
                        $model->avatar_id = $avatar['id'];
                        $model->save();
                    }
                }
                //chứng thực
                $certificates = Yii::$app->request->post('certificate');
                if (count($certificates)) {
                    for ($i = 0; $i < count($certificates); $i++) {
                        $cer = Yii::$app->request->post('certificate' . $certificates[$i]);
                        if ($cer) {
                            $img = Yii::$app->session[$cer];
                            if ($img) {
                                $cer_item = new CertificateProductItem();
                                $cer_item->avatar_path = $img['baseUrl'];
                                $cer_item->avatar_name = $img['name'];
                                $cer_item->product_id = $model->id;
                                $cer_item->certificate_product_id = $certificates[$i];
                                if ($certificates[$i] == 4) {
                                    $cer_item->link_certificate = (isset($_POST['link_certificate'])) ? $_POST['link_certificate'] : '';
                                    $cer_item->code = (isset($_POST['code_certificate'])) ? $_POST['code_certificate'] : '';
                                }
                                $cer_item->save();
                            }
                        }
                    }
                }
                return $this->redirect(['update', 'id' => $model->id]);
            }
        }
        $images = null;
        $certificates = CertificateProduct::find()->all();
        $certificate_items = [];
        $shop_transports = ShopTransport::getByShopCreate(Yii::$app->user->id);
        $model->videos = is_array($model->videos) ? $model->videos : explode(',.,', $model->videos);
        return $this->render('create', [
            'model' => $model,
            'images' => $images,
            'certificates' => $certificates,
            'certificate_items' => $certificate_items,
            'shop_transports' => $shop_transports,

        ]);
    }

    public function actionDeleteall()
    {
        if (isset($_GET['listid']) && count($_GET['listid'])) {
            return Product::deleteAll(['id' => $_GET['listid'], 'shop_id' => Yii::$app->user->id]);
        }
        return 0;
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        Yii::$app->view->dynamicPlaceholders = [
            'asset' => 'AppAssetManagement'
        ];
        $model = $this->findModel($id);
        if ($model->shop_id == Yii::$app->user->id && $model->load(Yii::$app->request->post())) {
            $model->status_quantity = isset($_POST['Product']['status_quantity']) ? 1 : 0;
            $model->price = str_replace('.', '', $model->price);
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
            $shop = Shop::findOne(Yii::$app->user->id);
            $model->province_id = $shop->province_id;
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
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Lưu thành công.');
                //van chuyen 
                if ($model->height > 0 && $model->width > 0 && $model->length > 0 && $model->weight > 0) {
                    ProductTransport::createdInShop($model->id, $model->shop_id);
                } else {
                    ProductTransport::deleteInShop($model->id);
                }
                //anh
                $avatar = null;
                $setavtar = Yii::$app->request->post('setava');
                $newimage = Yii::$app->request->post('newimage');
                $countimage = $newimage ? count($newimage) : 0;
                if ($newimage && $countimage > 0) {
                    $kt = 1;
                    $coun = 1;
                    foreach ($newimage as $image_code) {
                        $imgtem = \common\models\media\ImagesTemp::findOne($image_code);
                        if ($imgtem) {
                            $nimg = new ProductImage();
                            $nimg->attributes = $imgtem->attributes;
                            $nimg->product_id = $model->id;
                            if ($setavtar) {
                                if ($setavtar == $image_code) {
                                    $nimg->is_avatar = 1;
                                }
                            } else {
                                if ($coun) {
                                    $nimg->is_avatar = 1;
                                    $coun = 0;
                                }
                            }
                            if ($nimg->save()) {
                                $model->status = 2;
                                $imgtem->delete();
                                if ($setavtar) {
                                    if ($setavtar == $image_code) {
                                        $avatar = $nimg->attributes;
                                    }
                                } else {
                                    if ($kt) {
                                        $avatar = $nimg->attributes;
                                        $kt = 0;
                                    }
                                }
                            }
                        }
                    }
                }
                if ($avatar) {
                    $model->avatar_path = $avatar['path'];
                    $model->avatar_name = $avatar['name'];
                    $model->avatar_id = $avatar['id'];
                    $model->save();
                } else {
                    if ($avatartg = ProductImage::findOne($setavtar)) {
                        $model->avatar_path = $avatartg['path'];
                        $model->avatar_name = $avatartg['name'];
                        $model->avatar_id = $avatartg['id'];
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
            }
        }
        $images = ProductImage::find()->where(['product_id' => $id])->all();
        $certificates = CertificateProduct::find()->all();
        $certificate_items = CertificateProductItem::getUpdateProduct($model->id);
        $shop_transports = ShopTransport::getByShop(Yii::$app->user->id);
        $product_transports = ProductTransport::getByProduct($model->id);
        $model->videos = is_array($model->videos) ? $model->videos : explode(',.,', $model->videos);
        return $this->render('update', [
            'model' => $model,
            'images' => $images,
            'certificates' => $certificates,
            'certificate_items' => $certificate_items,
            'shop_transports' => $shop_transports,
            'product_transports' => $product_transports,

        ]);
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete()
    {
        $id = isset($_POST['id']) ? $_POST['id'] : 0;
        $model = $this->findModel($id);
        if ($model && $model->shop_id == Yii::$app->user->id) {
            return $this->findModel($id)->delete();
        }
        return 0;
    }

    public function actionDeleteImage($id)
    {
        $img = ProductImage::findOne($id);
        if ($img) {
            $images = ProductImage::find()->where(['product_id' => $img->product_id])->all();
            if (count($images) > 1) {
                $img->delete();
            }
        }
        return true;
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

    public function beforeAction($action)
    {
        if (!Shop::findOne(Yii::$app->user->id)) {
            $this->redirect(['/management/shop/create']);
        }
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionUploadfile()
    {
        if (isset($_FILES['file'])) {
            $file = $_FILES['file'];
            if ($file['size'] > 1024 * 1024 * 10) {
                Yii::$app->end();
            }
            $up = new UploadLib($file);
            $up->setPath(array('news', date('Y_m_d', time())));
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

    public function actionUploadfilec()
    {
        if (isset($_FILES['file'])) {
            $file = $_FILES['file'];
            if ($file['size'] > 1024 * 1024 * 10) {
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

    public function actionReview($id = -9)
    {
        $images = [];
        if ($id > 0) {
            $images = ProductImage::find()->where(['product_id' => $id])->all();
            $product = $this->findModel($id);
        }
        $id = -9;
        $this->layout = 'detail';
        Yii::$app->view->dynamicPlaceholders = [
            'asset' => 'AppAssetDetailProduct'
        ];

        $model = $this->findModel($id);
        $model->attributes = $product->attributes;
        if (!$model && !$product) {
            return 'Trang đang được cập nhật...';
        }
        if ($model->load(Yii::$app->request->post())) {
            $model->status_quantity = isset($_POST['Product']['status_quantity']) ? 1 : 0;
            $model->status = 2;
            $model->price = str_replace('.', '', $model->price);
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

            $category = new ClaCategory();
            $category->type = ClaCategory::CATEGORY_PRODUCT;
            $category->generateCategory();
            //
            $categoryTrack = array_reverse($category->saveTrack($model->category_id));
            $categoryTrack = implode(ClaCategory::CATEGORY_SPLIT, $categoryTrack);
            //
            $model->category_track = $categoryTrack;
            $shop = Shop::findOne(Yii::$app->user->id);
            $model->province_id = $shop->province_id;
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
            $model->shop_id = -1;
            if ($model->save()) {
                //van chuyen 
                if ($model->height > 0 && $model->width > 0 && $model->length > 0 && $model->weight > 0) {
                    ProductTransport::createdInShop($model->id, Yii::$app->user->id);
                } else {
                    ProductTransport::deleteInShop($model->id);
                }
                //anh
                $avatar = null;
                $setavtar = Yii::$app->request->post('setava');
                $newimage = Yii::$app->request->post('newimage');
                $countimage = $newimage ? count($newimage) : 0;
                if ($newimage && $countimage > 0) {
                    $kt = 1;
                    foreach ($newimage as $image_code) {
                        $imgtem = \common\models\media\ImagesTemp::findOne($image_code);
                        if ($imgtem) {
                            $nimg = new ProductImage();
                            $nimg->attributes = $imgtem->attributes;
                            $nimg->product_id = $model->id;
                            $images[] = $nimg;
                            if ($setavtar) {
                                if ($setavtar == 'product_' . $image_code) {
                                    $avatar = $nimg->attributes;
                                }
                            } else {
                                if ($kt) {
                                    $avatar = $nimg->attributes;
                                    $kt = 0;
                                }
                            }
                        }
                    }
                }
                if ($avatar) {
                    $model->avatar_path = $avatar['path'];
                    $model->avatar_name = $avatar['name'];
                    $model->avatar_id = $avatar['id'];
                    $model->save();
                } else {
                    if ($avatartg = ProductImage::findOne($setavtar)) {
                        $model->avatar_path = $avatartg['path'];
                        $model->avatar_name = $avatartg['name'];
                        $model->avatar_id = $avatartg['id'];
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
                            $cer_item->link_certificate = (isset($_POST['link_certificate']) && $_POST['link_certificate'] && $certificates[$i] == 4) ? $_POST['link_certificate'] : '';
                            if ($cer_item->save()) {
                                $in[] = $cer_item['id'];
                            }
                        }
                    }
                }
                CertificateProductItem::deleteAll("id NOT IN (" . implode(',', $in) . ") AND product_id = " . $model->id);
            }
        }
        $certificates = CertificateProduct::find()->all();
        $certificate_imgs = CertificateProductItem::getUpdateProduct($model->id);
        //save

        //detail
        $category = ProductCategory::findOne($model->category_id);
        //
        Yii::$app->view->title = $model->meta_title ? $model->meta_title : $model->name;
        // add meta description
        Yii::$app->params['breadcrumbs'] = [
            Yii::t('app', 'home') => Url::home(),
        ];
        if ($category) {
            $categoryClass = new ClaCategory(['type' => ClaCategory::CATEGORY_PRODUCT, 'create' => true]);
            $tracks = $categoryClass->getTrackCategory($category['id']);
            foreach ($tracks as $tr) {
                Yii::$app->params['breadcrumbs'][$tr['name']] = $tr['link'];
            }
        }
        // hiển thị thêm các thuộc tính hệ thống
        $is_add_wish = 0;
        $model->shop_id = Yii::$app->user->id;
        $shop = Shop::findOne($model->shop_id);
        $shopadd = \common\models\shop\ShopAddress::find()->where(['shop_id' => $model->shop_id, 'isdefault' => 0])->all();
        $user = User::findOne($model->shop_id);
        return $this->render('detail', [
            'model' => $model,
            'category' => $category,
            'is_add_wish' => $is_add_wish,
            'shop' => $shop,
            'user' => $user,
            'shopadd' => $shopadd,
            'certificates' => $certificates,
            'certificate_imgs' => $certificate_imgs,
            'images' => $images
        ]);
    }

    public function actionLoadProduct()
    {
        $pagesize = isset($_GET['per-page']) ? $_GET['per-page'] : 19;
        $page = Yii::$app->request->get('page', 1);
        $status = Yii::$app->request->get('status', '');
        $products = Product::getProduct(array_merge($_GET, [
            'shop_id' => Yii::$app->user->id,
            'status_quantity' => $status,
            'limit' => $pagesize,
            'page' => $page,
            'status' => 0,
            'province_id' => '',
        ]));

        $totalitem = Product::getProduct(array_merge($_GET, [
            'shop_id' => Yii::$app->user->id,
            'status_quantity' => $status,
            'count' => 1,
            'status' => 0,
            'province_id' => '',
        ]));

        return $this->renderAjax('load', [
            'products' => $products,
            'totalitem' => $totalitem,
            'limit' => $pagesize,
        ]);
    }

    public function actionChangeStatusQuantity()
    {
        $id = isset($_POST['id']) ? $_POST['id'] : 0;
        $status_quantity = isset($_POST['status_quantity']) ? $_POST['status_quantity'] : -1;
        $model = $this->findModel($id);
        if ($model && $model->shop_id == Yii::$app->user->id && $status_quantity >= 0) {
            $model->status_quantity = $status_quantity;
            return $model->save();
        }
        return 0;
    }
}
