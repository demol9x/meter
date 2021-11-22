<?php

namespace frontend\widgets\searchHome;

use common\components\ClaBds;
use common\models\product\ProductCategory;
use common\models\product\ProductCategoryType;
use yii\base\Widget;

class SearchHomeWidget extends \frontend\components\CustomWidget
{

    public $view = 'view';
    protected $data = array();
    protected $provinces = array();

    public function init()
    {
        $resquest = [];
        $category_type = ProductCategoryType::find()->where(['status' => 1])->asArray()->all();
        $this->provinces = (new \common\models\Province())->optionsCache();
        foreach ($category_type as $type) {
            $categories = ProductCategory::getByType($type['id']);
            $type['categories'] = $categories;
            if($type['bo_donvi_tiente'] == ClaBds::KEY_BOTIENTE_BAN){
                $type['price_fillter'] = ClaBds::donvitiente_ban_filter();
            }else{
                $type['price_fillter'] = ClaBds::donvitiente_thue_fillter();
            }

            $resquest[] = $type;
        }
        $this->data = $resquest;
        parent::init();
    }

    public function run()
    {
        return $this->render($this->view, [
            'data' => $this->data,
            'provinces' => $this->provinces,
            'huong_nha_select' => ClaBds::huong_nha(),
            'dien_tich' => ClaBds::dien_tich_fillter(),
        ]);
    }

}

?>