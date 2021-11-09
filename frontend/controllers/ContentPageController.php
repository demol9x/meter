<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\Url;
use common\models\news\ContentPage;

/**
 * ContentPage controller
 */
class ContentPageController extends CController
{

    /**
     * return option district
     * @return type
     */
    public function actionDetail($id, $alias = null)
    {
        $this->layout = '@frontend/views/layouts/content_page';
        //
        if (!$model = $this->findModel($id)) {
            $this->layout = 'error_layout';
            return $this->render('error');
        } else {
            if ($alias != $model->alias) {
                return $this->redirect(['detail', 'id' => $model->id, 'alias' => $model->alias]);
            }
        }

        Yii::$app->params['breadcrumbs'] = [
            'Trang chủ' => Url::home(),
            $model->title => Url::current()
        ];
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
        //
        return $this->render('detail', [
            'model' => $model
        ]);
    }

    /**
     * Finds the CarCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return CarCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        return ContentPage::findOne($id);
    }
}
