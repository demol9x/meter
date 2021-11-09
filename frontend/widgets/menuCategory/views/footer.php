<?php if (isset($data) && $data) { ?>

    <?php
    $flag = 2;
    foreach ($data as $menu) { ?>
        <aside class="widget widget_text">
            <h3 class="widget-title"><?= Trans($menu['name'], $menu['name_en']) ?></h3>
        </aside>
        <?php
        if (isset($menu['items']) && count($menu['items'])) {
            ?>
            <ul id="text-3">
                <?php foreach ($menu['items'] as $menu) { 
                    $menu['name'] = Trans($menu['name'],$menu['name_en']);
                    ?>
                    <li>
                        <a href="<?= $menu['link'] ?>"
                           title="<?= $menu['name'] ?>"><i class="fa fa-angle-right"></i><?= $menu['name'] ?>
                        </a>
                    </li>
                <?php } ?>
            </ul>
            <?php
        }
        ?>
    <?php } ?>
<?php } ?>
