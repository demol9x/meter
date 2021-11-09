<?php if (isset($data) && $data) { ?>
    <div class="bg-img">
        <?php foreach ($data as $tg) {
            $banner->setAttributeShow($tg); ?>
            <img src="<?= $banner->src ?>" />
        <?php } ?>
    </div>
<?php } ?>