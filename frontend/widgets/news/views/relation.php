<?php

use common\components\ClaHost;
use yii\helpers\Url;
?>
<?php if (isset($data) && $data) { ?>
    <div class="news-relate">
        <div class="title-standard">
            <h2>
                <a href="javascript:void(0)">Bài viết liên quan</a>
            </h2>
            <div class="time" id="countdown"></div>
            <a href="" class="view-more">Xem tất cả <i class="fa fa-angle-right"></i><i class="fa fa-angle-right"></i></a>
        </div>
        <div class="slide-news-relate">
            <?php
            foreach ($data as $item) {
                $url = Url::to(['/news/news/detail', 'id' => $item['id'], 'alias' => $item['alias']]);
                ?>
                <div class="item-news-relate">
                    <div class="img-item-news">
                        <a href="<?= $url ?>" title="<?= $item['title'] ?>">
                            <?php if($item['avatar_name']) { ?>
                                <img class="hover-img" src="<?= ClaHost::getImageHost(), $item['avatar_path'], 's400_400/', $item['avatar_name'] ?>" alt="<?= $item['title'] ?>" />
                            <?php } ?>
                        </a>
                    </div>
                    <div class="title-item-news">
                        <p class="time-news">
                            <span><i class="fa fa-calendar"></i> <?= date('d/m/Y', $item['publicdate']) ?></span>
                            <span>|</span>
                            <span>Đăng bởi: <?= $item['author'] ?></span>
                        </p>
                        <h2>
                            <a href="<?= $url ?>" title="<?= $item['title'] ?>"><?= $item['title'] ?></a>
                        </h2>
                        <p>
                            <?= $item['short_description'] ?>
                        </p>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
<?php } ?>