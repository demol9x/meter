<?php
use common\components\ClaHost;
use yii\helpers\Url;

?>

<div class="blog-page">
    <div class="full-text full-text-nopad">
        <h2><?= $category['name'] ?></h2>
        <p>
            <?= $category['description'] ?>
        </p>
    </div>
    <div class="list-blog-item">
        <?php if (isset($data) && $data) { ?>
            <?php foreach ($data as $new) { ?>
                <div class="item-blog-news">
                    <div class="img-item-blog-news">
                        <a href="<?= $link = Url::to(['/news/news/detail', 'id' => $new['id'], 'alias' => $new['alias']]) ?>"
                           title="<?= $new['title'] ?>">
                            <img src="<?= ClaHost::getImageHost(), $new['avatar_path'], 's300_300/' , $new['avatar_name'] ?>" alt="<?= $name = $new['title'] ?>" >
                        </a>
                    </div>
                    <div class="title-item-blog-news">
                        <h2 class="blog_entry-title">
                            <a href="<?= $link ?>"
                               title="<?= $name ?>"><?= $name ?></a>
                        </h2>
                        <span><?= date('d/m/Y', $new['publicdate']) ?></span>
                        <p>
                            <?= nl2br($new['short_description']) ?>
                        </p>
                        <a href="<?= $link ?>"
                           title="<?= $new['title'] ?>"
                           class="view-more-news"><?= Yii::t('app', 'view_detail') ?></a>
                    </div>
                </div>
            <?php } ?>
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