<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use common\models\User;
use yii\helpers\Url;

/**
 * Site controller
 */
class VosoController extends CController
{

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionGetInfo($id)
    {
        $product = \common\models\product\Product::findOne($id);
        $data = [];
        if ($product) {
            $info = $product->attributes;
            $data = [
                'id' => $info['id'],
                'name' => $info['name'],
                'category_id' => $info['name'],
                'category_track' => $info['name'],
                'code' => $info['name'],
                'price' => $info['name'],
                'price_market' => $info['name'],
                'price_range' => $info['price_range'],
                'quality_range' => $info['quality_range'],
                'quantity' => $info['name'],
                'status' => $info['name'],
                'short_description' => $info['name'],
                'description' => $info['name'],
                'shop_id' => $info['name'],
                'status_quantity' => $info['name'],
            ];
            $data = ['code' => 1, 'message' => 'Sản phẩm tồn tại', 'id' => $id, 'data' => $data];
        } else {
            $data = ['code' => 0, 'message' => 'Sản phẩm không tồn tại', 'id' => $id, 'data' => []];
        }
        echo json_encode($data);
        die();
    }

    public function actionGetAll()
    {
        $product = (new \yii\db\Query())->from('product')->select('id,name,category_id,category_track,code,price,price_market,price_range,quality_range,quantity,status,short_description,description,shop_id,status_quantity,weight,height,length,width,unit,avatar_path,avatar_name')->where(['voso_connect' => 1])->all();
        $data = ['code' => 1, 'message' => 'Danh sách sản phẩm kết nối voso', 'data' => []];
        if ($product) {
            for ($i = 0; $i < count($product); $i++) {
                $tg = $product[$i];
                $tg['image'] = $tg['avatar_name'] ?  '<?= __SERVER_NAME ?>/' . $tg['avatar_path'] . $tg['avatar_name'] : '';
                $product[$i] = $tg;
            }
            $data['data'] = $product;
        }
        echo json_encode($data);
        die();
    }

    public function actionGetAllCaegory()
    {
        $cats = (new \yii\db\Query())->from('product_category')->select('id,name,parent')->all();
        $data = ['code' => 1, 'message' => 'Danh sách danh mục sản phẩm OCOP', 'data' => []];
        if ($cats) {
            $data = [];
            foreach ($cats as $item) {
                $data[$item['id']] = $item;
            }
            $data['data'] = $data;
        }
        echo json_encode($data);
        die();
    }

    public function actionUpdateInfo()
    {
        // $product = \common\models\product\Product::findOne($id);
        // $data = [];
        // if ($product) {
        //     $info = $product->attributes;
        //     $data = [
        //         'id' => $info['id'],
        //         'name' => $info['name'],
        //         'category_id' => $info['name'],
        //         'category_track' => $info['name'],
        //         'code' => $info['name'],
        //         'price' => $info['name'],
        //         'price_market' => $info['name'],
        //         'price_range' => $info['price_range'],
        //         'quality_range' => $info['quality_range'],
        //         'quantity' => $info['name'],
        //         'status' => $info['name'],
        //         'short_description' => $info['name'],
        //         'description' => $info['name'],
        //         'shop_id' => $info['name'],
        //         'status_quantity' => $info['name'],
        //     ];
        //     $data = ['code' => 1, 'message' => 'Sản phẩm tồn tại', 'id' => $id, 'data' => $data];
        // } else {
        //     $data = ['code' => 0, 'message' => 'Sản phẩm không tồn tại', 'id' => $id, 'data' => []];
        // }
        $return = [];
        $data = $_POST;
        if (isset($data['time']) && isset($data['voso_pass'])) {
            if ($data['voso_pass'] == md5('12345678' . $data['time'])) {
                $return = ['code' => 1, 'message' => 'Lưu thành công.Hiện tại đang trong chế độ kiểm thử. Vui lòng dữ liệu chưa được đồng bộ.', 'data' => $data];
            } else {
                $return = ['code' => 0, 'message' => 'Không thể kết nối.', 'data' => $data];
            }
        }
        echo json_encode($return);
        die();
    }

    public function actionGetAddressShop($shop_id)
    {
        $adds = (new \yii\db\Query())->from('shop_address')->select('*')->where(['shop_id' => $shop_id])->orderBy('isdefault DESC')->all();
        $data = ['code' => 1, 'message' => 'Danh sách địa chỉ', 'data' => $adds];
        echo json_encode($data);
        die();
    }

    public function actionAddOrder()
    {
        $product = \common\models\order\Order::findOne($id);
        $data = [];
        if ($product) {
            $info = $product->attributes;
            $data = [
                'id' => $info['id'],
                'name' => $info['name'],
                'category_id' => $info['name'],
                'category_track' => $info['name'],
                'code' => $info['name'],
                'price' => $info['name'],
                'price_market' => $info['name'],
                'price_range' => $info['price_range'],
                'quality_range' => $info['quality_range'],
                'quantity' => $info['name'],
                'status' => $info['name'],
                'short_description' => $info['name'],
                'description' => $info['name'],
                'shop_id' => $info['name'],
                'status_quantity' => $info['name'],
            ];
            $data = ['code' => 1, 'message' => 'Sản phẩm tồn tại', 'id' => $id, 'data' => $data];
        } else {
            $data = ['code' => 0, 'message' => 'Sản phẩm không tồn tại', 'id' => $id, 'data' => []];
        }
        $return = [];
        $data = $_POST;
        if (isset($data['time']) && isset($data['voso_pass'])) {
            if ($data['voso_pass'] == md5('12345678' . $data['time'])) {
                $return = ['code' => 1, 'message' => 'Lưu thành công.Hiện tại đang trong chế độ kiểm thử. Vui lòng dữ liệu chưa được đồng bộ.', 'data' => $data];
            } else {
                $return = ['code' => 0, 'message' => 'Không thể kết nối.', 'data' => $data];
            }
        }
        echo json_encode($return);
        die();
    }
}
