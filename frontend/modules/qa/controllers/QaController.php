<?php

namespace frontend\modules\qa\controllers;

use Yii;
use yii\web\Controller;
use common\models\qa\QACategory;
use common\models\qa\QA;
use common\components\ClaLid;
use yii\helpers\Url;

/**
 * QA controller for the `qa` module
 */
class QaController extends Controller {

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {
        $this->layout = 'main';
        //
        Yii::$app->view->title = Yii::t('app','qa_title');
        // add meta description
        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => Yii::t('app','qa_title')
        ]);
        // add meta keywords
        Yii::$app->view->registerMetaTag([
            'name' => 'keywords',
            'content' => Yii::t('app','qa_title')
        ]);
        Yii::$app->params['breadcrumbs'] = [
            'Trang chủ' => Url::home(),
            Yii::t('app','qa_title') => Url::to(['/qa/qa/index']),
        ];
        //
        $pagesize = ClaLid::DEFAULT_LIMIT;

        $page = Yii::$app->request->get('page', 1);

        $data = QA::getqa([
                    'limit' => $pagesize,
                    'page' => $page,
        ]);

        $totalitem = QA::countAllqa();

        return $this->render('index', [
                    'data' => $data,
                    'totalitem' => $totalitem,
                    'limit' => $pagesize
        ]);
    }

    public function actionCategory($id) {
        $this->layout = 'main';
        $category = QACategory::findOne($id);
        if ($category === NULL) {
            $this->layout = '@frontend/views/layouts/error_layout.php';
            return $this->render('error');
        }
        //
        Yii::$app->view->title = $category->meta_title ? $category->meta_title : $category->name;
        // add meta description
        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => $category->meta_description
        ]);
        // add meta keywords
        Yii::$app->view->registerMetaTag([
            'name' => 'keywords',
            'content' => $category->meta_keywords
        ]);
        Yii::$app->params['breadcrumbs'] = [
            'Trang chủ' => Url::home(),
            Yii::t('app','qa_title') => Url::to(['/qa/qa/index']),
            $category->name => Url::current()
        ];
        //
        $pagesize = ClaLid::DEFAULT_LIMIT;
        $page = Yii::$app->request->get('page', 1);
        $listcate = QACategory::getListCatById($id);
        $data = QA::getqa([
                    'category_id' => $listcate,
                    'limit' => $pagesize,
                    'page' => $page,
        ]);
        $totalitem = QA::countAllqa();
        return $this->render('index', [
                    'category' => $category,
                    'data' => $data,
                    'totalitem' => $totalitem,
                    'limit' => $pagesize
        ]);
    }

    public function actionDetail($id) {
        $this->layout = 'main';
        //
        $model = $this->findModel($id);
        //
        $category = QACategory::findOne($model->category_id);
        if ($category === NULL) {
            $this->layout = '@frontend/views/layouts/error_layout.php';
            return $this->render('error');
        }
        //
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
        Yii::$app->params['breadcrumbs'] = [
            'Trang chủ' => Url::home(),
            $category->name => Url::to(['/qa/qa/category', 'id' => $category->id, 'alias' => $category->alias]),
            $model->title => Url::current()
        ];
        //
        return $this->render('detail', [
                    'model' => $model
        ]);
    }

    /**
     * Finds the QA model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return QA the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = QA::findOne($id)) !== null) {
            return $model;
        } else {
            $this->layout = '@frontend/views/layouts/error_layout.php';
            return $this->render('error');
        }
    }

}
