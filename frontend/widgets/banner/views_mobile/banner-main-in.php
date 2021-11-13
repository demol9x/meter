<?php if (isset($data) && $data) {
$banner->setAttributeShow($data[0]); ?>
<div class="site51_bann_col0_slidein">
    <div class="bann_in">
        <img src="<?= $banner->src ?>" alt="<?= $banner['name'] ?>">
    </div>
</div>
<?php } ?>