<?php

namespace frontend\modules\management\controllers;

use Yii;
use common\models\shop\Shop;
use common\models\Province;
use common\models\District;
use common\models\Ward;
use common\components\UploadLib;
use common\components\ClaHost;
use common\components\ClaGenerate;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\shop\ShopImages;
use common\models\rating\Rating;
use common\models\shop\ShopAddress;

/**
 * ShopController implements the CRUD actions for Shop model.
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

    /**
     * Creates a new Shop model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Shop();
        $this->layout = 'main-shop-create';

        $shop = Shop::findOne(Yii::$app->user->id);
        if ($shop) {
            return $this->redirect(['update']);
        }
        $user = \common\models\User::findOne(Yii::$app->user->id);
        \Yii::$app->session->open();
        $_SESSION['create_shop'] = 1;
        if ($model->load(Yii::$app->request->post())) {
            $model->id = Yii::$app->user->id;
            $model->user_id = Yii::$app->user->id;
            $model->type = implode(' ', $model->type);
            if ($user->email) {
                $model->email = $user->email;
            }
            //
            $avatar1 = Yii::$app->session[$model->avatar1];
            if ($avatar1) {
                $model->image_path = $avatar1['baseUrl'];
                $model->image_name = $avatar1['name'];
            }
            //
            $avatar2 = Yii::$app->session[$model->avatar2];
            if ($avatar2) {
                $model->avatar_path = $avatar2['baseUrl'];
                $model->avatar_name = $avatar2['name'];
            }

            //
            $model->status = 2;
            $model->province_name = ($tg = Province::findOne($model->province_id)) ? $tg['name'] : '';
            $model->district_name = ($tg = District::findOne($model->district_id)) ? $tg['name'] : '';
            $model->ward_name = ($tg = Ward::findOne($model->ward_id)) ? $tg['name'] : '';
            if ($model->latlng) {
                $tgss = explode(',', $model->latlng);
                if (count($tgss) > 1) {
                    $model->lat = $tgss[0];
                    $model->lng = $tgss[1];
                }
            }
            $model->time_limit_type = 1;
            $model->time_limit = time() + 365 * 24 * 60 * 60;
            if ($model->save()) {
                if ($model->time_limit_type_term == 0) {
                    $coin = \common\models\gcacoin\Gcacoin::findOne($model->user_id);
                    $xu = 1000;
                    if ($coin->addCoin(-$xu) && $coin->save(false)) {
                        $model->time_limit_type = 0;
                        $model->save(false);
                    } else {
                        Yii::$app->session->setFlash('error', 'Quý khách không đủ V để thanh toán. Tài khoản quý khách sẽ chuyển về gói gói miễn phí 12 tháng đầu. Quý lòng Nạp V và cập nhật lại gói.');
                    }
                }
                ShopAddress::addAddress($model);
                unset(Yii::$app->session[$model->avatar2]);
                unset(Yii::$app->session[$model->avatar1]);
                $newimage = Yii::$app->request->post('newimage');
                $countimage = $newimage ? count($newimage) : 0;
                if ($newimage && $countimage > 0) {
                    foreach ($newimage as $image_code) {
                        $imgtem = \common\models\media\ImagesTemp::findOne($image_code);
                        if ($imgtem) {
                            $nimg = new ShopImages();
                            $nimg->attributes = $imgtem->attributes;
                            $nimg->shop_id = $model->id;
                            if ($nimg->save()) {
                                $imgtem->delete();
                            }
                        }
                    }
                }
                $newimage2 = Yii::$app->request->post('newimage2');
                $countimage = $newimage2 ? count($newimage2) : 0;
                if ($newimage2 && $countimage > 0) {
                    foreach ($newimage2 as $image_code) {
                        $imgtem = \common\models\media\ImagesTemp::findOne($image_code);
                        if ($imgtem) {
                            $nimg = new ShopImages();
                            $nimg->attributes = $imgtem->attributes;
                            $nimg->shop_id = $model->id;
                            $nimg->type = 2;
                            if ($nimg->save()) {
                                $imgtem->delete();
                            }
                        }
                    }
                }
                $siteinfo = \common\components\ClaLid::getSiteinfo();
                $email_manager = $siteinfo->email_rif;
                if ($email_manager) {
                    \common\models\mail\SendEmail::sendMail([
                        'email' => $email_manager,
                        'title' => 'Gian hàng mới tạo trên OCOP',
                        'content' => '<p>Gian hàng ' . $model->name . ' của thành viên ' . $user->username . ' mới tạo và đang chờ được kích hoạt trên ocopmart.org.</p><p><a href="ocopmart.org/admin">Đi đến quản trị để kích hoạt</a></p>'
                    ]);
                }
                return $this->redirect(['auth']);
            }
        }
        $model->province_id = null;
        $list_district = District::dataFromProvinceId(0);
        $list_ward = Ward::dataFromDistrictId(0);
        $list_province = Province::optionsProvince();
        $images = null;
        $model->type = is_array($model->type) ? $model->type : explode(' ', $model->type);
        return $this->render('create', [
            'model' => $model,
            'images' => $images,
            'list_district' => $list_district,
            'list_ward' => $list_ward,
            'list_province' => $list_province,
            'user' => $user
        ]);
    }

    public function actionRemoveNew()
    {
        unset($_SESSION['create_shop']);
        return $this->redirect(['/management/shop/update']);
    }
    /**
     * Updates an existing Shop model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate()
    {
        $id = Yii::$app->user->id;
        $model = $this->findModel($id);
        $sum_product = \common\models\product\Product::find()->where(['shop_id' => $id])->count();
        return $this->render('update', [
            'model' => $model,
            'sum_product' => $sum_product,
        ]);
    }

    public function actionAuth()
    {
        $id = Yii::$app->user->id;
        $model = $this->findModel($id);
        if ($newimage = Yii::$app->request->post('newimage')) {
            $countimage = $newimage ? count($newimage) : 0;
            if ($newimage && $countimage > 0) {
                foreach ($newimage as $image_code) {
                    $imgtem = \common\models\media\ImagesTemp::findOne($image_code);
                    if ($imgtem) {
                        $nimg = new ShopImages();
                        $nimg->attributes = $imgtem->attributes;
                        $nimg->shop_id = $model->id;
                        $nimg->type = Shop::IMG_AUTH;
                        if ($nimg->save()) {
                            $imgtem->delete();
                        }
                    }
                }
            }
        }
        $images = ShopImages::find()->where(['shop_id' => $id, 'type' => Shop::IMG_AUTH])->all();
        return $this->render('auth', [
            'model' => $model,
            'images' => $images,
        ]);
    }

    public function actionUpdatess()
    {
        $id = Yii::$app->user->id;
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $avatar1 = Yii::$app->session[$model->avatar1];
            if ($avatar1) {
                $model->image_path = $avatar1['baseUrl'];
                $model->image_name = $avatar1['name'];
            }
            //
            $avatar2 = Yii::$app->session[$model->avatar2];
            if ($avatar2) {
                $model->avatar_path = $avatar2['baseUrl'];
                $model->avatar_name = $avatar2['name'];
            }
            $model->status = 2;
            $model->province_name = ($tg = Province::findOne($model->province_id)) ? $tg['name'] : '';
            $model->district_name = ($tg = District::findOne($model->district_id)) ? $tg['name'] : '';
            $model->ward_name = ($tg = Ward::findOne($model->ward_id)) ? $tg['name'] : '';
            if ($model->save()) {
                unset(Yii::$app->session[$model->avatar2]);
                unset(Yii::$app->session[$model->avatar1]);
                $newimage = Yii::$app->request->post('newimage');
                $countimage = $newimage ? count($newimage) : 0;
                if ($newimage && $countimage > 0) {
                    foreach ($newimage as $image_code) {
                        $imgtem = \common\models\media\ImagesTemp::findOne($image_code);
                        if ($imgtem) {
                            $nimg = new ShopImages();
                            $nimg->attributes = $imgtem->attributes;
                            $nimg->shop_id = $model->id;
                            if ($nimg->save()) {
                                $imgtem->delete();
                            }
                        }
                    }
                }
            }
        }
        $list_district = District::dataFromProvinceId($model->province_id);
        $list_ward = Ward::dataFromDistrictId($model->district_id);
        $list_province = Province::optionsProvince();
        $images = ShopImages::find()->where(['shop_id' => $id])->all();
        return $this->render('update', [
            'model' => $model,
            'images' => $images,
            'list_district' => $list_district,
            'list_province' => $list_province,
            'list_ward' => $list_ward,

        ]);
    }

    public function actionImage()
    {
        $id = Yii::$app->user->id;
        $model = $this->findModel($id);
        $newimage = Yii::$app->request->post('newimage');
        $countimage = $newimage ? count($newimage) : 0;
        if ($newimage && $countimage > 0) {
            foreach ($newimage as $image_code) {
                $imgtem = \common\models\media\ImagesTemp::findOne($image_code);
                if ($imgtem) {
                    $nimg = new ShopImages();
                    $nimg->attributes = $imgtem->attributes;
                    $nimg->shop_id = $model->id;
                    $nimg->type = 1;
                    if ($nimg->save()) {
                        $imgtem->delete();
                    }
                }
            }
        }
        $images = ShopImages::find()->where(['shop_id' => $id, 'type' => 1])->all();
        return $this->render('image', [
            'model' => $model,
            'images' => $images,
        ]);
    }

    /**
     * Deletes an existing Shop model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */

    public function actionDeleteImage($id)
    {
        ShopImages::findOne($id)->delete();
        return true;
    }

    /**
     * Finds the Shop model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Shop the loaded model
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

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionUploadfile()
    {
        if (isset($_FILES['file'])) {
            $file = $_FILES['file'];
            if ($file['size'] > 1024 * 1000) {
                Yii::$app->end();
            }
            $up = new UploadLib($file);
            $up->setPath(array('shop', date('Y_m_d', time())));
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

    public function actionUploadfilebgr()
    {
        if (isset($_FILES['file'])) {
            $file = $_FILES['file'];
            if ($file['size'] > 1024 * 1000) {
                Yii::$app->end();
            }
            $up = new UploadLib($file);
            $up->setPath(array('shop', date('Y_m_d', time())));
            $up->uploadImage();
            $return = array();
            $response = $up->getResponse(true);
            $return = array('status' => $up->getStatus(), 'data' => $response, 'host' => ClaHost::getImageHost(), 'size' => '');
            if ($up->getStatus() == '200') {
                $keycode = ClaGenerate::getUniqueCode();
                $return['data']['realurl'] = ClaHost::getImageHost() . $response['baseUrl'] . 's400_400/' . $response['name'];
                $return['data']['avatar'] = $keycode;
                Yii::$app->session[$keycode] = $response;
                $shop = Shop::findOne(Yii::$app->user->id);
                if ($shop) {
                    $shop->image_name = $response['name'];
                    $shop->image_path = $response['baseUrl'];
                    $shop->save();
                }
            }
            echo json_encode($return);
            Yii::$app->end();
        }
        //
    }

    public function actionUploadfileava()
    {
        if (isset($_FILES['file'])) {
            $file = $_FILES['file'];
            if ($file['size'] > 1024 * 1000) {
                Yii::$app->end();
            }
            $up = new UploadLib($file);
            $up->setPath(array('shop', date('Y_m_d', time())));
            $up->uploadImage();
            $return = array();
            $response = $up->getResponse(true);
            $return = array('status' => $up->getStatus(), 'data' => $response, 'host' => ClaHost::getImageHost(), 'size' => '');
            if ($up->getStatus() == '200') {
                $keycode = ClaGenerate::getUniqueCode();
                $return['data']['realurl'] = ClaHost::getImageHost() . $response['baseUrl'] . 's400_400/' . $response['name'];
                $return['data']['avatar'] = $keycode;
                Yii::$app->session[$keycode] = $response;
                $shop = Shop::findOne(Yii::$app->user->id);
                if ($shop) {
                    $shop->avatar_name = $response['name'];
                    $shop->avatar_path = $response['baseUrl'];
                    $shop->save();
                }
            }
            echo json_encode($return);
            Yii::$app->end();
        }
        //
    }

    public function actionUpdateAjax($attr, $value)
    {
        $model = $this->findModel(Yii::$app->user->id);
        if ($model && $value) {
            if ($attr == 'birthday') {
                $model->$attr = strtotime($value);
                if (strtotime($value) < 1000) {
                    return 0;
                }
            } else {
                $model->$attr = $value;
            }
            if ($model->save())
                return 1;
            echo "<pre>";
            print_r($model);
            die();
        }
        return 0;
    }

    public function actionRate()
    {
        $rates = Rating::getRatings(Rating::RATING_SHOP, Yii::$app->user->id);
        // echo "<pre>";
        // print_r($rates); die();
        return $this->render('rate', [
            'rates' => $rates,
        ]);
    }

    public function actionTime()
    {
        $user_id = Yii::$app->user->id;
        $shop = Shop::findOne($user_id);
        $package = \common\models\shop\ShopTimeLimit::find()->where(['status' => 1])->all();
        $coin = \common\models\gcacoin\Gcacoin::getModel($user_id);
        $history = \common\models\gcacoin\GcaCoinHistory::find()->where(['user_id' => Yii::$app->user->id, 'type' => 'PACKAGE_SHOP_TIME'])->orderBy(['id' => SORT_DESC])->all();
        return $this->render('time', [
            'shop' => $shop,
            'package' => $package,
            'coin' => $coin,
            'history' => $history,
        ]);
    }

    public function actionBuyPackage($id)
    {
        $user_id = Yii::$app->user->id;
        $shop = Shop::findOne($user_id);
        $package = \common\models\shop\ShopTimeLimit::find()->where(['status' => 1, 'id' => $id])->one();
        if ($package) {
            $coin = \common\models\gcacoin\Gcacoin::getModel($user_id);
            $first_coin = $coin->getCoin();
            if ($coin->addCoin(-$package->coin) && $coin->save(false)) {
                if ($id == \common\models\shop\ShopTimeLimit::ID_NOT_LIMMIT) {
                    $shop->time_limit_type = 0;
                } else {
                    $shop->time_limit = ($shop->time_limit > time()) ? $shop->time_limit + $package->time : time() + $package->time;
                }
                $shop->save(false);
                $history = new \common\models\gcacoin\GcaCoinHistory();
                $history->user_id = Yii::$app->user->id;
                $history->type = 'PACKAGE_SHOP_TIME';
                $history->data = 'Gia hạn thành công ' . $package->name;
                $history->gca_coin = -$package->coin;
                $history->first_coin = $first_coin;
                $history->last_coin = $coin->getCoin();
                $history->save();
                Yii::$app->session->setFlash('success', 'Gia hạn thành công <b>' . $package->name . '</b>');
            } else {
                Yii::$app->session->setFlash('error', 'Giao hạn không thành công <b>' . $package->name . '</b>. Vui lòng nạp V để thực hiện giao dịch này.');
            }
        } else {
            Yii::$app->session->setFlash('error', 'Gọi gia hạn không khả dụng. Vui lòng chọn gói gia hạn khác');
        }
        return $this->redirect(['time']);
    }

    public function actionTransport()
    {
        return $this->render('transport', []);
    }
}
