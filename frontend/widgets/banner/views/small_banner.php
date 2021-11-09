<style type="text/css">
    .banner-inhome .small-banner .item-img img {
        max-height: 122px;
    }
</style>
<?php if (isset($data) && $data) { ?>
    <div class="small-banner">
        <?php foreach ($data as $tg) {
            $banner->setAttributeShow($tg); ?>
            <div class="item-img relative">
                <a <?= $banner['target'] ? 'target="_bank"' : '' ?> <?= $banner['link'] ? 'href="' . $banner['link'] . '"' : '' ?> title="<?= $banner['name'] ?>">
                    <img alt="<?= $banner['name'] ?>" src="<?= $banner->src ?>" />
                </a>
            </div>
        <?php } ?>
    </div>

<?php } ?>