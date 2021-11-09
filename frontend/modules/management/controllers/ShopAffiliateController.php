<?php

namespace frontend\modules\management\controllers;

use Yii;
use common\models\shop\Shop;
use common\models\product\Product;
use yii\web\Controller;
use yii\filters\VerbFilter;

class ShopAffiliateController extends Controller
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

    public function actionIndex()
    {
        Yii::$app->view->title = "Cấu hình Affilliate";
        $user_id = Yii::$app->user->id;
        $model = Shop::findOne($user_id);
        $productalls = Product::find()->where(['shop_id' => $user_id])->all();
        $products = [];
        $product_ns = [];
        if ($productalls) foreach ($productalls as $item) {
            if ($item->status_affiliate == 1) {
                $products[] = $item;
            } else {
                $product_ns[] = $item;
            }
        }
        if ($model->load(Yii::$app->request->post())) {
            if ($model->status_affiliate != $model->status_affiliate_waitting || $model->affiliate_admin != $model->affiliate_admin_waitting || $model->affiliate_gt_shop != $model->affiliate_gt_shop_waitting || $model->affilliate_status_service != $model->affilliate_status_service_waitting) {
                $model->affiliate_waitting = 1;
            }
            if ($model->affiliate_waitting) {
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Đã lưu đăng cho duyệt từ BQT');
                } else {
                    Yii::$app->session->setFlash('error', 'Lưu lỗi.');
                }
            }
        }
        return $this->render('index', [
            'model' => $model,
            'products' => $products,
            'product_ns' => $product_ns,
        ]);
    }

    public function actionIndexService()
    {
        Yii::$app->view->title = "Cấu hình QR-CODE dịch vụ";
        $user_id = Yii::$app->user->id;
        $model = Shop::findOne($user_id);
        $productalls = Product::find()->where(['shop_id' => $user_id])->all();
        $products = [];
        $product_ns = [];
        if ($productalls) foreach ($productalls as $item) {
            if ($item->status_affiliate == 1) {
                $products[] = $item;
            } else {
                $product_ns[] = $item;
            }
        }
        return $this->render('index-service', [
            'model' => $model,
            'products' => $products,
            'product_ns' => $product_ns,
        ]);
    }

    public function actionDelele($id)
    {
        $model = Product::find()->where(['shop_id' => Yii::$app->user->id, 'id' => $id])->one();
        if ($model) {
            $model->status_affiliate = 0;
            $model->save(false);
        }
        return 'success';
    }

    public function actionCancerChange()
    {
        $model = Shop::findOne(Yii::$app->user->id);
        if ($model) {
            $model->affiliate_waitting = 0;
            $model->affiliate_gt_shop_waitting = 0;
            $model->affiliate_admin_waitting = 0;
            $model->status_affiliate_waitting = 0;
            if ($model->save(false)) {
                Yii::$app->session->setFlash('success', 'Hủy thành công.');
            } else {
                Yii::$app->session->setFlash('error', 'Hủy thành lỗi.');
            }
        }
        return $this->redirect(['index']);
    }

    public function actionUpdateList()
    {
        if (isset($_POST['list'])) {
            $list = $_POST['list'];
            $type = (isset($_POST['submit']) && $_POST['submit'] == 'delete') ? true : false;
            $datas = [];
            foreach ($list as $key => $item) {
                if (isset($item['id']) && $item['id'] == 1) {
                    $product = \common\models\product\Product::find()->where(['id' => $key, 'shop_id' => Yii::$app->user->id])->one();
                    if ($product) {
                        if ($type) {
                            $product->status_affiliate = 0;
                        } else {
                            $product->status_affiliate = 1;
                            $product->affiliate_gt_product = $item['affiliate_gt_product'];
                            $product->affiliate_m_v = $item['affiliate_m_v'];
                            $product->affiliate_charity = $item['affiliate_charity'];
                            $product->affiliate_safe = $item['affiliate_safe'];
                        }
                        if ($product->checkAffiliate()) {
                            $datas[] = $product;
                        } else {
                            return 'error';
                        }
                    }
                }
            }
            if ($datas) {
                foreach ($datas as $item) {
                    $item->save();
                }
                Yii::$app->session->setFlash('success', $type ? 'Xóa thành công' : 'Cập nhật thành công');
            }
            return 'success';
        }
        return 'error';
    }

    public function actionUpdate()
    {
        if (isset($_POST['product_id'])) {
            $product_id = $_POST['product_id'];
            $product = \common\models\product\Product::find()->where(['id' => $product_id, 'shop_id' => Yii::$app->user->id])->one();
            if ($product) {
                $product->status_affiliate = 1;
                $product->affiliate_gt_product = $_POST['affiliate_gt_product'];
                $product->affiliate_m_v = $_POST['affiliate_m_v'];
                $product->affiliate_charity = $_POST['affiliate_charity'];
                $product->affiliate_safe = $_POST['affiliate_safe'];
                if ($product->save()) {
                    return $this->renderAjax('partial/update', ['product' => $product, 'error' => 0]);
                } else {
                    return $this->renderAjax('partial/update', ['product' => $product, 'error' => 1]);
                }
            }
        }
        return '';
    }

    public function actionSaveService()
    {
        if (isset($_POST['list'])) {
            $list = $_POST['list'];
            $status = isset($_POST['status']) && $_POST['status'] ? 1 : 0;
            foreach ($list as $key => $item) {
                if (isset($item['id']) && $item['id'] == 1) {
                    $product = \common\models\product\Product::find()->where(['id' => $key, 'shop_id' => Yii::$app->user->id])->one();
                    $shop = \common\models\shop\Shop::findOne(Yii::$app->user->id);
                    if ($product && $shop) {
                        if ($product->pay_servive != 1) {
                            $product->affiliate_charity = $item['affiliate_charity'];
                            $product->affiliate_safe = $item['affiliate_safe'];
                        }
                        $product->status_affiliate = 1;
                        $product->pay_servive = 1;
                        $product->affiliate_gt_product = $item['affiliate_gt_product'];
                        $product->affiliate_m_v = $item['affiliate_m_v'];
                        if ($shop->affilliate_status_service != $status) {
                            $shop->affilliate_status_service = $status;
                            if (!$shop->save()) {
                                return 'error';
                            }
                        }
                        if ($product->checkAffiliate() && $product->save()) {
                            Yii::$app->session->setFlash('success', 'Lưu thành công.');
                            $pr = \common\models\product\Product::updateAll(['pay_servive' => 0], "pay_servive = 1 AND shop_id = " . Yii::$app->user->id . ' AND id !=' . $product->id);
                            return 'success';
                        }
                    }
                }
            }
        }
        return 'error';
    }

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
}
