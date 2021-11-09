<?php

namespace frontend\widgets\productConfigurable;

use Yii;
use yii\base\Widget;
use common\models\product\Product;
use common\components\ClaProduct;

class ProductConfigurableWidget extends \frontend\components\CustomWidget {

    public $view = 'view';
    public $title = '';
    public $parent = [];
    public $products = [];
    public $productsPrice = [];
    public $dataCompare = [];
    public $dataWeightRange = [];
    public $attributes = [
        'material' => [
            'name' => 'Chất liệu',
            'field_app' => 'Fk_chatlieu',
            'items' => [],
            'field' => 'cus_field3'
        ],
        'color' => [
            'name' => 'Màu sắc',
            'field_app' => 'Fk_mausac',
            'items' => [],
            'field' => 'cus_field4'
        ],
        'color_stone' => [
            'name' => 'Màu đá',
            'field_app' => 'Fk_mdID',
            'items' => [],
            'field' => 'cus_field7'
        ],
        'size' => [
            'name' => 'Độ dài',
            'field_app' => 'Fk_size',
            'items' => [],
            'field' => 'cus_field9'
        ],
        'type' => [
            'name' => 'Loại',
            'field_app' => 'Fk_loaiID',
            'items' => [],
            'field' => 'cus_field10'
        ],
        'size_stone' => [
            'name' => 'Kích cỡ đá',
            'field_app' => 'Fk_kcdID',
            'items' => [],
            'field' => 'cus_field14'
        ],
        'weight' => [
            'name' => 'Khoảng trọng lượng',
            'field_app' => 'Fk_ktl',
            'items' => [],
            'field' => 'cus_field19'
        ],
    ];

    public function init() {
        //
        $this->products = Product::getProductConfigurable($this->parent['id']);
        $ids = [];
        $dataProcessWeight = [];
        foreach ($this->products as $product) {
            $this->productsPrice[$product['id']] = (int) $product['price'];
            $key = [];
            $dataProcessWeight[$product['id']]['weight'] = $product['weight_gold'];
            $dataProcessWeight[$product['id']]['khoangtrongluong'] = (int) $product['cus_field19'];
            foreach ($this->attributes as $attr) {
                if ($product[$attr['field']]) {
                    if (!in_array($product[$attr['field']], $ids)) {
                        $ids[] = (int) $product[$attr['field']];
                    }
                    $key[] = (int) $product[$attr['field']];
                }
            }
            array_push($key, $product['weight_gold']);
            $key_string = str_replace('.', '_', join('_', $key));
            if (!isset($this->dataCompare[$key_string])) {
                $this->dataCompare[$key_string] = $product['id'];
            }
        }
        foreach ($dataProcessWeight as $dt) {
            if (!isset($this->dataWeightRange[$dt['khoangtrongluong']])) {
                $this->dataWeightRange[$dt['khoangtrongluong']] = [];
            }
            if (!in_array($dt['weight'], $this->dataWeightRange[$dt['khoangtrongluong']])) {
                $this->dataWeightRange[$dt['khoangtrongluong']][] = $dt['weight'];
            }
        }
        $attributes = ClaProduct::getDataOptionByIds($ids);
        foreach ($attributes as $attribute) {
            switch ($attribute['attribute_id']) {
                case 3: // Chất liệu
                    $this->attributes['material']['items'][] = $attribute;
                    break;
                case 4: // Màu sắc
                    $this->attributes['color']['items'][] = $attribute;
                    break;
                case 7: // Màu đá
                    $this->attributes['color_stone']['items'][] = $attribute;
                    break;
                case 9: // Độ dài (Size)
                    $this->attributes['size']['items'][] = $attribute;
                    break;
                case 10: // Kiểu loại
                    $this->attributes['type']['items'][] = $attribute;
                    break;
                case 14: // Kích cỡ đá
                    $this->attributes['size_stone']['items'][] = $attribute;
                    break;
                case 19: // Khoảng trọng lượng
                    $this->attributes['weight']['items'][] = $attribute;
                    break;
            }
        }
        //
        parent::init();
    }

    public function run() {
        //
        return $this->render($this->view, [
                    'title' => $this->title,
                    'products' => $this->products,
                    'attributes' => $this->attributes,
                    'dataWeightRange' => $this->dataWeightRange,
                    'dataCompare' => $this->dataCompare,
                    'productsPrice' => $this->productsPrice
        ]);
        //
    }

}

?>