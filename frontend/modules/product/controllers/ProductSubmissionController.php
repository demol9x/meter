<?php

namespace frontend\modules\product\controllers;

use common\components\ClaBds;
use common\models\product\ProductCategoryType;
use common\models\shop\Shop;
use Yii;
use frontend\controllers\CController;
use common\models\product\ProductCategory;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use common\models\Province;

class ProductSubmissionController extends CController
{
    public function actionIndex() {
        $shop = Shop::findOne(Yii::$app->user->id);
        if($shop){
            return $this->render('index');
        }else{
            return $this->redirect('/');
        }
    }
}
