<?php

namespace frontend\modules\management\controllers;


use common\components\ClaGenerate;
use common\components\UploadLib;
use common\models\package\Package;
use common\models\package\PackageOrder;
use common\models\user\Tho;
use frontend\controllers\CController;

use Yii;
use frontend\models\User;
use yii\web\Response;
use yii\web\UploadedFile;


class PackageorderController extends CController
{


    public function actionIndex()
    {
        $this->layout = 'main';
        $packages = PackageOrder::find()->where(['package_order.shop_id' => Yii::$app->user->id])->joinWith(['package'])->asArray()->all();

        return $this->render('index', [
            'packages' => $packages,
        ]);
    }


}

