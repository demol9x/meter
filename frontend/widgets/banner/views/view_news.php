<style type="text/css">
    .ad-spots a {
        margin-top: 20px;
        display: block;
    }
</style>
<?php if (isset($data) && $data) { ?>
    <div class="ad-spots">
        <div class="widget-content">
            <?php foreach ($data as $tg) {
                $banner->setAttributeShow($tg); ?>
                <a href="<?= $banner['link'] ?>" title="<?= $banner['name'] ?>">
                    <img src="<?= $banner->src ?>" />
                </a>
            <?php } ?>
        </div>
    </div>
<?php } ?>