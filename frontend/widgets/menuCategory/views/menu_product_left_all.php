<?php

use yii\helpers\Url;
?>
<style type="text/css">
    body .menu-bar-lv-1 a {
        background: #f5f5f5;
        padding: 5px 0px;
    }

    body .menu-bar-store {
        background: #f5f5f5;
    }

    body .menu-bar-lv-2,
    .menu-bar-lv-2 a,
    body .menu-bar-lv-3,
    body .menu-bar-lv-4 a {
        padding-left: 15px;
    }

    .liactive>a {
        font-weight: bold;
        color: #dbbf6d;
    }

    .liactive .fa-angle-down:before {
        color: #dbbf6d;
    }

    .liactive {
        display: block !important;
    }
</style>
<?php
function writeUl($data, $index)
{
    if (isset($data['active'])) unset($data['active']);
    if ($data) {
        foreach ($data as $value) {
            $name = $value['name'];
            echo '<div class="menu-bar-lv-' . $index . ($value['active'] ? ' liactive' : '') . '">
                    <a  class="a-lv-' . $index . '" href="' . Url::to(['/product/product/category', 'id' => $value['id'], 'alias' => $value['alias']]) . '">' . $name . '</a>';
            if ($value['items']) {
                writeUl($value['items'], $index + 1);
            }
            echo '</div>';
        }
        echo '<span class="span-lv-' . ($index - 1) . ' fa fa-angle-down"></span>';
    }
}
?>
<?php if (isset($data) && $data) { ?>
    <h2><?= Yii::t('app', 'menu_product') ?></h2>
    <div class="menu-bar-store" tabindex="-1">
        <?php foreach ($data as $menu) { ?>
            <div class="menu-bar-lv-1 <?= $menu['active'] ? 'liactive' : '' ?>">
                <a class="a-lv-1" href="<?= Url::to(['/product/product/category', 'id' => $menu['id'], 'alias' => $menu['alias']]) ?>"><?= $menu['name'] ?></a>
                <?php
                writeUl($menu['items'], 2);
                ?>
            </div>
        <?php } ?>
    </div>
<?php  } ?>
<script>
    $('.liactive').parent().children('div').css('display', 'block');
    $('.liactive > div').css('display', 'block');
    $('.liactive').closest('.menu-bar-lv-2').addClass('liactive');
    $('.liactive').closest('.menu-bar-lv-1').addClass('liactive');
</script>