<?php if (isset($data) && $data) { ?>
    <div class="text_content"><?= $menu_group['name'] ?></div>
    <ul>
        <?php
        foreach ($data as $menu) { ?>
            <li><a href="<?= $menu['link'] ?>"><?= $menu['name'] ?></a></li>
        <?php } ?>
    </ul>
<?php } ?>
