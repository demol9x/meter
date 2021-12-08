<?php

namespace frontend\modules\package\controllers;

use common\components\ClaGenerate;
use common\components\ClaMeter;
use common\models\general\UserWish;
use common\models\package\PackageImage;
use common\models\package\PackageOrder;
use common\models\package\PackageWish;
use common\models\Province;
use common\models\user\UserAddress;
use frontend\models\User;
use Yii;
use frontend\controllers\CController;
use common\components\ClaLid;
use yii\helpers\Url;
use  common\models\package\Package;
use common\models\shop\Shop;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * News controller for the `news` module
 */
class PackageController extends CController
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = 'main';

        Yii::$app->params['breadcrumbs'] = [
            'Trang chủ' => Url::home(),
            'Gói thầu' => Url::to(['/package/package/index']),
        ];
        $pagesize = 24;
        $page = Yii::$app->request->get('page', 1);
        $provinces = Province::find()->asArray()->all();
        $package_wish = PackageWish::find()->where(['user_id' => Yii::$app->user->id])->asArray()->all();
        $package_wish = array_column($package_wish, 'package_id', 'id');
        $data = Package::getPackage(array_merge(Yii::$app->request->get() ,[
            'limit' => $pagesize,
            'page' => $page,
            ]));
        $km_shop=[];
        $km_qd=[];
        if(Yii::$app->user->id){
            $shop = UserAddress::find()->where(['user_id' =>Yii::$app->user->id,'isdefault'=>1])->asArray()->one();
            if(isset($shop['latlng']) && $shop['latlng']){
                $km_shop= explode(',',$shop['latlng']);
            }
        }

        return $this->render('index', [
            'data' => $data['data'],
            'totalitem' => $data['total'],
            'limit' => $pagesize,
            'provinces' => array_column($provinces,'name','id'),
            'package_wish'=>$package_wish,
            'km_shop'=>$km_shop
        ]);
    }
    public  function  actionAddLike(){
        $user_id = Yii::$app->user->getId();
        $package_id = Yii::$app->request->get('package_id',0);
        $message = '';
        $errors = [];
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if(Yii::$app->user->getId()){
                $user = \frontend\models\User::findOne($user_id);
                $package_wish = PackageWish::find()->where(['user_id' => $user_id, 'package_id' => $package_id])->one();
                if ($package_wish) {
                    if ($package_wish->delete()) {
                        return json_encode([
                            'success' => true,
                            'errors' => $errors,
                            'message' => 'Xóa khỏi danh sách yêu thích thành công'
                        ]);
                    } else {
                        $message = $package_wish->getErrors();
                    }
                }
                else {
                    $package_wish = new PackageWish();
                    $package_wish->user_id = $user_id;
                    $package_wish->package_id = $package_id;
                    if ($package_wish->save()) {
                        return json_encode([
                            'success' => true,
                            'errors' => $errors,
                            'message' => 'Thêm vào danh sách yêu thích thành công'
                        ]);
                    } else {
                        $errors = $package_wish->getErrors();
                    }
                }
            }
            else {
                $message = 'Bạn phải đăng nhập để thực hiện hành động này.';
            }
        }
        return json_encode([
            'success' => false,
            'errors' => $errors,
            'message' => $message
        ]);
    }
    public function actionDetail($id, $t = 0)
    {
        $this->layout = 'detail';
        $package = Package::findOne($id);
        $shop = Shop::find()->where(['user_id' => $package->shop_id])->joinWith(['province', 'district', 'ward'])->asArray()->one();
        $count = PackageOrder::find()->where(['package_id' => $package->id])->count();
        $image = PackageImage::find(['package_id'=>$id])->asArray()->all();
        //Gói thầu tương tự
        $package_shop=Package::find()->where(['shop_id' => $package->shop_id, 'status' => 1])->joinWith(['province'])->asArray()->limit(15)->all();
        foreach ($package_shop as $key =>$value){
            if($value['id']==$id){
                unset($package_shop[$key]);
            }
        }
        //Gói thầu khác
        $package_related = Package::find()->where(['shop_id' => $package->shop_id, 'status' => 1])->andWhere(['<>', 'package.id', $id])->joinWith(['province'])->asArray()->limit(15)->all();
        Yii::$app->params['breadcrumbs'] = [
            Yii::t('app', 'home') => Url::home(),
            $package->name => Url::to(['/package/package/detail','alias' => $package->alias, 'id' => $package->id])
        ];
        $package_wish = PackageWish::find()->where(['user_id' => Yii::$app->user->id])->asArray()->all();
        $package_wish = array_column($package_wish, 'package_id', 'id');
        //Gói thầu nổi  bật
        $package_ishot = Package::find()->where(['isnew' => 1, 'status' => 1])->joinWith(['province'])->asArray()->limit(5)->all();
        $shop_user= Shop::findOne(['user_id' => Yii::$app->user->getId()]);
        $check = PackageOrder::find()->where(['shop_package_id' => Yii::$app->user->getId(),'package_id' => $id])->one();
        $package_active = Package::find()->where(['id' => $id, 'shop_id'=>Yii::$app->user->getId()])->all();

        $model = new PackageOrder();
        if($model->load(Yii::$app->request->post()))
        {
            if(Yii::$app->user->getId()) {
                if ($shop_user) {
                    if(!$package_active){
                        if (!$check) {
                            $model->founding = strtotime($model->founding);
                            $model->shop_id = Yii::$app->user->id;
                            $model->package_id = $id;
                            $model->shop_package_id = $package->shop_id;
                            $model->file = UploadedFile::getInstance($model, 'file');
                            if ($model->file) {
                                $model->file->saveAs(Yii::getAlias('@rootpath') . '/static/media/files/package/' . ClaGenerate::getUniqueCode() . '.' . $model->file->extension);
                                $model->attachment = '/static/media/files/package/' . ClaGenerate::getUniqueCode() . '.' . $model->file->extension;
                            }
                            if ($model->save()) {
                                Yii::$app->session->setFlash('success', "Đăng kí dự thầu thành công");
                                return $this->refresh();
                            } else {
                                Yii::$app->session->setFlash('success', 'Đăng kí không thành công ');

                            }
                        }
                        else
                        {
                            Yii::$app->session->setFlash('success', 'Bạn đã đăng kí dự thầu');
                        }
                    }
                    else{
                        Yii::$app->session->setFlash('success', 'Bạn không được dư thầu gói thầu của mình');
                    }
                }
                else{
                    Yii::$app->session->setFlash('success', 'Chỉ có tài khoản doanh nghiệp mới được tham gia dự thầu.');
                }
            }
            else
            {
                Yii::$app->session->setFlash('success', 'Bạn vui lòng đăng nhập để dự thầu');
            }
        }
        return $this->render('detail', [
            't' => $t,
            'package' => $package,
            'shop'=>$shop,
            'count'=>$count,
            'image'=>$image,
            'package_related'=>$package_related,
            'package_wish'=>$package_wish,
            'model'=>$model,
            'shop_user'=>$shop_user,
            'package_ishot'=>$package_ishot,
            'check'=>$check,
            'package_shop'=>$package_shop,
            'package_active'=>$package_active
        ]);
    }

    public function actionDownload($id)
    {
        

    }
    public function actionCheck(){
        $user_id= Yii::$app->user->getId();
        $package_id = Yii::$app->request->get('package_id',0);
        $message = '';
        $errors = [];
        $html='' ;
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($user_id){
                $user = \frontend\models\User::findOne($user_id);
                if($user->type==User::TYPE_DOANH_NGHIEP){
                    $package = Package::findOne($package_id);
                    if($package && $package->shop_id != $user_id){
                        $check = PackageOrder::find()->where(['shop_id' => $user_id,'package_id' => $package_id])->one();
                        if ($check) {
                            return json_encode([
                                'success'=>true,
                            ]);
                        }
                        else
                        {
                            $message = 'Bạn đã đăng kí dự thầu';
                        }
                    }
                    else{
                        $message = 'Bạn không thể đầu tư gói thầu của chính mình hoặc gói thầu không tồn tại';
                    }
                }
                else{
                    $message = 'Chỉ có tài khoản doanh nghiệp mới được tham gia dự thầu.';
                }
            }
            else
            {
                $message = 'Bạn phải đăng nhập để thực hiện hành động này.';
                $html = '/login/login/login';
            }
        }
        return json_encode([
            'success' => false,
            'errors' => $errors,
            'message' => $message,
            'html'=>$html,
        ]);
    }
    /**
     * Finds the News model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return News the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */

    protected function addView($id)
    {
        if (($model = Package::findOne($id)) !== null) {
            $key = 'package_viewed_' . $model->id;
            if (!isset($_COOKIE[$key])) {
                $model->viewed++;
                $connection = Yii::$app->db;
                $connection->createCommand()->update('package', ['viewed' => $model->viewed], 'id =' . $model->id)->execute();
                setcookie($key, "1", time() + (60), "/");
            }
            return $model;
        } else {
            return 0;
        }
    }
}
