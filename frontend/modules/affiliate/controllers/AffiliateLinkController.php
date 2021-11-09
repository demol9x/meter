<?php

namespace frontend\modules\affiliate\controllers;

use common\models\product\Product;
use Yii;
use common\models\affiliate\AffiliateLink;
use common\models\affiliate\search\AffiliateLinkSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\ClaLid;
use yii\web\Response;

/**
 * AffiliateLinkController implements the CRUD actions for AffiliateLink model.
 */
class AffiliateLinkController extends Controller
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

    /**
     * Lists all AffiliateLink models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = 'main';
        //
        $pagesize = isset($_GET['per-page']) ? $_GET['per-page'] : ClaLid::DEFAULT_LIMIT;
        $page = Yii::$app->request->get('page', 1);
        //
        $links = AffiliateLink::getAllLink();
        //
        $affLinkIds = array_column($links, 'id');
        //
        $allClick = \common\models\affiliate\AffiliateClick::getClickByAffiliateIds($affLinkIds);
        //
        $allOrder = \common\models\order\OrderItem::getOrderByAffiliateIds(array_column($links, 'object_id'));
        //

        $affOjectIds = array_column($links, 'object_id');
        $affOjectIds = count($affOjectIds) > 0 ? $affOjectIds : [-1];

        $data = Product::getProduct([
            'limit' => 20,
            'id' => $affOjectIds,
            'page' => $page,
        ]);

        $totalitem = Product::getProduct(array_merge($_GET, [
            'count' => 1,
            'limit' => 20,
            'id' => $affOjectIds,
            'page' => $page,
        ]));

        $affiliate = \common\models\affiliate\Affiliate::find()->one();

        return $this->render('index', [
            'products' => $data,
            'totalitem' => $totalitem,
            'limit' => $pagesize,
            'links' => $links,
            'affiliate' => $affiliate,
            'allClick' => $allClick,
            'allOrder' => $allOrder,
        ]);
    }

    public function actionAdd()
    {
        $this->layout = 'main';
        //
        $pagesize = isset($_GET['per-page']) ? $_GET['per-page'] : ClaLid::DEFAULT_LIMIT;
        $page = Yii::$app->request->get('page', 1);

        $keyword = \Yii::$app->request->get('keyword');
        //
        $links = AffiliateLink::getAllLink();

        $affOjectIds = array_column($links, 'object_id');

        $data = Product::getProduct([
            'shop_affiliate' => \common\components\ClaLid::STATUS_ACTIVED,
            'shop_status_affiliate' => \common\components\ClaLid::STATUS_ACTIVED,
            'status_affiliate' => \common\components\ClaLid::STATUS_ACTIVED,
            'limit' => 20,
            'keyword' => $keyword,
            '_id' => $affOjectIds,
            'page' => $page,
        ]);

        $totalitem = Product::getProduct(array_merge($_GET, [
            'shop_affiliate' => \common\components\ClaLid::STATUS_ACTIVED,
            'shop_status_affiliate' => \common\components\ClaLid::STATUS_ACTIVED,
            'status_affiliate' => \common\components\ClaLid::STATUS_ACTIVED,
            'count' => 1,
            'limit' => 20,
            'keyword' => $keyword,
            '_id' => $affOjectIds,
            'page' => $page,
        ]));

        $affiliate = \common\models\affiliate\Affiliate::find()->one();

        return $this->render('add', [
            'products' => $data,
            'totalitem' => $totalitem,
            'limit' => $pagesize,
            'links' => $links,
            'affiliate' => $affiliate
        ]);
    }

    /**
     * Displays a single AffiliateLink model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new AffiliateLink model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = 'main';
        //
        $model = new AffiliateLink();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing AffiliateLink model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing AffiliateLink model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AffiliateLink model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return AffiliateLink the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AffiliateLink::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCreateLink()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $url = Yii::$app->request->get('url');
            $object_id = Yii::$app->request->get('object_id');
            $type = Yii::$app->request->get('type');
            if (isset($url) && $url) {
                $model = new AffiliateLink();
                $model->user_id = \Yii::$app->user->id;
                $model->url = $url;
                $model->type = $type;
                $model->object_id = $object_id;
                //
                if ($model->save()) {
                    $link = $model->url . '?affiliate_id=' . $model->id;
                    $model->link = $link;
                    if ($model->save()) {
                        return [
                            'message' => 'success',
                            'link' => $link
                        ];
                    } else {
                        echo '<pre>';
                        print_r($model->getErrors());
                        echo '</pre>';
                        die();
                    }
                } else {
                    echo '<pre>';
                    print_r($model->getErrors());
                    echo '</pre>';
                    die();
                }
            }
        }
    }
}
