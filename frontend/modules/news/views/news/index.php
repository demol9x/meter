<link rel="stylesheet" href="<?= yii::$app->homeUrl ?>css/view.css">
<?php

use common\components\ClaHost;
use yii\helpers\Url;

?>
<?=
\frontend\widgets\banner\BannerWidget::Widget([
    'view' => 'banner-main-in',
    'limit' => 3,
    'group_id' => 3,
]);
?>
<div class="container_fix">
    <?=
    \frontend\widgets\breadcrumbs\BreadcrumbsWidget::Widget(['view' => 'view']);
    ?>
    <div class="tintuc">
        <div class="tintuc__center">
            <div id="tintucchung" class="content-tab">
                <?php if (isset($_GET['cate']) && $_GET['cate']) {
                    foreach ($category_news as $key) {
                        if ($_GET['cate'] == $key['id']) {?>
                            <h2 class="title_30"><?= $key['name']?></h2>
                        <?php } } ?>
                <?php } else {?>
                    <h2 class="title_30">tin tức chung</h2>
                <?php } ?>
                <div class="main-tintuc">
                    <?php
                    if(isset($data) && $data){
                        $i = 0;
                    foreach($data as $key) {
                        $i=$i+3;
                        $link = Url::to(['/news/news/detail', 'id' => $key['id'], 'alias' => $key['alias']]);

                        ?>
                        <div class="item-tintuc wow fadeInUp" data-wow-delay="0.<?= $i ?>s">
                            <div class="item-img">
                                <a href="<?php echo $link ?>"><img
                                            src="<?= ClaHost::getImageHost(), $key['avatar_path'] . 's400_400/' . $key['avatar_name'] ?>"
                                            alt="<?php echo $key['title'] ?>"></a>
                                <div class="date">
                                    <time class="content_14">
                                        <span><?= date('d', $key['publicdate']) ?></span><br><?= date('m', $key['publicdate']) ?>
                                        /<?= date('Y', $key['publicdate']) ?></time>
                                </div>
                            </div>
                            <div class="item-text">
                                <a href="<?= $link ?>">
                                    <h4 class="title_20"><?php echo $key['title'] ?></h4>
                                </a>
                                <p class="content_16"><?php echo $key['short_description'] ?></p>
                                <div class="flex-text">
                                    <p class="content_14"><span>Đăng bởi: </span><?= $key['author'] ?></p>
                                    <?php
                                    $cate_show = \common\models\news\NewsCategory::find()->select('name')->where(['id' => $key['category_id']])->One();
                                    ?>
                                    <p class="content_14">
                                        <span>Danh mục: </span><?php echo isset($key['category_id']) && $key['category_id'] && $cate_show ? $cate_show->name : 'Đang cập nhật' ?>
                                    </p>
                                </div>
                                <a href="<?php echo $link ?>" class="btn-docthem btn-animation2 content_16">Đọc thêm</a>
                            </div>
                        </div>
                    <?php }}
                    else { ?>
                        <div class="" style="width: 100%;color: #289300;background: #ffffff; border: 1.5px solid #289300; height: 50px; display: flex; justify-content: center;align-items: center">
                            <i class="fas fa-bomb" style="color:#289300 "></i> Danh mục bạn chọn chưa có tin tức.
                            <a href="<?=\yii\helpers\Url::to(['/news/news/index'])?>">Quay lại</a>
                        </div>

                    <?php }?>
                </div>
                <div class="pagination">
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
        <div class="tintuc__left">
            <div class="tab-tintuc">
                <a class="back"></a>
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
                <a class="continue"></a>
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
