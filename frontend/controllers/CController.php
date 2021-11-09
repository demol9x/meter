<?php

/**
 * Created by PhpStorm.
 * @author: Hatv
 * Date: 08/02/2018
 * Time: 2:53 CH
 */

namespace frontend\controllers;

use Yii;
use yii\web\Controller;

class CController extends Controller
{

    function init()
    {
        parent::init();
        if (isset($_GET['active_app_gcaeco'])) {
            \Yii::$app->session->open();
            $_SESSION['active_app_gcaeco'] = $_GET['active_app_gcaeco'];
        } else if (\common\components\ClaSite::isMobile()) {
            \Yii::$app->session->open();
            if (!isset($_SESSION['app_screen_doing'])) {
                if (isset($_GET['screen_start_mobile'])) {
                    $_SESSION['app_screen_doing'] = $_GET['screen_start_mobile'];
                    return '';
                } else {
			$siteinfo = \common\components\ClaLid::getSiteinfo();
                    echo '
                        <div style="display: flex; width: 100%; height: 100vh">
                            <img style="margin: auto;" src="' .$siteinfo->logo. '">
                        </div>
                        <script src="' . Yii::$app->homeUrl . 'js/jquery.min.js"></script>
                        <script type="text/javascript">
                            $.ajax({
                                url: "' . Yii::$app->homeUrl . 'site/set-mobile.html",
                                data: {
                                    screen_start_mobile: screen.width + "," + screen.height
                                },
                                success: function(result) {
                                    location.reload();
                                }
                            });
                        </script>';
                    die();
                }
            }
        }
    }

    function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        if (!Yii::$app->user->isGuest) {
            if (!isset($_COOKIE["_frontend_userinfo"])) {
                $userInfo = \common\models\User::findIdentity(Yii::$app->user->id);
                if ($userInfo) {
                    setcookie('_frontend_userinfo', json_encode(['id' => $userInfo->id, 'username' => $userInfo->username, 'auth_key' => $userInfo->auth_key]), time() + 24 * 3600 * 30);
                }
            }
        } else {
            if (isset($_COOKIE["_frontend_userinfo"])) {
                unset($_COOKIE["_frontend_userinfo"]);
                setcookie('_frontend_userinfo', '', time() - 3600, '/');
            }
        }
        return parent::beforeAction($action);
    }
}
