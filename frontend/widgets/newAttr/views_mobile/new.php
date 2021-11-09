<?php

use yii\helpers\Url;
use common\components\ClaHost;
if (isset($news) && $news) {
    ?>
    <div class="news-hot">
        <div class="title-top-reason">
            <h2><?= $title ?></h2>
        </div>
        <ul>
            <?php foreach ($news as $new) {
                $newtitle = $new['title'];
                $link =  Url::to(['/news/news/detail', 'id' => $new['id'], 'alias' => $new['alias']]);
                ?>
            <li>
                <div class="item-hot-news">
                    <div class="img-item-hot-news">
                        <a href="<?= $link ?>">
                            <img src="<?= ClaHost::getImageHost(), $new['avatar_path'], 's100_100/', $new['avatar_name'] ?>" alt="<?= $newtitle ?>" title="<?= $newtitle ?>">
                        </a>
                    </div>
                    <div class="title-item-hot-news">
                        <h2><a href="<?= $link ?>"><?= $newtitle ?></a></h2>
                        <span><?= date('d/m/Y', $new['publicdate']) ?></span>
                    </div>
                </div>
            </li>
            <?php } ?>
        </ul>
    </div>
<?php } ?>