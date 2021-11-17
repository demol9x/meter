<?php

namespace frontend\widgets\package;

use Yii;
use yii\base\Widget;
use common\models\package\Package;

class PackageWidget extends \frontend\components\CustomWidget {

    public $limit = 10;
    public $view = 'view';
    protected $package = [];

    public function init() {
        $this->package = Package::getPackage([
            'limit' => $this->limit,
        ]);
        //
        parent::init();

    }

    public function run() {
        //
        return $this->render($this->view, [
            'package' => $this->package,
            'limit'=>$this->limit,
        ]);
    }

}

?>