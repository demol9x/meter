<?php

namespace backend\modules\user\controllers;

use Yii;
use frontend\models\User;
use common\models\shop\Shop;
use common\models\shop\ShopSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\transport\Transport;
use common\models\transport\ShopTransport;

/**
 * UserController implements the CRUD actions for User model.
 */
class MailController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex() {
        return $this->render('index', [
                    // 'searchModel' => $searchModel,
                    // 'dataProvider' => $dataProvider,
        ]);
    }

    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionSendMail($page = 0) {
        $type = $_POST['type'];
        $arr = $_POST;
        switch ($type) {
            case 0:
                $data = (new \yii\db\Query())->select('email')
                ->from('user')
                ->all();
                $data2 = (new \yii\db\Query())->select('email')
                ->from('shop')
                ->all();
                $data = array_merge($data,$data2);
                break;
            case 1:
                $data = (new \yii\db\Query())
                ->select('email')
                ->from('user')
                ->all();
                break;
            case 2:
                $data = (new \yii\db\Query())->select('email')
                ->from('shop')
                // ->limit(10)
                // ->orderBy('id')
                ->all();
                break;
           
        }
        // echo '<pre>';
        // print_r($data);
        // die();
        $once = 25;
        $start = $page*$once;
        $end = count($data) > ($page*$once +$once) ? ($page*$once +$once) : count($data);
        for ($i= $start; $i < $end; $i++) { 
            $arr['email'] = $data[$i]['email'];
            if($arr['email']) {
                $this->sendMail($arr);
            }
        }
        $page++;
        return $this->renderAjax('waiting', [
                'page' => $page,
                'once' => $once,
                'end' => $end,
                'post' => $_POST,
                'count' => count($data),
        ]);
        
    }

    public function sendMail($arr) {
        $email = $arr["email"];
        $link = $arr["link"];
        if (isset($arr["title"])) {
            $tieude = $arr["title"];
        } else {
            $tieude = "Thông báo từ ".__NAME;
        }
        if (isset($arr["content"])) {
            $content = $arr["content"];
            $content .= $link ? '<br/><a href="'.$link.'">Xem chi tiết</a>' : '';
        } else {
            $content = "Cám ơn quý khách đã sử dụng dịch vụ của ".__NAME.".<br/> <a href='".__SERVER_NAME."'>Đến trang web ngay</a>";
        }
        Yii::$app->mailer->compose()
                ->setFrom([Yii::$app->params['adminEmail'] => __NAME])
                ->setTo($email)
                ->setSubject($tieude)
                ->setHtmlBody($content)
                ->send();
    }
}
