<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 9/25/2018
 * Time: 11:50 AM
 */

namespace frontend\controllers;

use common\components\ClaGenerate;
use common\models\gcacoin\Config;
use common\models\gcacoin\WithDraw;
use common\models\product\Product;
use yii\web\Controller;
use common\components\ClaQrCode;
use common\models\cron\CronEmail;
use common\models\gcacoin\Gcacoin;
use common\models\qrcode\PayQrcode;
use frontend\models\User;
use yii;

class QrcodeController extends Controller
{
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionCheckProduct()
    {
        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();
            $public_key = isset($post['public_key']) ? $post['public_key'] : '';
            $from_id = isset($post['from_id']) ? $post['from_id'] : '';
            $token = isset($post['token']) ? $post['token'] : '';
            $model = PayQrcode::findOne(['token' => $token]);
            $from_user = User::findOne($from_id);
            $config = Config::find()->one();
            if ($model && $from_user) {
                if (md5($from_user->id . $from_user->auth_key) == $public_key) {
                    $data = json_decode($model->data, true);
                    $dataProcessed = array();
                    foreach ($data as $key => $value) {
                        $dataProcessed[$key] = $value . '';
                    }
                    $more_info = [];
                    $gca_coin = Gcacoin::findOne($from_id);
                    if (isset($gca_coin) && $gca_coin) {
                    } else {
                        $gca_coin = new Gcacoin();
                        $gca_coin->user_id = $from_id;
                        $gca_coin->gca_coin = ClaGenerate::encrypt(0);
                        $gca_coin->save();
                    }
                    $name = '';
                    if ($model->type == 'user') {
                        $to_user = User::findOne($data['user_id']);

                        $arr = [
                            'user' => [
                                'to_account' => $to_user->username,
                                'to_phone' => $to_user->phone,
                                'title_money' => 'Nhập số tiền cần chuyển',
                                'value_money' => '',
                                'title_content' => 'Nội dung chuyển tiền',
                                'content' => ''
                            ]
                        ];
                        $more_info = $arr;
                    } elseif ($model->type == 'product' || $model->type == 'order') {
                        $name = isset($dataProcessed['id']) ? 'Sản phẩm ' . Product::findOne($dataProcessed['id'])->name : 'Mã đơn hàng OR' . $dataProcessed['order_id'] . '';
                    }
                    $return = [
                        'success' => true,
                        'message' => '',
                        'id' => $model->id . '',
                        'token' => $model->token . '',
                        'type' => $model->type . '',
                        'price' => number_format($model->price) . '',
                        'data' => $dataProcessed,
                        'from_account' => $from_user->username,
                        'from_phone' => $from_user->phone,
                        'account_balances' => (float)ClaGenerate::decrypt($gca_coin->gca_coin),
                        'name' => $name,
                        'more_info' => $more_info
                    ];
                } else {
                    $return = [
                        'success' => false,
                        'message' => 'Tài khoản không hợp lệ.',
                    ];
                }
            } else {
                $return = [
                    'success' => false,
                    'message' => 'Mã QR hoặc tài khoản không tồn tại.',
                ];
            }
            return json_encode($return);
        } else {
            return false;
        }
    }

    public function actionPay()
    {
        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();
            $public_key = isset($post['public_key']) ? $post['public_key'] : '';
            $id = isset($post['user_id']) ? $post['user_id'] : 'id';
            $token = isset($post['token']) ? $post['token'] : 'token';
            $more_info = isset($post['more_info']) ? $post['more_info'] : array();
            $model = PayQrcode::findOne(['token' => $token]);
            $user = User::findOne($id);
            $history_warning = WithDraw::find()->where(['user_id' => $id,'status' => 0])->all();
            $coin_waning = 0;
            if(isset($history_warning) && $history_warning){
                foreach ($history_warning as $his){
                    $coin_waning += $his->value;
                }
            }
            if ($model && $user) {
                if (md5($user->id . $user->auth_key) == $public_key) {
                    $gcacoin = Gcacoin::findOne($user->id);
                    $config = Config::find()->one();

                    if (isset($more_info) && $more_info) {
                        $more_info = str_replace('\\', '', $more_info);
                        $more_info = json_decode($more_info);
                        if (isset($more_info->user) && $model->type == ClaQrCode::TYPE_USER) {
                            $to_id = (json_decode($model->data))->user_id;
                            $coin_send = (isset($more_info->user->value_money) ? $more_info->user->value_money : 0);
                            $content = (isset($more_info->user->content) ? $more_info->user->content : '');
                            $to_gcacoin = Gcacoin::findOne($to_id);
                            if (isset($to_gcacoin) && $to_gcacoin) {
                            } else {
                                $to_gcacoin = new Gcacoin();
                                $to_gcacoin->user_id = $to_id;
                                $to_gcacoin->gca_coin = ClaGenerate::encrypt(0);
                                $to_gcacoin->save();
                            }
                            if (((float)ClaGenerate::decrypt($gcacoin->gca_coin) - $coin_waning) >= $coin_send) {
                                $first_coin = (float)ClaGenerate::decrypt($gcacoin->gca_coin);
                                $to_first_coin = (float)ClaGenerate::decrypt($to_gcacoin->gca_coin);

                                $gcacoin->gca_coin = ClaGenerate::encrypt((float)ClaGenerate::decrypt($gcacoin->gca_coin) - $coin_send);
                                $to_gcacoin->gca_coin = ClaGenerate::encrypt((float)ClaGenerate::decrypt($to_gcacoin->gca_coin) + $coin_send);
                                if ($gcacoin->update() && $to_gcacoin->update()) {

                                    ClaQrCode::SendMail($user->email, -($coin_send), $gcacoin->gca_coin);
                                    $to_email = User::findOne($to_id)->email;
                                    ClaQrCode::SendMail($to_email, +($coin_send), $to_gcacoin->gca_coin);

                                    //send notification
                                    $data = [
                                        'title' => 'Chuyển tiền thành công.',
                                        'content' => 'Quý khách đã thực hiện chuyển thành công <b style="color: green">' . $coin_send . '</b> OCOP V cho <b style="color: green">' . $user->username . '</b>.'
                                    ];
                                    $to_data = [
                                        'title' => 'Giao dịch thành công.',
                                        'content' => 'Quý khách nhận được <b style="color: green">' . $coin_send . '</b> OCOP V từ <b style="color: green">' . $user->username . '</b>. <b style="color: red"><br>Nội dung </b> : ' . $content . ''
                                    ];
                                    ClaQrCode::SendNotifi($model->type, json_encode($data), $coin_send, '', $id);
                                    ClaQrCode::SendNotifi($model->type, json_encode($to_data), $coin_send, '', $to_id);

                                    //Lưu lịch sử thanh toán
                                    $to_history = ClaQrCode::PayHistory($id, $to_id, $model->type, json_encode($data), -($coin_send), $first_coin, $gcacoin->gca_coin);
                                    $to_history = json_decode($to_history);
                                    $code = '';
                                    if (isset($to_history->success) && $to_history->success) {
                                        $code = ClaQrCode::TRANSACTION_CODE . $to_history->data->id;
                                    }
                                    $from_history = ClaQrCode::PayHistory($to_id, $id, $model->type, json_encode($to_data), $coin_send, $to_first_coin, $to_gcacoin->gca_coin);

                                    $return = [
                                        'success' => true,
                                        'data' => [
                                            'code' => $code,
                                        ],
                                        'message' => 'Thanh toán thành công.',
                                    ];
                                } else {
                                    $return = [
                                        'success' => false,
                                        'message' => [
                                            '1' => $gcacoin->getErrors(),
                                            '2' => $to_gcacoin->getErrors()
                                        ]
                                    ];
                                }
                            } else {
                                $return = [
                                    'success' => false,
                                    'message' => 'Tài khoản của bạn không đủ tiền.'
                                ];
                            }
                        }
                    } else {
                        $sale = 1 - ($config->sale / 100);
                        $coin = (($model->price) / ($config->money)) * $config->gcacoin * $sale;
                        if (((float)ClaGenerate::decrypt($gcacoin->gca_coin) - $coin_waning) >= $coin) {
                            $first_coin = (float)ClaGenerate::decrypt($gcacoin->gca_coin);
                            $gcacoin->gca_coin = ClaGenerate::encrypt((float)ClaGenerate::decrypt($gcacoin->gca_coin) - $coin);
                            $data = [
                                'type' => $model->type,
                                'price' => $model->price,
                                'user_id' => $id,
                                'data' => json_decode($model->data, true),
                            ];
                            $order_check = ClaQrCode::CheckPayment($data);
                            if ($order_check) {
                                $history_id = \common\models\gcacoin\Gcacoin::order($order_check);
                                if (isset($history_id) && $history_id) {
                                    $order_check->payment_status = \common\components\payments\ClaPayment::PAYMENT_STATUS_SUCCESS;
                                    $order_check->save(false);
                                    $code = ClaQrCode::TRANSACTION_CODE . $history_id;
                                    $return = [
                                        'success' => true,
                                        'data' => [
                                            'code' => $code
                                        ],
                                        'message' => 'Thanh toán thành công.',
                                    ];


                                } else {
                                    $order_check->payment_status = \common\components\payments\ClaPayment::PAYMENT_STATUS_WAITING;
                                    $order_check->save(false);
                                    $return = [
                                        'success' => false,
                                        'message' => 'Thanh toán thất bại.',
                                    ];
                                }
                            } else {
                                $return = [
                                    'success' => false,
                                    'message' => 'Tạo đơn hàng thất bại.'
                                ];
                            }
                        } else {
                            $return = [
                                'success' => false,
                                'message' => 'Tài khoản của bạn không đủ tiền.'
                            ];
                        }
                    }
                } else {
                    $return = [
                        'success' => false,
                        'message' => 'Tài khoản không tồn tại.'
                    ];
                }
            } else {
                $return = [
                    'success' => false,
                    'message' => 'Sản phẩm hoặc người dùng không tồn tại.' . $token . '---' . $id . ''
                ];
            }
            return json_encode($return);
        } else {
            return false;
        }
    }

    public function actionCronEmail()
    {
        $model = CronEmail::find()->limit(20)->orderBy(['created_at' => SORT_ASC])->all();
        foreach ($model as $item) {
            Yii::$app->mailer->compose()
                ->setFrom(Yii::$app->params['adminEmail'])
                ->setTo($item->email)
                ->setSubject('Thay đổi số dư tài khoản')
                ->setHtmlBody($item->content)
                ->send();
            $item->delete();
        }
        exit(1);
    }
}