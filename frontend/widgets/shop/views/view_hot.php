<?php

use yii\helpers\Url;
use common\components\ClaHost;

if (isset($shop) && $shop) {

 ?>
<div class="pro_package">
    <div class="pro_content">
        <div class="content_text"><h3>nhà thầu</h3></div>
        <a class="content_viewall" href="<?= Url::to(['/shop/shop/index'])?>"><span>Xem tất cả</span><i class="far fa-chevron-right"></i></a>
    </div>
    <div class="pro_flex">
    <?php
    $i=1;
    foreach ($shop as $shopt) {
        $i+2;
        $url = \yii\helpers\Url::to(['/shop/shop/detail', 'id' => $shopt['user']['id'], 'alias' => $shopt['alias']]);
        $avatar_path = \common\components\ClaHost::getImageHost() . '/imgs/default.png';
        if (isset($shopt['avatar_path']) && $shopt['avatar_path']) {
            $avatar_path = \common\components\ClaHost::getImageHost() . $shopt['avatar_path'] . $shopt['avatar_name'];
        }
        ?>
        <div class="pro_card wow fadeIn"  data-wow-delay="0.<?= $i ?>s">
            <a href="<?= $url ?>">
                <div class="card_img">
                    <img src="<?= $avatar_path ?>" alt="<?= $shopt['name'] ?>">
                </div>
                <div class="card_text">
                    <div class="title"><?= $shopt['name'] ?></div>
                    <div class="adress"><span><?= isset($shopt['province_id'])&& $shopt['province_id'] ?$shopt['province']['name']: 'Đang cập nhật' ?></span>
                        <?php if(isset($shopt['rate']) && $shopt['rate']){?>
                        <span><i class="fas fa-star"></i><?= $shopt['rate'] ?>/5</span>
                    <?php }?>
                    </div>
                </div>
            </a>
            <label class="heart">
                <a data-id="<?= $shopt['user_id'] ?>"
                   class="iuthik1 iuthik_shop <?= in_array($shopt['user_id'], $us_wish) ? 'active' : '' ?>">
                    <i class="fas fa-heart"></i></a>
            </label>
            <?php
            if(isset($shopt['is_hot']) && $shopt['is_hot']==1){
                ?>
                <div class="hot_product"><img src="<?php Yii::$app->homeUrl ?>images/hot_product.png" alt=""></div>
            <?php } ?>
        </div>
    <?php }?>
    </div>
</div>
<?php } ?>
<script>
    $(".iuthik_shop").click(function (){
        var t = $(this);
        var dn_id = $(this).data('id');
        $.ajax({
            url: "<?= yii\helpers\Url::to(['/shop/shop/add-like']) ?>",
            type: "get",
            data: {"dn_id": dn_id},
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
