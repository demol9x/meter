<?php

namespace frontend\mobile\modules\management\controllers;

use Yii;
use common\models\product\DiscountCode;
use common\models\product\DiscountShopCode;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\Url;

class DiscountCodeController extends Controller
{
    
    public $shop;

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

    public function beforeAction($action)
    {
        $this->shop = \common\models\shop\Shop::findOne(Yii::$app->user->id);
        if (Yii::$app->controller->action->id == "create") {
            if ($this->shop->status_discount_code != 1) {
                $this->redirect(['index']);
                Yii::$app->end();
                return false;
            }
        }
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex($page = 1, $limit = '')
    {
        $get = $_GET;
        $model = new DiscountCode();
        $get['shop_id'] = Yii::$app->user->id;
        $get['status'] = '';
        $limit =  $limit ? $limit : $model->default_limit;
        $data = $model->getByAttr([
            'page' => $page,
            'limit' => $limit,
            'attr' => $get,
            'order' => 'time_end DESC'
        ]);
        $totalitem = $model->getByAttr([
            'count' => 1,
            'attr' => $get
        ]);
        Yii::$app->view->title = 'Quản lý mã khuyến mãi';
        // \Yii::$app->params['breadcrumbs'][Yii::t('app', 'home')] = Yii::$app->homeUrl;
        $arr_limit = [12, 24, 36, 48, 96];
        return $this->render('index', [
            'data' => $data,
            'limit' => $limit,
            'totalitem' => $totalitem,
            'model' => $model,
            'arr_limit' => $arr_limit,
            'shop' => $this->shop
        ]);
    }

    public function actionCreate()
    {
        $model = new DiscountShopCode();
        // $model->scenario = 'user';
        Yii::$app->view->title = 'Tạo mã giảm giá';
        \Yii::$app->params['breadcrumbs'][Yii::t('app', 'home')] = Yii::$app->homeUrl;
        \Yii::$app->params['breadcrumbs'][Yii::t('app', 'quản lý mã giảm giá')] = Url::to(['index']);
        \Yii::$app->params['breadcrumbs'][Yii::$app->view->title] = '';
        //post
        if ($model->load(Yii::$app->request->post())) {
            $model->time_start = strtotime($model->time_start);
            $model->time_end = strtotime($model->time_end);
            $model->status = 1;
            $model->shop_id = Yii::$app->user->id;
            if ($model->all != 1) {
                if (isset($_POST['add']) && $_POST['add']) {
                    $model->products = implode(' ', $_POST['add']);
                } else {
                    $model->addError('all', 'Vui lòng chọn sản phẩm.');
                    return $this->render('create', [
                        'model' => $model,
                    ]);
                }
            }
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Tạo mã thành công.');
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('error', 'Lưu lỗi.');
                $model->time_start = date('d-m-Y H:i', $model->time_start);
                $model->time_end = date('d-m-Y H:i', $model->time_end);
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        if (Yii::$app->request->isAjax) {
            Yii::$app->session->setFlash('success', 'Xóa thành công.');
            return '<script type="text/javascript">location.reload();</script>';
        }
        return $this->redirect(['index']);
    }

    public function actionDeleteAll()
    {
        if (isset($_POST['item-check']) && $_POST['item-check']) {
            Yii::$app->session->setFlash('success', 'Xóa thành công.');
            DiscountCode::deleteAll(['id' => $_POST['item-check'], 'shop_id' => Yii::$app->user->id]);
            Yii::$app->session->setFlash('success', 'Đã xóa.');
        }
        return '<script type="text/javascript">location.reload();</script>';
    }

    protected function findModel($id)
    {
        if (($model = DiscountCode::find()->where(['id' => $id, 'shop_id' => Yii::$app->user->id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
