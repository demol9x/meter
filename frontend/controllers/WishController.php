<?php

namespace frontend\controllers;

use common\components\ClaLid;
use Yii;
use yii\web\Controller;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Url;
use common\models\product\ProductWish;
use common\models\product\Product;

/**
 * Site controller
 */
class WishController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    // 'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'successCallback'],
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex() {
        $this->layout = 'home';
        $siteinfo = \common\components\ClaLid::getSiteinfo();
        // add title for view
        Yii::$app->view->title = Yii::t('app', 'list_like');
        // add meta description
        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => Yii::t('app', 'list_like')
        ]);
        // add meta keywords
        Yii::$app->view->registerMetaTag([
            'name' => 'keywords',
            'content' =>Yii::t('app', 'list_like')
        ]);
        //
        $ids = ProductWish::getWishAllByUser();
        $pagesize = ClaLid::DEFAULT_LIMIT;
        $page = Yii::$app->request->get('page', 1);
        //
        $data = $_GET;
        //
        $products = Product::getProduct(array_merge($data, [
                    'limit' => $pagesize,
                    'page' => $page,
                    'id' => $ids,
                    'status' => ''
                ]));
        //
        $totalitem = Product::getProduct(array_merge($data, [
                    'count' => 1,
                    'id' => $ids
                ]));
        //
        return $this->render('index', [
                    'data' => $products,
                    'totalitem' => $totalitem,
                    'limit' => $pagesize
        ]);
    }
    public function actionAddLike() {
        if($user_id = Yii::$app->user->id) {
            if(isset($_GET['id'])) {
                $wish = new ProductWish();
                $wish->user_id = $user_id;
                $wish->product_id = $_GET['id'];
                $wish->created_at =  time();
                if($wish->save()) {
                    return $this->renderAjax('response-like', [
                        'repspone' => 1
                    ]);
                }
                return $this->renderAjax('response-like', [
                    'repspone' => -1
                ]);
            }
            
        } else {
            return $this->renderAjax('response-like', [
                'repspone' => 0
            ]);
        }
    }

    public function actionRemoveLike() {
        if($user_id = Yii::$app->user->id) {
            if(isset($_GET['id'])) {
                $wish = ProductWish::find()->where(['user_id'=> Yii::$app->user->id, 'product_id' => $_GET['id']])->one();
                $wish->delete();
                return $this->renderAjax('response-like', [
                    'repspone' => 2
                ]);
            }
            
        } else {
            return $this->renderAjax('response-like', [
                'repspone' => 0
            ]);
        }
    }

}
