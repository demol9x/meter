<?php

use yii\helpers\Url;
?>
<div class="list-skip-link">
    <ul>
        <li class="btn-show-cate-mobile">
            <div class="ico">
                <img src="<?= Yii::$app->homeUrl ?>images/03.png" alt="<?= Yii::t('app', 'all_menu') ?>">
            </div>
            <div class="title">
                <h2>
                    <a><?= Yii::t('app', 'all_menu') ?></a>
                </h2>
            </div>
        </li>
        <li class="btn-show-store-mobile">
            <div class="ico">
                <a  href="<?= Url::to(['/site/sell-with-gca']) ?>"><img src="<?= Yii::$app->homeUrl ?>images/04.png" alt="<?= Yii::t('app', 'sale_with_gca') ?>"></a>
            </div>
            <div class="title">
                <h2>
                    <a href="<?= Url::to(['/site/sell-with-gca']) ?>"><?= Yii::t('app', 'sale_with_gca') ?></a>
                </h2>
            </div>
        </li>
        <li class="btn-show-search-mobile">
            <div class="ico">
                <a target="_blank"  href="https://gcaeco.com/">
                    <img src="<?= Yii::$app->homeUrl ?>images/02.png" alt="<?= Yii::t('app', 'find_location_product') ?>">
                </a>
            </div>
            <div class="title">
                <h2>
                    <a target="_blank"  href="https://gcaeco.com/"><?= Yii::t('app', 'find_location_product') ?></a>
                </h2>
            </div>
        </li>
        <li class="btn-show-store-mobile">
            <div class="ico">
                <a target="_blank" href="https://member.gcaeco.vn/">
                    <img src="<?= Yii::$app->homeUrl ?>images/icon_card.png" alt="<?= Yii::t('app', 'member_card') ?>">
                </a>
            </div>
            <div class="title">
                <h2>
                    <a target="_blank" href="https://member.gcaeco.vn/"><?= Yii::t('app', 'member_card') ?></a>
                </h2>
            </div>
        </li>
    </ul>
</div>