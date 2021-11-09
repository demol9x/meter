<?php 
use yii\helpers\Url;
?>
<div class="result">
    <ul>
        <?php if($data) {
            foreach ($data as $shop) { ?>
                <li class="result-item">
                    <a href="<?= Url::to(['/shop/shop/detail', 'id' => $shop['id'], 'alias' => $shop['alias'] ]) ?>" title="<?= $shop['name'];?>"><?= $shop['name']; ?></a>
                </li>
            <?php }
        } else { ?>
        <li class="not-found-search"><?= Yii::t('app', 'havent_shop_for_keyword') ?></li>
        <?php } ?>
    </ul>
</div>