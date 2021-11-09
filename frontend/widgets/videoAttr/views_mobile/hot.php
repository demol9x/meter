<?php

use yii\helpers\Url;
use common\components\ClaHost;
if (isset($videos) && $videos) {
    ?>
    <div class="video-hots list-video-other">
        <div class="title-video-other">
            <h2 class="txt-left"><a href="" class="txt-left"><?= $title ?></a></h2>
        </div>
        <div class="row multi-columns-row">
            <?php 
                $st =1;
                foreach ($videos as $video) {
                    $name = $video['name'];
                    $short_description = $video['short_description'];
                    $link = Url::to(['/media/video/detail','id' =>$video['id'], 'alias' => $video['alias']]);
                    $image = ClaHost::getImageHost(). $video['avatar_path']. 's300_300/'. $video['avatar_name'];
                    $title = Yii::t('app','view_more');
                    if($st) { $st = 0;?>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <div class="img-item-video-up">
                                <a href="<?= $link ?>" class="hover-img">
                                    <img src="<?= $image ?>" alt="<?= $name ?>">
                                </a>
                                <div class="title-item-video-other">
                                    <h3><a href="<?= $link ?>"><?= $name ?></a></h3>
                                    <div>
                                        <?= $short_description ?>
                                    </div>
                                    <a href="<?= $link ?>" class="view-more-video-other"><?= $title ?></a>
                                </div>
                            </div> 
                        </div>
                        <?php } else { ?>
                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                            <div class="item-video-other">
                                <div class="img-item-video-other">
                                    <a href="<?= $link ?>">
                                        <img src="<?= $image ?>" alt="<?= $name ?>">
                                    </a>
                                </div>
                                <div class="title-item-video-other">
                                    <h2><a href="<?= $link ?>"><?= $name ?></a></h2>
                                    <p>
                                        <?= $short_description ?>
                                    </p>
                                    <a href="<?= $link ?>" class="view-more-video-other"><?= $title ?></a>
                                </div>
                            </div>
                        </div>
                        <?php 
                    } 
                }
            ?>
        </div>
    </div>
<?php } ?>