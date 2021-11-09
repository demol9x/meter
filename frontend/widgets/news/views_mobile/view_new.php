<?php

use common\components\ClaHost;
use yii\helpers\Url;
?>
<?php if (isset($data) && $data) { ?>
    <div class="news-hot">
        <h2>Bài viết gần đây</h2>
        <div class="owl-news-hot-inmobile">
            <?php
            foreach ($data as $item) {
                $url = Url::to(['/news/news/detail', 'id' => $item['id'], 'alias' => $item['alias']]);
                ?>
                <div class="item-news-hot">
                    <div class="img-news-hot">
                        <a href="<?= $url ?>" title="<?= $item['title'] ?>">
                            <?php if($item['avatar_name']) { ?>
                                <img class="hover-img" src="<?= ClaHost::getImageHost(), $item['avatar_path'], 's150_150/', $item['avatar_name'] ?>" alt="<?= $item['title'] ?>" />
                            <?php } ?>
                        </a>
                    </div>
                    <div class="title-news-hot">
                        <h3>
                            <a href="<?= $url ?>" title="<?= $item['title'] ?>"><?= $item['title'] ?></a>
                        </h3>
                        <span class="time-hot"><i class="fa fa-clock-o"></i><?= date('d/m/Y', $item['publicdate']) ?></span>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>

<?php } ?>