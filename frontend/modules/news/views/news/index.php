<link rel="stylesheet" href="<?= yii::$app->homeUrl?>css/view.css">
<?php

use common\components\ClaHost;
use yii\helpers\Url;
?>
<?php if (isset($data) && $data) {?>

<div class="container_fix">
    <?=
    \frontend\widgets\banner\BannerWidget::Widget([
        'view'=>'banner-main',
        'limit'=>3,
        'group_id'=>3,
    ]);
    ?>

 <?=
 \frontend\widgets\breadcrumbs\BreadcrumbsWidget::Widget([]);
 ?>

    <div class="tintuc">
        <div class="tintuc__center">
            <div id="tintucchung" class="content-tab">
                <h2 class="title_30">tin tức chung</h2>
                <div class="main-tintuc">
                    <?php
                    foreach ($data as $key) {
                        $url = Url::to(['/news/news/detail', 'id' => $key['id'], 'alias' => $key['alias']]);
                        ?>
                        <div class="item-tintuc wow fadeInUp" >
                            <div class="item-img">
                                <a href="<?= $url ?>" title="<?= $key['title'] ?>">
                                    <img src="<?= ClaHost::getImageHost(), $key['avatar_path'] . 's400_400/' . $key['avatar_name'] ?>" alt="<?= $key['title'] ?>">
                                </a>
                                <div class="date">
                                    <time class="content_14"><span><?= date('d',$key['publicdate'])?></span><br><?= date('m',$key['publicdate'])?>/<?= date('y',$key['publicdate'])?></time>
                                </div>
                            </div>
                            <div class="item-text">
                                <h2>
                                    <a href="<?= $url ?>" title="<?= $key['title'] ?>"><?= $key['title'] ?></a>
                                </h2>
                                <p><?= $key['short_description'] ?></p>
                                <div class="flex-text">
                                    <p class="content_14"><span>Đăng bởi: </span><?= $key['author'] ?></p>
                                    <?php $cate1= \common\models\news\NewsCategory::findOne($key['category_id']);?>
                                    <p class="content_14"><span>Category: </span><?= $cate1->name ?> </p>
                                    <p class="content_14"><span>Bình luận: </span>0</p>
                                </div>
                                <a href="<?= $url ?>" class="btn-docthem btn-animation2 content_16">Đọc thêm</a>
                            </div>
                        </div>
                    <?php }  ?>
                    <div class="paginate" >
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

        <div class="tintuc__left">
            <div class="tab-tintuc">
                <a class="back"></a>
                <nav class="van-tabs">
                    <?php foreach ($category_news as $list) {?>
                        <a href="/news/news/index?&cate=<?= $list['id']?>" id="tintucchung"><label id="tintucchung" class="active content_16"><?= $list['name'] ?></label></a>
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
                        <a class="item-img" href="<?= $urf ?>"><img src="<?= ClaHost::getImageHost(), $value['avatar_path'], 's200_200/', $value['avatar_name'] ?>" alt="" />></a>
                        <a class="content_16" href="<?= $urf ?>"><?= $value['title'] ?></a>
                    </div>
                     <?php }?>
                </div>
            </div>
            <?php }?>
        </div>
    </div>
</div>
<?php } ?>