<?php
use yii\helpers\Url;

    if (!function_exists('writeUl')) {
        function writeUl($data, $index) {
            if(isset($data['active'])) unset($data['active']);
            if($data) {
                    foreach ($data as $value) {
                        $name = $value['name'];
                        echo '<div class="menu-bar-lv-'.$index.($value['active'] ? ' liactive' : '').'">
                            <a  class="a-lv-'.$index.'" href="'.Url::to(['/product/product/category', 'id' => $value['id'], 'alias' => $value['alias']]).'">'.$name.'</a>';
                        if($value['items']) {
                            writeUl($value['items'], $index+1);
                        } 
                        echo '</div>';
                    }
                echo '<span class="span-lv-'.($index-1).' fa fa-angle-down"></span>';
            }
        }
    }
?>
<?php if (isset($data) && $data) { ?>
    <h2><?= Yii::t('app', 'menu_product') ?></h2>
    <div class="menu-bar-store" tabindex="-1">
        <?php foreach ($data as $menu) {?>
            <div  class="menu-bar-lv-1 <?= (isset($menu['active']) && $menu['active']) ? 'liactive' : '' ?>">
                <a class="a-lv-1" href="<?= Url::to(['/product/product/category', 'id' => $menu['id'], 'alias' => $menu['alias']]) ?>"><?= $menu['name'] ?></a>
                <?php 
                    writeUl($menu['items'],2);
                ?>
            </div>
        <?php } ?>
    </div>
<?php  } ?>