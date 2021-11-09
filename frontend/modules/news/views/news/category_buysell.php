<?php

use common\models\ActiveFormC;
use common\models\news\News;
use yii\helpers\Url;

$user_id = Yii::$app->user->id;
$account_status = \common\models\shop\Shop::checkAccountStatus($user_id);
$list_rns = [];
$list_rnb = [];
if ($account_status) {
    $list_rns = \common\models\form\FormRegisterSell::getListRegisted($user_id);
    $list_rnb = \common\models\form\FormRegisterBuy::getListRegisted($user_id);
}
?>
<link href="<?= Yii::$app->homeUrl ?>css/style-news.css" rel="stylesheet">
<style>
    .title-news2 ul li {
        width: 100%;
        text-align: center;
    }

    .title-news2 ul li a {
        font-size: 20px;
    }

    .container .col-md-6 .title-news2 {
        border-bottom: 1px solid #000;
    }

    .container>.title-news2 {
        border-bottom: 2px solid #17a34a;
        margin-bottom: 0px;
    }

    .container>.title-news2 {
        margin-top: 10px;
    }

    .content-news2 .title-news2 a {
        font-size: 18px;
        display: block;
        padding: 15px 0px;
        color: #000;
    }

    .content-news2 ul {
        padding: 0px 0px;
    }

    .content-news2 ul li {
        list-style: none;
        position: relative;
        clear: both;
        overflow: hidden;
        background: #ebebeb;
        margin-bottom: 6px;
        padding: 15px;
        color: #fff;
    }

    .content-news2 {
        background: #fff;
        padding-bottom: 40px;
    }

    .content-news2 h3 {
        font-size: 15px;
        max-width: calc(100% - 90px);
        float: left;
    }

    .content-news2 ul li .tool {
        height: 100%;
        float: right;
        text-align: right;
        margin-top: 15px;
        width: 80px;
    }
</style>
<div class="news-index news-index2">
    <div class="container">
        <div class="title-news2">
            <ul>
                <li>
                    <a><?= $category->name ?></a>
                </li>
            </ul>
        </div>
        <div class="image"> </div>
        <div class="content-news2">
            <p class="center" style="margin-top: 15px;"><?= $category->description ?></p>
            <div class="row">
                <?php $category = common\models\news\NewsCategory::findOne(News::CATEGORY_BUY);
                if ($category) {
                ?>
                    <div class="col-md-6 col-sx-12">
                        <h2 class="title-news2"><a href="<?= Url::to(['/news/news/category', 'id' => $category['id'], 'alias' => $category['alias']]) ?>"><?= $category['name'] ?></a></h2>
                        <ul>
                            <?php
                            $data_s = News::getNews([
                                'category_id' => News::CATEGORY_BUY,
                                'limit' => $limit,
                            ]);
                            if ($data_s) foreach ($data_s as $new) {
                                $rged = in_array($new['id'], $list_rns) ? 1 : 0;
                            ?>
                                <li>
                                    <h3><a href="<?= Url::to(['/news/news/detail', 'id' => $new['id'], 'alias' => $new['alias']]) ?>"><?= $new['title'] ?></a></h3>
                                    <?php if ($new['user_id']) { ?>
                                        <div class="tool">
                                            <a data-user_id="<?= $new['id'] ?>" data-note="<?= $rged ? '1' : '0' ?>" href="<?= $account_status ? ' #form-sell'  : ' #form-note' ?>" class="regiter-bs open-popup-link register_sell"><?= $rged ? 'Đăng ký lại' : 'Đăng ký' ?></a>
                                        </div>
                                    <?php } ?>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                <?php } ?>
                <?php $category = common\models\news\NewsCategory::findOne(News::CATEGORY_SELL);
                if ($category) {
                ?>
                    <div class="col-md-6 col-sx-12">
                        <h2 class="title-news2"><a href="<?= Url::to(['/news/news/category', 'id' => $category['id'], 'alias' => $category['alias']]) ?>"><?= $category['name'] ?></a></h2>
                        <ul>
                            <?php
                            $data_b = News::getNews([
                                'category_id' => News::CATEGORY_SELL,
                                'limit' => $limit,
                            ]);
                            if ($data_b) foreach ($data_b as $new) {
                                $rged = in_array($new['id'], $list_rnb) ? 1 : 0; ?>
                                <li>
                                    <h3><a href="<?= Url::to(['/news/news/detail', 'id' => $new['id'], 'alias' => $new['alias']]) ?>"><?= $new['title'] ?></a></h3>
                                    <?php if ($new['user_id']) { ?>
                                        <div class="tool">
                                            <a data-user_id="<?= $new['id'] ?>" data-note="<?= $rged ? '1' : '0' ?>" href="<?= $account_status ? ' #form-buy'  : ' #form-note' ?>" class="regiter-bs open-popup-link register_buy"><?= $rged ? 'Đăng ký lại' : 'Đăng ký' ?></a>
                                        </div>
                                    <?php } ?>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>