<?php $this->beginContent('@frontend/views/layouts/main.php'); ?>
<div id="main">
    <?= \frontend\widgets\breadcrumbs\BreadcrumbsWidget::widget() ?>
    
    <div class="categories-product-page">
        
        <?= $content ?>
        
    </div>
</div>
<!-- /content-wrap -->
<?php $this->endContent(); ?>