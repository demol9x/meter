<?php

use common\components\ClaHost;
use yii\helpers\Url;
?>

<?php if (isset($data) && $data) { ?>
    <div class="tintuc-index">
        <div class="container">
            <?php
            foreach ($data as $news) {
                $url = Url::to(['/news/news/detail', 'id' => $news['id'], 'alias' => $news['alias']]);
                ?>
                <div class="item-news">
                    <div class="img-item-news">
                        <a href="<?= $url ?>" title="<?= $news['title'] ?>">
                            <img src="<?= ClaHost::getImageHost(), $news['avatar_path'], 's400_400/', $news['avatar_name'] ?>" alt="<?= $news['title'] ?>" />
                        </a>
                    </div>
                    <div class="title-item-news">
                        <h2>
                            <a href="<?= $url ?>" title="<?= $news['title'] ?>"><?= $news['title'] ?></a>
                        </h2>
                        <p class="time-news">
                            <span><i class="fa fa-calendar"></i> <?= date('d/m/Y', $news['publicdate']) ?></span>
                            <span>|</span>
                            <span>Đăng bởi: <?= $news['author'] ?></span>
                        </p>
                        <p><?= $news['short_description'] ?></p>
                        <div class="tool-item-news">
                            <a href="<?= $url ?>" class="view-more btn-style-2">Đọc tiếp</a>
                            <?= frontend\widgets\shareSocial\ShareSocialWidget::widget() ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="paginate">
                <?=
                yii\widgets\LinkPager::widget([
                    'pagination' => new yii\data\Pagination([
                        'pageSize' => $limit,
                        'totalCount' => $totalitem
                            ])
                ]);
                ?>               
            </div>
        </div>
    </div>
<?php } ?>

