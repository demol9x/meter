<?php if (isset($data) && $data) { ?>
    <ul>
        <?php foreach ($data as $menu) { ?>
        <li>
            <a <?= $menu['target'] ? 'target="_blank"' : '' ?> href="<?= $menu['link']; ?>"><?= $menu['name']; ?></a>
        </li>
        <?php } ?>
    </ul>
<?php } ?>
