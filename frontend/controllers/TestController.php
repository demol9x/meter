<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\rating\Rating;
use common\models\rating\RateResponse;
use common\models\product\Product;
use yii\web\Response;
use common\models\User;
use yii\helpers\Url;

/**
 * Site controller
 */
class TestController extends CController
{

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionTest()
    {
        $model = new \common\models\Province();
        \Yii::$app->cache->delete('cache_tableall_' . $model->getTableName());
        \Yii::$app->cache->delete('cache_table_' . $model->getTableName());
        // $test = \common\components\ClaGenerate::encrypt(517.33);
        // echo $test;
        // echo "<br/>";
        // echo (float)\common\components\ClaGenerate::decrypt($test);
    }

    // function delete_files($target)
    // {
    //     if (is_dir($target)) {
    //         $files = glob($target . '*', GLOB_MARK); //GLOB_MARK adds a slash to directories returned
    //         foreach ($files as $file) {
    //             $this->delete_files($file);
    //         }
    //         rmdir($target);
    //     } elseif (is_file($target)) {
    //         unlink($target);
    //     }
    // }

    // public function actionTest() {
    //     $user = \frontend\models\User::findOne(69);
    //     $user->phone = '0965865762';
    //     echo "<pre>";
    //     print_r(\common\components\api\ApiGetflycrm::addAccount($user));
    // }

    // public function actionAddMoney() {
    //     $product = \common\models\product\Product::findOne(9888);
    //     return  $product->userBeforeProduct();
    //     // $order_shop = \common\models\order\OrderShop::findOne(246);
    //     // $order_shop->addAffiliate();
    //     // return '1';
    // }

    // public function actionIndex() {
    //     $order = \common\models\order\Order::findOne(327);
    //     return $order->getSaleBuyCoin();
    //     \common\models\gcacoin\Gcacoin::order($order);
    //     return;
    // }


    // public function actionSendMail()
    // {
    //     $email = 'cntt.vancong1993@gmail.com'; 
    //     $title = 'gửi file đến công nguyễn'; 
    //     $content = '<p>Bạn có nhận được file không?</p>';
    //     $fileatttype = "application/pdf";
    //     $fileattname = "newname.pdf"; //name that you want to use to send or you can use the same name
    //     // This attaches the file
    //     $semi_rand     = md5(time());
    //     $data = '<table cellpadding="10" cellspacing="0">
    //                 <tbody>
    //                     <tr>
    //                         <td>&nbsp;</td>
    //                         <td><strong>Yaris G CVT</strong>
    //                         <p>650.000.000 VND</p>
    //                         </td>
    //                         <td><strong>Wigo G 1.2 MT</strong>
    //                         <p>345.000.000 VND</p>
    //                         </td>
    //                     </tr>
    //                     <tr>
    //                         <td>&nbsp;</td>
    //                     </tr>
    //                     <tr>
    //                         <td>Số chỗ ngồi</td>
    //                         <td>5 chỗ</td>
    //                         <td>5 chỗ</td>
    //                     </tr>
    //                     <tr>
    //                         <td>Kiểu dáng</td>
    //                         <td>Hatchback</td>
    //                         <td>Hatchback</td>
    //                     </tr>
    //                     <tr>
    //                         <td>Nhiên liệu</td>
    //                         <td>Xăng</td>
    //                         <td>Xăng</td>
    //                     </tr>
    //                     <tr>
    //                         <td>Xuất xứ</td>
    //                         <td>Xe nhập khẩu</td>
    //                         <td>Xe nhập khẩu</td>
    //                     </tr>
    //                 </tbody>
    //             </table>';
    //     // $data = chunk_split(base64_encode($data));
    //     if($email) {
    //         $email_manager = \Yii::$app->params['adminEmail'];
    //         $app_name = \Yii::$app->name;
    //         $kt = \Yii::$app->mailer->compose()
    //         ->setFrom([$email_manager => $app_name])
    //         ->setTo($email)
    //         ->setSubject($title)
    //         ->setHtmlBody($content)
    //         ->attachContent($data, ['fileName' => $fileattname, 'contentType' => $fileatttype])
    //         ->send();
    //         echo $kt;
    //     }
    // }

    // public function actionAddImageShop()
    // {
    //     // $shops = \common\models\shop\Shop::find()->where(" avatar_name IS NULL OR avatar_name ='' OR image_name IS NULL OR image_name ='' ")->all();
    //     $shops = \common\models\shop\Shop::find()->where(" image_name IS NULL OR image_name =''")->limit(100)->all();
    //     $connection = Yii::$app->db;
    //     // $connection->createCommand()->update('product', ['viewed' => $model->viewed], 'id =' . $model->id)->execute();
    //     foreach ($shops as $shop) {
    //         $connection->createCommand()->update('shop', ['image_path' => '/media/images/shop/2019_01_02/', 'image_name' => 'df-1546395774.png'], 'id =' . $shop->id)->execute();
    //     }
    //     echo count($shops);
    // }
}
