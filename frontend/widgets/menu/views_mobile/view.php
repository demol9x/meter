<?php

use common\components\ClaHost;

$controller = Yii::$app->controller->id;
$action = Yii::$app->controller->action->id;
$class = '';
// if ($controller == 'site' && $action == 'index') {
//     $class = 'active';
// }
?>

<?php if (isset($data) && $data) { ?>
    <ul>
        <?php
        $i = 0;
        foreach ($data as $menu_lv1) {
            $i++;
            $name = Trans($menu_lv1['name'], $menu_lv1['name_en']);
            ?>
            <li class="<?= $i == 1 ? $class : '' ?> <?= $menu_lv1['active'] ? 'active' : '' ?>">
                <a href="<?= $menu_lv1['link'] ?>"
                   title="<?= $name ?>"><span><?= $name ?></span></a>
                   <?php write_ul($menu_lv1, $cap = 2) ?>
            </li>
        <?php } ?>
        <li class="gold-price">
            <a href="<?= \yii\helpers\Url::to(['/site/gold'])  ?>"><?= Yii::t('app', 'gold_price') ?></a>
            <ul>
                <?php 
                    $gold = \common\models\product\ProductCurrency::getGoldIndex();
                    if($gold) foreach ($gold as $value) {
                    ?>
                    <li><?= $value['name'] .': '. number_format($value['price_buy'], 0, ',', '.') ?> Đ</li>
                <?php } ?>
                <li><?= Yii::t('app', 'last_update_on'),' '.date('d/m/Y', time()) ?> </li>
            </ul>
        </li>
    </ul>
<?php } ?>

<?php 
    function write_ul($data, $cap = 1) { 
        if (isset($data['items']) && count($data['items'])) {
            echo '<ul>';
            foreach ($data['items'] as $item) { 
                $name2 = Trans($item['name'], $item['name_en']);
                ?>
                <li class="<?= $item['active'] ? 'active' : '' ?>">
                    <a href="<?= $item['link'] ?>"
                       title="<?= $name2 ?>"><span><?= $name2 ?></span>
                    </a>
                    <?php 
                        if (isset($item['items']) && count($item['items']))  write_ul($item, $cap+1);
                    ?>
                </li>
            <?php }
            echo '</ul>';
        }
    }
?>

