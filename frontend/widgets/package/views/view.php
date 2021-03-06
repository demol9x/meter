<?php
use common\components\ClaHost;
use common\models\Province;
if(isset($package) && $package){
unset($package[0]);
?>
<div class="pro_similar">
    <div class="pro_package">
        <div class="pro_content">
            <div class="content_text">
                <h3>gói thầu tương tự</h3>
            </div>
        </div>
        <div class="pro_flex item-list-sp">
            <?php
                $i=3;
                foreach ($package as $key ){
                $url = \yii\helpers\Url::to(['/package/package/detail', 'id' => $key['id'], 'alias' => $key['alias']]);
                $i+3;
            ?>
            <div class="pro_card wow fadeIn" data-wow-delay="0.<?= $i ?>s">
                <a href="<?= $url ?>">
                    <div class="card_img">
                        <img src="<?= ClaHost::getImageHost(), $key['avatar_path'], $key['avatar_name'] ?>" alt="<?= $key['name']?>">
                    </div>
                    <div class="card_text">
                        <div class="title"><?= $key['name']?></div>
                        <?php $provin= Province::findOne($key['province_id']) ; ?>
                        <div class="adress"><span><?= $provin->name ?></span><span>60km</span></div>
                        <div class="date_time"><span><img src="<?= yii::$app->homeUrl?>images/time_pro.png" alt=""><?= date('d',$key['created_at'])?>/<?= date('m',$key['created_at'])?>/<?= date('Y',$key['created_at'])?></span></div>
                    </div>
                </a>
                <label class="heart">
                    <input class="Dashboard" name="" type="checkbox">
                    <div class="check">
                        <span class="iuthik1 active"><img class="img_add_tim" src="<?= yii::$app->homeUrl?>images/tim.png" alt=""></span>
                        <span class="iuthik2"><i class="fas fa-heart"></i></span>
                    </div>
                </label>
                <?php if(isset($key['ishot']) && $key['ishot']==1){?>
                    <div class="hot_product"><img src="<?= Yii::$app->homeUrl ?>images/hot_product.png" alt=""></div>
                <?php }?>
            </div>
            <?php }?>
        </div>
    </div>
</div>
<?php }?>