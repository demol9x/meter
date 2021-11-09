<?php $this->beginContent('@frontend/views/layouts/main_info.php'); ?>
<?= $this->render('@frontend/views/layouts/partial/header_not_filter'); ?>

<div id="main-content">
    <div class="container">
        <div class="list-job">
            <?= $content ?>
        </div>
    </div>
</div>

<?= $this->render('@frontend/views/layouts/partial/footer'); ?>
<?php $this->endContent(); ?>