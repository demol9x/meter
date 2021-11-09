<?php

use yii\helpers\Url;

$id_brand = Yii::$app->request->get('id', 0);
$brand = common\models\product\Brand::findOne($id_brand);
?>
    <?php if (isset($data) && $data) { ?>
    <div class="sibar-cate">
    <?php foreach ($data as $item) { 
        $name = Trans($item['name'], $item['name_en']);
        ?>
            <h2 class="<?= $item['active'] ? 'active' : '' ?>">
                <a href="<?= Url::to(['/product/product/brand-category', 'id' => $id_brand, 'alias' => $brand['alias'], 'cat_id' => $item['id'], 'cat_alias' => $item['alias']]) ?>" title="<?= $name ?>"><?= $name ?></a>
            </h2>
                <?php if (isset($item['children']) && $item['children']) { ?>
                <ul>
                    <?php foreach ($item['children'] as $cat) { 
                        $cat_name = Trans($cat['name'], $cat['name_en']);
                        ?>
                        <li><a href="<?= Url::to(['/product/product/brand-category', 'id' => $id_brand, 'alias' => $brand['alias'], 'cat_id' => $cat['id'], 'cat_alias' => $cat['alias']]) ?>" title="<?= $cat_name ?>"><?= $cat_name ?></a></li>
                <?php } ?>
                </ul>
        <?php } ?>
    <?php } ?>
    </div>
<?php } ?>