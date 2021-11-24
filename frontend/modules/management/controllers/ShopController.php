<?php

namespace frontend\modules\management\controllers;


use common\models\shop\Shop;
use frontend\controllers\CController;
use Yii;
use frontend\models\User;


class ShopController extends CController
{


    public function actionIndex()
    {
        $this->layout = 'main';
        $user = User::findIdentity(Yii::$app->user->getId());
        $shop = Shop::findOne(Yii::$app->user->id);
        if($shop->founding){
            $shop->founding = date('Y-m-d',$shop->founding);
        }
        if($shop->load(Yii::$app->request->post())){
            if($shop->founding){
                $shop->founding = strtotime($shop->founding);
            }
            $shop->save();
            \Yii::$app->getSession()->setFlash('cusses', 'Cập nhật thành công!');
            return $this->refresh();
        }
        return $this->render('index', [
            'user' => $user,
            'shop' => $shop,
        ]);
    }

}
