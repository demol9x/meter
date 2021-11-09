<?php

use common\components\ClaLid;
use yii\helpers\Url;

?>
<style type="text/css">
    .front-back-page {
        top: 0px !important;
    }
</style>
<div id="main">
    <?php if (!\common\components\ClaSite::isMobile()) { ?>
        <div class="container">
            <div class="title-news2">
                <ul>
                    <?php
                    $new_cats = \common\models\news\NewsCategory::find()->where(['show_in_home' => 1, 'status' => 1])->limit(5)->orderBy('order ASC')->all();
                    if ($new_cats) {
                        foreach ($new_cats as $item) {
                    ?>
                            <li>
                                <a href="<?= Url::to(['/news/news/category', 'id' => $item->id, 'alias' => $item->alias]) ?>"><?= $item->name ?></a>
                            </li>
                    <?php }
                    } ?>
                    <li>
                        <a href="<?= Url::to(['/media/video/index']) ?>">Video</a>
                    </li>
                    <?php if (Yii::$app->user->id) { ?>
                        <style>
                            .f-right {
                                float: right;
                                margin-right: 10px;
                                cursor: pointer;
                            }

                            #linkcopy {
                                opacity: 0;
                                position: absolute;
                            }
                        </style>
                        <li class="f-right copr">
                            <a onclick="copyText($(this))">Ocop mart afilliate</a>
                            <input id="linkcopy" value="<?= \yii\helpers\Url::to(['/login/login/signup', 'user_id' => Yii::$app->user->id], true); ?>">
                        </li>
                        <script type="text/javascript">
                            function copyText(_this) {
                                var copyText = document.getElementById("linkcopy");
                                copyText.select();
                                document.execCommand("copy");
                                _this.html('Copied Link Affiliate');
                            }
                        </script>
                    <?php } ?>
                </ul>
            </div>
        </div>
    <?php } ?>
    <?php if (!\common\components\ClaSite::isActiceApp() && !(isset($_GET['active_app_gcaeco']))) { ?>
        <div class="banner-inhome">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                        <?=
                            \frontend\widgets\banner\BannerWidget::widget([
                                'view' => 'big_banner',
                                'group_id' => 1,
                                'limit' => 5
                            ])
                        ?>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <?=
                            \frontend\widgets\banner\BannerWidget::widget([
                                'view' => 'small_banner',
                                'group_id' => 2,
                                'limit' => 5
                            ])
                        ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <?= (\common\components\ClaSite::isMobile()) ? \frontend\widgets\menu\MenuWidget::widget(['view' => 'menu_index_mobile', 'group_id' => 9]) : '' ?>

    <?=
        frontend\widgets\categoryShowHome\CategoryShowHomeWidget::widget([])
    ?>

    <?php
    echo \frontend\widgets\banner\BannerQcWidget::widget([
        'view' => 'banner_qc',
        'group_id' => \common\components\ClaLid::getIdQc('index'),
        'limit' => 1,
        'stt' => 1,
    ])
    ?>

    <?=
        \frontend\widgets\promotion\PromotionWidget::widget([
            'view' => 'view',
            'limit' => 50,
            'title' => Yii::t('app', 'product_sale'),
        ])
    ?>

    <?php
    echo \frontend\widgets\banner\BannerQcWidget::widget([
        'view' => 'banner_qc',
        'group_id' => \common\components\ClaLid::getIdQc('index'),
        'limit' => 1,
        'stt' => 2,
    ])
    ?>

    <?=
        \frontend\widgets\productNewOnDay\ProductNewOnDayWidget::widget([
            'view' => 'product_home',
        ])
    ?>

    <?php
    echo \frontend\widgets\banner\BannerQcWidget::widget([
        'view' => 'banner_qc',
        'group_id' => \common\components\ClaLid::getIdQc('index'),
        'limit' => 1,
        'stt' => 3,
    ])
    ?>

    <?=
        frontend\widgets\categoryShowHome2\CategoryShowHome2Widget::widget([
            'view' => 'view_product'
        ])
    ?>

    <?php
    echo \frontend\widgets\banner\BannerQcWidget::widget([
        'view' => 'banner_qc',
        'group_id' => \common\components\ClaLid::getIdQc('index'),
        'limit' => 1,
        'stt' => 4,
    ])
    ?>

    <?=
        frontend\widgets\productTopsearch\ProductTopsearchWidget::widget([
            'limit' => 10
        ]);
    ?>

    <?php
    echo \frontend\widgets\banner\BannerQcWidget::widget([
        'view' => 'banner_qc',
        'group_id' => \common\components\ClaLid::getIdQc('index'),
        'limit' => 1,
        'stt' => 5,
    ])
    ?>

    <?=
        \frontend\widgets\html\HtmlWidget::widget([
            'view' => 'media_index',
        ])
    ?>

    <?php
    echo \frontend\widgets\banner\BannerQcWidget::widget([
        'view' => 'banner_qc',
        'group_id' => \common\components\ClaLid::getIdQc('index'),
        'limit' => 1,
        'stt' => 7,
    ])
    ?>
    <?=
        \frontend\widgets\html\HtmlWidget::widget([
            'view' => 'map_index',
            'input' => [
                'zoom' => 12
            ]
        ])
    ?>
    <?php
    echo \frontend\widgets\banner\BannerQcWidget::widget([
        'view' => 'banner_qc',
        'group_id' => \common\components\ClaLid::getIdQc('index'),
        'limit' => 1,
        'stt' => 8,
    ])
    ?>

</div>