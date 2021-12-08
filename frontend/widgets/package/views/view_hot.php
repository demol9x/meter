<?php

use common\components\ClaMeter;
use yii\helpers\Url;
use common\components\ClaHost;
use common\models\Province;
if (isset($package) && $package) {

?>
    <div class="pro_package">
        <div class="pro_content">
            <div class="content_text"><h3>gói thầu</h3></div>
            <a class="content_viewall" href="<?php echo Url::to(['/package/package/index'])?>"><span>Xem tất cả</span><i class="far fa-chevron-right"></i></a>
        </div>
        <div class="pro_flex">
            <?php
            foreach ($package as $packages) {

                $avatar_path = \common\components\ClaHost::getImageHost() . '/imgs/default.png';
//                if(Yii::$app->user->id){
////                    $user_add= \common\models\user\UserAddress::findOne(['user_id'=>Yii::$app->user->id,'isdefault'=>1]);
////                    $addres=explode(',',$user_add['latlng']);
////                    $addres_pack= explode(',',$packages['latlng']);
////                    if($addres && $addres_pack){
////                        $data = (int)ClaMeter::betweenTwoPoint($addres[0], $addres[1], $addres_pack[0], $addres_pack[1]) . 'km';
////                    }
////                    else{
////                        $data=0  ;
////                    }
//
//                }
                $url = \yii\helpers\Url::to(['/package/package/detail', 'id' => $packages['id'], 'alias' => $packages['alias']]);
                ?>
                <div class="pro_card wow fadeIn"  data-wow-delay="0.3s">
                    <a href="<?= $url ?>">
                        <div class="card_img">
                            <img src="<?= isset($packages) && $packages['avatar_path'] ? ClaHost::getImageHost(). $packages['avatar_path']. $packages['avatar_name'] : $avatar_path  ?>" alt="<?= $packages['name'] ?>">
                        </div>
                        <div class="card_text">
                            <div class="title"><?= $packages['name'] ?></div>
                            <?php $provin= Province::findOne($packages['province_id']) ; ?>
                            <div class="adress"><span><?= $provin->name ?></span>
                                <?php if(isset($km_shop) && $km_shop){
                                    $km_qd= explode(',',$packages['latlng']);
                                    ?>
                                    <span>
                                    <?php
                                    if (isset($km_qd) && $km_qd) {
                                        ?>
                                        <?php echo (int)ClaMeter::betweenTwoPoint($km_shop[0], $km_shop[1], $km_qd[0], $km_qd[1]) . 'km'; ?>
                                    <?php } ?>
                                    </span>
                                <?php }?>
                                </div>
                            <div class="date_time"><img src="<?= Yii::$app->homeUrl ?>images/time_pro.png" alt=""><span><?= date('d',$packages['created_at'])?></span>/<span><?= date('m',$packages['created_at'])?></span>/<span><?= date('Y',$packages['created_at'])?></span></div>
                        </div>
                    </a>
                    <label class="heart">
                        <a data-id="<?= $packages['id'] ?>"
                           class="iuthik1 iuthik_pack <?= in_array($packages['id'], $package_wish) ? 'active' : '' ?>"><i
                                    class="fas fa-heart"></i></a>
                    </label>
                    <?php if(isset($packages['ishot']) && $packages['ishot']==1){?>
                    <div class="hot_product"><img src="<?= Yii::$app->homeUrl ?>images/hot_product.png" alt=""></div>
                    <?php }?>
                </div>
            <?php }?>
        </div>
    </div>
<?php } ?>
<script>
    $(".iuthik_pack").click(function () {
        var t = $(this);
        var package_id = $(this).data('id');
        $.ajax({
            url: "<?= yii\helpers\Url::to(['/package/package/add-like']) ?>",
            type: "get",
            data: {"package_id": package_id},
            success: function (response) {
                var data = JSON.parse(response);
                if (data.success) {
                    t.toggleClass('active');
                } else {
                    alert(data.message)
                }

            },
        });
    });
</script>
