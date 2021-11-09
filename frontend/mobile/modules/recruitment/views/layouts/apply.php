<?php $this->beginContent('@frontend/views/layouts/main.php'); ?>
<?= $this->render('@frontend/views/layouts/partial/header_not_filter'); ?>

<?= $content ?>

<?= $this->render('@frontend/views/layouts/partial/footer'); ?>
<?php $this->endContent(); ?>