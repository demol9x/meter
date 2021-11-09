<?php

namespace frontend\widgets\productCategoryChild;

use yii\base\Widget;
use \common\models\product\ProductCategory;
use \common\models\product\Product;
use common\components\ClaCategory;

class productCategoryChildWidget extends \frontend\components\CustomWidget
{
    protected $ary_category = array(); // promotions is show in home
    protected $data = array(); // promtion info and its products
    public $limit = 1; // Giới hạn cac chuong trinh khuyen mai o trang chu
    public $itemslimit = 5; // Gioi han san pham hien thi ra
    public $name = 'productCategoryChild'; // name of widget
    public $view = 'view'; // view of widget
    public $category_id = 1;
    public $getItems = false;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $type = ClaCategory::CATEGORY_PRODUCT;
        $category = new ClaCategory(array('type' => $type, 'create' => true));
        $this->ary_category = $category->createArrayCategory($this->category_id);
        if (count($this->ary_category) && $this->getItems) {
            foreach ($this->ary_category as $cate) {
                $this->data[$cate['id']] = $cate;
                $products = Product::getProduct(array('category_id' => $cate['id'], 'limit' => $this->itemslimit));
                $this->data[$cate['id']]['products'] = $products;
            }
        }else{
            $this->data = $this->ary_category;
        }
   
        return $this->render($this->view, array(
            'itemslimit' => $this->itemslimit,
            'data' => $this->data,
        ));
    }

}
