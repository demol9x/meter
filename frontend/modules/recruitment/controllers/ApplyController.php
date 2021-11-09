<?php

namespace frontend\modules\recruitment\controllers;

use frontend\controllers\CController;
use Yii;
use yii\web\Controller;
use common\models\recruitment\Recruitment;
use common\models\recruitment\RecruitmentInfo;
use common\models\recruitment\Apply;
use common\models\recruitment\ApplyFile;
use common\models\recruitment\ApplyEducation;
use common\models\recruitment\ApplyWorkHistory;
use common\models\Province;
use common\components\ClaLid;
use yii\helpers\Url;
use yii\web\Response;
use common\components\UploadLib;
use common\components\ClaGenerate;
use common\components\ClaHost;

/**
 * Apply controller for the `recruitment` module
 */
class ApplyController extends CController {

    public function uploadFileCv($file, $apply_id) {
        $model_file = new ApplyFile();
        $model_file->file_src = 'true';
        $model_file->size = $file['size'];
        $model_file->id = ClaGenerate::getUniqueCode(array('prefix' => 'f'));
        $model_file->display_name = $file['name'];
        $up = new UploadLib($file);
        $up->setPath(array($apply_id, date('d-m-Y')));
        $up->uploadFile();
        $response = $up->getResponse(true);
        if ($up->getStatus() == '200') {
            $model_file->path = $response['baseUrl'];
            $model_file->name = $response['name'];
            $model_file->extension = $response['ext'];
            $model_file->file_src = 'true';
            $model_file->apply_id = $apply_id;
            $model_file->save();
        } else {
            $model_file->addError('file_src', $response['error'][0]);
        }
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionApply($id) {
        $this->layout = 'apply';
        $recruitment = $this->findModel($id);
        //
        Yii::$app->view->title = 'Ứng tuyển - ' . $recruitment['title'];
        //
        Yii::$app->params['breadcrumbs'] = [
            'Trang chủ' => Url::home(),
            'Ứng tuyển - ' . $recruitment['title'] => Url::current()
        ];
        // init model apply
        $model = new Apply();
        //Default value
        $model->sex = 1;
        $model->married_status = 1;
        //
        $browser = $this->getBrowser();
        $browser_name = $browser['name'];
        //
        $locations = Province::getNameProvince($recruitment['locations']);
        //
        $src_avatar = Yii::$app->homeUrl . 'images/webcam3.jpg';
        //
        $post = Yii::$app->request->post('Apply');
        $work_history = Yii::$app->request->post('ApplyWorkHistory');
        $education_history = Yii::$app->request->post('ApplyEducation');
        if (isset($post) && $post) {
            $model->attributes = $post;
            $day = $post['day'];
            $month = $post['month'];
            $year = $post['year'];
            //
            $src_avatar = (isset($post['src_avatar']) && $post['src_avatar']) ? $post['src_avatar'] : $src_avatar;
            //
            if ($day && $month && $year) {
                $model->birthday = implode('-', array($post['year'], $post['month'], $post['day']));
            } else {
                $model->addError('birthday', 'Ngày sinh không được phép rỗng');
            }

            if ($model->avatar) {
                $avatar = Yii::app()->session[$model->avatar];
                if (!$avatar) {
                    $model->avatar = '';
                } else {
                    $model->avatar_path = $avatar['baseUrl'];
                    $model->avatar_name = $avatar['name'];
                }
            }
            if ($model->save()) {
                // save education history
                if (isset($education_history) && $education_history) {
                    foreach ($education_history as $edu) {
                        if ($edu['school']) {
                            $education = new ApplyEducation();
                            $education->apply_id = $model->id;
                            $education->school = $edu['school'];
                            $education->major = $edu['major'];
                            $education->qualification_type = $edu['qualification_type'];
                            $education->save();
                        }
                    }
                }
                // save work history
                if (isset($work_history) && $work_history) {
                    foreach ($work_history as $his) {
                        if ($his['company'] && $his['degree']) {
                            $history = new ApplyWorkHistory();
                            $history->apply_id = $model->id;
                            $history->company = $his['company'];
                            $history->field_business = $his['field_business'];
                            $history->scale = $his['scale'];
                            $history->position = $his['position'];
                            $history->job_detail = $his['job_detail'];
                            $history->time_work = $his['time_work'];
                            $history->reason_offwork = $his['reason_offwork'];
                            $history->save();
                        }
                    }
                }
                //
                $file_cv = $_FILES['file_cv'];
                if ($file_cv && $file_cv['name']) {
                    $ext = pathinfo($file_cv['name'], PATHINFO_EXTENSION);
                    $file_allow = array('doc', 'pdf');
                    if (in_array($ext, $file_allow)) {
                        $this->uploadFileCv($file_cv, $model->id);
                    }
                }

                Yii::$app->session->setFlash('success', 'Bạn đã nộp đơn thành công.');
                return $this->redirect(['/recruitment/apply/success']);
            }
        }
        //
        return $this->render('apply', [
                    'recruitment' => $recruitment,
                    'model' => $model,
                    'browser_name' => $browser_name,
                    'locations' => $locations,
                    'src_avatar' => $src_avatar
        ]);
    }

    public function actionSuccess() {
        $this->layout = 'apply';
        return $this->render('success', [
        ]);
    }

    public function actionRenderWorkHistory() {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $stt = Yii::$app->request->get('stt');
            if ($stt) {
                $html = $this->renderAjax('item_work_history', [
                    'stt' => $stt
                ]);
                return [
                    'html' => $html
                ];
            }
        }
    }

    public function actionRenderEducation() {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $stt = Yii::$app->request->get('stt');
            if ($stt) {
                $html = $this->renderAjax('item_education', [
                    'stt' => $stt
                ]);
                return [
                    'html' => $html
                ];
            }
        }
    }

    /**
     * get info browser
     * @return type
     */
    function getBrowser() {
        $u_agent = $_SERVER['HTTP_USER_AGENT'];
        $bname = 'Unknown';
        $platform = 'Unknown';
        $version = "";

        //First get the platform?
        if (preg_match('/linux/i', $u_agent)) {
            $platform = 'linux';
        } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
            $platform = 'mac';
        } elseif (preg_match('/windows|win32/i', $u_agent)) {
            $platform = 'windows';
        }

        // Next get the name of the useragent yes seperately and for good reason
        if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
            $bname = 'IE'; //Internet Explorer
            $ub = "MSIE";
        } elseif (preg_match('/Firefox/i', $u_agent)) {
            $bname = 'FF'; //Mozilla Firefox
            $ub = "Firefox";
        } elseif (preg_match('/Chrome/i', $u_agent)) {
            $bname = 'CHROME'; //Google Chrome
            $ub = "Chrome";
        } elseif (preg_match('/Safari/i', $u_agent)) {
            $bname = 'SAFARI'; //Apple Safari
            $ub = "Safari";
        } elseif (preg_match('/Opera/i', $u_agent)) {
            $bname = 'OPERA';
            $ub = "Opera";
        } elseif (preg_match('/Netscape/i', $u_agent)) {
            $bname = 'NETSCAPE'; // Netscape
            $ub = "Netscape";
        }

        // finally get the correct version number
        $known = array('Version', $ub, 'other');
        $pattern = '#(?<browser>' . join('|', $known) .
                ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        if (!preg_match_all($pattern, $u_agent, $matches)) {
            // we have no matching number just continue
        }

        // see how many we have
        $i = count($matches['browser']);
        if ($i != 1) {
            //we will have two since we are not using 'other' argument yet
            //see if version is before or after the name
            if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
                $version = $matches['version'][0];
            } else {
                $version = $matches['version'][1];
            }
        } else {
            $version = $matches['version'][0];
        }

        // check if we have a number
        if ($version == null || $version == "") {
            $version = "?";
        }

        return array(
            'userAgent' => $u_agent,
            'name' => $bname,
            'version' => $version,
            'platform' => $platform,
            'pattern' => $pattern
        );
    }

    protected function findModel($id) {
        if (($model = Recruitment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelInfo($id) {
        if (($model = RecruitmentInfo::findOne($id)) !== null) {
            return $model;
        } else {
            return new RecruitmentInfo();
        }
    }

    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    /**
     * upload file
     */
    public function actionUploadfile() {
        if (isset($_FILES['webcam']) || isset($_FILES['file'])) {
            $file = isset($_FILES['webcam']) ? $_FILES['webcam'] : $_FILES['file'];
            if ($file['size'] > 1024 * 1000 * 2) {
                Yii::app()->end();
            }
            $up = new UploadLib($file);
            $path = uniqid();
            $up->setPath(array('recruitment', 'avatar', $path));
            $up->uploadImage();
            $return = array();
            $response = $up->getResponse(true);
            $return = array('status' => $up->getStatus(), 'data' => $response, 'host' => ClaHost::getImageHost(), 'size' => '');
            if ($up->getStatus() == '200') {
                $keycode = ClaGenerate::getUniqueCode();
                $return['data']['realurl'] = ClaHost::getImageHost() . $response['baseUrl'] . 's500_500/' . $response['name'];
                $return['data']['avatar'] = $keycode;
                Yii::$app->session[$keycode] = $response;
            }
            echo json_encode($return);
            Yii::$app->end();
        }
        //
    }

}
