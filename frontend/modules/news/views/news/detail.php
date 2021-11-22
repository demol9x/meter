<?php

use common\components\ClaHost;
use common\components\ClaLid;

use yii\helpers\Url;
?>
<?php
if(isset($model) && $model){
?>
<div class="container_fix">
    <?=
    \frontend\widgets\breadcrumbs\BreadcrumbsWidget::widget(
            ['view'=>'view']
    );
    ?>
    <div class="chitiettintuc">
        <div class="tintuc">
            <div class="tintuc__center">
                <h2 class="title_30"><?= isset($model->title) && $model->title ? $model->title : 'Đang cập nhật'?></h2>
                <div class="gettit">
                    <div class="date_time">
                        <img src="<?= yii::$app->homeUrl?>images/time.png" alt="">
                        <span class="content_16"><?= date('d',$model->publicdate) ?></span><span class="content_16">-<?= date('m',$model->publicdate) ?></span><span class="content_16">-<?= date('Y',$model->publicdate) ?></span>
                    </div>
                    <div class="operation">
                       <?php
                            echo \frontend\widgets\facebookcomment\FacebookcommentWidget::widget(['view'=>'view'])
                       ?>
                    </div>
                </div>
                <div class="news_desc" >
                    <?php echo $model->description ?>

                </div>

                <div class="tuongtac">
                    <div class="item-share">
                        <p class="content_16"><i class="fal fa-user"></i>Đăng bởi: &nbsp;<span><?php echo isset($model->author ) && $model->author ? $model->author : 'Đang cập nhật'?></span></p>

                        <?php
                        if(isset($category) && $category){
                        ?>
                        <p class="content_16"><i class="fal fa-folder-open"></i><span><?php echo $category->name ?></span></p>
                            <?php }?>
                        <div class="share-icon">
                            <i class="fal fa-share-alt"></i>
                            <p class="content_16">Chia sẻ:</p>
                            <a href=""><i class="fab fa-facebook-f"></i></a>
                            <a href=""><i class="fab fa-instagram"></i></a>
                            <a href=""><i class="fab fa-twitter"></i></a>
                            <a href=""><i class="fab fa-skype"></i></a>
                        </div>
                    </div>
                    <div class="item-comment">
                        <div class="comment-n">
                            <span class="content_16">Bình luận:</span>&nbsp;<span class="content_16">0 bình luận.</span>
                        </div>
                        <div class="check-cmt">
                            <span class="content_16">Sắp xếp theo:</span>
                            <div class="item-cmt">
                                <select class="content_16">
                                    <option value="news">Mới nhất</option>
                                    <option value="all">Tất cả</option>
                                    <option value="fit">Phù hợp</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="item-input-comment">
                        <span class="image_cmt"><img src="<?= yii::$app->homeUrl?>images/Vector.png" alt=""></span>
                        <textarea class="content_16" name="comment" rows="4" cols="50" placeholder="Nhập bình luận của bạn. Vui lòng nhập tiếng việt có dấu."></textarea>
                    </div>
                    <div class="comment_in_fb">
                        <a href="" title="" class="content_16"><i class="fab fa-facebook-f"></i> Plugin bình luận trên Facebook</a>
                    </div>
                </div>
                <div class="tintuclienquan">
                    <h3 class="content_16">bài viết liên quan</h3>
                    <div class="row-main">
                        <a class="item-tin">
                            <div class="item-img">
                                <img src="<?= yii::$app->homeUrl?>images/tinkhac_1.png" alt="">
                                <div class="date">
                                    <time><span>03</span><br>08/2021</time>
                                </div>
                            </div>
                            <div class="item-text">
                                <p class="content_16">Dự án Phát triển hệ thống kiểm soát giao thông cho đường cao tốc tại Hà Nội.</p>
                                <time class="date_time"><img src="<?= yii::$app->homeUrl?>images/time_pro.png" alt=""><span>22</span>-<span>11</span>-<span>21</span></time>
                            </div>
                        </a>
                        <a class="item-tin">
                            <div class="item-img">
                                <img src="<?= yii::$app->homeUrl?>images/tinkhac_1.png" alt="">
                                <div class="date">
                                    <time><span>03</span><br>08/2021</time>
                                </div>
                            </div>
                            <div class="item-text">
                                <p class="content_16">Dự án Phát triển hệ thống kiểm soát giao thông cho đường cao tốc tại Hà Nội.</p>
                                <time class="date_time"><img src="<?= yii::$app->homeUrl?>images/time_pro.png" alt=""><span>22</span>-<span>11</span>-<span>21</span></time>
                            </div>
                        </a>
                        <a class="item-tin">
                            <div class="item-img">
                                <img src="<?= yii::$app->homeUrl?>images/tinkhac_1.png" alt="">
                                <div class="date">
                                    <time><span>03</span><br>08/2021</time>
                                </div>
                            </div>
                            <div class="item-text">
                                <p class="content_16">Dự án Phát triển hệ thống kiểm soát giao thông cho đường cao tốc tại Hà Nội.</p>
                                <time class="date_time"><img src="<?= yii::$app->homeUrl?>images/time_pro.png" alt=""><span>22</span>-<span>11</span>-<span>21</span></time>
                            </div>
                        </a>
                    </div>
                </div>

            </div>
            <div class="tintuc__left">
                <div class="tab-tintuc">
                    <nav class="van-tabs">
                        <a href="<?php echo '/news/news/index' ?>"><label
                                    class="<?php echo isset($_GET['cate']) && $_GET['cate'] ? '' : 'active' ?> content_16">Tin
                                Tức chung</label></a>
                        <?php if (isset($category_news) && $category_news) {
                            foreach ($category_news as $key) {
                                ?>
                                <a href="<?php echo '/news/news/index?&cate=' . $key['id'] ?>"><label
                                            class="<?php echo isset($_GET['cate']) && $_GET['cate'] == $key['id'] ? 'active' : '' ?> content_16"><?= $key['name'] ?></label></a>
                            <?php }
                        } ?>
                    </nav>
                </div>
                <div class="tinkhac">
                    <h3 class="title_24">Bài viết nổi bật</h3>
                    <?php
                    echo frontend\widgets\news\NewsWidget::Widget([
                        'view'=>'view',
                        'ishot'=>1,
                        'limit'=>5,
                    ])
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>