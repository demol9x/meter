<?php
use common\components\ClaHost;
use yii\helpers\Url;
if (isset($data) && $data) {
    $data0=array_slice($data,1,4);
    $data1=array_slice($data,5,2);
    ?>
<div class="site51_new_col12_tintuc">
    <div class="container_fix">
        <div class="pro_content">
            <div class="content_text">
                <h3><?= $category->name?></h3>
            </div>
            <a class="content_viewall" href="<?= Url::to(['/news/news/index']) ?>"><span>Xem tất cả</span><i class="far fa-chevron-right"></i></a>
        </div>
        <div class="news_flex">
            <?php if($data) {
                $item = $data[0];
                unset($data[0]);
            ?>
            <a class="news_hot" href="<?= Url::to(['/news/news/detail', 'id' => $item['id'], 'alias' => $item['alias']]) ?>">
                <div class="news_img_1">
                    <img src="<?= ClaHost::getImageHost(), $item['avatar_path'], 's300_300/', $item['avatar_name'] ?>" alt="<?= $item['title'] ?>">
                </div>
                <div class="title">
                    <?= $item['title'] ?>
                </div>
                <div class="description">
                    <?= $item['short_description'] ?>
                </div>
                <div class="date_time"><img src="<?= yii::$app->homeUrl?>images/time_pro.png" alt=""><span><?= date('d', $item['publicdate']) ?></span>-<span><?= date('m', $item['publicdate']) ?></span>-<span><?= date('Y', $item['publicdate']) ?></span></div>
            </a>
            <?php } ?>
            <div class="new_hot_column">
                <?php

                if(count($data)) {
                    foreach ($data0 as $item) {

                ?>
                <a class="news_hot" href="<?= Url::to(['/news/news/detail', 'id' => $item['id'], 'alias' => $item['alias']]) ?>">
                    <div class="news_img">
                        <img src="<?= ClaHost::getImageHost(), $item['avatar_path'], 's300_300/', $item['avatar_name'] ?>" alt="<?= $item['title'] ?>">
                    </div>
                    <div class="content_16_b">
                        <?= $item['title'] ?>
                    </div>
                </a>
                        <?php
                    } }?>
            </div>
            <div class="new_hot_column">
                <?php foreach ($data1 as $item){?>
                <a class="hot_news" href="<?= Url::to(['/news/news/detail', 'id' => $item['id'], 'alias' => $item['alias']]) ?>">
                    <div class="news_img_2">
                        <img src="<?= ClaHost::getImageHost(), $item['avatar_path'], 's300_300/', $item['avatar_name'] ?>" alt="<?= $item['title'] ?>">
                    </div>
                    <div class="content_16_b">
                        <?= $item['title'] ?>
                    </div>
                </a>
                <?php }?>
            </div>
        </div>
    </div>
</div>
<?php } ?>