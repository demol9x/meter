<?php

use yii\helpers\Url;
use common\components\ClaHost;
$province = \common\models\Province::optionsProvince();
?>
<?php if(isset($shops) && $shops) {
    $dv = Yii::t('app', 'm');
    $dvkm = Yii::t('app', 'km');
    foreach ($shops as $shop) {
        $url = \yii\helpers\Url::to(['/shop/shop/detail', 'id' => $shop['id'], 'alias' => $shop['alias']]);
        $text_star = '';
        for ($i = 1; $i < 6; $i++) { 
            $text_star .= '<span class="fa fa-star'. (($shop['rate'] >= $i) ? '' : '-o').' yellow"></span>';
            $src = $shop['avatar_path'] ? ClaHost::getImageHost(). $shop['avatar_path'].'s100_100/'. $shop['avatar_name'] : ClaHost::getImageHost().'/imgs/shop_default.png';
        } 
        ?>
            <div class="item-address move-position-<?= $shop['id']  ?>"  id="open-item-<?= $shop['id'] ?>">
                <div class="img">
                    <a href="<?= $url ?>">
                        <img src="<?= $src ?>" alt="<?= $shop['name'] ?>" />
                    </a>
                </div>
                <div class="title">
                    <h2>
                        <a href="<?= $url ?>" title="<?= $shop['name'] ?>"><?= $shop['name'] ?></a>
                    </h2>
                    <div class="review">
                        <div class="star">
                            <?= $text_star ?>
                            <span><?= $shop['rate_count'] ? '(' . $shop['rate_count'] . ')' : '' ?></span>
                        </div>
                    </div>
                    <div class="location">
                        <i class="fa fa-map-marker"></i> 
                        <?= $province[$shop['province_id']] ?>
                    </div>
                </div>
                <?php if(isset($shop['distance'])) { ?>
                    <button class="btn-distance"  id="chiduong-<?= $shop['id'] ?>">
                        <img src="<?= Yii::$app->homeUrl ?>images/map-marker-icon.png" alt="">
                        <span>
                            <?php if($shop['distance'] > 1000) { ?>
                                <?= number_format($shop['distance']/1000, 1, ',', '.').$dvkm ?>
                            <?php } else { ?>
                                <?= number_format($shop['distance'], 0, ',', '.').$dv ?>
                            <?php } ?> 
                        </span>
                    </button>
                <?php } ?>
            </div>
    <?php } ?>
<?php } ?>