<?php

use common\components\ClaHost;
use common\components\ClaLid;

use yii\helpers\Url;
?>

<body>
<div class="container_fix">
<?php if ($category->id != \common\models\news\News::CATEGORY_BUY && $category->id != \common\models\news\News::CATEGORY_SELL) { ?>

<!--    --><?//=
//    \frontend\widgets\breadcrumbs\BreadcrumbsWidget::Widget([]);
//    ?>
    <div class="chitiettintuc">
        <div class="tintuc">
            <div class="tintuc__center">

                <h2 class="title_30"><?= $model['title'] ?></h2>

                    <div class="date_time">
                        <span class="content_16"><i class="fa fa-clock-o"></i> <?= date('d/m/Y', $model['publicdate']) ?></span>
                        <div class="operation">
                            <button class="btn fb like wow bounceIn" data-wow-delay="0.3s">
                                <span><img src="<?= yii::$app->homeUrl?>images/like.png" alt=""></span>
                                <span class="like">Like</span>
                                <span>41</span>
                                </buton>
                                <button class="btn fb share_fb wow bounceIn" data-wow-delay="0.4s"><span>Share</span></buton>
                                    <button class="btn zl share_zl wow bounceIn" data-wow-delay="0.5s">
                                        <span><img src="<?= yii::$app->homeUrl?>images/zl.png" alt=""></span><span>Chiasẻ</span>
                                        </buton>
                                        <button class="btn tw share_tw wow bounceIn" data-wow-delay="0.6s">
                                            <span><img src="<?= yii::$app->homeUrl?>images/tw.png" alt=""></span><span>Tweet</span>
                                            </buton>
                                            <button class="btn in wow bounceIn" data-wow-delay="0.7s">
                                                <span><img src="<?= yii::$app->homeUrl?>images/in.png" alt=""></span>
                                                </buton>
                        </div>
                    </div>
                    <?php if ($model['avatar_name']) { ?>
                        <div style="width: 0px; overflow: hidden; float: left">
                            <img src="<?= ClaHost::getImageHost(), $model['avatar_path'] . 's400_400/' . $model['avatar_name'] ?>" alt="<?= $model['title'] ?>" title="<?= $model['title'] ?>">
                        </div>
                    <?php } ?>

                    <div class="infor-news-detail">
                        <hr>
                        <div class="content-standard-ck">
                            <?php if ($model['avatar_name']) { ?>
                                <div style="width: 0px; overflow: hidden; float: left">
                                    <img src="<?= ClaHost::getImageHost(), $model['avatar_path'] . 's400_400/' . $model['avatar_name'] ?>" alt="<?= $model['title'] ?>" title="<?= $model['title'] ?>">
                                </div>
                            <?php } ?>
                            <?= $model['description'] ?>
                            <hr>
                            <?php
                            if (isset($model['meta_keywords'])) {
                                $tags = explode(',', $model['meta_keywords']);
                                ?>
                                <?php
                            }
                            ?>
                            <?= frontend\widgets\shareSocial\ShareSocialWidget::widget() ?>
                        </div>
                    </div>


                <div class="tuongtac">
                    <div class="item-share">
                        <p class="content_16"><i class="fal fa-user"></i>Đăng bởi: &nbsp;<span><?= $model['author'] ?></span></p>
                        <?php $cate1= \common\models\news\NewsCategory::findOne($model->category_id);?>
                        <p class="content_16"><i class="fal fa-folder-open"></i><span><?= $cate1->name?></span></p>
                        <p class="content_16"><i class="fal fa-comments-alt"></i><span>Bình luận: 0</span></p>
                        <div class="share-icon">
                            <i class="fal fa-share-alt"></i>
                            <p class="content_16">Chia sẻ:</p>
                            <a href=""><i class="fab fa-facebook-f"></i></a>
                            <a href=""><i class="fab fa-instagram"></i></a>
                            <a href=""><i class="fab fa-twitter"></i></a>
                            <a href=""><i class="fab fa-skype"></i></a>
                        </div>
                    </div>
                    <div class="comment_in_fb">
                        <?= \frontend\widgets\facebookcomment\FacebookcommentWidget::widget() ?>
                    </div>
                </div>

                <?php } else {
                    echo $this->render('detail_buysell_'.$category->id, ['category' => $category, 'model' => $model]);
                } ?>


                <div class="tintuclienquan">
                    <h3 class="content_16">bài viết liên quan</h3>
                    <div class="row-main">
                        <?php if (isset($like) && $like) {?>
                        <?php
                        foreach ($like as $lk){
                            $url = Url::to(['/news/news/detail', 'id' => $lk['id'], 'alias' => $lk['alias']]);
                            ?>
                        <a class="item-tin">
                            <div class="item-img">
                                <img src="<?= ClaHost::getImageHost(), $lk['avatar_path'], 's200_200/', $lk['avatar_name'] ?>" alt="" />
                                <div class="date">
                                    <time><span><?= date('d',$lk['publicdate'])?></span><br><?= date('m',$lk['publicdate'])?>/<?= date('y',$lk['publicdate'])?></time>
                                </div>
                            </div>
                            <div class="item-text">
                                <span><?= $lk['title'] ?></span>
                                <time class="date_time"><img src="<?= yii::$app->homeUrl?>images/time_pro.png" alt=""><span>22</span>-<span>11</span>-<span>21</span></time>
                            </div>
                        </a>
                        <?php }?>
                    </div>
                    <?php }?>
                </div>

            </div>
            <div class="tintuc__left">
                <div class="tab-tintuc">
                    <a class="back"></a>
                    <nav class="van-tabs">
                        <?php foreach ($category_news as $key) {?>
                            <a href="/news/news/index?&cate=<?= $key['id']?>" id="tintucchung"><label id="tintucchung" class="active content_16"><?= $key['name'] ?></label></a>
                        <?php }?>
                    </nav>
                    <a class="continue"></a>
                </div>
                <div class="tinkhac">
                    <h3 class="title_24">Bài viết nổi bật</h3>
                    <div class="slide-tin">
                        <?php if (isset($ishot) && $ishot) {?>
                        <?php
                        foreach ($ishot as $value){
                            $urf = Url::to(['/news/news/detail', 'id' => $value['id'], 'alias' => $value['alias']]);
                            ?>
                            <div class="tinkhac-item">
                                <a class="item-img" href="<?= $urf?>"><img src="<?= ClaHost::getImageHost(), $value['avatar_path'], 's200_200/', $value['avatar_name'] ?>" alt="" /></a>
                                <a class="content_16" href="<?= $urf?>"><?= $value['title'] ?></a>
                            </div>
                        <?php }?>
                    </div>
                </div>
                <?php }?>
            </div>
        </div>
    </div>
</div>

</body>

