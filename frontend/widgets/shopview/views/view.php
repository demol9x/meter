<?php use yii\helpers\Url;?>
<?php if(isset($data) && $data){?>
<?php
foreach ($data as $key) {
    $url= Url::to(['/user/user/detail','id'=>$key['user_id']]);
    $avatar_path = \common\components\ClaHost::getImageHost() . '/imgs/default.png';
    if (isset($key['user']['avatar_path']) && $key['user']['avatar_path']) {
        $avatar_path = \common\components\ClaHost::getImageHost() . $key['user']['avatar_path'] . $key['user']['avatar_name'];
    }
    ?>
    <div class="pro_card wow fadeIn">
        <a href="<?=  $url ?>">
            <div class="card_img">
                <img src="<?= $avatar_path ?>" alt="<?= $key['name'] ?>">
            </div>
            <div class="card_text">
                <div class="title"><?= $key['name'] ?></div>
                <div class="adress"><span><?= isset($key['province']['name'])&&$key['province']['name'] ? $key['province']['name']: 'Đang cập nhật'?></span>
                    <?php
                    if (isset($key['rate']) && $key['rate']) { ?>
                        <span><i class="fas fa-star"></i><?php echo $key['rate'] ?>/5</span>
                    <?php }
                    else{?>
                        <span><i class="fas fa-star"></i>0/5</span>
                        <?php }?>
                </div>
            </div>
            <?php if(isset($key['is_hot']) && $key['is_hot']==1){?>
            <div class="hot_product"><img src="<?= yii::$app->homeUrl?>images/hot_product.png" alt=""></div>
        <?php }?>
        </a>
        <label class="heart">
            <a data-id="<?= $key['user_id'] ?>"
               class="iuthik1 tho_like <?= in_array($key['user_id'], $us_wish) ? 'active' : '' ?>"><i
                        class="fas fa-heart"></i></a>
        </label>
    </div>
<?php } ?>
<?php } ?>



