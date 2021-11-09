<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use common\models\District;
use common\models\Ward;
use yii\web\Response;

/**
 * Suggest controller
 */
class SuggestController extends CController {

    /**
     * return option district
     * @return type
     */
    public function actionGetdistrict() {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $province_id = Yii::$app->request->get('province_id', 0);
            $label = Yii::$app->request->get('label', '');
            $districts = District::dataFromProvinceId($province_id);
            if (isset($districts) && $districts) {
                $html = $this->renderAjax('options_district', [
                    'options' => $districts,
                    'label' => $label
                ]);
                return [
                    'code' => 200,
                    'html' => $html
                ];
            } else {
                Yii::$app->response->statusCode = 400;
            }
        }
    }

    public function actionGetDistrict1() {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $province_id = Yii::$app->request->get('province_id', 0);
            $label = Yii::$app->request->get('label', '');
            $districts = District::dataFromProvinceId($province_id);
            if (isset($districts) && $districts) {
                $html = $this->renderAjax('options_district_1', [
                    'options' => $districts,
                    'label' => $label,
                    'province_id' => $province_id
                ]);
                return $html;
            } else {
                Yii::$app->response->statusCode = 400;
            }
        }
    }

    /**
     * return option ward
     * @return type
     */
    public function actionGetward() {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $district_id = Yii::$app->request->get('district_id', 0);
            $label = Yii::$app->request->get('label', '');
            $wards = Ward::dataFromDistrictId($district_id);
            if (isset($wards) && $wards) {
                $html = $this->renderAjax('options_ward', [
                    'options' => $wards,
                    'label' => $label
                ]);
                return [
                    'code' => 200,
                    'html' => $html
                ];
            } else {
                Yii::$app->response->statusCode = 400;
            }
        }
    }

}
