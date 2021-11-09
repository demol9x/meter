<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\components\UploadLib;
use common\components\ClaHost;

/**
 *  Upload controller
 */
class UploadController extends Controller
{
    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionUploadimage()
    {

        if (Yii::$app->request->isPost) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
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
            if (!in_array(strtolower($fileinfo['extension']), \common\models\site\Images::getImageExtension())) {
                echo json_encode(array('code' => 1, 'message' => 'File không đúng định dạng'));
                return;
            }
            $filesize = $file['size'];
            if ($filesize < 1 || $filesize > UploadLib::SIZE_MAX_IMAGE * 1024 * 1024) {
                echo json_encode(array('code' => 1, 'message' => 'Cỡ file không đúng'));
                return;
            }
            //
            $imageoptions = Yii::$app->request->post('imageoptions');
            $imageoptions = json_decode($imageoptions, true);
            //
            $resizes = isset($imageoptions['resizes']) ? $imageoptions['resizes'] : array();
            $up = new UploadLib($file);
            $up->setPath(['save_tem']);
            $up->setResize($resizes);
            $up->uploadImage();
            $response = $up->getResponse(true);
            if ($up->getStatus() == '200') {
                $imgtemp = new \common\models\site\ImagesTemp();
                $imgtemp->id = \common\components\ClaGenerate::getUniqueCode();
                $imgtemp->name = $response['name'];
                $imgtemp->path = $response['baseUrl'];
                $imgtemp->display_name = $response['original_name'];
                $imgtemp->alias = \common\components\HtmlFormat::parseToAlias($imgtemp->display_name);
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

    public function actionDelete($id)
    {
        $model = \common\models\site\Images::findOne($id);
        if ($model) {
            $model->delete();
        }
        return true;
    }

    public function actionUploadfile()
    {
        if (isset($_FILES['file'])) {
            $file = $_FILES['file'];
            if ($file['size'] > 1024 * 1024 * UploadLib::SIZE_MAX_IMAGE) {
                Yii::$app->end();
            }
            
            $up = new UploadLib($file);
            $up->setPath(['save_tem']);
            $up->uploadImage();
            $return = array();
            $response = $up->getResponse(true);
            $return = array('status' => $up->getStatus(), 'data' => $response, 'host' => ClaHost::getImageHost(), 'size' => '');
            if ($up->getStatus() == '200') {
                $keycode = \common\components\ClaGenerate::getUniqueCode();
                $return['data']['realurl'] = ClaHost::getImageHost() . $response['baseUrl'] . 's400_400/' . $response['name'];
                $return['data']['avatar'] = $keycode;
                Yii::$app->session[$keycode] = $response;
            }
            echo json_encode($return);
            Yii::$app->end();
        }
    }
}
