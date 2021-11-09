<?php

namespace frontend\modules\media\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use common\models\media\Video;
use common\models\Province;
use common\models\media\VideoCategory;
use yii\web\Response;

/**
 * Video controller
 */
class VideoController extends Controller {

    public function actionIndex() {
       

        return $this->render('index', [
                    // 'category' => $category,
                    // 'videos' => $videos,
                    // 'totalitem' => $totalitem,
                    // 'limit' => $pagesize
        ]);
    }
    public function actionCategory($id) {
        $this->layout = '@frontend/views/layouts/province';

        $category = VideoCategory::findOne($id);
        if ($category === NULL) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        Yii::$app->view->title = $category->name;
        $pagesize = 20;
        $page = Yii::$app->request->get('page', 1);
        $videos = Video::getVideoInCategory($id, [
                    'limit' => $pagesize,
                    'page' => $page,
        ]);
        $totalitem = Video::countVideoInCategory($id);

        return $this->render('category', [
                    'category' => $category,
                    'videos' => $videos,
                    'totalitem' => $totalitem,
                    'limit' => $pagesize
        ]);
    }

    /**
     * @return type
     */
    public function actionProvince($id) {
        $this->layout = '@frontend/views/layouts/province';

        $province = Province::findOne($id);
        if ($province === NULL) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        Yii::$app->view->title = $province->name;
        $pagesize = 20;
        $page = Yii::$app->request->get('page', 1);
        $videos = Video::getVideoInProvince($id, [
                    'limit' => $pagesize,
                    'page' => $page,
        ]);
        $totalitem = Video::countVideoInProvince($id);

        return $this->render('province', [
                    'province' => $province,
                    'videos' => $videos,
                    'totalitem' => $totalitem,
                    'limit' => $pagesize
        ]);
    }

    public function actionDetail($id) {
        $this->layout = '@frontend/views/layouts/detail';
        //
        $model = $this->findModel($id);
        Yii::$app->view->title = $model->name;
        $category = $model->category;
        //
        return $this->render('detail', [
                    'model' => $model,
                    'category' => $category,
        ]);
    }

    /**
     * Finds the Video model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Video the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Video::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
