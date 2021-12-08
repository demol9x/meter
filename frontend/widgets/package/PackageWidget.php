<?php

namespace frontend\widgets\package;

use common\models\package\PackageWish;
use common\models\user\UserAddress;
use Yii;
use yii\base\Widget;
use common\models\package\Package;

class PackageWidget extends \frontend\components\CustomWidget {

    public $limit = 10;
    public $view = 'view';
    protected $package = [];
    public $shop_id=0;
    public $isnew=0;
    public $ishot=0;
    public $package_wish=[];
    public $km_shop=[];

    public function init() {
        $this->package = Package::getPackage([
            'limit' => $this->limit,
            'shop_id'=>$this->shop_id,
            'isnew'=>$this->isnew,
            'ishot'=>$this->ishot,
        ]);
        $this->package_wish = PackageWish::find()->where(['user_id' => Yii::$app->user->id])->asArray()->all();
        $this->package_wish = array_column($this->package_wish, 'package_id', 'id');

        if(Yii::$app->user->id){
            $shop = UserAddress::find()->where(['user_id' =>Yii::$app->user->id,'isdefault'=>1])->asArray()->one();
            if(isset($shop['latlng']) && $shop['latlng']){
                $this->km_shop= explode(',',$shop['latlng']);
            }
        }
        parent::init();
    }

    public function run() {
        //
        return $this->render($this->view, [
            'package' => $this->package['data'],
            'limit'=>$this->limit,
            'shop_id'=>$this->shop_id,
            'isnew'=>$this->isnew,
            'ishot'=>$this->ishot,
            'package_wish'=>$this->package_wish,
            'km_shop'=>$this->km_shop,
        ]);
    }

}

?>