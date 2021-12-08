<?php

namespace frontend\modules\management\controllers;


use common\models\District;
use common\models\Province;
use common\models\shop\Shop;
use common\models\user\UserImage;
use common\models\Ward;
use frontend\controllers\CController;
use Yii;
use frontend\models\User;
use yii\web\Response;


class ShopController extends CController
{


    public function actionIndex()
    {
        $this->layout = 'main';
        $user = User::findIdentity(Yii::$app->user->getId());
        $shop = Shop::findOne(Yii::$app->user->id);
        $images = UserImage::getImages(Yii::$app->user->id);
        if ($shop->founding) {
            $shop->founding = date('Y-m-d', $shop->founding);
        }
        if ($shop->load(Yii::$app->request->post())) {
            $newimage = Yii::$app->request->post('newimage');
            $countimage = $newimage ? count($newimage) : 0;

            if ($shop->founding) {
                $shop->founding = strtotime($shop->founding);
            }

            if ($shop->province_id) {
                $province = Province::findOne($shop->province_id);
                $shop->province_name = $province->name;
            }
            if ($shop->district_id) {
                $district = District::findOne($shop->district_id);
                $shop->district_name = $district->name;
            }
            if ($shop->ward_id) {
                $ward = Ward::findOne($shop->ward_id);
                $shop->ward_name = $ward->name;
            }

            if ($shop->save()) {
                $setava = Yii::$app->request->post('setava');
                $simg_id = str_replace('new_', '', $setava);
                $avatar = [];
                $recount = 0;
                if ($newimage && $countimage > 0) {
                    foreach ($newimage as $image_code) {
                        $imgtem = \common\models\media\ImagesTemp::findOne($image_code);
                        if ($imgtem) {
                            $nimg = new UserImage();
                            $nimg->attributes = $imgtem->attributes;
                            $nimg->id = NULL;
                            unset($nimg->id);
                            $nimg->user_id = $shop->user_id;
                            if ($nimg->save()) {
                                if ($recount == 0) {
                                    $avatar = $nimg->attributes;
                                    $recount = 1;
                                }
                                if ($imgtem->id == $simg_id) {
                                    $avatar = $nimg->attributes;
                                }
                                $imgtem->delete();
                            }
                        }
                    }
                }
            }

            \Yii::$app->getSession()->setFlash('cusses', 'Cập nhật thành công!');
            return $this->refresh();
        }
        return $this->render('index', [
            'user' => $user,
            'shop' => $shop,
            'images' => $images,
        ]);
    }

    public function actionDeleteImage($id)
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $id = Yii::$app->request->get('id');
            $image = UserImage::findOne($id);
            if ($image->delete()) {
                return ['code' => 200];
            }
        }
    }


}
