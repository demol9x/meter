<?php if (isset($data) && $data) { ?>
    <ul>
        <?php foreach ($data as $menu) { ?>
        <li>
            <a <?= $menu['target'] ? 'target="_blank"' : '' ?> href="<?= $menu['link']; ?>"><?= Trans($menu['name'],$menu['name_en']); ?></a>
        </li>
        <?php } ?>
    </ul>
<?php } ?>
