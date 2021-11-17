<?php

namespace frontend\modules\product\controllers;

use common\models\Province;
use Yii;
use frontend\controllers\CController;
use common\models\product\ProductCategory;
use common\models\shop\Shop;
use frontend\models\User;
use common\models\product\Product;
use common\models\product\ProductWish;
use common\components\ClaLid;
use common\components\ClaCategory;
use yii\helpers\Url;
use yii\web\Response;
use common\components\ClaHost;
use common\models\product\CertificateProduct;
use common\models\product\CertificateProductItem;
use common\models\affiliate\AffiliateLink;
use common\models\affiliate\AffiliateClick;

class ProductController extends CController
{

    public $view_for_action = '';
    public $asset = 'AppAsset';

    /**
     * Renders the index view for the module
     * @return string
     */
    public function beforeAction($event)
    {
        Yii::$app->session->open();
        return parent::beforeAction($event);
    }

    public function actionGetProductHome($cat_id)
    {
        $this->layout = '@frontend/views/layouts/empty.php';
        $products = Product::getProduct([
            'category_id' => $cat_id,
            'isnew' => 1,
            'order' => 'id DESC ',
            'limit' => 50,
            'page' => 1,
        ]);
        if ($products) {
            return \frontend\widgets\html\HtmlWidget::widget([
                'input' => [
                    'products' => $products
                ],
                'view' => 'view_product_1'
            ]);
        }
        return '';
    }

    public function actionProductHot()
    {
        // $this->layout = 'category';
        Yii::$app->view->title = 'Sản phẩm nổi bật';
        $productdes = 'Sản phẩm nổi bật';
        // add meta description
        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => $productdes
        ]);
        // add meta keywords
        Yii::$app->view->registerMetaTag([
            'name' => 'keywords',
            'content' => $productdes
        ]);
        //
        Yii::$app->params['breadcrumbs'] = [
            Yii::t('app', 'home') => Url::home(),
        ];
        Yii::$app->params['breadcrumbs']['Sản phẩm nổi bật'] = Url::to(['product/product/product-hot']);
        //
        $pagesize = isset($_GET['per-page']) ? $_GET['per-page'] : ClaLid::DEFAULT_LIMIT;
        $page = Yii::$app->request->get('page', 1);

        $data = Product::getProduct(array_merge($_GET, [
            'limit' => $pagesize,
            'page' => $page,
            'ishot' => 1
        ]));

        $totalitem = Product::getProduct(array_merge($_GET, [
            'count' => 1,
            'ishot' => 1,
        ]));

        return $this->render('product_hot', [
            'data' => $data,
            'totalitem' => $totalitem,
            'limit' => $pagesize,
            'productdes' => $productdes,
        ]);
    }

    public function actionSuggest()
    {
        // $this->layout = 'category';
        Yii::$app->view->title = Yii::t('app', 'suggest_to_day');
        $productdes = Yii::t('app', 'suggest_to_day');
        // add meta description
        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => $productdes
        ]);
        // add meta keywords
        Yii::$app->view->registerMetaTag([
            'name' => 'keywords',
            'content' => $productdes
        ]);
        //
        Yii::$app->params['breadcrumbs'] = [
            Yii::t('app', 'home') => Url::home(),
        ];
        Yii::$app->params['breadcrumbs'][Yii::t('app', 'suggest_to_day')] = Url::to(['product/product/index']);
        //
        $pagesize = isset($_GET['per-page']) ? $_GET['per-page'] : ClaLid::DEFAULT_LIMIT;
        $page = Yii::$app->request->get('page', 1);

        $data = Product::getProduct(array_merge($_GET, [
            // 'category_id' => $category->id,
            'limit' => $pagesize,
            'page' => $page,
            // 'ishot' => 1
        ]));

        $totalitem = Product::getProduct(array_merge($_GET, [
            'count' => 1,
            // 'ishot' => 1,
        ]));

        return $this->render('suggest', [
            // 'category' => $category,
            'data' => $data,
            'totalitem' => $totalitem,
            'limit' => $pagesize,
            'productdes' => $productdes,
        ]);
    }

    public function actionIndex()
    {
        $this->layout = 'brand';
        Yii::$app->view->title = Yii::t('app', 'product');
        $productdes = Yii::t('app', 'product');
        // add meta description
        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => $productdes
        ]);
        // add meta keywords
        Yii::$app->view->registerMetaTag([
            'name' => 'keywords',
            'content' => $productdes
        ]);
        //
        Yii::$app->params['breadcrumbs'] = [
            Yii::t('app', 'home') => Url::home(),
        ];
        Yii::$app->params['breadcrumbs'][Yii::t('app', 'product')] = Url::to(['/product/product/index']);
        //
        $pagesize = 24;

        $page = Yii::$app->request->get('page', 1);
        $province_id = Yii::$app->request->get('p', 0);
        $keyword = Yii::$app->request->get('k', '');
        $data = Product::getProduct(array_merge($_GET,[
            'keyword'=>$keyword,
            'province_id'=>$province_id,
            'limit' => $pagesize,
            'page' => $page,
        ]));

        $totalitem = Product::getProduct(array_merge($_GET,[
            'count' => 1,
            'keyword'=>$keyword,
            'province_id'=>$province_id,
            'limit' => $pagesize,
            'page' => $page,
        ]));

        return $this->render('index', [
            // 'category' => $category,
            'data' => $data,
            'totalitem' => $totalitem,
            'limit' => $pagesize,
            'productdes' => $productdes,
        ]);
    }

    public function actionBrandCategory($id)
    {
        $this->layout = 'brand';
        $brand_name = Product::getBrandName($id);
        if ($brand_name == '') {
            $this->layout = '@frontend/views/layouts/error_layout';
            return $this->render('error');
        }
        $cat_id = \Yii::$app->request->get('cat_id', 0);
        //
        Yii::$app->view->title = $brand_name;
        //
        Yii::$app->params['breadcrumbs'] = [
            Yii::t('app', 'home') => Url::home(),
            $brand_name => Url::current()
        ];
        //
        $pagesize = ClaLid::DEFAULT_LIMIT;
        $page = Yii::$app->request->get('page', 1);

        $data = Product::getProduct([
            'brand' => $id,
            'limit' => $pagesize,
            'page' => $page,
            'category_id' => $cat_id
        ]);

        $totalitem = Product::countAllProduct([
            'brand' => $id,
            'category_id' => $cat_id
        ]);
        //
        return $this->render('brand', [
            'data' => $data,
            'totalitem' => $totalitem,
            'limit' => $pagesize
        ]);
    }

    public function actionBrand($id)
    {
        $this->layout = 'brand';
        $brand_name = Product::getBrandName($id);
        if ($brand_name == '') {
            $this->layout = '@frontend/views/layouts/error_layout';
            return $this->render('error');
        }
        //
        Yii::$app->view->title = $brand_name;
        //
        Yii::$app->params['breadcrumbs'] = [
            Yii::t('app', 'home') => Url::home(),
            $brand_name => Url::current()
        ];
        //
        $pagesize = ClaLid::DEFAULT_LIMIT;
        $page = Yii::$app->request->get('page', 1);

        $data = Product::getProduct([
            'brand' => $id,
            'limit' => $pagesize,
            'page' => $page,
        ]);

        $totalitem = Product::countAllProduct([
            'brand' => $id,
        ]);
        //
        return $this->render('brand', [
            'data' => $data,
            'totalitem' => $totalitem,
            'limit' => $pagesize
        ]);
    }

    public function actionWishList()
    {
        $this->layout = 'detail';

        Yii::$app->view->title = 'Danh sách sản phẩm yêu thích';
        // add meta description
        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => 'Danh sách sản phẩm yêu thích'
        ]);
        // add meta keywords
        Yii::$app->view->registerMetaTag([
            'name' => 'keywords',
            'content' => 'Danh sách sản phẩm yêu thích'
        ]);

        //
        Yii::$app->params['breadcrumbs'] = [
            Yii::t('app', 'home') => Url::home(),
        ];

        //
        $pagesize = ClaLid::DEFAULT_LIMIT;
        // $page = Yii::$app->request->get('page', 1);

        $listp = ProductWish::getWishByAttr([
            'limit' => $pagesize,
            'attr' => ['user_id' => Yii::$app->user->getId()],
            'order' => 'created_at '
        ]);

        $data = Product::find()->where(['id' => $listp])->all();

        $totalitem = ProductWish::getWishByAttr([
            'attr' => ['user_id' => Yii::$app->user->getId()],
            'count' => 1
        ]);

        return $this->render('wishlist', [
            'data' => $data,
            'totalitem' => $totalitem,
            'limit' => $pagesize,
        ]);
    }

    public function actionCategory($id)
    {
        $_SESSION['url_back_login'] = 'http://' . \common\components\ClaSite::getServerName() . "$_SERVER[REQUEST_URI]";
        $this->layout = 'category';
        $category = ProductCategory::findOne($id);
        if ($category === NULL) {
            $this->layout = '@frontend/views/layouts/error_layout';
            return $this->render('error');
        }
        if (!$category->bgr_name) {
            $catimg = $category->getBackGruond();
            if ($catimg) {
                $category->bgr_name = $catimg->bgr_name;
                $category->bgr_path = $catimg->bgr_path;
            }
        }
        //
        Yii::$app->view->title = $category->meta_title ? $category->meta_title : $category->name;
        // add meta description
        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => $category->meta_description
        ]);
        // add meta keywords
        Yii::$app->view->registerMetaTag([
            'name' => 'keywords',
            'content' => $category->meta_keywords
        ]);
        //
        $categoryClass = new ClaCategory(['type' => ClaCategory::CATEGORY_PRODUCT, 'create' => true]);
        $tracks = $categoryClass->getTrackCategory($id);
        //
        Yii::$app->params['breadcrumbs'] = [
            Yii::t('app', 'home') => Url::home(),
        ];
        foreach ($tracks as $tr) {
            Yii::$app->params['breadcrumbs'][$tr['name']] = $tr['link'];
        }
        //
        $pagesize = ClaLid::DEFAULT_LIMIT;
        $page = Yii::$app->request->get('page', 1);
        $province_id = Yii::$app->request->get('province_id', 0);
        $price_max = Yii::$app->request->get('price_max', 0);
        $price_min = Yii::$app->request->get('price_min', 0);

        $allow = true;
        if ($id == ProductCategory::CATEGORY_AFILATE) {
            $data = Product::getProduct([
                'status_affiliate' => 1,
                'order' => 'affiliate_safe DESC, updated_at DESC',
                'limit' => $pagesize,
                'page' => $page,
                'province_id' => $province_id,
                'price_max' => $price_max,
                'price_min' => $price_min,
            ]);

            $totalitem = Product::getProduct([
                'status_affiliate' => 1,
                'province_id' => $province_id,
                'price_max' => $price_max,
                'price_min' => $price_min,
                'count' => 1
            ]);
        } else {
            $allow = $category->allowGroup(Yii::$app->user->id);
            if ($allow) {
                if ($category->isAllGroup() && Yii::$app->user->id) {
                    $category_id = \common\models\user\UserInGroup::getListCatAllow(Yii::$app->user->id);
                } else {
                    $category_id = $category->id;
                }
                $data = Product::getProduct([
                    'category_id' => $category_id,
                    'limit' => $pagesize,
                    'page' => $page,
                    'province_id' => $province_id,
                    'price_max' => $price_max,
                    'price_min' => $price_min,
                ]);

                $totalitem = Product::getProduct([
                    'category_id' => $category_id,
                    'province_id' => $province_id,
                    'price_max' => $price_max,
                    'price_min' => $price_min,
                    'count' => 1
                ]);
            } else {
                $data = [];
                $totalitem = 0;
            }
        }
        return $this->render('category', [
            'category' => $category,
            'data' => $data,
            'totalitem' => $totalitem,
            'limit' => $pagesize,
            'allow' => $allow,
        ]);
    }

    public function actionAddWish($id, $data)
    {
        if ($data) {
            $model = new ProductWish();
            $model->product_id = $id;
            $model->user_id = Yii::$app->user->getId();
            if ($model->save()) {
                return 1;
            }
        } else {
            $model = ProductWish::find()->where(['product_id' => $id, 'user_id' => Yii::$app->user->getId()])->one();
            if ($model->delete()) {
                return 2;
            }
        }
        return 0;
    }

    public function actionSearchProduct($term, $callback)
    {
        $data = '';
        $ls = '(0';
        foreach ($_SESSION['compares'] as $value) {
            $ls .= ',' . $value;
        }
        $ls .= ')';
        if ($products = Product::find()->select('*')->where(['like', 'name', $term])->andWhere(" id NOT IN $ls")->asArray()->all()) {
            foreach ($products as $product) {
                $src = ClaHost::getImageHost() . $product['avatar_path'] . 's50_50/' . $product['avatar_name'];
                $data[] = '<p><a class="click" onclick="addpc(' . $product['id'] . ')"><img src="' . $src . '" ><span>' . $product['name'] . '</span></a></p>';
            }
        }

        return $callback . '(' . json_encode($data) . ');';
    }

    public function actionDetail($id, $t = 0)
    {
        $_SESSION['url_back_login'] = 'http://' . \common\components\ClaSite::getServerName() . "$_SERVER[REQUEST_URI]";
        $this->layout = 'detail';

        //
        $model = $this->addView($id);
        // $model = $this->findModel($id);
        if (!$model) {
            $this->layout = '@frontend/views/layouts/error_layout';
            return $this->render('error');
        }
        //
        $category = ProductCategory::findOne($model->category_id);
        if (!$category) {
            $this->layout = '@frontend/views/layouts/error_layout';
            return $this->render('error');
        }
        if ($model->status != 1) {
            $category = ProductCategory::findOne($model->category_id);
            if ($category) {
                return $this->redirect(['/product/product/category', 'alias' => $category->alias, 'id' => $category->id]);
            } else {
                return $this->goHome();
            }
        }
        $shop= Shop::findOne($model->shop_id);
        if (!$shop) {
            $this->layout = '@frontend/views/layouts/error_layout';
            return $this->render('error');
        }
        //
        Yii::$app->view->title = $model->meta_title ? $model->meta_title : $model->name;
        // add meta description
        $meta_description = $model->meta_description ? $model->meta_description : $model->name;
        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => $meta_description
        ]);
        // add meta keywords
        Yii::$app->view->registerMetaTag([
            'name' => 'keywords',
            'content' => $model->meta_keywords
        ]);
        // add meta image
        $avatar = \common\components\ClaHost::getLinkImage($model->avatar_path, $model->avatar_name, ['size' => 's600_600/']);
        Yii::$app->view->registerMetaTag([
            'property' => 'og:title',
            'content' => $model->meta_title ? $model->meta_title : $model->name
        ]);
        Yii::$app->view->registerMetaTag([
            'property' => 'og:description',
            'content' => $meta_description
        ]);
        Yii::$app->view->registerMetaTag([
            'property' => 'og:image',
            'content' => $avatar
        ]);
        Yii::$app->view->registerMetaTag([
            'property' => 'og:url',
            'content' => Url::current([], true)
        ]);
        Yii::$app->view->registerMetaTag([
            'property' => 'og:site_name',
            'content' => 'meter'
        ]);
        Yii::$app->view->registerMetaTag([
            'property' => 'og:type',
            'content' => 'website'
        ]);

        //
        Yii::$app->params['breadcrumbs'] = [
            Yii::t('app', 'home') => Url::home(),
            $model->name => Url::to(['/product/product/detail','alias' => $model->alias, 'id' => $model->id])
        ];

        //





        //
        $is_add_wish = Yii::$app->user->getId() ? ProductWish::find()->Where(['user_id' => Yii::$app->user->getId(), 'product_id' => $id])->count() : 0;



        return $this->render('detail', [
            't' => $t,
            'model' => $model,
            'category' => $category,
            'is_add_wish' => $is_add_wish,
            'shop'=>$shop,
        ]);
    }

    public function actionGetQr()
    {
        $option = $_POST;
        $option['type'] = 'product';
        $quantity = $option['quantity'];
        $shipfee = $option['shipfee'];
        $product_id = $option['product_id'];
        $product = Product::findOne($product_id);
        if ($product) {
            $option['price'] = $product->getPrice($quantity) * $quantity;
            // $option['price'] = $product->getPrice($quantity)*$quantity + $shipfee;
            $src = \common\components\ClaOrderQr::getImgQR($option);
            return '<img src="' . $src . '" >';
        }
        return '';
    }

    public function actionGetImages()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $color = Yii::$app->request->get('color', '');
            $id = Yii::$app->request->get('id', 0);
            $images = \common\models\product\ProductImage::getImagesByColor($id, $color);
            if ($images) {
                $html = $this->renderAjax('ajax/images', [
                    'images' => $images
                ]);
                return [
                    'code' => 200,
                    'html' => $html
                ];
            }
        }
    }
    protected function addView($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            $key = 'product_viewed_' . $model->id;
            if (!isset($_COOKIE[$key])) {
                $model->viewed++;
                $connection = Yii::$app->db;
                $connection->createCommand()->update('product', ['viewed' => $model->viewed], 'id =' . $model->id)->execute();
                setcookie($key, "1", time() + (60), "/");
            }
            return $model;
        } else {
            return 0;
        }
    }
}
