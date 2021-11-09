<?php

use common\models\ActiveFormC;
use common\components\ClaHost;
use yii\helpers\Url;

$list_rn = [];
$user_id = Yii::$app->user->id;
$account_status = \common\models\shop\Shop::checkAccountStatus($user_id);
if ($account_status) {
    $list_rn = \common\models\form\FormRegisterBuy::getListRegisted($user_id);
}
?>
<link href="<?= Yii::$app->homeUrl ?>css/style-news.css" rel="stylesheet">
<div class="news-index news-index2">
    <div class="container">
        <div class="title-news2">
            <ul>
                <li>
                    <a><?= $category->name ?></a>
                </li>
            </ul>
        </div>
        <div class="content-news2">
            <div class="col-left-news2">
                <div class="layout-cln layout-cln2">
                    <div class="box-news4">
                        <div class="list-box-news4">
                            <?php foreach ($data as $news) {
                                $url = Url::to(['/news/news/detail', 'id' => $news['id'], 'alias' => $news['alias']]);
                                $rged = in_array($news['id'], $list_rn) ? 1 : 0;
                            ?>
                                <div class="item-box-new4">
                                    <div class="box-images">
                                        <a href="<?= $url ?>" title="<?= $news['title'] ?>">
                                            <img src="<?= ClaHost::getImageHost(), $news['avatar_path'], 's300_300/', $news['avatar_name'] ?>" alt="<?= $news['title'] ?>" />
                                        </a>
                                    </div>
                                    <div class="box-info">
                                        <h3>
                                            <a href="<?= $url ?>" title="<?= $news['title'] ?>"><?= $news['title'] ?></a>
                                        </h3>
                                        <div class="desc-news2">
                                            <?= $news['short_description'] ?>
                                        </div>
                                        <div class="date-news2">
                                            <h3 class="disable"><?= $news['title'] ?></h3>
                                            <span class="date1">
                                                <i class="fa fa-clock-o" aria-hidden="true"></i>
                                                <?= date('d/m/Y', $news['publicdate']) ?>
                                            </span>
                                            <span>|</span>
                                            <span class="date2">
                                                <?= Yii::t('app', 'author') ?>: <?= $news['author'] ? $news['author'] : Yii::t('app', 'admin') ?>
                                            </span>
                                            <div class="right-social-box">
                                                <span data-user_id="<?= $news['id'] ?>" data-note="<?= $rged ? '1' : '0' ?>" href="<?= $account_status ? ' #form-buy'  : ' #form-note' ?>" class="regiter-bs open-popup-link register_buy"><?= $rged ? 'Đăng ký lại' : 'Đăng ký' ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="paginate">
                        <?=
                            yii\widgets\LinkPager::widget([
                                'pagination' => new yii\data\Pagination([
                                    'pageSize' => $limit,
                                    'totalCount' => $totalitem
                                ])
                            ]);
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-right-news2">
                <style type="text/css">
                    .cate-news-detail h2 {
                        margin-top: -21px;
                    }

                    .title-news2 {
                        margin-top: 5px;
                    }
                </style>
                <?=
                    \frontend\widgets\category\CategoryWidget::widget([
                        'type' => common\components\ClaCategory::CATEGORY_NEWS,
                        'view' => 'view_news'
                    ])
                ?>
                <?php
                echo \frontend\widgets\videoAttr\VideoAttrWidget::widget([
                    'attr' => [
                        'category_id' => 1,
                        'homeslide' => 1
                    ],
                    'limit' => 3,
                    'view' => 'home_fix'
                ]);
                ?>

                <?php
                echo \frontend\widgets\news\NewsWidget::widget([
                    'limit' => 6,
                    'ishot' => 1,
                    'view' => 'home_right',
                ]);

                ?>
            </div>
        </div>
    </div>
</div>