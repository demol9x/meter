<?php

namespace api\modules\v1\controllers;

use api\components\RestController;
use common\models\general\ChucDanh;
use common\models\OptionPrice;
use common\models\Province;
use Yii;

class GeneralController extends RestController
{
    function actionGetWards()
    {
        $post = Yii::$app->getRequest()->getBodyParams();
        $list = [];
        if (isset($post['district_id']) && $post['district_id']) {
            $list = \common\models\Ward::dataFromDistrictId($post['district_id']);
        } else {
            $list = (new \common\models\Ward())->optionsCache();
        }
        return $this->responseData([
            'success' => true,
            'data' => $list
        ]);
    }

    function actionGetDistricts()
    {
        $post = Yii::$app->getRequest()->getBodyParams();
        if (isset($post['province_id']) && $post['province_id']) {

            $list = \common\models\District::dataFromProvinceId($post['province_id']);
        } else {
            $list = (new \common\models\District())->optionsCache();
        }
        return $this->responseData([
            'success' => true,
            'data' => $list
        ]);
    }

    function actionGetProvinces()
    {
        $post = Yii::$app->getRequest()->getBodyParams();
        $s = isset($post['s']) && $post['s'] ? $post['s'] : '';
        if ($s) {
            $list = Province::find()->where(['like', 'name', $s])->asArray()->all();
            $list = array_column($list, 'name', 'id');
        } else {
            $list = (new \common\models\Province())->optionsCache();
        }

        return $this->responseData([
            'success' => true,
            'data' => $list
        ]);
    }

    function actionGetJob()
    {
        $post = $_GET;
        $s = isset($post['s']) && $post['s'] ? $post['s'] : '';
        if ($s) {
            $jobs = ChucDanh::find()->where(['like', 'name', $s])->asArray()->all();
            $jobs = array_column($jobs, 'name', 'id');
        } else {
            $jobs = ChucDanh::getJob();
        }
        return $this->responseData([
            'success' => true,
            'data' => $jobs
        ]);
    }

    function actionGetPriceFillter()
    {
        $prices = OptionPrice::find()->asArray()->all();
        return $this->responseData([
            'success' => true,
            'data' => $prices
        ]);
    }

    protected function verbs()
    {
        return [
            'get-wards' => ['POST'],
            'get-districts' => ['POST'],
            'get-provinces' => ['POST'],
            'get-job' => ['GET'],
        ];
    }
}


