<?php if (isset($data) && $data) { ?>
    <ul>
        <?php foreach ($data as $menu) { ?>
        <li><a href="<?= yii\helpers\Url::to(['/news/news/category', 'id' => $menu['id'], 'alias' => $menu['alias']]) ?>"><?= Trans($menu['name'],$menu['name_en']); ?></a></li>
        <?php } ?>
    </ul>
<?php } ?>
