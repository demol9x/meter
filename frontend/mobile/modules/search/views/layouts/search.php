<?php $this->beginContent('@frontend/views/layouts/main.php'); ?>

<div id="main">
    <?= \frontend\widgets\breadcrumbs\BreadcrumbsWidget::widget() ?>
    <div class="categories-product-page">
        <div class="section-product">
            <div class="container">
                <div class="page-goi-y">
                    <div class="title center">
                        <h2><?= Yii::t('app', 'response_search') ?></h2>
                    </div>
                    <?= $content ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endContent(); ?>