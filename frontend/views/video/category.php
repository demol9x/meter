<?php

use yii\helpers\Url;
use common\components\ClaHost;

$language = \common\components\ClaLid::getCurrentLanguage();
?>
<?php if ($category['embed']) { ?>
<!--    <div class="banner-index">
         Insert to your webpage where you want to display the slider 
        <div id="amazingslider-wrapper-1" style="display:block;position:relative;max-width:100%;margin:0 auto;">
            <div id="amazingslider-1" style="display:block;position:relative;margin:0 auto;">
                <ul class="amazingslider-slides" style="display:none;">
                    <li>
                        <video preload="none" data-mediatype=11 src="<?= $category['embed'] ?>?autoplay=1&loop=1&cc_load_policy=1rel=0&amp;controls=0&amp;showinfo=0&playlist=Scxs7L0vhZ4&amp;volume=0"  frameborder="0" allowfullscreen></video>
                        <div class="categories-list-table wow fadeInUp" data-wow-delay="1s">
                            <div class="frame-categories-list">
                                <h2><?= $category['name'] ?></h2>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
         End of body section HTML codes 
    </div>-->
<?php } ?>

<?php if (isset($videos) && $videos) { ?>
    <div class="box-list-video">
        <?php foreach ($videos as $video) { ?>
            <div class="item-video" src="<?= $video['embed'] ?>?&theme=dark&autohide=2&modestbranding=1&controls=0&showinfo=0&autoplay=1">
                <div class="img-item-video">
                    <a href="<?= Url::to(['/video/detail', 'id' => $video['id'], 'alias' => $video['alias']]) ?>">
                        <img src="<?= ClaHost::getImageHost(), $video['avatar_path'], 's300_300/', $video['avatar_name'] ?>" />
                    </a>
                    <div class="btn-play"><a href="<?= Url::to(['/video/detail', 'id' => $video['id'], 'alias' => $video['alias']]) ?>"></a></div>
                </div>
                <div class="title-item-video">
                    <h2>
                        <a href="<?= Url::to(['/video/detail', 'id' => $video['id'], 'alias' => $video['alias']]) ?>" title="<?= $language == 'vi' ? $video['name'] : $video['name_en'] ?>">
                            <?= $language == 'vi' ? $video['name'] : $video['name_en'] ?>
                        </a>
                    </h2>
                    <span>4K <spam><?= $video['length'] ?>s</spam></span>
                </div>
                <div class="show-iframe">
                </div>
            </div>
        <?php } ?>
        <div class="paginate">
            <?=
            yii\widgets\LinkPager::widget([
                'pagination' => new yii\data\Pagination([
                    'totalCount' => $totalitem,
                    'pageSize' => $limit
                        ]),
            ]);
            ?>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $(".item-video").each(function () {
                var getSrc = $(this).attr('src');
                $(this).hover(
                        function () {
                            $(this).find(".show-iframe").html('<iframe src="" frameborder="0" allowfullscreen></iframe>');
                            $(".show-iframe iframe").attr("src", getSrc);
                        },
                        function () {
                            $(".show-iframe iframe").remove();
                        }
                );
            });
        });
    </script>
<?php } ?>