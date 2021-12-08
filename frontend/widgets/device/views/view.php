<?php

use common\models\product\Product;
use yii\helpers\Url;
?>

<?php
if (isset($data) && $data) {
    ?>
    <div class="pro_package">
        <div class="pro_content">
            <div class="content_text"><h3>thiết bị công nghiệp</h3></div>
            <a class="content_viewall" href="<?= Url::to(['/product/product/index'])?>"><span>Xem tất cả</span><i class="far fa-chevron-right"></i></a>
        </div>
        <div class="pro_flex">
            <?php
            $i=1;
            foreach ($data as $key) {
                $i++;
                $price_market = $key['price_market'];
                $text_price_market = Product::getTextByPriceCustom($key['price_market']);
                $price = $key['price'];
                $text_price = Product::getTextByPriceCustom($key['price']);
                $avatar_path = \common\components\ClaHost::getImageHost() . '/imgs/default.png';
                if (isset($key['avatar_path']) && $key['avatar_path']) {
                    $avatar_path = \common\components\ClaHost::getImageHost() . $key['avatar_path'] . $key['avatar_name'];
                }
                $link = \yii\helpers\Url::to(['/product/product/detail', 'id' => $key['id'], 'alias' => $key['alias']]);
                ?>
                <div class="pro_card wow fadeIn" data-wow-delay="0.<?= $i ?>s">
                    <a href="<?= $link ?>">
                        <div class="card_img">
                            <img src="<?= $avatar_path ?>" alt="">
                        </div>
                        <div class="card_text">
                            <div class="title">
                                <?= isset($key['name']) && $key['name'] ? $key['name'] : 'Đang cập nhật' ?>
                            </div>
                            <div class="pro_price"><span><?php echo $text_price ?></span><span><?php echo $text_price_market ?></span></div>
                            <div class="pro_exchange"><span><i class="fas fa-star"></i><?= $key['rate_count'] ?  $key['rate_count'] : 0 ?>/5</span><span>Đã bán <?= $key['total_buy'] ?></span></div>
                        </div>
                    </a>
                    <label class="heart wishlist">
                        <?php if (isset(Yii::$app->user->id) && Yii::$app->user->id) { ?>
                            <?php if (Product::inWish2($key['id'])) { ?>
                                <a class="iuthik1  active" onclick="removeLike(<?= $key['id'] ?>, $(this));" alt="Xóa khỏi danh sách yêu thích"> <i class="fas fa-heart"></i></a>
                            <?php } else { ?>
                                <a class="iuthik1" onclick="addLike(<?= $key['id'] ?>, $(this));" alt="Thêm vào yêu thích"> <i class="fas fa-heart"></i></a>
                            <?php } ?>
                        <?php } else { ?>
                            <a class="iuthik1" onclick="loginLike($(this));" alt="Thêm vào yêu thích"> <i class="fas fa-heart"></i></a>
                        <?php } ?>
                    </label>
                    <?php if (isset($key['ishot']) && $key['ishot'] == 1 ) { ?>
                        <div class="hot_product"><img src="<?= yii::$app->homeUrl ?>images/hot_product.png" alt="icon"></div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>