<?php

namespace frontend\modules\shop\controllers;

use backend\modules\optionprice\Optionprice;
use common\components\ClaMeter;
use common\models\general\ChucDanh;
use common\models\general\UserWish;
use common\models\package\Package;
use common\models\package\PackageWish;
use common\models\Province;
use common\models\user\Tho;
use common\models\user\UserImage;
use Yii;
use yii\db\Expression;
use yii\web\Controller;
use common\models\product\ProductCategory;
use common\models\shop\Shop;
use common\models\shop\ShopImages;
use common\models\product\Product;
use common\models\product\ProductWish;
use common\models\product\ProductAttributeSet;
use common\components\ClaLid;
use common\components\ClaCategory;
use common\components\ClaArray;
use frontend\components\FilterHelper;
use yii\helpers\Url;
use yii\web\Response;
use common\components\ClaHost;
use frontend\models\User;

;

/**
 * Shop controller for the `product` module
 */
class ShopController extends Controller
{

    public $layout = 'main';

    /**
     * Renders the index view for the module
     * @return string
     */
    public function beforeAction($event)
    {
        Yii::$app->session->open();
        return parent::beforeAction($event);
    }

    public function actionIndex()
    {
        $pagesize = 24;
        $page = Yii::$app->request->get('page', 1);
        $users = \frontend\models\User::getS(array_merge(Yii::$app->request->get(), [
            'limit' => $pagesize,
            'page' => $page,
        ]));
        $us_wish = UserWish::find()->where(['user_id_from' => Yii::$app->user->id, 'type' => \frontend\models\User::TYPE_DOANH_NGHIEP])->asArray()->all();
        $us_wish = array_column($us_wish, 'user_id', 'id');
        $provinces = Province::find()->asArray()->all();
        $option_price = \common\models\OptionPrice::find()->asArray()->all();
        return $this->render('index', [
            'users' => $users['data'],
            'us_wish' => $us_wish,
            'provinces' => array_column($provinces, 'name', 'id'),
            'limit' => $pagesize,
            'totalitem' => $users['total'],
            'option_price' => $option_price,
        ]);
    }

    public function actionAddLike()
    {
        $user_id = Yii::$app->user->getId();
        $dn_id = Yii::$app->request->get('dn_id', 0);
        $message = '';
        $errors = [];
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if (Yii::$app->user->getId()) {
                $user = \frontend\models\User::findOne($user_id);
                $user_wish = UserWish::find()->where(['user_id_from' => $user_id, 'user_id' => $dn_id])->one();
                if ($user_wish) {
                    if ($user_wish->delete()) {
                        return json_encode([
                            'success' => true,
                            'errors' => $errors,
                            'message' => 'Xóa khỏi danh sách yêu thích thành công'
                        ]);
                    } else {
                        $message = $user_wish->getErrors();
                    }
                } else {
                    $user_wish = new UserWish();
                    $user_wish->user_id_from = $user_id;
                    $user_wish->user_id = $dn_id;
                    $user_wish->type = \frontend\models\User::TYPE_DOANH_NGHIEP;
                    if ($user_wish->save()) {
                        return json_encode([
                            'success' => true,
                            'errors' => $errors,
                            'message' => 'Thêm vào danh sách yêu thích thành công'
                        ]);
                    } else {
                        $message = $user_wish->getErrors();
                    }
                }
            } else {
                $message = 'Bạn phải đăng nhập để thực hiện hành động này.';
            }
        }
        return json_encode([
            'success' => false,
            'errors' => $errors,
            'message' => $message
        ]);
    }

    public function actionDetail($id)
    {
        $shop = Shop::findOne($id);
        Yii::$app->params['breadcrumbs'] = [
            Yii::t('app', 'home') => Url::home(),
            'Nhà thầu'=>Url::to(['/shop/shop/detail','id'=>$id])
        ];
        if($shop){
            $data = $shop->attributes;
            //Ảnh nhà thầu
            $images = UserImage::getImages($id);
            $data['images'] = $images;
            //Gói thầu chào bán
            $package_related = Package::find()->where(['shop_id' => $id, 'status' => 1])->joinWith(['province'])->asArray()->all();
            $related = [];
            $package_wish = PackageWish::find()->where(['user_id' => Yii::$app->user->id])->asArray()->all();
            $package_wish = array_column($package_wish, 'package_id', 'id');
            if ($package_related) {
                if(Yii::$app->user->id){
                    $package_wish = PackageWish::find()->where(['user_id' => Yii::$app->user->id])->asArray()->all();
                    $package_wish = array_column($package_wish, 'package_id', 'id');
                }
                foreach ($package_related as $value) {
                    $value['is_wish'] = false;
                    if (isset($package_wish) && $package_wish && in_array($value['id'], $package_wish)) {
                        $value['is_wish'] = true;
                    }
//                    if ($lat && $lng) {
//                        $value['km'] = (int)ClaMeter::betweenTwoPoint($lat, $lng, $value['lat'], $value['long']) . 'km';
//                    } else {
//                        $value['km'] = '';
//                    }
                    $related[] = $value;
                }
            }
            $data['related'] = $related;
            $shop_related = [];
            $shop_more = Shop::getShopRelation(['_id' => $id,'limit' => 8]); //Lấy ra nhà thầu khác
            if($shop_more){
                if(Yii::$app->user->id){
                    $shop_wish = UserWish::find()->where(['user_id_from' => Yii::$app->user->id,'type' => User::TYPE_DOANH_NGHIEP])->asArray()->all();
                    $shop_wish = array_column($shop_wish, 'user_id', 'id');
                }
                foreach ($shop_more as $value) {
                    $value['is_wish'] = false;
                    if (isset($shop_wish) && $shop_wish && in_array($value['user_id'], $shop_wish)) {
                        $value['is_wish'] = true;
                    }
                    $shop_related[] = $value;
                }
            }
            $data['shop_more'] = $shop_related;

            //Gói thầu nỏi bật
            $package_ishot = Package::find()->where(['isnew' => 1, 'status' => 1])->joinWith(['province'])->asArray()->limit(5)->all();

            return $this->render('detail', [
                'package_ishot'=>$package_ishot,
                'package_wish'=>$package_wish,
                'data' => $data
            ]);
        }else{
            return $this->redirect('/');
        }

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
            $name_shop_ck = 'view_shop_' . $model->id;
            if (!isset($_COOKIE[$name_shop_ck])) {
                $model->viewed++;
                $connection = Yii::$app->db;
                $connection->createCommand()->update('shop', ['viewed' => $model->viewed], 'id =' . $model->id)->execute();
                setcookie($name_shop_ck, "1", time() + (60), "/");
            }
            return $model;
        } else {
            return 0;
        }
    }


}
