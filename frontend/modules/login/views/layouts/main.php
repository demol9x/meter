<?php $this->beginContent('@frontend/views/layouts/main.php'); ?>
<div class="content-wrap">
    <?= \frontend\widgets\breadcrumbs\BreadcrumbsWidget::widget(); ?>
    <?= $content ?>
</div>
<?php $this->endContent(); ?>
