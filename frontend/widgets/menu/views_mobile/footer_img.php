<?php if (isset($data) && $data) { ?>
    <h2><?= $menu_group['name'] ?></h2>
    <ul>
        <?php
        foreach ($data as $menu) { ?>
            <li>
                <a href="<?= $menu['link'] ?>" title="<?= $menu['name'] ?>">
                    <img src="<?= common\components\ClaHost::getImageHost(), $menu['avatar_path'], $menu['avatar_name'] ?>" alt="<?= $menu['name'] ?>" />
                </a>
            </li>
        <?php } ?>
    </ul>
<?php } ?>