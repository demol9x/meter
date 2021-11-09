<?php if (isset($data) && $data) { ?>
    <?php foreach ($data as $tg) {
        $banner->setAttributeShow($tg); ?>
        <a <?= $banner['target'] ? 'target="_bank"' : '' ?> <?= $banner['link'] ? 'href="' . $banner['link'] . '"' : '' ?> title="<?= $banner['name'] ?>">
            <img src="<?= $banner->src ?>" alt="<?= $banner['name'] ?>" />
        </a>
    <?php } ?>
<?php } ?>