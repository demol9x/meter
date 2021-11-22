<?php

namespace api\modules\v1\controllers;

use api\components\RestController;
use common\models\general\ChucDanh;
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
        $list = (new \common\models\Province())->optionsCache();
        return $this->responseData([
            'success' => true,
            'data' => $list
        ]);
    }

    function actionGetJob(){
        $jobs = ChucDanh::getJob();
        return $this->responseData([
            'success' => true,
            'data' => $jobs
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


