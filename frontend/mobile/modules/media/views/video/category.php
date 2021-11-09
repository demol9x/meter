<?php

use yii\helpers\Url;
use common\components\ClaHost;
?>

<style type="text/css">
    .col-xs-6 .img-item-video-up {
        height: 400px;
        overflow: hidden;
        position: relative;
    }
    .video-hots .col-xs-6 {
        margin-right: -15px;
    }
    .col-xs-6 .img-item-video-up img{
        width: 100%;
    }
    .img-item-video-up .title-item-video-other h3 a {
        font-weight: 300;
        color: #fff;
        font-size: 17px;
        text-transform: uppercase;
    }
    .img-item-video-up .title-item-video-other h3{
        margin: 0px 0px 5px;
    }
    .img-item-video-up .title-item-video-other {
        height: 100px;
        color: #fff;
    }
    .col-lg-3 .img-item-video-other{
        height: 195px;
        overflow: hidden;
    }
    .col-lg-3 .item-video-other{
        margin: 0px;
        margin-bottom: 10px;
    }
    .item-video-other:hover .title-item-video-other h2 {
        margin-top: 2px;
    }
    @media (min-width: 1200px){
        .video-hots .multi-columns-row .col-lg-3:nth-child(4n+5) {
             clear: none; 
        }
    }
</style>

<div class="page-history">
    <div class="container">
        <?=
            \frontend\widgets\videoAttr\VideoAttrWidget::widget([
            'view' => 'hot',
            'title' => $category['name'],
            'attr' => ['ishot' => 1, 'category_id' => $category->id],
            'limit' => 5
                ])
        ?>
        <div class="list-video-other">
            <div class="title-video-other">
                <h2><?= Yii::t('app', 'video') ?></h2>
            </div>
            <div class="row multi-columns-row">
               <?php 
                    foreach ($videos as $video) {
                        $name = $video['name'];
                        $short_description = $video['short_description'];
                        $link = Url::to(['/video/video/detail','id' =>$video['id'], 'alias' => $video['alias']]);
                        $image = ClaHost::getImageHost(). $video['avatar_path']. 's300_300/'. $video['avatar_name'];
                        $title = Yii::t('app','view_more');
                        ?>
                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                            <div class="item-video-other">
                                <div class="img-item-video-other">
                                    <a href="<?= $link ?>">
                                        <img src="<?= $image ?>" alt="<?= $name ?>">
                                    </a>
                                </div>
                                <div class="title-item-video-other">
                                    <h2><a href="<?= $link ?>"><?= $name ?></a></h2>
                                    <p>
                                        <?= $short_description ?>
                                    </p>
                                    <a href="<?= $link ?>" class="view-more-video-other"><?= $title ?></a>
                                </div>
                            </div>
                        </div>
                        <?php 
                    }
                ?>
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
    </div>
</div>