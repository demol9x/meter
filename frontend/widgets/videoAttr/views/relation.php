<?php

use yii\helpers\Url;
use common\components\ClaHost;
if (isset($videos) && $videos) {
    ?>
    <div class="news-hot">
        <h2><?= $title ?></h2>
        <div class="owl-news-hot-inmobile">
            <?php foreach ($videos as $video) { 
                $name = $video['name'];
                $link = Url::to(['/media/video/detail','id' =>$video['id'], 'alias' => $video['alias']]);
                $image = ClaHost::getImageHost(). $video['avatar_path']. 's400_400/'. $video['avatar_name'];
                ?>
                <div class="item-news-hot">
                    <div class="img-news-hot">
                        <a class="hover-img">
                            <img src="<?= $image ?>" alt="<?= $name ?>">
                        </a>
                    </div>
                    <div class="title-news-hot">
                        <h3>
                            <a href="<?= $link ?>"><?= $name ?></a>
                        </h3>
                        <span class="time-hot">
                            <i class="fa fa-clock-o"></i>
                            <?= date('d/m/Y', $video['created_at']) ?>
                        </span>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>