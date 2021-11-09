<?php

namespace frontend\mobile\modules\media\controllers;

use Yii;
use yii\web\Controller;
use common\components\UploadLib;
use common\components\ClaGenerate;
use common\components\ClaHost;
use common\components\HtmlFormat;
use common\models\media\Images;
use common\models\media\ImagesTemp;
use yii\web\Response;

/**
 * Upload router
 */
class UploadController extends Controller {

    /**
     * upload image
     */
    public function actionUploadimage() {

        if (Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $name = \Yii::$app->request->get('name', '');
            if (!$name) {
                $name = 'files';
            }
            $file = $_FILES[$name];
            if (!$file) {
                $file = $_FILES['Filedata'];
            }
            if (!$file) {
                echo json_encode(array('code' => 1, 'message' => 'File không tồn tại'));
                return;
            }
            $fileinfo = pathinfo($file['name']);
            if (!in_array(strtolower($fileinfo['extension']), Images::getImageExtension())) {
                echo json_encode(array('code' => 1, 'message' => 'File không đúng định dạng'));
                return;
            }
            $filesize = $file['size'];
            if ($filesize < 1 || $filesize > 8 * 1024 * 1000) {
                echo json_encode(array('code' => 1, 'message' => 'Cỡ file không đúng'));
                return;
            }
            //
            $path = Yii::$app->request->post('path');
            $path = json_decode($path, true);
            if (!$path) {
                echo json_encode(array('code' => 1, 'message' => 'Đường dẫn không đúng'));
                return;
            }
            //
            $imageoptions = Yii::$app->request->post('imageoptions');
            $imageoptions = json_decode($imageoptions, true);
            //
            $resizes = isset($imageoptions ['resizes']) ? $imageoptions ['resizes'] : array();
            $up = new UploadLib($file);
            $up->setPath($path);
            $up->setResize($resizes);
            $up->uploadImage();
            $response = $up->getResponse(true);
            if ($up->getStatus() == '200') {
                $imgtemp = new ImagesTemp();
                $imgtemp->id = ClaGenerate::getUniqueCode();
                $imgtemp->name = $response['name'];
                $imgtemp->path = $response['baseUrl'];
                $imgtemp->display_name = $response['original_name'];
                $imgtemp->alias = HtmlFormat::parseToAlias($imgtemp->display_name);
                $imgtemp->width = $response['imagesize'][0];
                $imgtemp->height = $response['imagesize'][1];
                if ($imgtemp->save()) {
                    return [
                        'code' => 200,
                        'imgid' => $imgtemp->id,
                        'imagepath' => ClaHost::getImageHost() . '/' . $imgtemp->path,
                        'imagename' => $imgtemp->name,
                        'imgurl' => ClaHost::getImageHost() . $imgtemp->path . 's200_200/' . $imgtemp->name,
                        'imgfullurl' => ClaHost::getImageHost() . $imgtemp->path . $imgtemp->name,
                    ];
                }
            }
            return $response;

            Yii::$app->end();
        }
    }

    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

}
