<?php
if ($data) {
    foreach ($data as $item) {
        $name = Trans($item['name'], $item['name_en']);
        ?>
        <div class="menu-bar-lv-1">
            <a class="a-lv-1" href="<?= $item['link'] ?>" title="<?= $name ?>"><?= $name ?></a>
            <?php if (isset($item['children']) && $item['children']) { ?>
                <?php foreach ($item['children'] as $cat) { 
                    $cat_name = Trans($cat['name'], $cat['name_en']);
                    ?>
                    <div class="menu-bar-lv-2">
                        <a class="a-lv-2" href="<?= $cat['link'] ?>" title="<?= $cat_name ?>">
                            <i class="fa fa-angle-right"></i><?= $cat_name ?>
                        </a>
                        <?php if (isset($cat['children']) && $cat['children']) { ?>
                            <?php foreach ($cat['children'] as $cat_children) { 
                                $cat_children_name = Trans($cat_children['name'], $cat_children['name_en']);
                                ?>
                                <div class="menu-bar-lv-3">
                                    <a class="a-lv-3" href="<?= $cat_children['link'] ?>" title="<?= $cat_children_name ?>">
                                        <i class="fa fa-angle-right"></i>
                                        <i class="fa fa-angle-right"></i><?= $cat_children_name ?>
                                    </a>
                                </div>
                            <?php } ?>
                            <span class="span-lv-2 fa fa-angle-down"></span>
                        <?php } ?>
                    </div>
                <?php } ?>
                <span class="span-lv-1 fa fa-angle-down"></span>
            <?php } ?>
        </div>
        <?php
    }
}
?>

