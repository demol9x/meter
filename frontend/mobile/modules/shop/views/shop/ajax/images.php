<?php
use common\components\ClaHost;
$i = 0;
foreach ($images as $image) {
    $i++;
    if ($i < 5) {
        ?>
        <div class="item-img-detail">
            <a href="<?= ClaHost::getImageHost(), $image['path'], $image['name'] ?>" rel="group1" class="fancybox">
                <img class="zoom-img" src="<?= ClaHost::getImageHost(), $image['path'], $image['name'] ?>" data-zoom-image="<?= ClaHost::getImageHost(), $image['path'], $image['name'] ?>">
            </a>
        </div>
        <?php
    }
}
?>
