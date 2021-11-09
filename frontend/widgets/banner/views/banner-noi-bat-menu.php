<?php $i = 0;
if (isset($data) && $data) { ?>
    <ul>
        <?php foreach ($data as $tg) {
            $banner->setAttributeShow($tg);
            $i++; ?>
            <li><a <?= $banner['target'] ? 'target="_blank"' : '' ?> href="<?= $banner['link'] ?>"><?= Trans($banner['name'], $banner['name_en']) ?></a></li> <?= ($i == count($data)) ? '' : '<li><span>.</span></li>' ?>
        <?php } ?>
    </ul>
<?php } ?>