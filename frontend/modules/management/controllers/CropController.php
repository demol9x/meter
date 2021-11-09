<?php

namespace frontend\modules\management\controllers;

use Yii;
use common\components\UploadLib;
use common\components\ClaHost;
use common\components\ClaGenerate;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\shop\Shop;
use common\models\product\Product;
use frontend\models\User;
use common\components\ClaLid;
use common\components\ClaCategory;
use common\components\ClaArray;
use yii\helpers\Url;
use yii\web\Response;
/**
 * ProductController implements the CRUD actions for Product model.
 */
class CropController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionUploadproductfilecrop() {
        $data = $_POST['url_img'];

        $id = isset($_POST['id']) ? $_POST['id'] : 0;

        if(strpos($data, 'ata:image/png;base64')) {
            $data = str_replace('data:image/png;base64,', '', $data);
            $end = '.png';
        } else {
            $data = str_replace('data:image/jpeg;base64,', '', $data);
            $end = '.jpg';
        }
        $data = str_replace(' ', '+', $data);

        $data = base64_decode($data);

        $name = rand().time().$end;

        $file = '../../static/media/images/product/'.$name;

        $success = file_put_contents($file, $data);

        if($avatartg = \common\models\product\ProductImage::findOne($id)) {
            $avatartg->path = '/media/images/product/';
            $avatartg->name = $name;
            $avatartg->save();
        } else {
            if($avatartg = \common\models\media\ImagesTemp::findOne($id));
            $avatartg->path = '/media/images/product/';
            $avatartg->name = $name;
            $avatartg->save();
        }
        return ClaHost::getImageHost().'/media/images/product/s200_200/'.$name;
    }

    public function actionUpdatebgrfilecrop() {
        $data = $_POST['url_img'];

        if(strpos($data, 'ata:image/png;base64')) {
            $data = str_replace('data:image/png;base64,', '', $data);
            $end = '.png';
        } else {
            $data = str_replace('data:image/jpeg;base64,', '', $data);
            $end = '.jpg';
        }
        $data = str_replace(' ', '+', $data);

        $data = base64_decode($data);

        $name = rand().time().$end;

        if(!is_dir('../../static/media/images/shop/')) {
            mkdir('../../static/media/images/shop/', null, true);
        }
        $file = '../../static/media/images/shop/'.$name;

        $success = file_put_contents($file, $data);

        if($shop = Shop::findOne(Yii::$app->user->id)) {
            $shop->image_path = '/media/images/shop/';
            $shop->image_name = $name;
            $shop->save();
        }

        return ClaHost::getImageHost().'/media/images/shop/s200_200/'.$name;
    }

    public function actionUpdateavafilecrop() {
        $data = $_POST['url_img'];

        if(strpos($data, 'ata:image/png;base64')) {
            $data = str_replace('data:image/png;base64,', '', $data);
            $end = '.png';
        } else {
            $data = str_replace('data:image/jpeg;base64,', '', $data);
            $end = '.jpg';
        }
        $data = str_replace(' ', '+', $data);

        $data = base64_decode($data);

        $name = rand().time().$end;

        if(!is_dir('../../static/media/images/shop/')) {
            mkdir('../../static/media/images/shop/', null, true);
        }
        $file = '../../static/media/images/shop/'.$name;

        $success = file_put_contents($file, $data);

        if($shop = Shop::findOne(Yii::$app->user->id)) {
            $shop->avatar_path = '/media/images/shop/';
            $shop->avatar_name = $name;
            $shop->save();
        }

        return ClaHost::getImageHost().'/media/images/shop/s200_200/'.$name;
    }

    public function actionLoadCroppie($id, $img, $type = 'avatar') {
        switch ($type) {
            case 'avatar':
                $size = [400, 400];
                $img=str_replace("/s200_200","",$img);
                $url = \yii\helpers\Url::to(['/management/crop/updateavafilecrop']);
                return \frontend\widgets\cropImage\CropImageWidget::widget([
                            'view' => 'croppie',
                            'input' => [
                                'size' => $size,
                                'id' => $id,
                                'img' => $img,
                                'url' => $url,
                            ]
                        ]); 
                break;
            case 'backgruond':
                $size = [1000, 300];
                $img=str_replace("/s200_200","",$img);
                $url = \yii\helpers\Url::to(['/management/crop/updatebgrfilecrop']);
                return \frontend\widgets\cropImage\CropImageWidget::widget([
                            'view' => 'croppie',
                            'input' => [
                                'size' => $size,
                                'id' => $id,
                                'img' => $img,
                                'url' => $url,
                            ]
                        ]); 
                break;
            case 'product':
                $size = [400, 400];
                $img=str_replace("/s200_200","",$img);
                $url = \yii\helpers\Url::to(['/management/crop/uploadproductfilecrop']);
                return \frontend\widgets\cropImage\CropImageWidget::widget([
                            'view' => 'croppie',
                            'input' => [
                                'size' => $size,
                                'id' => $id,
                                'img' => $img,
                                'url' => $url,
                            ]
                        ]); 
                break;
        }
    }

    public function actionLoadCroppieProduct($id, $img, $id_div) {
        $size = [400, 400];
        $img=str_replace("/s200_200","",$img);
        $url = \yii\helpers\Url::to(['/management/crop/uploadproductfilecrop',]);
        return \frontend\widgets\cropImage\CropImageWidget::widget([
                'view' => 'croppie',
                'input' => [
                    'size' => $size,
                    'id' => $id_div,
                    'img' => $img,
                    'url' => $url,
                    'id_image_product' => $id
                ]
            ]); 
    }

}
