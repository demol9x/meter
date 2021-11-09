<?php

use common\components\ClaHost;
use yii\helpers\Url;
?>
<?php if (isset($data) && $data) { ?>
    <div class="news-job">
        <h2><img src="<?= Yii::$app->homeUrl ?>images/folded-newspaper.png">Tin tức</h2>
        <div class="row">
            <?php foreach ($data as $item) { 
                $item['title'] = Trans($item['title'],$item['title_en']);
                $item['short_description'] = Trans($item['short_description'],$item['short_description_en']);
                ?>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="item-news-job">
                        <div class="img-news-job">
                            <a href="<?= Url::to(['/news/news/detail', 'id' => $item['id'], 'alias' => $item['alias']]) ?>" title="<?= $item['title'] ?>">
                                <img src="<?= ClaHost::getImageHost(), $item['avatar_path'], $item['avatar_name'] ?>" />
                            </a>
                        </div>
                        <div class="ctn-news-job">
                            <h2>
                                <a href="<?= Url::to(['/news/news/detail', 'id' => $item['id'], 'alias' => $item['alias']]) ?>" title="<?= $item['title'] ?>"><?= $item['title'] ?></a>
                            </h2>
                            <p><span><i class="fa fa-calendar"></i><?= date('d/m/Y', $item['publicdate']) ?></span></p>
                            <p>
                                <?= $item['short_description'] ?>
                            </p>
                            <a href="<?= Url::to(['/news/news/detail', 'id' => $item['id'], 'alias' => $item['alias']]) ?>" title="<?= $item['title'] ?>" class="view-more-blog"><?= Yii::t('app','view_more')  ?></a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>