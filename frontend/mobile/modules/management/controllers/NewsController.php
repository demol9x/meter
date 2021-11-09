<?php

namespace frontend\mobile\modules\management\controllers;

use Yii;
use common\components\UploadLib;
use common\components\ClaHost;
use common\components\ClaGenerate;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\news\News;
use yii\helpers\Url;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class NewsController extends \frontend\controllers\CController
{
    public $layout = "main_user";

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
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex($page = 1, $limit = '')
    {
        $get = $_GET;
        $model = new News();
        $get['user_id'] = Yii::$app->user->id;
        $get['status'] = '';
        $limit =  $limit ? $limit : $model->default_limit;
        $data = $model->getByAttr([
            'page' => $page,
            'limit' => $limit,
            'attr' => $get
        ]);
        $totalitem = $model->getByAttr([
            'count' => 1,
            'attr' => $get
        ]);
        Yii::$app->view->title = 'Quản lý bài tin';
        // \Yii::$app->params['breadcrumbs'][Yii::t('app', 'home')] = Yii::$app->homeUrl;
        $arr_limit = [12, 24, 36, 48, 96];
        return $this->render('index', [
            'data' => $data,
            'limit' => $limit,
            'totalitem' => $totalitem,
            'model' => $model,
            'arr_limit' => $arr_limit,
        ]);
    }

    public function actionCreate()
    {
        $model = new News();
        // $model->scenario = 'user';
        Yii::$app->view->title = 'Đăng bài mới';
        \Yii::$app->params['breadcrumbs'][Yii::t('app', 'home')] = Yii::$app->homeUrl;
        \Yii::$app->params['breadcrumbs'][Yii::t('app', 'quản lý bài tin')] = Url::to(['/management/news/index']);
        \Yii::$app->params['breadcrumbs'][Yii::$app->view->title] = '';
        //post
        if ($model->load(Yii::$app->request->post())) {
            $model->user_id = Yii::$app->user->id;
            $model->status = 2;
            $model->author = \common\models\User::findOne(Yii::$app->user->id)->username;
            $model->publicdate = time();
            if ($model->avatar) {
                $avatar = Yii::$app->session[$model->avatar];
                if ($avatar) {
                    $model->avatar_path = $avatar['baseUrl'];
                    $model->avatar_name = $avatar['name'];
                }
                unset(Yii::$app->session[$model->avatar]);
            }
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Đăng bài thành công.');
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('error', 'Lưu lỗi.');
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        // $model->scenario = 'user';
        Yii::$app->view->title = 'Cập nhập bài tin';
        \Yii::$app->params['breadcrumbs'][Yii::t('app', 'home')] = Yii::$app->homeUrl;
        \Yii::$app->params['breadcrumbs'][Yii::t('app', 'quản lý bài tin')] =  Url::to(['/management/news/index']);
        \Yii::$app->params['breadcrumbs'][Yii::$app->view->title] = '';
        if ($model->load(Yii::$app->request->post())) {
            $model->user_id = Yii::$app->user->id;
            $model->status = $model->status ? 2 : 0;
            $model->author = \common\models\User::findOne(Yii::$app->user->id)->username;
            $model->publicdate = time();
            if ($model->avatar) {
                $avatar = Yii::$app->session[$model->avatar];
                if ($avatar) {
                    $model->avatar_path = $avatar['baseUrl'];
                    $model->avatar_name = $avatar['name'];
                }
                unset(Yii::$app->session[$model->avatar]);
            } else {
                $model->avatar = true;
            }
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Đăng bài thành công.');
                return $this->redirect(['index']);
            } else {
                // print_r($model->errors);
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionChangeStatus($id, $status)
    {
        $model = $this->findModel($id);
        if ($model) {
            $model->status = $status ? 2 : 0;
            $model->save(false);
        }
        return '<script type="text/javascript">location.reload();</script>';
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        if (Yii::$app->request->isAjax) {
            return '<script type="text/javascript">location.reload();</script>';
        }
        return $this->redirect(['index']);
    }

    public function actionDeleteAll()
    {
        if (isset($_POST['item-check']) && $_POST['item-check']) {
            News::deleteAll(['id' => $_POST['item-check'], 'user_id' => Yii::$app->user->id]);
            Yii::$app->session->setFlash('success', 'Đã xóa.');
        }
        return '<script type="text/javascript">location.reload();</script>';
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
                $return['data']['realurl'] = ClaHost::getImageHost() . $response['baseUrl'] . 's400_400/' . $response['name'];
                $return['data']['avatar'] = $keycode;
                Yii::$app->session[$keycode] = $response;
            }
            echo json_encode($return);
            Yii::$app->end();
        }
        //
    }

    protected function findModel($id)
    {
        if (($model = News::find()->where(['id' => $id, 'user_id' => Yii::$app->user->id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionSellIndex($page = 1, $limit = '')
    {
        $get = $_GET;
        $model = new \common\models\form\FormRegisterSell();
        $get['user_news_id'] = Yii::$app->user->id;
        // $get['status'] = '';
        $limit =  $limit ? $limit : $model->default_limit;
        $data = $model->getByAttr([
            'page' => $page,
            'limit' => $limit,
            'attr' => $get
        ]);
        $totalitem = $model->getByAttr([
            'count' => 1,
            'attr' => $get
        ]);
        Yii::$app->view->title = 'Danh sách liên hệ bán';
        $arr_limit = [12, 24, 36, 48, 96];
        return $this->render('sell/index', [
            'data' => $data,
            'limit' => $limit,
            'totalitem' => $totalitem,
            'model' => $model,
            'arr_limit' => $arr_limit,
        ]);
    }

    public function actionSellView($id)
    {
        $model = \common\models\form\FormRegisterSell::findOne($id);
        if ($model) {
            if (!$model->viewed) {
                $model->viewed = 1;
                $model->save(false);
            }
            return $this->renderAjax('sell/view', ['model' => $model]);
        }
        return '';
    }

    public function actionSellDelete($id)
    {
        \common\models\form\FormRegisterSell::findOne($id)->delete();
        if (Yii::$app->request->isAjax) {
            return '<script type="text/javascript">location.reload();</script>';
        }
        return $this->redirect(['index']);
    }

    public function actionSellDeleteAll()
    {
        if (isset($_POST['item-check']) && $_POST['item-check']) {
            \common\models\form\FormRegisterSell::deleteAll(['id' => $_POST['item-check'], 'user_news_id' => Yii::$app->user->id]);
            Yii::$app->session->setFlash('success', 'Đã xóa.');
        }
        return '<script type="text/javascript">location.reload();</script>';
    }

    public function actionBuyIndex($page = 1, $limit = '')
    {
        $get = $_GET;
        $model = new \common\models\form\FormRegisterBuy();
        $get['user_news_id'] = Yii::$app->user->id;
        $limit =  $limit ? $limit : $model->default_limit;
        $data = $model->getByAttr([
            'page' => $page,
            'limit' => $limit,
            'attr' => $get
        ]);
        $totalitem = $model->getByAttr([
            'count' => 1,
            'attr' => $get
        ]);
        Yii::$app->view->title = 'Danh sách liên hệ mua';
        $arr_limit = [12, 24, 36, 48, 96];
        return $this->render('buy/index', [
            'data' => $data,
            'limit' => $limit,
            'totalitem' => $totalitem,
            'model' => $model,
            'arr_limit' => $arr_limit,
        ]);
    }

    public function actionBuyView($id)
    {
        $model = \common\models\form\FormRegisterBuy::findOne($id);
        if ($model) {
            if (!$model->viewed) {
                $model->viewed = 1;
                $model->save(false);
            }
            return $this->renderAjax('buy/view', ['model' => $model]);
        }
        return '';
    }

    public function actionBuyDelete($id)
    {
        \common\models\form\FormRegisterBuy::findOne($id)->delete();
        if (Yii::$app->request->isAjax) {
            return '<script type="text/javascript">location.reload();</script>';
        }
        return $this->redirect(['index']);
    }

    public function actionBuyDeleteAll()
    {
        if (isset($_POST['item-check']) && $_POST['item-check']) {
            \common\models\form\FormRegisterBuy::deleteAll(['id' => $_POST['item-check'], 'user_news_id' => Yii::$app->user->id]);
            Yii::$app->session->setFlash('success', 'Đã xóa.');
        }
        return '<script type="text/javascript">location.reload();</script>';
    }
}
