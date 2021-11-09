<?php

use common\components\ClaHost;
use yii\helpers\Url;
?>
<link href="<?= Yii::$app->homeUrl ?>css/style-news.css" rel="stylesheet">
<style type="text/css">
    .content-news2 a>img {
        width: 100%;
        height: auto !important;
    }
</style>
<?php if ($category->id !=  5 && $category->id != \common\models\news\News::CATEGORY_BUY && $category->id != \common\models\news\News::CATEGORY_SELL) { ?>
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
                    <div class="layout-cln layout-cln1">
                        <div class="col-left-lcln">
                            <?php
                            $count = count($data);
                            $i = 0;
                            for ($i; $i < $count; $i++) {
                                $news = $data[$i];
                                $url = Url::to(['/news/news/detail', 'id' => $news['id'], 'alias' => $news['alias']]);
                            ?>
                                <div class="box-news2">
                                    <div class="box-images">
                                        <a href="<?= $url ?>" title="<?= $news['title'] ?>">
                                            <img src="<?= ClaHost::getImageHost(), $news['avatar_path'], 's800_800/', $news['avatar_name'] ?>" alt="<?= $news['title'] ?>" />
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
                                            <span class="date1">
                                                <i class="fa fa-clock-o" aria-hidden="true"></i>
                                                <?= date('d/m/Y', $news['publicdate']) ?>
                                            </span>
                                            <span>|</span>
                                            <span class="date2">
                                                <?= Yii::t('app', 'author') ?>: <?= $news['author'] ? $news['author'] : Yii::t('app', 'admin') ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            <?php
                                unset($data[$i]);
                                break;
                            } ?>
                        </div>
                        <div class="col-right-lcln">
                            <div class="box-news3">
                                <div class="list-box-news3">
                                    <?php for ($i = $i + 1; $i < $count; $i++) {
                                        $news = $data[$i];
                                        $url = Url::to(['/news/news/detail', 'id' => $news['id'], 'alias' => $news['alias']]);
                                    ?>
                                        <div class="item-box-new3">
                                            <div class="box-images">
                                                <a href="<?= $url ?>" title="<?= $news['title'] ?>">
                                                    <img src="<?= ClaHost::getImageHost(), $news['avatar_path'], 's300_300/', $news['avatar_name'] ?>" alt="<?= $news['title'] ?>" />
                                                </a>
                                            </div>
                                            <div class="box-info">
                                                <h3>
                                                    <a href="<?= $url ?>" title="<?= $news['title'] ?>"><?= $news['title'] ?></a>
                                                </h3>
                                                <div class="date-news2">
                                                    <span class="date1">
                                                        <i class="fa fa-clock-o" aria-hidden="true"></i>
                                                        <?= date('d/m/Y', $news['publicdate']) ?>
                                                    </span>
                                                    <span>|</span>
                                                    <span class="date2">
                                                        <?= Yii::t('app', 'author') ?>: <?= $news['author'] ? $news['author'] : Yii::t('app', 'admin') ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                        unset($data[$i]);
                                        if ($i >= 2) {
                                            break;
                                        }
                                    } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="layout-cln layout-cln2">
                        <div class="box-news4">
                            <div class="list-box-news4">
                                <?php for ($i = $i + 1; $i < $count; $i++) {
                                    $news = $data[$i];
                                    $url = Url::to(['/news/news/detail', 'id' => $news['id'], 'alias' => $news['alias']]);
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
                                                <span class="date1">
                                                    <i class="fa fa-clock-o" aria-hidden="true"></i>
                                                    <?= date('d/m/Y', $news['publicdate']) ?>
                                                </span>
                                                <span>|</span>
                                                <span class="date2">
                                                    <?= Yii::t('app', 'author') ?>: <?= $news['author'] ? $news['author'] : Yii::t('app', 'admin') ?>
                                                </span>
                                                <!-- <?= frontend\widgets\shareSocial\ShareSocialWidget::widget() ?> -->
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

                        .cate-news-detail h2 {
                            margin-top: 0px;
                        }

                        .title-news2 {
                            margin-bottom: 5px;
                        }

                        .cate-news-detail {
                            margin-top: 0px;
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
<?php } else {
    if ($category->id == \common\models\news\News::CATEGORY_BUY || $category->id == \common\models\news\News::CATEGORY_SELL) {
        echo $this->render('category_buysell_child_' . $category->id, ['category' => $category, 'data' => $data, 'limit' => $limit, 'totalitem' => $totalitem]);
    } else {
        echo $this->render('category_buysell', ['category' => $category, 'data' => $data, 'limit' => $limit, 'totalitem' => $totalitem]);
    }
} ?>