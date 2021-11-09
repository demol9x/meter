<?php if (isset($data) && $data) { ?>
    <div class="big-banner owl-carousel owl-theme">
        <?php foreach ($data as $tg) {
            $banner->setAttributeShow($tg); ?>
            <div class="item-img relative">
                <a <?= $banner['target'] ? 'target="_bank"' : '' ?> <?= $banner['link'] ? 'href="' . $banner['link'] . '"' : '' ?> title="<?= $banner['name'] ?>">
                    <img alt="<?= $banner['name'] ?>" src="<?= $banner->src ?>" /> <!-- class="lazy" -->
                </a>
            </div>
        <?php } ?>
    </div>
<?php } ?>