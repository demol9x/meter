<?php

use yii\helpers\Url;
use common\components\ClaHost;
if (isset($videos) && $videos) {
    ?>
    <div class="news-index video-home">
        <div class="container">
            <div class="row">
                <?php 
                    $st =1;
                    foreach ($videos as $video) {
                        $name = $video['name'];
                        $short_description = $video['short_description'];
                        $link = Url::to(['/media/video/detail','id' =>$video['id'], 'alias' => $video['alias']]);
                        $image = ClaHost::getImageHost(). $video['avatar_path']. 's400_400/'. $video['avatar_name'];
                        $title = Yii::t('app','view_more'); 
                        ?>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div class="img-item-video-up">
                                    <div class="white">
                                        <div class="video-img">
                                            <div class="box-i  load-video" data-link="<?= $video['embed'] ?>?autoplay=1">
                                                <img src="<?= Yii::$app->homeUrl ?>images/youtube_button.png">
                                            </div>
                                            <a class="hover-img">
                                                <img class="lazy" data-src="<?= $image ?>" alt="<?= $name ?>">
                                            </a>
                                        </div>
                                        <div class="title-item-video-other">
                                            <a href="<?= $link ?>"><?= $name ?></a>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        <?php
                    }
                ?>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.load-video').click(function () {
                $(this).html('<iframe src="'+$(this).attr('data-link')+'" frameborder="0" allowfullscreen=""></iframe>');
            })
        })
    </script>
<?php } ?>