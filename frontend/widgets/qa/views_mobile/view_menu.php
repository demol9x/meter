<?php 
use  yii\helpers\Url;

function writeUl($data, $index) {
    if(isset($data['active'])) unset($data['active']);
    if($data) {
            foreach ($data as $value) {
                $name = $value['name'];
                echo '<div class="menu-bar-lv-'.$index.($value['active'] ? ' liactive' : '').'">
                    <a  class="a-lv-'.$index.'" href="'.Url::to(['/qa/qa/category', 'id' => $value['id'], 'alias' => $value['alias']]).'">'.$name.'</a>';
                if($value['items']) {
                    writeUl($value['items'], $index+1);
                } 
                echo '</div>';
            }
        echo '<span class="span-lv-'.($index-1).' fa fa-angle-down"></span>';
    }
}
?>
<?php if (isset($data) && $data) { ?>
    <h3 style="font-size: 20px;font-weight: 600;color: #333333;margin: 30px 0px 30px 0px;">Danh mục</h3>
    <div class="menu-bar-store" tabindex="-1">
        <?php foreach ($data as $menu) {?>
            <div  class="menu-bar-lv-1 <?= ($menu['active']) ? 'liactive' : '' ?>">
                <a class="a-lv-1" href="<?= Url::to(['/qa/qa/category', 'id' => $menu['id'], 'alias' => $menu['alias']]) ?>"><?= $menu['name'] ?></a>
                <?php 
                    writeUl($menu['items'],2);
                ?>
            </div>
        <?php } ?>
    </div>
<?php  } ?>