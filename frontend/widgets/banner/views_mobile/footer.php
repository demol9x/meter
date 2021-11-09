<?php if (isset($data) && $data) { ?>
    <h2><?= $group['name'] ?></h2>
    <?php foreach ($data as $tg) {
        $banner->setAttributeShow($tg); ?>
        <img src="<?= $banner->src ?>" alt="<?= $banner['name'] ?>">
    <?php } ?>
<?php } ?>