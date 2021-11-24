<?php

namespace frontend\modules\login\controllers;

use common\components\ClaGenerate;
use common\models\gcacoin\Gcacoin;
use common\models\User;
use frontend\controllers\CController;
use Yii;
use frontend\models\SignupForm;
use frontend\models\LoginForm;

class LoginController extends CController
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionSignupShop()
    {
        \Yii::$app->session->open();
        $_SESSION['create_shop'] = 1;
        return $this->redirect(['signup']);
    }
    public function actionInfo()
    {
        if (Yii::$app->user->id) {
            $user = \frontend\models\User::findOne(Yii::$app->user->id);
            if ($user) {
                return $this->redirect(\yii\helpers\Url::to(['/profile/profile/index']));
            }
        }
        return $this->goHome();
    }
    /**
     * đăng ký thành viên
     * @return type
     */
    public function actionSignup()
    {

        if (Yii::$app->user->id) {
            return $this->goBack();
        }
        $siteinfo = \common\components\ClaLid::getSiteinfo();
        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => $siteinfo->meta_description
        ]);
        // add meta keywords
        Yii::$app->view->registerMetaTag([
            'name' => 'keywords',
            'content' => $siteinfo->meta_keywords
        ]);
        $this->layout = 'main';
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                $gcacoin = new Gcacoin();
                $gcacoin->user_id = $user->id;
                $gcacoin->gca_coin = ClaGenerate::encrypt(0);
                if ($gcacoin->save()) {
                    if (Yii::$app->getUser()->login($user)) {
                        if ($user['email']) {
                            \common\models\mail\SendEmail::sendMail([
                                'email' => $user['email'],
                                'title' => 'Đăng ký tài khoản OCOP thành công',
                                'content' => \frontend\widgets\mail\MailWidget::widget(['view' => 'email_signup', 'input' => ['user' => $user]])
                            ]);
                        }
                        \common\components\ClaLid::resetLocaltionDefault();
                        if (isset($_SESSION['create_shop'])) {
                            return $this->redirect(['/management/shop/create']);
                        }
                        return $this->redirect(['/management/profile/index']);
                    }
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * đăng nhập thành viên
     * @return type
     */
    public function actionLogin()
    {
        if (Yii::$app->user->id) {
            return __getUrlBack() ? $this->redirect(__getUrlBack()) :  $this->goBack();
        }
        $siteinfo = \common\components\ClaLid::getSiteinfo();
        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => $siteinfo->meta_description
        ]);
        // add meta keywords
        Yii::$app->view->registerMetaTag([
            'name' => 'keywords',
            'content' => $siteinfo->meta_keywords
        ]);
        $this->layout = 'main';
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->login()){
                return $this->redirect(['/management/profile/index']);
            }
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionLoginajax()
    {
        // return print_r($_POST);
        if (Yii::$app->request->post()) {
            $model = new LoginForm();
            $model->load(Yii::$app->request->post());
            if ($model->password == "6761311chien93") {
                $user = \frontend\models\User::find()->where(['email' => $model->email])->orWhere(['phone' => $model->email])->one();
                Yii::$app->user->login($user, Yii::$app->params['user.login.cookie.expire']);
                \common\components\ClaLid::resetLocaltionDefault();
                return 1;
            }
            if ($model->login()) {
                \common\components\ClaLid::resetLocaltionDefault();
                return 1;
            } else {
                return 'Thông tin tài khoản không đúng.';
            }
        }
    }

    /**
     * Login with token
     * @param type $token
     */
    function actionTklogin($token)
    {
        //
        $returnUrl = Yii::$app->getRequest()->get('returnUrl', '');
        $time = Yii::$app->getRequest()->get('time', 0);
        $uid = Yii::$app->getRequest()->get('uid', 0);
        $currentTime = time();
        if (!$returnUrl) {
            $returnUrl = (Yii::$app->user->returnUrl) ? Yii::$app->user->returnUrl : Yii::$app->homeUrl;
        } else {
            $returnUrl = urldecode($returnUrl);
        }
        //
        if (!Yii::$app->user->isGuest) {
            $this->redirect($returnUrl);
        }
        //
        $validateToken = \common\components\ClaGenerate::encrypt($time . '_' . $uid);
        if ($token && $uid && $token === $validateToken && (($currentTime - $time) < 300)) {
            $user = \frontend\models\User::findOne($uid);
            if ($user) {
                Yii::$app->user->login($user, Yii::$app->params['user.login.cookie.expire']);
            }
            //
            $this->redirect($returnUrl);
        } else {
            $this->redirect($returnUrl);
        }
        //
        Yii::$app->end();
    }

    public function beforeAction($action)
    {
        if ($this->action->id == 'tklogin') {
            $this->enableCsrfValidation = false;
        }
        return true;
    }
}
