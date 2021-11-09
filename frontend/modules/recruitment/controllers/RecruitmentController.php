<?php

namespace frontend\modules\recruitment\controllers;

use frontend\controllers\CController;
use Yii;
use yii\web\Controller;
use common\models\recruitment\Recruitment;
use common\models\recruitment\RecruitmentInfo;
use common\components\ClaLid;

/**
 * Recruitment controller for the `recruitment` module
 */
class RecruitmentController extends CController {

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {
        Yii::$app->view->title = 'Tất cả việc làm';
        $this->layout = 'main';

        $pagesize = ClaLid::DEFAULT_LIMIT;
        $page = Yii::$app->request->get('page', 1);
        // params search
        $location = Yii::$app->request->get('l', 0);
        $category_id = Yii::$app->request->get('c', 0);
        $keyword = Yii::$app->request->get('k', '');
        //
        $data = Recruitment::getAllRecruitment([
                    'limit' => $pagesize,
                    'page' => $page,
                    'location' => $location,
                    'category_id' => $category_id,
                    'keyword' => $keyword
        ]);
        $totalitem = Recruitment::countAllRecruitment([
                    'location' => $location,
                    'category_id' => $category_id,
                    'keyword' => $keyword
        ]);
        //
        return $this->render('index', [
                    'data' => $data,
                    'limit' => $pagesize,
                    'totalitem' => $totalitem,
                    'location' => $location,
                    'category_id' => $category_id,
                    'keyword' => $keyword
        ]);
    }

    public function actionDetail($id) {
        $this->layout = 'detail';
        //
        $model = $this->findModel($id);
        // add title for view
        Yii::$app->view->title = $model->meta_title ? $model->meta_title : $model->title;
        // add meta description
        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => $model->meta_description
        ]);
        // add meta keywords
        Yii::$app->view->registerMetaTag([
            'name' => 'keywords',
            'content' => $model->meta_keywords
        ]);
        $info = $this->findModelInfo($id);
        //
        $company = \frontend\models\User::findOne($model->user_id);
        $company_info = \frontend\models\UserRecruiterInfo::findOne($model->user_id);
        //
        return $this->render('detail', [
                    'model' => $model,
                    'info' => $info,
                    'company' => $company,
                    'company_info' => $company_info,
        ]);
    }

    protected function findModel($id) {
        if (($model = Recruitment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelInfo($id) {
        if (($model = RecruitmentInfo::findOne($id)) !== null) {
            return $model;
        } else {
            return new RecruitmentInfo();
        }
    }

}
