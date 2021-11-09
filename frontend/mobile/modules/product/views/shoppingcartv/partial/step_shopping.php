<?php

use yii\helpers\Url;
?>
<div class="list-process-payment">
    <ul>
        <li class="<?= isset($active) && $active >= 1 ? 'active' : '' ?> <?= isset($active) && $active == 1 ? 'current' : '' ?>">
            <a href="">
                <img src="<?= Url::home() ?>images/process-1.png" alt="">
                <span><?= Yii::t('app', 'login') ?></span>
            </a>
        </li>
        <li class="<?= isset($active) && $active >= 2 ? 'active' : '' ?> <?= isset($active) && $active == 2 ? 'current' : '' ?>">
            <a href="<?= Url::to(['/product/shoppingcart/index']) ?>">
                <img src="<?= Url::home() ?>images/process-2.png" />
                <span><?= Yii::t('app', 'shoppingcart') ?></span>
            </a>
        </li>
        <li class="<?= isset($active) && $active >= 3 ? 'active' : '' ?> <?= isset($active) && $active == 3 ? 'current' : '' ?>">
            <a href="<?= Url::to(['/product/shoppingcart/ship-address']) ?>">
                <img src="<?= Url::home() ?>images/process-3.png" />
                <span><?= Yii::t('app', 'ship_address') ?></span>
            </a>
        </li>
        <li class="<?= isset($active) && $active >= 4 ? 'active' : '' ?> <?= isset($active) && $active == 4 ? 'current' : '' ?>">
            <a href="<?= Url::to(['/product/shoppingcart/checkout']) ?>">
                <img src="<?= Url::home() ?>images/process-4.png" />
                <span><?= Yii::t('app', 'step_4') ?></span>
            </a>
        </li>
    </ul>
</div>