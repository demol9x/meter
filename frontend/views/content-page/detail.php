<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = $model->title;
$this->params['breadcrumbs'][] = $this->title;
?>
<?php //Menu main
echo frontend\widgets\banner\BannerWidget::widget([
    'view' => 'banner-main-in',
    'group_id' => 3,
])
?>
<div class="site51_html_col0_gioithieu">
    <div class="container_fix">
        <?php //Menu main
        echo frontend\widgets\breadcrumbs\BreadcrumbsWidget::widget([])
        ?>

        <div class="gioithieu">
            <div class="gioithieu__left wow fadeIn" data-wow-delay="0.3s">
                <h2 class="title_30"><?= $this->title ?></h2>
                <ul class="content_16">
                    <li>
                        <?= $model->short_description ?>
                    </li>
                    <li>
                        <?= $model->description ?>
                    </li>
                </ul>
            </div>
        </div>
        <div class="share">
            <?=
            frontend\widgets\facebookcomment\FacebookcommentWidget::widget([
                'view' => 'share'
            ]);
            ?>
        </div>
        <div class="facebook-cm">
            <?=
            frontend\widgets\facebookcomment\FacebookcommentWidget::widget([
            ]);
            ?>
        </div>
    </div>
</div>
<style>
    .site51_html_col0_gioithieu .gioithieu__left {
        width: 100%;
        padding-right: 0;
    }
    .site51_html_col0_gioithieu .gioithieu {
        margin: 35px 0 0 0;
    }
    .tw.share_tw {
        background: #1c96e8;
        text-align: center;
        padding: 3px 7px;
        border-radius: 3px;
        color: #fff;
        font-size: 12px;
        position: relative;
        top: -3px;
        left: 5px;
    }
</style>
