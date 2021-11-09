<?php $this->beginContent('@frontend/views/layouts/main.php'); ?>
    <div class="content-wrap">
        <div class="banner-slider-index">
            <?= \frontend\widgets\banner\BannerWidget::widget([
                    'view' => 'banner-main',
                    'group_id' => \frontend\widgets\banner\BannerWidget::BANNER_CHINH,
                    'limit' => 5
                ]
            )
            ?>
        </div>
        <div class="camket">
            <?= \frontend\widgets\banner\BannerWidget::widget([
                    'view' => 'banner-noi-bat',
                    'group_id' => \frontend\widgets\banner\BannerWidget::BANNER_NOI_BAT,
                    'limit' => 5
                ]
            )
            ?>
        </div>
        <?= $content ?>
        <!--        <div class="page-list-product">-->
        <!--            --><? // //=
        //            \frontend\widgets\breadcrumbs\BreadcrumbsWidget::widget();
        //            ?>
        <!--            <div class="list-product">-->
        <!--                <div class="container">-->
        <!--                    <div class="row">-->
        <!--                        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-4">-->
        <!--                            --><? // //=
        //                            \frontend\widgets\category\CategoryWidget::widget([
        //                                'type' => common\components\ClaCategory::CATEGORY_PRODUCT
        //                            ]);
        //                            ?>
        <!---->
        <!--                        </div>-->
        <!---->
        <!---->
        <!--                    </div>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--        </div>-->
    </div>
    <!-- /content-wrap -->
<?php $this->endContent(); ?>