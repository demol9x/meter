<?php

namespace frontend\widgets\menu;

use yii\base\Widget;
use common\components\ClaMenu;
use common\models\menu\MenuGroup;

class MenuWidget extends \frontend\components\CustomWidget {

    public $view = 'view';
    public $group_id = 0;
    public $parent = 0;
    public $data = array();
    public $orther = array();

    public function init() {
        parent::init();
    }

    public function run() {
        $menu_group = MenuGroup::getOneMuch($this->group_id);
        //
        $clamenu = new ClaMenu(array(
            'create' => true,
            'group_id' => $this->group_id,
        ));
        $this->data = $clamenu->createMenu($this->parent);
        //
        return $this->render($this->view, [
                    'data' => $this->data,
                    'menu_group' => $menu_group,
                    'orther' => $this->orther,
        ]);
    }

}

?>