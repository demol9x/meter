<?php if (isset($data) && $data) { ?>
    <div class="partner-in-store">
        <h2>
            <?= $group['name'] ?>
        </h2>
        <div class="container">
            <div class="slider-item-partner">
                <?php foreach ($data as $tg) {
                    $banner->setAttributeShow($tg); ?>
                    <div class="item-partner">
                        <div class="vertical">
                            <div class="middle">
                                <a <?= $banner['target'] ? 'target="_bank"' : '' ?> <?= $banner['link'] ? 'href="' . $banner['link'] . '"' : '' ?>>
                                    <img src="<?= $banner->src ?>" alt="<?= $banner['name'] ?>" title="<?= $banner['name'] ?>">
                                </a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>