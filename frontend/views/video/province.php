<?php

use yii\helpers\Url;
use common\components\ClaHost;

$language = \common\components\ClaLid::getCurrentLanguage();
?>

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
                        <a href="<?= Url::to(['/video/detail', 'id' => $video['id'], 'alias' => $video['alias']]) ?>">
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