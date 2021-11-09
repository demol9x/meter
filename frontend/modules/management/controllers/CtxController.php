<?php

namespace frontend\modules\management\controllers;

use Yii;
use common\models\product\CerXts;
use common\models\product\CerXtsShop;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\shop\ShopImages;

/**
 * ShopController implements the CRUD actions for Shop model.
 */
class CtxController extends Controller
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

    public function actionIndex()
    {
        $shop_id = Yii::$app->user->id;
        $cers = CerXtsShop::find()->where(['shop_id' => $shop_id])->all();
        $list_c = CerXts::find()->all();
        $data = [];
        if ($list_c && $cers) {
            foreach ($cers as $item) {
                $data[$item['cer_xts_id']] = $item->attributes;
            }
        }
        return $this->render('index', [
            'cers' => $data,
            'list_c' => $list_c,
        ]);
    }

    /**
     * Creates a new Shop model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionUpdate($cer_id)
    {
        $cer = CerXts::findOne($cer_id);
        if (!$cer) {
            return $this->redirect(['index']);
        }
        $model = CerXtsShop::getOne(['cer_xts_id' => $cer_id, 'shop_id' => Yii::$app->user->id]);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                return $this->redirect(['index']);
            }
        }
        return $this->render('update', [
            'model' => $model,
            'cer' => $cer,
        ]);
    }

    public function actionDel($id)
    {
        if ($model = $this->findModel($id)) {
            $model->delete();
            Yii::$app->session->setFlash('success', Yii::t('app', 'delete_success'));
        }
        return $this->redirect(['index']);
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
        if (($model = CerXtsShop::findOne($id)) !== null) {
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
}
