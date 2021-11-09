<?php

use yii\helpers\Url;
use common\components\ClaHost;
$this->title = "Video";
$video = $data[0];
unset($data[0]);
?>
<link href="<?= Yii::$app->homeUrl ?>css/style-news.css" rel="stylesheet">
<style type="text/css">
    .one-video iframe {
        width: 100%;
        height: 400px;
    }
    .news-index {
        padding-top: 20px;
    }
    h2 a {
        font-size: 20px;
        color: #000;
    }
</style>
<div class="news-index news-index2">
    <div class="container">
        <div class="content-news2">
            <div class="col-left-news2">
                <div class="one-video">
                    <div class="img">
                        <iframe class="video-youtube" src="<?= $video['embed'] ?>" frameborder="0" allowfullscreen=""></iframe>
                    </div>
                    <div class="dcript-one">
                        <h2><a href="<?= Url::to(['/media/video/detail', 'id' => $video['id'], 'alias' => $video['alias']]) ?>"><?= $video['name'] ?></a></h2> 
                        <p>
                            <?= $video['short_description'] ?>
                        </p>
                    </div>
                </div>
                <?php if (isset($data) && $data) { ?>
                        <?=
                            \frontend\widgets\banner\BannerQcWidget::widget([
                                'view' => 'banner_qc_in_new',
                                'group_id' => \common\components\ClaLid::getIdQc('index'),
                                'limit' => 1,
                                'stt' => 6,
                            ])
                        ?>
                        <div class="layout-cln layout-cln2">
                            <div class="box-news4">
                                <div class="list-box-news4">
                                    <?php foreach ($data as $item) {   
                                        ?>
                                        <div class="item-box-new4">
                                            <div class="box-images">
                                                <a href="<?= Url::to(['/media/video/detail', 'id' => $item['id'], 'alias' => $item['alias']]) ?>" title="<?= $item['name'] ?>">
                                                    <img src="<?= ClaHost::getImageHost(), $item['avatar_path'], $item['avatar_name'] ?>" atl="<?= $item['name'] ?>" />
                                                </a>
                                            </div>
                                            <div class="box-info">
                                                <h3>
                                                    <a href="<?= Url::to(['/media/video/detail', 'id' => $item['id'], 'alias' => $item['alias']]) ?>" title="<?= $item['name'] ?>"><?= $item['name'] ?></a>
                                                </h3>
                                                <div class="desc-news2">
                                                    <?= $item['short_description'] ?>
                                                </div>
                                                <div class="date-news2">
                                                <span class="date1">
                                                    <i class="fa fa-clock-o" aria-hidden="true"></i>
                                                    <?= date('d/m/Y', $item['created_at']) ?>
                                                </span>
                                                    <span>|</span>
                                                    <span class="date2">
                                                     Đăng bởi: Admin
                                                </span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                <?php } ?>
            </div>
            <div class="col-right-news2">
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
            </div>
        </div>
    </div>
</div>
    