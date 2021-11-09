<?php

use yii\helpers\Url;
use common\components\ClaHost;
if (isset($news) && $news) {
    ?>
<style type="text/css">
    .title-news-relate h3 a {
        font-size: 16px;
        line-height: 14px;
        font-family: 'Roboto', 'Open Sans', sans-serif;
        font-weight: 500;
        line-height: 25px;
    }
    .title-item-hot-news h2 a {
        line-height: 20px;
    }
</style>
    <div class="news-relate">
        <h2 class="head-news-relate"><span><?= $title ?></span></h2>
        <div class="row">
            <div class="owl-news-relate-inmobile">
                <?php foreach ($news as $new) {
                    $newtitle = $new['title'];
                    $link =  Url::to(['/news/news/detail', 'id' => $new['id'], 'alias' => $new['alias']]);
                    ?>
                    <div class="item-news-relate">
                        <div class="img-news-relate">
                            <a href="<?= $link ?>">
                            <img class="hover-img" src="<?= ClaHost::getImageHost(), $new['avatar_path'], 's500_500/', $new['avatar_name'] ?>" alt="<?= $newtitle ?>" title="<?= $newtitle ?>">
                        </a>
                        </div>
                        <div class="title-news-relate">
                            <h3>
                                <a href="<?= $link ?>"><?= $newtitle ?></a>
                            </h3>
                            <p class="time-relate"><i class="fa fa-clock-o"></i><?= date('d - M', $new['publicdate']) ?></p>
                        </div>
                    </div>
                <?php } ?> 
            </div>
            <script>
                $(document).ready(function () {
                    if ($(window).width() < 600) {
                        $(".owl-news-relate-inmobile").owlCarousel({
                            navigation: true,
                            pagination: false,
                            lazyLoad: true,
                            items: 2,
                            navigationText: ["<span class='fa fa-angle-left'></span>", "</span><span class='fa fa-angle-right'></span>"],
                            itemsDesktop: [1199, 2],
                            itemsDesktopSmall: [992, 2],
                            itemsTablet: [768, 2],
                            itemsTabletSmall: [600, 2],
                            itemsMobile: [360, 2]
                        });
                    }
                    ;
                });
            </script>
        </div>
    </div>
<?php } ?>