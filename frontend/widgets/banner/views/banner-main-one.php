<?php if (isset($data) && $data) {
    $banner->setAttributeShow($data[0]); ?>
    <a href="<?= $banner['link'] ?>">
        <img src="<?= $banner->src ?>" alt="<?= $banner['name'] ?>">
    </a>
<?php } ?>