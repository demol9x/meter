<?php $this->beginContent('@frontend/views/layouts/main.php'); ?>

<div class="content-wrap">
    <div class="page-list-product">
        <?=
        \frontend\widgets\breadcrumbs\BreadcrumbsWidget::widget();
        ?>
        <div class="list-product">
            <div class="container">
                <div class="row">
                    <div class="col-lg-2 col-md-2 col-sm-3 col-xs-4">
                        <?=
                        \frontend\widgets\category\CategoryWidget::widget([
                            'type' => common\components\ClaCategory::CATEGORY_PRODUCT,
                            'view' => 'view_brand'
                        ]);
                        ?>

                    </div>

                    <?= $content ?>

                </div>
            </div>
        </div>
    </div>
</div><!-- /content-wrap -->

<?php $this->endContent(); ?>