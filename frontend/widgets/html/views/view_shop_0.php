<?php

use yii\helpers\Url;
use common\components\ClaHost;
use common\models\Region;
$shop = \common\models\shop\Shop::optionsShop();
?>
<?php if(isset($shops) && $shops) {
    foreach ($shops as $shop) {
        $url = \yii\helpers\Url::to(['/shop/shop/detail', 'id' => $shop['id'], 'alias' => $shop['alias']]);
        if(isset($shop['count_product'])) {
            $count_product = $shop['count_product'];
        } else {
            $count_product = 0;
        }
        ?>
        <div class="item-info-donhang">
            <div class="title">
                <div class="img">
                    <a href="<?= $url ?>">
                        <img src="<?= ClaHost::getImageHost(), $shop['avatar_path'],'s100_100/', $shop['avatar_name'] ?>" alt="<?= $shop['name'] ?>" />
                        <?= $shop['name'] ?>
                    </a>
                </div>
                <div class="btn-view-shop">
                    <a href="<?= $url ?>"><i class="fa fa-home"></i><?= Yii::t('app', 'view_shop') ?></a>
                </div>
                <?php if($shop['level'] > 1) { ?>
                    <div class="code-donhang">
                        <p class="success-order">
                            <i class=""><i class="fa fa-check-circle" aria-hidden="true"></i> <?= Yii::t('app', 'shop_gold') ?></i>
                        </p>
                    </div>
                <?php } ?>
            </div>
            <div class="table-donhang table-shop">
                <div class="see-store-w">
                    <div class="some-product">
                        <div class="slide-some-product owl-carousel owl-theme">
                            <?php 
                                $list_name = '';
                                if($products[$shop['id']]) {
                                    foreach ($products[$shop['id']] as $product) {
                                        $urlp = Url::to(['/product/product/detail', 'id' => $product['id'], 'alias' => $product['alias']]);
                                        $text = '<a href="'.$urlp.'">'.$product['name'].'</a>';
                                        $list_name .= $list_name ? ', '.$text : $text; 
                                        ?>
                                        <div class="product">
                                            <div class="img-thumb">
                                                <a href="<?= $urlp ?>">
                                                    <img src="<?= ClaHost::getImageHost(), $product['avatar_path'],'s400_400/', $product['avatar_name'] ?>" alt="<?= $product['name'] ?>" />
                                                </a>
                                            </div>
                                            <h3>
                                                <a href="<?= $urlp ?>"><?= $product['name'] ?></a>
                                            </h3>
                                        </div>
                                    <?php }
                                } 
                            ?>
                        </div>
                    </div>
                    <div class="attrs">
                         <div class="attr">
                            <span class="name"><?= Yii::t('app', 'shop_name') ?></span>
                            <div class="value">
                                <a href="<?= $url ?>"><?= $shop['name'] ?></a>
                            </div>
                        </div>
                        <div class="attr">
                            <span class="name"><?= Yii::t('app', 'main_products') ?></span>
                            <div class="value">
                                <?= $list_name ?>
                                <?= $count_product > 5 ? '...' : '' ?>
                                (<?= $count_product ?>)
                            </div>
                        </div>
                        <div class="attr">
                            <span class="name"><?= Yii::t('app', 'address') ?>:</span>
                            <div class="value">
                                <?= $shop['address'] ?>
                            </div>
                        </div>
                        <div class="attr">
                            <span class="name"><?= Yii::t('app', 'email') ?>:</span>
                            <div class="value">
                                <?= $shop['email'] ?>
                            </div>
                        </div>
                        <div class="attr">
                            <span class="name"><?= Yii::t('app', 'phone') ?>:</span>
                            <div class="value">
                                <?= $shop['phone'] ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
<?php } ?>