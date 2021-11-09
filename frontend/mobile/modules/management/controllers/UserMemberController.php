<?php

namespace frontend\mobile\modules\management\controllers;

use Yii;
use common\models\Ward;
use common\components\ClaGenerate;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ShopController implements the CRUD actions for Shop model.
 */
class UserMemberController extends Controller
{
    public $layout = 'main_user';
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
        $user = \common\models\User::findOne(Yii::$app->user->id);
        return $this->render('index', [
            'user' => $user,
        ]);
    }

    public function actionGetKey()
    {
        $post = $_GET;

        $ch = curl_init('https://member.gcaeco.vn/checkout/checklogin');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

        // execute!
        $response = curl_exec($ch);

        // close the connection, release resources used
        curl_close($ch);

        $response = json_decode($response, true);

        if($response['error_code']) {
            return $response['message'];
        } else {
            if(isset($response['private_key']) && $response['private_key']) {
                $user = \common\models\User::findOne(Yii::$app->user->id);
                $user->member_privatekey = $response['private_key'];
                if($user->save(false)) {
                    return '<script type="text/javascript"> location.reload(); </script>';
                }
            }
        }
    }

    public function actionDel()
    {
        $user = \common\models\User::findOne(Yii::$app->user->id);
        $user->member_privatekey = '';
        $user->save(false);
        return $this->redirect(['index']);
    }
}
