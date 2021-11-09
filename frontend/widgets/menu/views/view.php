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
    <?php
    foreach ($data as $menu_lv1) {
        ?>
        <li class="list <?php isset($menu_lv1['active'] )&& $menu_lv1['active'] ? 'active' : '' ?>"><a href="<?= $menu_lv1['link'] ?>"><?= $menu_lv1['name'] ?></a></li>
    <?php   }?>
<?php } ?>







