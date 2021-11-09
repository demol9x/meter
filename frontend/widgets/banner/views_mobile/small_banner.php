<?php if (isset($data) && $data) { ?>
    <div class="small-banner">
        <?php foreach ($data as $tg) {
            $banner->setAttributeShow($tg); ?>
            <div class="item-img">
                <a <?= $banner['target'] ? 'target="_bank"' : '' ?> <?= $banner['link'] ? 'href="' . $banner['link'] . '"' : '' ?> title="<?= $banner['name'] ?>">
                    <img src="<?= $banner->src ?>" alt="<?= $banner['name'] ?>" />
                </a>
            </div>
        <?php } ?>
    </div>

<?php } ?>