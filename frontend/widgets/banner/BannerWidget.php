<?php

namespace frontend\widgets\banner;

use common\models\banner\Banner;
use common\models\banner\BannerGroup;
use yii\base\Widget;
use yii\helpers\Html;

class BannerWidget extends \frontend\components\CustomWidget {

    const BANNER_NOI_BAT = 2;
    public $model;
    public $view = 'view';
    public $group_id = 0; //
    public $limit = 1;
    public $category_id = 0;

    public function init() {
        parent::init();
    }

    public function run() {
        $group = BannerGroup::getOneMuch($this->group_id);
        if ($group) {
            $data = Banner::getBannerFromGroupId($this->group_id, ['limit' => $this->limit, 'category_id' => $this->category_id]);
            return $this->render($this->view, [
                        'data' => $data,
                        'group' => $group,
                        'banner' => new Banner()
            ]);
        } else {
            die("Nhóm banner không tồn tại");
        }
    }

}

?>