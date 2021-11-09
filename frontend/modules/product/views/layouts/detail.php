<?php $this->beginContent('@frontend/views/layouts/main.php'); ?>

<div id="main">
    <?= \frontend\widgets\breadcrumbs\BreadcrumbsWidget::widget() ?>
    <?= $content ?>
    
</div>
<style type="text/css">
	body div#main div div div div div div div#zoom-fig div a#Zoom-1 > .mz-figure > img {
	    max-height: 500px !important;
	    width: initial !important;
	    max-width: 100% !important;
	}
</style>
<?php $this->endContent(); ?>