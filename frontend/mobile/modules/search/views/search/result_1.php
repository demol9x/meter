<?php 
use yii\helpers\Url;
?>
<div class="result">
    <ul>
        <?php if($data) {
            foreach ($data as $product) { ?>
                <li class="result-item">
                    <a href="<?= Url::to(['/product/product/detail', 'id' => $product['id'], 'alias' => $product['alias'] ]) ?>" title="<?= $product['name'];?>"><?= $product['name']; ?></a>
                </li>
            <?php }
        } else { ?>
        <li class="not-found-search"><?= Yii::t('app', 'havent_product_for_keyword') ?></li>
        <?php } ?>
    </ul>
</div>