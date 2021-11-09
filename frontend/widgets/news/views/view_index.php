<?php

use common\components\ClaHost;
use yii\helpers\Url;

function getDayOnWeek($value)
{
   switch ($value) {
        case 1:
           return "Thứ 2";
        case 2:
           return "Thứ 3";
        case 3:
           return "Thứ 4";
        case 4:
           return "Thứ 5";
        case 5:
           return "Thứ 6";
        case 6:
           return "Thứ 7";
        case 0:
           return "Chủ nhật";
   }
} 
?>

<?php if (isset($data) && $data) { ?>
    <div class="ctn-blog-news-index">
        <div class="container">
            <div class="index_col_title">
                <div class="collection-name">
                    <h3>
                        <a href="">
                             <img src="<?= Yii::$app->homeUrl ?>images/icon-logo.png" alt="">Khám phá
                        </a>
                    </h3>
                </div>
                <div class="collection-link">
                    <a href="<?= Url::to(['news/news/index']) ?>">Xem tất cả</a>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                    <?php $cuont = count($data);  ?>
                    <?php foreach ($data as $item) { ?>
                        <div class="big-news-index">
                            <div class="img-big-news-index">
                                <a href="<?= Url::to(['/news/news/detail', 'id' => $item['id'], 'alias' => $item['alias']]) ?>" title="<?= $item['title'] ?>">
                                    <img src="<?= ClaHost::getImageHost(), $item['avatar_path'], $item['avatar_name'] ?>" />
                                </a>
                            </div>
                            <div class="title-big-news-index">
                                <h2> <a href="<?= Url::to(['/news/news/detail', 'id' => $item['id'], 'alias' => $item['alias']]) ?>" title="<?= $item['title'] ?>"><?= $item['title'] ?></a> </h2>
                                <p> <span> <i class="fa fa-clock-o" aria-hidden="true"></i> <?= getDayOnWeek(date("N", $item['publicdate'])); ?>, <?= date('d/m/Y', $item['publicdate']) ?> </span>
                                    <span><i class="fa fa-eye" aria-hidden="true"></i><?= $item['viewed'] ?> lượt xem</span>
                                </p>
                                <p>
                                    <?= $item['short_description'] ?>
                                </p>
                            </div>
                        </div>
                    <?php break; } ?>
                    <div class="box-small-news-index">
                        <?php $view = 0; if($cuont > 1) foreach ($data as $item) if($view) { ?>
                        <div class="item-small-news-index">
                            <div class="img-item-small-news">
                                <a href="<?= Url::to(['/news/news/detail', 'id' => $item['id'], 'alias' => $item['alias']]) ?>" title="<?= $item['title'] ?>">
                                    <img src="<?= ClaHost::getImageHost(), $item['avatar_path'], $item['avatar_name'] ?>" />
                                </a>
                            </div>
                            <div class="title-item-small-news">
                                <h2> <a href="<?= Url::to(['/news/news/detail', 'id' => $item['id'], 'alias' => $item['alias']]) ?>" title="<?= $item['title'] ?>"><?= $item['title'] ?></a> </h2>
                                <p>
                                    <?= $item['short_description'] ?>
                                </p>
                            </div>
                        </div>
                        <?php } else {
                            $view =1;
                        } ?>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <div class="cate-news-index">
                        <?=
                            \frontend\widgets\news\NewsMenuWidget::widget([
                            'view' => 'ul',
                            'id' => 30
                            ])
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>