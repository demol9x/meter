<?php
use yii\helpers\Url;
use common\components\ClaHost;
use common\models\Province;
if (isset($package) && $package) {
?>
    <div class="pro_package">
        <div class="pro_content">
            <div class="content_text"><h3>gói thầu</h3></div>
            <a class="content_viewall" href=""><span>Xem tất cả</span><i class="far fa-chevron-right"></i></a>
        </div>
        <div class="pro_flex">
            <?php
            foreach ($package as $packages) {
                $url = \yii\helpers\Url::to(['/package/package/detail', 'id' => $packages['id'], 'alias' => $packages['alias']]);
                ?>
                <div class="pro_card wow fadeIn"  data-wow-delay="0.3s">
                    <a href="<?= $url ?>">
                        <div class="card_img">
                            <img src="<?= ClaHost::getImageHost(), $packages['avatar_path'], $packages['avatar_name'] ?>" alt="<?= $packages['name'] ?>">
                        </div>
                        <div class="card_text">
                            <div class="title"><?= $packages['name'] ?></div>
                            <?php $provin= Province::findOne($packages['province_id']) ; ?>
                            <div class="adress"><span><?= $provin->name ?></span><span>60km</span></div>
                            <div class="date_time"><img src="<?= Yii::$app->homeUrl ?>images/time_pro.png" alt=""><span><?= date('d',$packages['created_at'])?></span>-<span><?= date('m',$packages['created_at'])?></span>-<span><?= date('Y',$packages['created_at'])?></span></div>
                        </div>
                    </a>
                    <label class="heart">
                        <input class="Dashboard" name="" type="checkbox">
                        <div class="check">
                            <span class="iuthik1 active"><img class="img_add_tim" src="<?= Yii::$app->homeUrl ?>images/tim.png" alt=""></span>
                            <span class="iuthik2"><i class="fas fa-heart"></i></span>
                        </div>
                    </label>
                    <?php if(isset($packages['ishot']) && $packages['ishot']==1){?>
                    <div class="hot_product"><img src="<?= Yii::$app->homeUrl ?>images/hot_product.png" alt=""></div>
                    <?php }?>
                </div>
            <?php }?>
        </div>
    </div>
<?php } ?>