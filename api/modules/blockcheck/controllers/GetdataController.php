<?php

namespace api\modules\blockcheck\controllers;

//
use common\models\news\News;
use common\models\product\Product;
use Yii;
use frontend\models\LoginForm;
use frontend\models\SocialLoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\SignupFormSocial;
use frontend\models\ContactForm;
use frontend\models\User;

//
use api\components\RestController;

//
class GetdataController extends BlockcheckController
{
    const TYPE_FLASH_SALE = 'type_flash_sale';
    const TYPE_NEWS_HOME = 'type_news_home';
    const TYPE_BANK = 'type_bank';
    const PRICE_TYPE = 'price_type';

    /**
     * This method implemented to demonstrate the receipt of the token.
     * Do not use it on production systems.
     * @return string AuthKey or model with errors
     */
    public function actionDataShop()
    {
        $post = $this->getDataPost();
        $shop_id = $post['shop_id'];
        $resonse = $this->getResponse();
        if (isset($shop_id) && $shop_id) {
            $shop = \common\models\shop\Shop::findOne($shop_id);
            $image_auths = \common\models\shop\ShopImages::getImageAuths($shop_id);
            $images = \common\models\shop\ShopImages::getImages($shop_id);
            $resonse['data'] = (isset($shop) && $shop) ? $shop->attributes : [];
            $resonse['image_auths'] = (isset($image_auths) && $image_auths) ? $image_auths : [];
            $resonse['images'] = (isset($images) && $images) ? $images : [];
            $resonse['code'] = 1;
            $resonse['message'] = 'Lấy thông tin thành công.';
        } else {
            $resonse['error'] = 'Thông tin không chính xác';
        }
        return $this->responseData($resonse);
    }

    public function actionListProductShop()
    {
        $post = $this->getDataPost();
        $shop_id = $post['shop_id'];
        $resonse = $this->getResponse();
        if (isset($shop_id) && $shop_id) {
            $products = Product::getProductInShop($shop_id);
            if (isset($products) && $products) {
                foreach ($products as $key => $product) {
                    $images = Product::getImages($product['id']);
                    $products[$key]['images'] = $images;
                }
            }
            $resonse['data'] = (isset($products) && $products) ? $products : [];
            $resonse['code'] = 1;
            $resonse['message'] = 'Lấy thông tin shop thành công.';
        } else {
            $resonse['error'] = 'Thông tin đăng nhập không đúng';
        }
        return $this->responseData($resonse);
    }

    public function actionGetDataHome()
    {
        $post = $this->getDataPost();
        $type = $post['type'];
        $limit = (isset($post['limit']) && $post['limit']) ? $post['limit'] : 50;
        $resonse = $this->getResponse();
        if (isset($type) && $type) {
            $data = [];
            switch ($type) {
                case self::TYPE_FLASH_SALE: //
                    $data = self::getFlashsale($limit);
                    break;
                case self::TYPE_NEWS_HOME:
                    $data = self::getNewsHome($limit);
                    break;
                default:
                    $data = self::getBank();
                    break;
            }
            $resonse['data'] = (isset($data) && $data) ? $data : [];
            $resonse['code'] = 1;
            $resonse['message'] = 'Lấy thông tin thành công.';
        } else {
            $resonse['error'] = 'Thông tin không chính xác';
        }
        return $this->responseData($resonse);
    }

    public function actionGetNews()
    {
        $post = $this->getDataPost();
        $type = $post['type'];
        $user_id = (isset($post['user_id'])) ? $post['user_id'] : 0;
        $limit = (isset($post['limit']) && $post['limit']) ? $post['limit'] : 50;
        $resonse = $this->getResponse();
        $data = [];
        if (isset($type) && $type) {
            $condition = [
                'limit' => $limit,
                'type' => 1,
            ];
            if ($user_id) {
                $condition['user_id'] = $user_id;
            }
            $data['news'] = News::getNews($condition);
            $resonse['data'] = (isset($data) && $data) ? $data : [];
            $resonse['code'] = 1;
            $resonse['message'] = 'Lấy thông tin thành công.';
        }
        return $this->responseData($resonse);
    }

    public function actionGetData()
    {
        $post = $this->getDataPost();
        $type = $post['type'];
        $limit = (isset($post['limit']) && $post['limit']) ? $post['limit'] : 50;
        $resonse = $this->getResponse();
        if (isset($type) && $type) {
            $data = [];
            switch ($type) {
                case self::PRICE_TYPE;
                    $data = \common\components\ClaBds::getBoDonVi(true);
                    break;
                default:
                    $data = self::getBank();
                    break;
            }
            $resonse['data'] = (isset($data) && $data) ? $data : [];
            $resonse['code'] = 1;
            $resonse['message'] = 'Lấy thông tin thành công.';
        } else {
            $resonse['error'] = 'Thông tin không chính xác';
        }
        return $this->responseData($resonse);
    }


    function getFlashsale($limit)
    {
        $promotion = \common\models\promotion\Promotions::getPromotionNow();
        $data = [];
        if (isset($promotion) && $promotion) {
            $hour = $promotion->getHourNow();
            $promotion_id = $promotion ? $promotion->id : 0;
            $data['promotion'] = ($promotion) ? $promotion->attributes : []; //Thông tin khuyến mãi
            $data['products'] = \common\models\promotion\ProductToPromotions::getProductByAttr([
                'attr' => [
                    't.id' => $promotion_id,
                    'hour_space_start' => $hour,
                ],
                'order' => 'u.last_request_time desc, pt.id desc',
                'limit' => $limit
            ]); //Sản phẩm trong sale
            $data['time_end'] = $promotion ? $promotion->enddate : 0;; //Thời gian hết hạn
        }
        return $data;
    }

    function getNewsHome($limit)
    {
        $data = [];
        if (isset($limit) && $limit) {
            $data['news'] = News::getNews([
                'limit' => $limit,
                'ishot' => 1,
            ]);
        }
        return $data;
    }

    function getBank()
    {
        $data = [];
        $data['banks'] = \common\models\BankAdmin::find()->orderBy('isdefault DESC')->all();
        return $data;
    }

    /**
     *
     * @return type
     */
    protected function verbs()
    {
        return [
            'login' => ['POST'],
            'social-login' => ['POST'],
            'update-device' => ['POST'],
            'get-user-info' => ['GET'],
        ];
    }

}
