<?php

namespace frontend\widgets\packagelist;

use common\models\package\PackageWish;
use Yii;
use yii\base\Widget;
use common\models\package\Package;

class PackageWidget extends \frontend\components\CustomWidget {

    public $limit = 10;
    public $view = 'view';
    protected $package = [];
    public $package_wish=[];
    public function init() {

        //
        parent::init();
    }

    public function run() {
        //
        return $this->render($this->view, [
            'package' => $this->package,
        ]);
    }

}

?>