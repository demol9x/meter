<?php

namespace frontend\mobile\modules\management\controllers;

use Yii;
use frontend\models\User;
use common\components\ClaGenerate;
use common\components\UploadLib;
use common\components\ClaHost;
use common\models\user\UserAddress;

class ProfileController extends \frontend\controllers\CController
{

    public $layout = 'main_user';
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $user = User::findIdentity(Yii::$app->user->getId());
        $address = UserAddress::find()->where(['user_id' => Yii::$app->user->getId(), 'isdefault' => 1])->one();
        return $this->render('index', [
            'user' => $user,
            'address' => $address
        ]);
    }

    public function actionIndexManagement()
    {
        Yii::$app->view->dynamicPlaceholders = [
            'asset' => 'AppAssetManagement'
        ];
        $this->layout = 'main_user_index';
        return $this->render('index-management');
    }

    public function actionChangePassword()
    {
        $id = Yii::$app->user->getId();
        $user = \frontend\models\User::findIdentity($id);
        if (isset($_POST['passwordre']) && strlen($_POST['passwordre']) > 5) {
            if ($user->password_hash) {
                if (!(isset($_POST['password']))) {
                    Yii::$app->session->setFlash('error', 'Mật khẩu không đúng.');
                    return $this->render('change-password', [
                        'user' => $user
                    ]);
                }
                if ($user->validatePassword($_POST['password'])) {
                    $user->password_hash = Yii::$app->security->generatePasswordHash($_POST['passwordre']);
                    if ($user->save(false)) {
                        Yii::$app->session->setFlash('success', 'Đổi mật khẩu thành công.');
                        if ($user['email']) {
                            $this->sendMail([
                                'email' => $user['email'],
                                'title' => 'Đổi mật khẩu trên ocopmart.org.',
                                'content' => "Mật khẩu tài khoản '" . $user['username'] . "' đã được thay đổi trên ocopmart.org. Cám ơn quý khách đã sử dụng dịch vụ của ocopmart.org <p> <a style='display:inline-block; padding: 7px 15px; background:#337ab7; color:#fff; border-radius: 5px;' href='<?= __SERVER_NAME ?>/lien-he.html'>Click vào đây nếu không phải người thay đổi là bạn</a></p>"
                            ]);
                        }
                    } else {
                        Yii::$app->session->setFlash('error', 'Đổi mật khẩu không thành công.');
                    }
                    return $this->redirect(['/management/profile/change-password']);
                } else {
                    // echo $_POST['password'];
                    Yii::$app->session->setFlash('error', 'Mật khẩu không đúng.');
                }
            } else {
                $user->password_hash = Yii::$app->security->generatePasswordHash($_POST['passwordre']);
                // $user->phone = $user->phone ? $user->phone : '0000000000';
                if ($user->save(false)) {
                    Yii::$app->session->setFlash('success', 'Đổi mật khẩu thành công.');
                } else {
                    Yii::$app->session->setFlash('error', 'Đổi mật khẩu không thành công2.');
                }
                return $this->redirect(['/management/profile/index']);
            }
        }
        return $this->render('change-password', [
            'user' => $user
        ]);
    }

    public function actionChangePassword2()
    {
        $id = Yii::$app->user->getId();
        $user = \frontend\models\User::findIdentity($id);
        if (isset($_POST['passwordre']) && strlen($_POST['passwordre']) > 5) {
            if ($user->password_hash2) {
                if (!(isset($_POST['password']))) {
                    Yii::$app->session->setFlash('error', 'Mật khẩu cấp 2 không đúng.');
                    return $this->render('change-password', [
                        'user' => $user
                    ]);
                }
                if ($user->validatePassword2($_POST['password'])) {
                    $user->password_hash2 = Yii::$app->security->generatePasswordHash($_POST['passwordre']);
                    if ($user->save(false)) {
                        Yii::$app->session->setFlash('success', 'Đổi mật khẩu cấp 2 thành công.');
                        if ($user['email']) {
                            $this->sendMail([
                                'email' => $user['email'],
                                'title' => 'Đổi mật khẩu cấp 2 trên ocopmart.org.',
                                'content' => "Mật khẩu cấp 2 tài khoản '" . $user['username'] . "' đã được thay đổi trên ocopmart.org. Cám ơn quý khách đã sử dụng dịch vụ của ocopmart.org <p> <a style='display:inline-block; padding: 7px 15px; background:#337ab7; color:#fff; border-radius: 5px;' href='<?= __SERVER_NAME ?>/lien-he.html'>Click vào đây nếu không phải người thay đổi là bạn</a></p>"
                            ]);
                        }
                    } else {
                        Yii::$app->session->setFlash('error', 'Đổi mật khẩu cấp 2 không thành công.');
                    }
                    return $this->redirect(['/management/profile/change-password2']);
                } else {
                    // echo $_POST['password'];
                    Yii::$app->session->setFlash('error', 'Mật khẩu cấp 2 không đúng.');
                }
            } else {
                $user->password_hash2 = Yii::$app->security->generatePasswordHash($_POST['passwordre']);
                // $user->phone = $user->phone ? $user->phone : '0000000000';
                if ($user->save(false)) {
                    Yii::$app->session->setFlash('success', 'Đổi mật khẩu cấp 2 thành công.');
                } else {
                    Yii::$app->session->setFlash('error', 'Đổi mật khẩu cấp 2 không thành công2.');
                }
                return $this->redirect(['/management/profile/index']);
            }
        }
        return $this->render('change-password2', [
            'user' => $user
        ]);
    }

    public function actionResetPass2()
    {
        $id = Yii::$app->user->getId();
        $user = \frontend\models\User::findIdentity($id);
        $pass = 'Reset' . rand(100000, 999999);
        $user->password_hash2 = Yii::$app->security->generatePasswordHash($pass);
        if ($user['email']) {
            if ($user->save(false)) {
                Yii::$app->session->setFlash('success', 'Thay đổi mật khẩu cấp 2 thành công. Quý khách vui lòng truy cập email ' . $user->email . ' để biết thông tin đã thay đổi');
                $title = 'Đổi mật khẩu cấp 2 trên ocopmart.org.';
                $content = "Mật khẩu cấp 2 tài khoản '" . $user['username'] . "' đã được thay đổi thành <b>$pass</b> trên ocopmart.org. Cám ơn quý khách đã sử dụng dịch vụ của ocopmart.org<p> <a style='display:inline-block; padding: 7px 15px; background:#337ab7; color:#fff; border-radius: 5px;' href='<?= __SERVER_NAME ?>/lien-he.html'>Click vào đây nếu không phải người thay đổi là bạn</a></p>";
                $content = \frontend\widgets\mail\MailWidget::widget([
                    'view' => 'view',
                    'input' => [
                        'title' => $title,
                        'content' => $content
                    ]
                ]);
                Yii::$app->mailer->compose()
                    ->setFrom([Yii::$app->params['adminEmail'] => Yii::$app->name])
                    ->setTo($user['email'])
                    ->setSubject($title)
                    ->setHtmlBody($content)
                    ->send();
            } else {
                Yii::$app->session->setFlash('error', 'Đổi mật khẩu cấp 2 không thành công.');
            }
        } else {
            Yii::$app->session->setFlash('error', 'Vui lòng cập nhật email để có thể thực hiện chức năng này.');
        }
        return $this->redirect(['/management/profile/change-password2']);
    }

    public function actionGetOtp($attr, $value)
    {
        $user = User::findIdentity(Yii::$app->user->getId());
        return $this->renderAjax('partial/otp2', [
            'user' => $user,
            'attr' => $attr,
            'value' => $value,
        ]);

        // $user = User::findIdentity(Yii::$app->user->getId());
        // if (!(isset($user->$attr) && $value)) {
        //     return $this->renderAjax('partial/error', [
        //         'error' => 'value',
        //         'attr' => $attr,
        //         'value'  => $value
        //     ]);
        // }
        // $value = str_replace(' ', '', $value);
        // $check_require = User::find()->where([$attr => $value])->andWhere('id <> ' . Yii::$app->user->getId())->one();
        // if ($check_require) {
        //     return $this->renderAjax('partial/error', [
        //         'error' => 'require',
        //         'attr' => $attr,
        //         'value'  => $value
        //     ]);
        // }
        // if (!$user->phone) {
        //     $user->$attr = $value;
        //     if ($user->save()) {
        //         if ($user['email']) {
        //             $this->sendMail([
        //                 'email' => $user['email'],
        //             ]);
        //         }
        //         return $this->renderAjax('partial/saved', [
        //             'success' => 1,
        //             'attr' => $attr,
        //             'value'  => $value
        //         ]);
        //     } else {
        //         return $this->renderAjax('partial/error', [
        //             'error' => 'save',
        //             'attr' => $attr,
        //             'value'  => $value
        //         ]);
        //     }
        // } else {
        //     \Yii::$app->session->open();
        //     $kt = 0;
        //     if (isset($_SESSION['fix_profile_opt']['time'])) {
        //         if (time() - $_SESSION['fix_profile_opt']['time'] >= 5) {
        //             $kt = 1;
        //         }
        //     } else {
        //         $kt = 1;
        //     }
        //     $_SESSION['fix_profile_opt']['time'] = time();
        //     $_SESSION['fix_profile_opt']['attr'] = $attr;
        //     $_SESSION['fix_profile_opt']['value'] = $value;
        //     if ($kt) {
        //         $kt = \common\components\ClaQrCode::getOtpCheckAll($user->phone);
        //         if ($kt['success']) {
        //             return $this->renderAjax('partial/otp', [
        //                 'success' => 1,
        //                 'user' => $user
        //             ]);
        //         } else {
        //             return $this->renderAjax('partial/otp', [
        //                 'success' => 0,
        //                 'error' => $kt['error']
        //             ]);
        //         }
        //     }
        //     return $this->renderAjax('partial/otp', [
        //         'success' => 0,
        //         'error' => 'Quý khách nhập quá nhanh. Vui lòng thực hiện lại thao tác sau 5 giây.'
        //     ]);
        // }
    }

    public function actionSaveOtp($otp, $attr, $value)
    {
        $user = User::findIdentity(Yii::$app->user->getId());
        if ($user->checkOtp($otp)) {
            if (!in_array($attr, ['email', 'phone'])) {
                return $this->renderAjax('partial/error2', [
                    'error' => 'save',
                    'attr' => $attr,
                    'value'  => $value,
                    'user'  => $user,
                ]);
            }
            $user->$attr = $value;
            if ($user->save(false)) {
                if ($user['email']) {
                    $this->sendMail([
                        'email' => $user['email'],
                    ]);
                }
                return $this->renderAjax('partial/saved', [
                    'success' => 1,
                    'attr' => $attr,
                    'value'  => $value,
                    'user'  => $user,
                ]);
            } else {
                return $this->renderAjax('partial/error2', [
                    'error' => 'save',
                    'attr' => $attr,
                    'value'  => $value,
                    'user'  => $user,
                ]);
            }
        }
        return $this->renderAjax('partial/error2', [
            'error' => 'otp',
            'attr' => $attr,
            'value'  => $value,
            'user'  => $user,
        ]);
        // $kt = \common\components\ClaQrCode::checkOtpCheckAll($user['phone'], $otp);
        // $attr = $_SESSION['fix_profile_opt']['attr'];
        // $value = $_SESSION['fix_profile_opt']['value'];
        // if ((isset($kt['success']) && $kt['success'])) {
        //     unset($_SESSION['fix_profile_opt']['attr']);
        //     unset($_SESSION['fix_profile_opt']['value']);
        //     \common\components\ClaQrCode::updateOtp($phone, $otp);
        //     if (!(isset($user->$attr) && $value)) {
        //         return $this->renderAjax('partial/error', [
        //             'error' => 'value',
        //             'attr' => $attr,
        //             'value'  => $value
        //         ]);
        //     }
        //     $value = str_replace(' ', '', $value);
        //     $check_require = User::find()->where([$attr => $value])->andWhere('id <> ' . Yii::$app->user->getId())->one();
        //     if ($check_require) {
        //         return $this->renderAjax('partial/error', [
        //             'error' => 'require',
        //             'attr' => $attr,
        //             'value'  => $value
        //         ]);
        //     }
        //     $user->$attr = $value;
        //     if ($user->save()) {
        //         if ($user['email']) {
        //             $this->sendMail([
        //                 'email' => $user['email'],
        //             ]);
        //         }
        //         return $this->renderAjax('partial/saved', [
        //             'success' => 1,
        //             'attr' => $attr,
        //             'value'  => $value
        //         ]);
        //     } else {
        //         return $this->renderAjax('partial/error', [
        //             'error' => 'save',
        //             'attr' => $attr,
        //             'value'  => $value
        //         ]);
        //     }
        // }
        // return $this->renderAjax('partial/error', [
        //     'error' => 'otp',
        //     'message' => $kt['error'],
        //     'attr' => $attr,
        //     'value'  => $value
        // ]);
    }

    public function actionUpdateAjax($attr, $value)
    {
        $user = User::findIdentity(Yii::$app->user->getId());
        if ($value !== '') {
            switch ($attr) {
                case 'birthday':
                    $user->$attr = strtotime($value);
                    if (strtotime($value) < 1000) {
                        return 0;
                    }
                    break;
                case 'sex':
                    $user->$attr = $value;
                    break;
                case 'username':
                    $user->$attr = $value;
                    break;
            }
            if ($user->save(false)) {
                if ($user['email']) {
                    $this->sendMail([
                        'email' => $user['email'],
                    ]);
                }
                return 1;
            }
        }
        return 0;
    }

    public function actionUpdateGroup()
    {
        if (isset($_POST['UserInGroup']['user_group_id']) && $_POST['UserInGroup']['user_group_id']) {
            $model = \common\models\user\UserInGroup::getModel(['user_id' => Yii::$app->user->id, 'user_group_id' => $_POST['UserInGroup']['user_group_id']]);
            if ($model->load(Yii::$app->request->post())) {
                $model->user_id = Yii::$app->user->id;
                $model->status = 2;
                if ($model->avatar) {
                    $avatar = Yii::$app->session[$model->avatar];
                    if ($avatar) {
                        $avatar = \common\components\UploadLib::getSaveLink($avatar, 'group/');
                        $model->image = $avatar['baseUrl'] . $avatar['name'];
                    }
                    unset(Yii::$app->session[$model->avatar]);
                    $model->save();
                }
            }
        }
        $user = User::findIdentity(Yii::$app->user->getId());
        return $this->renderAjax('group', ['user' => $user]);
    }

    public function actionDeleteGroup($id)
    {
        $model = \common\models\user\UserInGroup::find()->where(['user_id' => Yii::$app->user->id, 'id' => $id])->one();
        if ($model && $model->delete()) {
            return 1;
        }
        return 0;
    }

    public function beforeAction($action)
    {
        if (Yii::$app->controller->action->id != 'change-password') {
            $user = User::findIdentity(Yii::$app->user->getId());
            if (!$user->password_hash) {
                return $this->redirect(['/management/profile/change-password']);
            }
        }
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionUploadfilebgr()
    {
        if (isset($_FILES['file'])) {
            $file = $_FILES['file'];
            if ($file['size'] > 1024 * 1000) {
                Yii::$app->end();
            }
            $up = new UploadLib($file);
            $up->setPath(array('profile', date('Y_m_d', time())));
            $up->uploadImage();
            $return = array();
            $response = $up->getResponse(true);
            $return = array('status' => $up->getStatus(), 'data' => $response, 'host' => ClaHost::getImageHost(), 'size' => '');
            if ($up->getStatus() == '200') {
                $keycode = ClaGenerate::getUniqueCode();
                $return['data']['realurl'] = ClaHost::getImageHost() . $response['baseUrl'] . 's400_400/' . $response['name'];
                $return['data']['avatar'] = $keycode;
                Yii::$app->session[$keycode] = $response;
                $user = User::findOne(Yii::$app->user->id);
                if ($user) {
                    $user->image_name = $response['name'];
                    $user->image_path = $response['baseUrl'];
                    $user->save(false);
                }
            }
            echo json_encode($return);
            Yii::$app->end();
        }
        //
    }

    public function actionUploadfileava()
    {
        if (isset($_FILES['file'])) {
            $file = $_FILES['file'];
            if ($file['size'] > 1024 * 1000) {
                Yii::$app->end();
            }
            $up = new UploadLib($file);
            $up->setPath(array('profile', date('Y_m_d', time())));
            $up->uploadImage();
            $return = array();
            $response = $up->getResponse(true);
            $return = array('status' => $up->getStatus(), 'data' => $response, 'host' => ClaHost::getImageHost(), 'size' => '');
            if ($up->getStatus() == '200') {
                $keycode = ClaGenerate::getUniqueCode();
                $return['data']['realurl'] = ClaHost::getImageHost() . $response['baseUrl'] . 's400_400/' . $response['name'];
                $return['data']['avatar'] = $keycode;
                Yii::$app->session[$keycode] = $response;
                $user = User::findOne(Yii::$app->user->id);
                if ($user) {
                    $user->avatar_name = $response['name'];
                    $user->avatar_path = $response['baseUrl'];
                    $user->save(false);
                }
            }
            echo json_encode($return);
            Yii::$app->end();
        }
        //
    }

    public function sendMail($arr)
    {
        $email = $arr["email"];
        // $url = $arr["url"];
        if (isset($arr["title"])) {
            $title = $arr["title"];
        } else {
            $title = "Thông báo cập nhật thông tin tài khoản trên ocopmart.org";
        }
        if (isset($arr["content"])) {
            $content = $arr["content"];
        } else {
            $content = "Thông tin tài khoản của quý khách đã được thay đổi lúc " . date('d/m/Y H:i') . ".Cám ơn quý khách đã sử dụng dịch vụ của ocopmart.org.<p> <a style='display:inline-block; padding: 7px 15px; background:#337ab7; color:#fff; border-radius: 5px;' href='<?= __SERVER_NAME ?>/lien-he.html'>Click vào đây nếu không phải người thay đổi là bạn</a></p>";
        }

        $content = \frontend\widgets\mail\MailWidget::widget([
            'view' => 'view',
            'input' => [
                'title' => $title,
                'content' => $content
            ]
        ]);
        \common\models\mail\SendEmail::addMail([
            'email' => $email,
            'title' => $title,
            'content' => $content,
        ]);
        // Yii::$app->mailer->compose()
        //         ->setFrom([Yii::$app->params['adminEmail'] => Yii::$app->name])
        //         ->setTo($email)
        //         ->setSubject($tieude)
        //         ->setHtmlBody($content)
        //         ->send();
    }
}