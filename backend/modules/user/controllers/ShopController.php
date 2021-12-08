<?php

namespace backend\modules\user\controllers;

use common\models\package\Package;
use Yii;
use frontend\models\User;
use common\models\shop\Shop;
use common\models\shop\ShopSearch;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\transport\Transport;
use common\models\transport\ShopTransport;

/**
 * UserController implements the CRUD actions for User model.
 */
class ShopController extends Controller
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
        $searchModel = new ShopSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 50;
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $model->affiliate_admin = $model->affiliate_admin_waitting;
            $model->affiliate_gt_shop = $model->affiliate_gt_shop_waitting;
            $model->status_affiliate = $model->status_affiliate_waitting;
            $model->affiliate_waitting = 0;
            if ($model->status_affiliate == 0) {
                $model->affilliate_status_service = 0;
            }
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Cập nhật thành công');
                return $this->redirect(['affiliate']);
            }
        }
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionCancerAffiliate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $model->affiliate_waitting = 0;
            if ($model->save()) {
                $noti = new \common\models\notifications\Notifications();
                $noti->title = 'Yêu cầu thay đổi affiliate của quý khách không được chập thuận';
                $noti->description = 'Yêu cầu thay đổi affiliate của quý khách không được chập thuận. Vui lòng liên hệ BQT để được tư vấn và giải đáp.';
                $noti->link = '#';
                $noti->type = 3;
                $noti->recipient_id = $model->user_id;
                $noti->unread = \common\components\ClaLid::STATUS_ACTIVED;
                $noti->save();
                Yii::$app->session->setFlash('success', 'Hủy thành công');
                return $this->redirect(['affiliate']);
            }
        }
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Shop();
        $model->scenario = 'backend';
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'backend';
        if ($model->load(Yii::$app->request->post())) {
            $kt = 0;
            $newimage = Yii::$app->request->post('newimage');
            $countimage = $newimage ? count($newimage) : 0;
            $newimageauth = Yii::$app->request->post('newimageauth');
            $countimageauth = $newimageauth ? count($newimageauth) : 0;
            $model->level = $model->level ? implode(' ', $model->level) : '';
            $model->type = $model->type ? implode(' ', $model->type) : '';
            if ($model->save()) {
                if ($newimage && $countimage > 0) {
                    foreach ($newimage as $image_code) {
                        $imgtem = \common\models\media\ImagesTemp::findOne($image_code);
                        if ($imgtem) {
                            $nimg = new \common\models\shop\ShopImages();
                            $nimg->attributes = $imgtem->attributes;
                            $nimg->id = NULL;
                            unset($nimg->id);
                            $nimg->shop_id = $model->id;
                            $nimg->type = 1;
                            if ($nimg->save()) {
                                $imgtem->delete();
                            }
                        }
                    }
                }
                if ($newimageauth && $countimageauth > 0) {
                    foreach ($newimageauth as $image_code) {
                        $imgtem = \common\models\media\ImagesTemp::findOne($image_code);
                        if ($imgtem) {
                            $nimg = new \common\models\shop\ShopImages();
                            $nimg->attributes = $imgtem->attributes;
                            $nimg->id = NULL;
                            unset($nimg->id);
                            $nimg->shop_id = $model->id;
                            $nimg->type = 2;
                            if ($nimg->save()) {
                                $imgtem->delete();
                            }
                        }
                    }
                }
                if ($model->status != 1) {
                    \common\models\product\Product::updateAll(['status' => 0], [
                        'AND',
                        'status <> 0',
                        ['shop_id' => $id]
                    ]);
                }
                Yii::$app->session->setFlash('success', 'Cập nhật thành công');
                return $this->redirect(['update', 'id' => $model->id]);
            }
        }
        $transports = Transport::getAll();
        $shop_transports = ShopTransport::getByShop($id);
        $model->level = is_array($model->level) ? $model->level : explode(' ', $model->level);
        $model->type = is_array($model->type) ? $model->type : explode(' ', $model->type);
        $image_auths = \common\models\shop\ShopImages::getImageAuths($id);
        $images = \common\models\shop\ShopImages::getImages($id);
        return $this->render('update', [
            'model' => $model,
            'transports' => $transports,
            'shop_transports' => $shop_transports,
            'image_auths' => $image_auths,
            'images' => $images,
        ]);
    }

    public function actionBlock($id)
    {
        $model = $this->findModel($id);
        if($model->status == 0){
            $model->status = 1;
        }else{
            $model->status = 0;
        }
        if ($model->save(false)) {
            

            Yii::$app->session->setFlash('success', 'Khóa "' . $model->name . '" thành công');
        } else {
            Yii::$app->session->setFlash('error', 'Khóa "' . $model->name . '" lỗi.');
        }
        return $this->redirect(['index']);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Shop::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionUpdateTransport($shop_id, $status, $id)
    {
        if (!$status) {
            $transport = ShopTransport::getByShopAndTransport($shop_id, $id);
            return $transport->delete();
        } else {
            $transport = new ShopTransport();
            $transport->status = $status;
            $transport->transport_id = $id;
            $transport->shop_id = $shop_id;
            $transport->default = 0;
        }
        return $transport->save();
    }

    public function actionUpdateTransportDefault($shop_id, $default, $id)
    {
        $transport = ShopTransport::getByShopAndTransport($shop_id, $id);
        if ($transport) {
            $transport->default = 1;
        } else {
            $transport = new ShopTransport();
            $transport->status = 1;
            $transport->transport_id = $id;
            $transport->shop_id = $shop_id;
            $transport->default = 1;
        }
        ShopTransport::updateAll(
            ['default' => 0],
            [
                'shop_id' => $shop_id
            ]
        );
        return $transport->save();
    }

    public function actionUpdateHot($user_id){
        $model = Shop::findOne($user_id);
        if($model->is_hot ==  0){
            $model->is_hot = 1;
        }else{
            $model->is_hot = 0;
        }
        if ($model->save()) {
            return \yii\helpers\Json::encode(array(
                'code' => 200,
                'html' => '<i class="fa fa-times" aria-hidden="true"></i>',
                'title' => Yii::t('app', 'click_to_on'),
                'link' => Url::to(['/user/shop/update-hot', 'user_id' => $user_id])
            ));
        } else {
            return \yii\helpers\Json::encode(array('code' => 400));
        }
    }

    public function actionDeleteImage($id)
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $id = Yii::$app->request->get('id');
            $image = \common\models\shop\ShopImages::findOne($id);
            if ($image->delete()) {
                return ['code' => 200];
            }
        }
    }
}
