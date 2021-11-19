<?php if (isset($data) && $data) { ?>
<label>
    <input class="Dashboard" name="" type="checkbox">
    <div class="foot-list">
        <h3 class="text_content"><?= $menu_group['name'] ?></h3>
        <ul>
            <?php
            foreach ($data as $menu) { ?>
            <li><a href="<?= $menu['link'] ?>" title="" class="content_14"><?= $menu['name'] ?></a></li>
            <?php } ?>
        </ul>
    </div>
</label>
<?php } ?>