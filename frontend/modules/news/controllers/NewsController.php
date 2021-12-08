<?php

namespace frontend\modules\news\controllers;

use Yii;
use frontend\controllers\CController;
use common\models\news\NewsCategory;
use common\models\news\News;
use common\components\ClaLid;
use yii\helpers\Url;

/**
 * News controller for the `news` module
 */
class NewsController extends CController
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = 'main';
        //
        Yii::$app->view->title = Yii::t('app', 'news');
        // add meta description
        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => Yii::t('app', 'news')
        ]);
        // add meta keywords
        Yii::$app->view->registerMetaTag([
            'name' => 'keywords',
            'content' => Yii::t('app', 'news')
        ]);
        Yii::$app->params['breadcrumbs'] = [
            'Trang chủ' => Url::home(),
            'Tin Tức' => Url::to(['/news/news/index']),
        ];
        //
        $pagesize = 8;
        $page = Yii::$app->request->get('page', 1);
        $category_id=Yii::$app->request->get('cate', 0);

        $data = News::getNews([
            'limit' => $pagesize,
            'page' => $page,
            'category_id'=>$category_id,
        ]);
        $category_news= NewsCategory::find()->where(['parent'=> 0])->asArray()->All();
        $totalitem = News::getNews([
            'count'=>1,
            'limit' => $pagesize,
            'page' => $page,
            'category_id'=>$category_id,
        ]);


        return $this->render('index', [
            'data' => $data,
            'totalitem' => $totalitem,
            'limit' => $pagesize,
            'category_news'=>$category_news,
        ]);
    }



    public function actionDetail($id)
    {
        $this->layout = 'main';
        //
        $model = $this->findModel($id);
        //
        $category = NewsCategory::findOne($model->category_id);
        if ($category === NULL) {
            $this->layout = '@frontend/views/layouts/error_layout.php';
            return $this->render('error');
        }
        //
        Yii::$app->view->title = $model->meta_title ? $model->meta_title : $model->title;
        // add meta description
        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => $model->meta_description ? $model->meta_description : $model->title
        ]);
        // add meta keywords
        Yii::$app->view->registerMetaTag([
            'name' => 'keywords',
            'content' => $model->meta_keywords ? $model->meta_keywords : $model->title
        ]);

        // add meta image
        $avatar = \common\components\ClaHost::getLinkImage($model->avatar_path, $model->avatar_name, ['size' => 's600_600/']);
        Yii::$app->view->registerMetaTag([
            'property' => 'og:title',
            'content' => $model->meta_title ? $model->meta_title : $model->title
        ]);
        Yii::$app->view->registerMetaTag([
            'property' => 'og:description',
//            'content' => $meta_description
        ]);
        Yii::$app->view->registerMetaTag([
            'property' => 'og:image',
            'content' => $avatar
        ]);
        Yii::$app->view->registerMetaTag([
            'property' => 'og:url',
            'content' => Url::current([], true)
        ]);
        Yii::$app->view->registerMetaTag([
            'property' => 'og:site_name',
            'content' => 'ocopmart.org'
        ]);
        Yii::$app->view->registerMetaTag([
            'property' => 'og:type',
            'content' => 'website'
        ]);
        Yii::$app->view->registerMetaTag([
            'property' => 'fb:app_id',
            'content' => '723791141343722'
        ]);
        Yii::$app->params['breadcrumbs'] = [
            'Trang chủ' => Url::home(),
            $category->name=>Url::to(['/news/news/index']),
            $model->title => Url::to(['/news/news/detail','id'=>$model['id'],'alias'=>$model['alias']]),
        ];
        $category_news= NewsCategory::find()->where(['parent'=> 0])->asArray()->All();

        $new_realate= News::find()->where(['category_id'=>$model->category_id])->limit(3)->all();
        foreach ($new_realate as $key => $value){
            if($model['id']== $value['id']){
                unset($new_realate[$key]);
                $new_realate= News::find()->where(['category_id'=>$model->category_id])->andWhere(['<>','id',$value['id']])->limit(3)->all();
            }
        }
        return $this->render('detail', [
            'model' => $model,
            'category' => $category,
            'category_news'=>$category_news,
            'new_realate'=>$new_realate
        ]);
    }

    /**
     * Finds the News model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return News the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = News::find()->where(['id' => $id, 'status' => 1])->one()) !== null) {
            return $model;
        } else {
            $this->layout = '@frontend/views/layouts/error_layout.php';
            return $this->render('error');
        }
    }
}
