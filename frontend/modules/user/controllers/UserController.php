<?php

namespace frontend\modules\user\controllers;

use backend\modules\auth\models\searchs\User;
use common\components\ClaGenerate;
use common\components\ClaUrl;
use common\models\general\ChucDanh;
use common\models\general\UserWish;
use common\models\Province;
use common\models\user\UserImage;
use Yii;
use frontend\controllers\CController;
use common\models\user\Tho;
use common\models\product\ProductWish;
use yii\helpers\Url;
use yii\web\Response;

class UserController extends CController
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

    public function actionIndex()
    {
        $this->layout = 'main';
        $pagesize = 24;
        $page = Yii::$app->request->get('page', 1);
        $users = \frontend\models\User::getT(array_merge(Yii::$app->request->get(),[
            'limit' => $pagesize,
            'page' => $page,
        ]));

        $us_wish = UserWish::find()->where(['user_id_from' => Yii::$app->user->id,'type' => \frontend\models\User::TYPE_THO])->asArray()->all();
        $us_wish = array_column($us_wish, 'user_id', 'id');
        $provinces = Province::find()->asArray()->all();
        $jobs = ChucDanh::getJob();
        $kns = Tho::numberKn();
        return $this->render('index', [
            'users' => $users['data'],
            'us_wish' => $us_wish,
            'provinces' => array_column($provinces,'name','id'),
            'jobs' => $jobs,
            'kns' => $kns,
            'limit' => $pagesize,
            'totalitem' => $users['total'],
        ]);
    }

    public function actionAddLike(){
        $user_id = Yii::$app->user->getId();
        $tho_id = Yii::$app->request->get('tho_id',0);
        $message = '';
        $errors = [];
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if(Yii::$app->user->getId()){
                $user = \frontend\models\User::findOne($user_id);
                $user_wish = UserWish::find()->where(['user_id_from' => $user_id, 'user_id' => $tho_id])->one();
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
                }
                else {
                    $user_wish = new UserWish();
                    $user_wish->user_id_from = $user_id;
                    $user_wish->user_id = $tho_id;
                    $user_wish->type = \frontend\models\User::TYPE_THO;
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
        $tho = Tho::find()->where(['user_id' => $id])->joinWith(['province','district','ward','user','job'])->asArray()->one();

        Yii::$app->params['breadcrumbs'] = [
            Yii::t('app', 'home') => Url::home(),
            'Thợ'=>Url::to(['/user/user/index']),
            isset($tho['name'])&&$tho['name'] ?$tho['name'] : ' Không có'=>Url::to(['/user/user/detail','id'=>$tho['user_id']]),
        ];
        $tho_related= Tho::find()->where(['tho.status'=>1])->andWhere(['>','kinh_nghiem',2])->joinWith(['province','district','ward','user','job'])->asArray()->all();
        if($tho_related && isset($tho_related)){
            foreach ($tho_related as $key =>$value){
               if($value['user_id']== $tho['user_id']){
                   unset($tho_related[$key]);
               }
            }
        }
        $tho_hot = Tho::find()->where(['tho.status'=>1,'tho.is_hot' => 1])->joinWith(['province','district','ward','user','job'])->asArray()->limit(5)->all();
        if($tho_hot && isset($tho_hot)){
            foreach ($tho_hot as $key =>$value){
                if($value['user_id']== $tho['user_id']){
                    unset($tho_hot[$key]);
                }
            }
        }
        if($tho){
            $data = $tho;
            //Ảnh nhà thầu
            $images = UserImage::getImages($id);
            $data['images'] = $images;
        }
        $us_wish = UserWish::find()->where(['user_id_from' => Yii::$app->user->id,'type' => \frontend\models\User::TYPE_THO])->asArray()->all();
        $us_wish = array_column($us_wish, 'user_id', 'id');
        return $this->render('detail', [
            'data'=>$data,
            'tho_related'=>$tho_related,
            'us_wish'=>$us_wish,
            'tho_hot'=>$tho_hot,
        ]);
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
