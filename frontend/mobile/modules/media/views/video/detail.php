<style type="text/css">
    .content-standard-ck > iframe {
        width: 100%;
        height: 40vh;
    }
</style>
<div class="video-detail">
    <div class="container">
        <div class="box-shadow-payment">
            <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                <div class="infor-news-detail">
                    <h2 class="title-detail">
                        <?= $model['name'] ?>
                    </h2>
                    <p class="time-news">
                        <span><i class="fa fa-clock-o"></i> <?= date('d/m/Y', $model['created_at']) ?></span>
                        <span>|</span>
                        <span><?= Yii::t('app', 'author') ?>: <?= $model['author'] ? $model['author'] : Yii::t('app', 'admin') ?></span>
                    </p>
                    <hr>
                    <div class="content-standard-ck">
                        <iframe class="video-youtube" src="<?= $model['embed'] ?>" frameborder="0" allowfullscreen></iframe>
                        <hr>
                        <div class="description">
                            <p>
                                <b><?= $model->short_description ?></b>
                            </p>
                            <?= $model->description ?>
                        </div>
                        <?php 
                            $model->meta_keywords = $model->meta_keywords ? explode(',', $model->meta_keywords) : [];
                            echo frontend\widgets\tags\TagsWidget::widget([
                                'data' => $model->meta_keywords,
                                'link' => '',
                                'type' => 4,
                            ]) 
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
                    \frontend\widgets\videoAttr\VideoAttrWidget::widget([
                        'view' => 'relation',
                        'attr' => [
                            'category_id' => $model->category_id,
                        ],
                        '_video' => $model->id,
                        'limit' => 8,
                        'title' => Yii::t('app', 'video_relation')
                    ]) 
                ?>
            </div>
        </div>
    </div>
</div>
