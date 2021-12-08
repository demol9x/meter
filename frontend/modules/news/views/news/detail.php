<?php

use common\components\ClaHost;
use common\components\ClaLid;

use yii\helpers\Url;

?>
<?php
if (isset($model) && $model) {
    ?>
    <div class="container_fix">
        <?=
        \frontend\widgets\breadcrumbs\BreadcrumbsWidget::widget(
            ['view' => 'view']
        );
        ?>
        <div class="chitiettintuc">
            <div class="tintuc">
                <div class="tintuc__center">
                    <h2 class="title_30"><?= isset($model->title) && $model->title ? $model->title : 'Đang cập nhật' ?></h2>
                    <div class="gettit">
                        <div class="date_time">
                            <img src="<?= yii::$app->homeUrl ?>images/time.png" alt="">
                            <span class="content_16"><?= date('d', $model->publicdate) ?></span><span
                                    class="content_16">-<?= date('m', $model->publicdate) ?></span><span
                                    class="content_16">-<?= date('Y', $model->publicdate) ?></span>
                        </div>
                        <div class="operation">
                            <?php echo
                            \frontend\widgets\facebookcomment\FacebookcommentWidget::widget(['view' => 'share']);
                            ?>
                        </div>
                    </div>
                    <div class="news_desc">
                        <?php echo $model->description ?>

                    </div>

                    <div class="tuongtac">
                        <div class="item-share">
                            <p class="content_16"><i class="fal fa-user"></i>Đăng bởi:
                                &nbsp;<span><?php echo isset($model->author) && $model->author ? $model->author : 'Đang cập nhật' ?></span>
                            </p>

                            <?php
                            if (isset($category) && $category) {
                                ?>
                                <p class="content_16"><i
                                            class="fal fa-folder-open"></i><span><?php echo $category->name ?></span>
                                </p>
                            <?php } ?>
                            <?php
                            echo \frontend\widgets\facebookcomment\FacebookcommentWidget::widget(['view' => 'share_1'])
                            ?>
                        </div>
                        <?php
                        echo \frontend\widgets\facebookcomment\FacebookcommentWidget::widget(['view' => 'view'])
                        ?>
                    </div>

                    <?php
                    if (isset($new_realate) && $new_realate) {
                        ?>
                        <div class="tintuclienquan">
                            <h3 class="title_26">bài viết liên quan</h3>
                            <div class="row-main">
                                <?php
                                foreach ($new_realate as $key) {
                                    $avatar_path = \common\components\ClaHost::getImageHost() . '/imgs/default.png';
                                    if (isset($key['avatar_path']) && $key['avatar_path']) {
                                        $avatar_path = \common\components\ClaHost::getImageHost() . $key['avatar_path'] . $key['avatar_name'];
                                    }
                                    $url = Url::to(['/news/news/detail', 'id' => $key['id'], 'alias' => $key['alias']]);
                                    ?>
                                    <a class="item-tin" href="<?= $url ?>">
                                        <div class="item-img">
                                            <img src="<?= $avatar_path ?>" alt="<?= $key['title'] ?>">
                                            <div class="date">
                                                <time>
                                                    <span><?= date('d', $key['publicdate']) ?></span><br><?= date('m', $key['publicdate']) ?>
                                                    /<?= date('Y', $key['publicdate']) ?></time>
                                            </div>
                                        </div>
                                        <div class="item-text">
                                            <p class="content_16"><?= isset($key['title']) && $key['title'] ? $key['title'] : 'Đang cập nhật' ?></p>
                                            <time class="date_time">
                                                <img src="<?= yii::$app->homeUrl ?>images/time_pro.png"
                                                     alt=""><span><?= date('d', $key['publicdate']) ?></span>-<span><?= date('m', $key['publicdate']) ?></span>-<span><?= date('y', $key['publicdate']) ?></span>
                                            </time>
                                        </div>
                                    </a>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
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
                            'view' => 'view',
                            'ishot' => 1,
                            'limit' => 5,
                            '_id' => $model['id'],
                           
                        ]);
//                        echo '<pre>';
//                        print_r($model);
//                        echo '</pre>';
//                        die();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

