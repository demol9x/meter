<?php if (isset($data) && $data) { ?>
    <div class="icon_foot">
        <?php foreach ($data as $menu) { ?>
            <a <?= $menu['link'] ? ($menu['target'] ? 'target="_blank" href="' . $menu['link'] . '"' : 'href="' . $menu['link'] . '"') : '' ?>><?= $menu['description']?></a>

        <?php }?>
        <a class="backtotop" href=""><i class="fas fa-chevron-up"></i></a>
    </div>
<?php } ?>
