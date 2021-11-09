<?php
use yii\helpers\Url;
?>

<?php if (isset($data) && $data) { ?>
 <div class="bot-footer">
        <h2><?= Yii::t('app', 'menu_product') ?></h2>
    <div class="list-cate-footer">
        <?php $i=0; $len =  count($data); foreach ($data as $menu) { $i++; ?>
            <a href="<?= Url::to(['/product/product/category', 'alias' => $menu['alias'], 'id' => $menu['id']]) ?>"><?= $menu['name'] ?><?= ($len == $i) ? '.' : ',' ?> </a>
        <?php } ?>
    </div>
</div>
<?php } ?>

