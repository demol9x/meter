<?php

use common\components\ClaHost;
use common\components\ClaLid;
?>
<style type="text/css">
    .flex {
        display: flex;
    }
    .flex a, .flex img {
        margin: auto;
    }
</style>
<div class="tintuc-index">
    <div class="container">
        <div class="box-shadow-payment">
            <div class="no-row">
                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                    <div class="infor-news-detail">
                        <h2 class="title-detail">
                            <?= $model['title'] ?>
                        </h2>
                        <p class="time-news">
                            <span><i class="fa fa-clock-o"></i> <?= date('d/m/Y', $model['publicdate']) ?></span>
                            <span>|</span>
                            <span><?= Yii::t('app', 'author') ?>: <?= $model['author'] ? $model['author'] : Yii::t('app', 'admin') ?></span>
                        </p>
                        <hr>
                        <div class="content-standard-ck">
                            <p><b><?= $model['short_description'] ?></b></p>
                            <?php if($model['avatar_name']) { ?>
                                <div style="width: 0px; overflow: hidden; float: left">
                                    <img src="<?= ClaHost::getImageHost(), $model['avatar_path'].'s400_400/'.$model['avatar_name'] ?>" alt="<?= $model['title'] ?>" title="<?= $model['title'] ?>">
                                </div>
                            <?php } ?>
                            <?= $model['description'] ?>
                            <hr>
                            <?php
                            if (isset($model['meta_keywords'])) {
                                $tags = explode(',', $model['meta_keywords']);
                                ?>
                                <div class="hastag">
                                    <div class="tags"><i class="fa fa-tags" aria-hidden="true"></i>Tags</div>    
                                    <div class="tags_product">
                                        <?php foreach($tags as $tag) { ?>
                                        <a class="tag_title" title="<?= $tag ?>" href="#"><?= $tag ?></a>
                                        <?php } ?>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            <?= frontend\widgets\shareSocial\ShareSocialWidget::widget() ?>
                            
                        </div>
                        <div class="comment-fb">
                            <?= \frontend\widgets\facebookcomment\FacebookcommentWidget::widget() ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <?=
                    \frontend\widgets\category\CategoryWidget::widget([
                        'type' => common\components\ClaCategory::CATEGORY_NEWS,
                        'view' => 'view_news'
                    ])
                    ?>
                    <?=
                    frontend\widgets\news\NewsWidget::widget([
                        'limit' => 5,
                        'view' => 'view_new',
                        '_id' => $model['id'],
                        'isnew' => ClaLid::STATUS_ACTIVED
                    ])
                    ?>
                </div>
            </div>
        </div>
        <?=
        frontend\widgets\news\NewsWidget::widget([
            'relation' => ClaLid::STATUS_ACTIVED,
            'view' => 'relation',
            '_id' => $model['id'],
            'limit' => 3
        ])
        ?>

    </div>
</div>