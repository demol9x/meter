<?php

use yii\helpers\Url;
use common\components\ClaHost;
if (isset($videos) && $videos) {
    ?>

     <div class="layout-crn layout-crn2 ">
        <div class="title-crn">
            <h2>
                <a href="<?= Url::to(['/media/video/index']) ?>">Video</a>
            </h2>
        </div>
        <div class="content-crn">
            <div class="list-news-incate list-news-incate-crn">
                <?php 
                    $st =1;
                    foreach ($videos as $video) {
                        $name = $video['name'];
                        $short_description = $video['short_description'];
                        $link = Url::to(['/media/video/detail','id' =>$video['id'], 'alias' => $video['alias']]);
                        $image = ClaHost::getImageHost(). $video['avatar_path']. 's400_400/'. $video['avatar_name'];
                        $title = Yii::t('app','view_more'); 
                        ?>
                        <div class="item-news-incate">
                            <div class="img">
                                <a href="<?= $link ?>">
                                    <img src="<?= $image ?>" alt="<?= $name ?>">
                                </a>
                            </div>
                            <h3>
                                <a href="<?= $link ?>"><?= $name ?></a>
                            </h3>
                        </div>
                <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>