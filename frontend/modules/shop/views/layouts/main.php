<?php
use yii\widgets\Breadcrumbs;
?>
<?php $this->beginContent('@frontend/views/layouts/main.php'); ?>

 <div id="main">
    <div class="breadcrumb-box">
    	<div class="container">
        	<?= Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],]) ?>
        </div>
    </div>
    <?= $content ?>
    
</div>

<?php $this->endContent(); ?>