<?php $this->beginContent('@frontend/views/layouts/main.php'); ?>
    <div id="main">
	    <?= \frontend\widgets\breadcrumbs\BreadcrumbsWidget::widget() ?>
	        
	    <?= $content ?>
	        
	</div>
<?php $this->endContent(); ?>