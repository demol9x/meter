<?php

namespace frontend\controllers;

use common\components\ClaLid;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\review\CustomerReviews;


/**
 * Site controller
 */
class ReviewController extends CController {

    public $successUrl = 'Success';

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
        $limit = 10;
        $siteinfo = \common\components\ClaLid::getSiteinfo();
        // add title for view
        Yii::$app->view->title = isset($siteinfo->title) ? $siteinfo->title : 'Ý kiến người dùng';
        // add meta description
        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => $siteinfo->meta_description
        ]);
        // add meta keywords
        Yii::$app->view->registerMetaTag([
            'name' => 'keywords',
            'content' => $siteinfo->meta_keywords
        ]);
        //
        $data = CustomerReviews::getCustomerReview([
                'limit' => $limit,
            ]);
        $totalitem  = CustomerReviews::getCustomerReview([
                'count' => 1,
            ]);
        return $this->render('index',[
                        'data' => $data,
                        'totalitem' => $totalitem,
                        'limit' => $limit
                    ]);
    }

}
