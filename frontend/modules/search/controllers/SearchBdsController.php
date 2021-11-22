<?php

namespace frontend\modules\search\controllers;

use common\components\ClaLid;
use common\models\District;
use common\models\Province;
use common\models\Ward;
use yii\web\Controller;
use common\models\product\Product;

/**
 * Search controller
 */
class SearchBdsController extends Controller {

    public function actionIndex() {
        $get = $_GET;
        $hinh_thuc = isset($get['hinh_thuc']) && $get['hinh_thuc'] ? $get['hinh_thuc'] : '';
        $category_id = isset($get['category_id']) && $get['category_id'] ? $get['category_id'] : '';
        $province_id = isset($get['province_id']) && $get['province_id'] ? $get['province_id'] : 1;
        $district_id = isset($get['district_id']) && $get['district_id'] ? $get['district_id'] : '';
        $ward_id = isset($get['ward_id']) && $get['ward_id'] ? $get['ward_id'] : '';
        $price_min = isset($get['price_min']) && $get['price_min'] ? $get['price_min'] : 0;
        $price_max = isset($get['price_max']) && $get['price_max'] ? $get['price_max'] : '';
        $dien_tich_min = isset($get['dien_tich_min']) && $get['dien_tich_min'] ? $get['dien_tich_min'] : 0;
        $dien_tich_max = isset($get['dien_tich_max']) && $get['dien_tich_max'] ? $get['dien_tich_max'] : '';
        $project = isset($get['project']) && $get['project'] ? $get['project'] : '';
        $so_phong = isset($get['so_phong']) && $get['so_phong'] ? $get['so_phong'] : '';
        $huong_nha = isset($get['huong_nha']) && $get['huong_nha'] ? $get['huong_nha'] : '';
        $limit = isset($get['limit']) && $get['limit'] ? $get['limit'] : ClaLid::DEFAULT_LIMIT;
        $page = isset($get['page']) && $get['page'] ? $get['page'] : 1;
        $s = isset($get['s']) && $get['s'] ? $get['s'] : '';
        $lat = 21.014176;
        $lng = 105.789398;
        if($ward_id){
            $ward = Ward::findOne($ward_id);
            $latlng = explode(',',$ward->latlng);
            $lat = $latlng[0];
            $lng = $latlng[1];

        }elseif ($district_id){
            $district = District::findOne($district_id);
            $latlng = explode(',',$district->latlng);
            $lat = $latlng[0];
            $lng = $latlng[1];
        }elseif ($province_id){
            $province = Province::findOne($province_id);
            $latlng = explode(',',$province->latlng);
            $lat = $latlng[0];
            $lng = $latlng[1];
        }
        $options = [
            'hinh_thuc' => $hinh_thuc,
            'category_id' => $category_id,
            'province_id' => $province_id,
            'district_id' => $district_id,
            'ward_id' => $ward_id,
            'price_min' => $price_min,
            'price_max' => $price_max,
            'dien_tich_min' => $dien_tich_min,
            'dien_tich_max' => $dien_tich_max,
            'project' => $project,
            'so_phong' => $so_phong,
            'huong_nha' => $huong_nha,
            'limit' => $limit,
            'page' => $page,
            's' => $s,
            'status' => ClaLid::STATUS_ACTIVED,
        ];
        $products = Product::getBds($options);
        return $this->render('index', [
            'products' => $products['data'],
            'limit' => $limit,
            'page' => $page,
            'lat' => $lat,
            'lng' => $lng,
            'totalCount' => $products['totalItem']
        ]);
    }

}
