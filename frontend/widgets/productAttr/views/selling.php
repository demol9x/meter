<?php

use yii\helpers\Url;
use common\components\ClaHost;

if (isset($products) && $products) {
    ?>
    <div class="best-sell-product flex-col flex-right">
        <h2>
            <?= $title ?>
        </h2>
        <ul>
            <?php foreach ($products as $product) {
                $url = Url::to(['/product/product/detail', 'id' => $product['id'], 'alias' => $product['alias']]);
                ?>
                <li>
                    <div class="img">
                        <a href="<?= $url ?>" title="<?= $product['name'] ?>">
                            <img  src="<?= ClaHost::getImageHost(), $product['avatar_path'], 's100_100/', $product['avatar_name'] ?>" />
                        </a>
                    </div>
                    <div class="title">
                        <h3><a href="<?= $url ?>"><?= $product['name'] ?></a></h3>
                        <span class="price"><?= ($product['price'] > 0) ? number_format($product['price'], 0, ',', '.'). ' '.Yii::t('app', 'currency') : Yii::t('app', 'contact') ?>  </span>
                    </div>
                </li>
            <?php } ?>
        </ul>
    </div>
<?php } ?>
 