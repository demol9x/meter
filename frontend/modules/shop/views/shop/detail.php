<link rel="stylesheet" href="<?= yii::$app->homeUrl ?>css/chitietnhathau.css">
<?php


?>
<div class="site51_prodel_col12_chitietnhathau">
    <div class="container_fix">
        <div class="breadcrumb">
            <a href="/" title="" class="main content_16">Trang chủ</a>
            <a href="<?= \yii\helpers\Url::to(['/shop/shop/index']) ?>" title="" class="main content_16">Nhà thầu</a>
            <a href="" title="" class="main content_16"><?= $data['name'] ?></a>
        </div>
        <div class="pro_detail">
            <div class="detail_left wow fadeInLeft" data-wow-duration="3s"
                 style="visibility: visible; animation-duration: 3s;">
                <div class="left_env">
                    <div class="slide_detail_on">
                        <?php if ($data['images']): ?>
                            <?php foreach ($data['images'] as $image): ?>
                                <div class="img_detail">
                                    <a data-fancybox="gallery"
                                       href="<?= \common\components\ClaHost::getImageHost() . $image['path'] . $image['name'] ?>">
                                        <img src="<?= \common\components\ClaHost::getImageHost() . $image['path'] . $image['name'] ?>" alt="">
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="img_detail">
                                <?php
                                $avatar_path = \common\components\ClaHost::getImageHost() . '/imgs/default.png';
                                if (isset($data['avatar_path']) && $data['avatar_path']) {
                                    $avatar_path = \common\components\ClaHost::getImageHost() . $data['avatar_path'] .$data['avatar_name'];
                                }
                                ?>
                                <a data-fancybox="gallery"
                                   href="<?=  $avatar_path ?>">
                                    <img src="<?=  $avatar_path ?>" alt="">
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="slide_detail_in">
                        <?php if ($data['images']): ?>
                            <?php foreach ($data['images'] as $image): ?>
                                <div class="img_detail_1">
                                    <a data-fancybox="gallery"
                                       href="<?= \common\components\ClaHost::getImageHost() . $image['path'] . $image['name'] ?>">
                                        <img src="<?= \common\components\ClaHost::getImageHost() . $image['path'] . $image['name'] ?>"
                                             alt="">
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="img_detail_1">
                                <a data-fancybox="gallery"
                                   href="<?=  $avatar_path ?>">
                                    <img src="<?=  $avatar_path ?>"
                                         alt="">
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="detail_right wow fadeInRight" data-wow-duration="3s"
                 style="visibility: visible; animation-duration: 3s;">
                <div class="content">
                    <div class="title title_28">
                        <?= $data['name'] ?>
                    </div>
                    <div class="item-options">
                        <div class="star">
                            <div class="icon">
                                <i class='fa fa-star'></i>
                                <i class='fa fa-star'></i>
                                <i class='fa fa-star'></i>
                                <i class='fa fa-star'></i>
                                <i class='fa fa-star'></i>
                            </div>
                            <span><?= $data['rate'] ?></span>
                        </div>
                        <div class="description">
                            <i class="far fa-sticky-note"></i>
                            <span class="content_16">Số lần trúng thầu 15</span>
                        </div>
                    </div>
                </div>
                <div class="contact_info">
                    <div class="content_16_b">Thông tin liên hệ:</div>
                    <div class="contact_row">
                        <img src="<?= yii::$app->homeUrl ?>images/img_detail_home.png" alt="">
                        <a href="" class="content_16"><?= $data['name'] ?></a>
                    </div>
                    <div class="contact_row">
                        <i class="far fa-map-marker-alt"></i>
                        <span class="content_16"><?= $data['address']? $data['address'] :'Đang cập nhật' ?><?= $data['ward_name'] ? ', ' . $data['ward_name'] : '' ?><?= $data['district_name'] ? ', ' . $data['district_name'] : '' ?><?= $data['province_name'] ? ', ' . $data['province_name'] : '' ?></span>
                    </div>
                    <div class="contact_row">
                        <div class="contact_flex">
                            <div class="flex">
                                <i class="far fa-phone-alt"></i>
                                <a href="tel:<?= $data['phone'] ?>" class="content_16"><?= isset($data['phone']) && $data['phone']  ? $data['phone'] : 'Đang cập nhật'?></a>
                            </div>
                            <div class="flex">
                                <i class="far fa-envelope"></i>
                                <a href="mailto:<?= $data['email'] ?>" class="content_16"><?= $data['email'] ?></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="detail_des">
                    <span class="content_16_b">Giới thiệu:</span>
                    <span class="content_16"><?= $data['short_description'] ?></span>
                </div>
                <a id="chat-circle" class="detail_button btn-animation chatbox__button">
                    <img src="<?= yii::$app->homeUrl ?>images/chat_alt.png" alt=""><span class="content_16_b">Chat với nhà thầu</span>
                </a>
            </div>
        </div>
        <div class="pro_similar">
            <div class="pro_package">
                <nav class="van-tabs wow fadeInDown" data-wow-duration="3s">
                    <a class="back"></a>
                    <blockquote id="one" class="title_18 active">gói thầu đang chào<a href="" title="" id="one"></a>
                    </blockquote>
                    <blockquote id="two" class="title_18">công trình đã thực hiện<a href="" title="" id="TSKT"></a>
                    </blockquote>
                    <a class="continue"></a>
                </nav>
                <div class="pro_flex item-list-sp">
                    <?php if ($data['related']): ?>
                        <?php foreach ($data['related'] as $related):
                            $avatar = \common\components\ClaHost::getImageHost() . '/imgs/default.png';
                            if (isset($related['avatar_path']) && $related['avatar_path']) {
                                $avatar = \common\components\ClaHost::getImageHost() . $related['avatar_path'] . $related['avatar_name'];
                            }
                            ?>

                            <div class="pro_card wow fadeIn" data-wow-delay="0.2s">
                                <a href="<?= \yii\helpers\Url::to(['/package/package/detail', 'id' => $related['id']]) ?>">
                                    <div class="card_img">
                                        <img src="<?= $avatar ?>"
                                             alt="<?= $related['name'] ?>">
                                    </div>
                                    <div class="card_text">
                                        <div class="title"><?= $related['name'] ?></div>
                                        <div class="adress">
                                            <span><?= isset($related['province']) && $related['province'] ? $related['province']['name'] : 'Đang cập nhật' ?></span><span>60km</span>
                                        </div>
                                        <div class="date_time">
                                            <img src="<?= yii::$app->homeUrl ?>images/time_pro.png" alt="">
                                            <span><?= date('d-m-Y', $related['created_at']) ?></span>
                                        </div>
                                    </div>
                                </a>
                                <label class="heart">
                                    <a data-id="<?= $related['id'] ?>"
                                       class="iuthik1 package_wish <?= $related['is_wish'] ? 'active' : '' ?>"><i
                                                class="fas fa-heart"></i></a>
                                </label>
                                <?php if (isset($related['ishot']) && $related['ishot'] == 1) { ?>
                                    <div class="hot_product"><img
                                                src="<?= yii::$app->homeUrl ?>images/hot_product.png"
                                                alt=""></div>
                                <?php } ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="pro_main">
            <div class="pro_flex_left">
                <div class="nav_menu">
                    <a id="scroll_load_1" href="#" class="nav_list active title_18">giới thiệu nhà thầu</a>
                    <a id="scroll_load_2" href="#" class="nav_list title_18">HỒ SƠ CÔNG TY</a>
                    <a id="scroll_load_3" href="#" class="nav_list title_18">Đánh giá nhà thầu</a>
                </div>
                <div id="pro_desc_list" class="pro_description">
                    <?= $data['description'] ?>
                    <div class="button_position">
                        <a class="content_16 btn-animation">Xem thêm <i class="fas fa-chevron-down"></i></a>
                    </div>
                </div>
                <div id="pro_desc_list_1" class="pro_description_1">
                    <div class="pro_package">
                        <div class="pro_content">
                            <div class="content_text">
                                <h3>hồ sơ công ty</h3>
                            </div>
                        </div>
                        <div class="pro_flex">
                            <table>
                                <tr>
                                    <td>Tên Công ty</td>
                                    <td><?= $data['name'] ?></td>
                                </tr>
                                <tr>
                                    <td>Ngày thành lập</td>
                                    <td><?= $data['founding'] ? date('d-m-Y', $data['founding']) : 'Đang cập nhật' ?></td>
                                </tr>
                                <tr>
                                    <td>Mã số thuế</td>
                                    <td><?= $data['number_auth'] ? $data['number_auth'] : 'Đang cập nhật' ?></td>
                                </tr>
                                <tr>
                                    <td>Ngành nghề chính</td>
                                    <td><?= $data['business'] ? $data['business'] : 'Đang cập nhật' ?></td>
                                </tr>
                                <tr>
                                    <td>Số điện thoại</td>
                                    <td><?= $data['phone'] ? $data['phone'] : 'Đang cập nhật' ?></td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td><?= $data['email'] ? $data['email'] : 'Đang cập nhật' ?></td>
                                </tr>
                                <tr>
                                    <td>Website</td>
                                    <td><?= $data['website'] ? $data['website'] : 'Đang cập nhật' ?></td>
                                </tr>
                                <tr>
                                    <td>Địa chỉ</td>
                                    <td><?= $data['address'] ?><?= $data['ward_name'] ? ', ' . $data['ward_name'] : '' ?><?= $data['district_name'] ? ', ' . $data['district_name'] : '' ?><?= $data['province_name'] ? ', ' . $data['province_name'] : 'Đang cập nhật' ?></td>
                                </tr>
                                <tr>
                                    <td>Vốn điều lệ</td>
                                    <td><?= $data['price'] ? number_format($data['price']) . ' triệu' : 'Đang cập nhật' ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php if (isset($package_ishot) && $package_ishot) {?>
                <div class="pro_flex_right">
                    <div class="pro_package">
                        <div class="pro_content">
                            <div class="content_text">
                                <h3>nổi bật</h3>
                            </div>
                        </div>
                        <div class="pro_flex item-list-hot-deal">
                            <?php
                            foreach ($package_ishot as $key) {
                                $link = \yii\helpers\Url::to(['/package/package/detail', 'id' => $key['id'], 'alias' => $key['alias']]);
                                $avatar_path = \common\components\ClaHost::getImageHost() . '/imgs/default.png';
                                if (isset($key['avatar_path']) && $key['avatar_path']) {
                                    $avatar_path = \common\components\ClaHost::getImageHost() . $key['avatar_path'] . $key['avatar_name'];
                                }
                                ?>
                                <div class="pro_card wow fadeIn" data-wow-delay="0.1s">
                                    <a href="<?= $link ?>">
                                        <div class="card_img">
                                            <img src="<?= $avatar_path ?>" alt="<?= $key['name'] ?>">
                                        </div>
                                        <div class="card_text">
                                            <div class="title"><?= $key['name'] ?></div>
                                            <div class="adress"><span><?= $key['province']['name'] ?></span>
                                                <span>60km</span>
                                            </div>
                                            <div class="date_time">
                                    <span>
                                        <img src="<?= yii::$app->homeUrl ?>images/time_pro.png" alt="">
                                        <?= date('d-m-y', $key['created_at']) ?>
                                    </span>
                                            </div>
                                        </div>
                                    </a>
                                    <label class="heart">
                                        <a data-id="<?= $key['id'] ?>"
                                           class="iuthik1  package_wish <?= in_array($key['id'], $package_wish) ? 'active' : '' ?>"><i
                                                    class="fas fa-heart"></i></a>
                                    </label>
                                    <?php
                                    if (isset($key) && $key['ishot'] == 1) {
                                        ?>
                                        <div class="hot_product"><img
                                                    src="<?= yii::$app->homeUrl ?>images/hot_product.png"
                                                    alt=""></div>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>


    <?=
    \frontend\widgets\rating\RatingWidget::widget([
        'view' => 'view',
        'type' => \common\models\rating\Rating::TYPE_SHOP,
        'object_id' => $data['user_id'],
        'title' => 'Đánh giá nhà thầu',
        'rating' => [
            'rate' => $data['rate'],
            'rate_count' => $data['rate_count']
        ]
    ])
    ?>
    <?php if ($data['shop_more']):?>
        <div class="pro_slide">
            <div class="pro_package">
                <div class="pro_content">
                    <div class="content_text">
                        <h3>Nhà thầu khác</h3>
                    </div>
                </div>
                <div class="pro_flex slide_pro_active">
                    <?php foreach ($data['shop_more'] as $item):
                        $avatar_shop_1 = \common\components\ClaHost::getImageHost() . '/imgs/default.png';
                        if (isset($item['avatar_path']) && $item['avatar_path']) {
                            $avatar_shop_1 = \common\components\ClaHost::getImageHost() . $item['avatar_path'] . $item['avatar_name'];
                        }
                        ?>
                        <div class="pro_card wow fadeIn" data-wow-delay="0.2s">
                            <a href="<?= \yii\helpers\Url::to(['/shop/shop/detail', 'id' => $item['user_id']]) ?>">
                                <div class="card_img">
                                    <img src="<?= $avatar_shop_1 ?>"
                                         alt="<?= $item['name'] ?>">
                                </div>
                                <div class="card_text">
                                    <div class="title"><?= $item['name'] ?></div>
                                    <div class="adress">
                                        <span><?= isset($item['province']) && $item['province'] ? $item['province']['name'] : 'Đang cập nhật' ?></span><span><?= $item['rate'] ? $item['rate'] : 0 ?>/5</span>
                                    </div>
                                </div>
                            </a>
                            <label class="heart">
                                <a data-id="<?= $item['user_id'] ?>"
                                   class="iuthik1 shop_wish <?= $item['is_wish'] ? 'active' : '' ?>"><i
                                            class="fas fa-heart"></i></a>
                            </label>
                            <?php if (isset($related['ishot']) && $related['ishot'] == 1) { ?>
                                <div class="hot_product"><img
                                            src="<?= yii::$app->homeUrl ?>images/hot_product.png"
                                            alt=""></div>
                            <?php } ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
</div>
<script>
    $(".package_wish").click(function () {
        var t = $(this);
        var package_id = $(this).data('id');
        $.ajax({
            url: "<?= yii\helpers\Url::to(['/ajax/wish-list']) ?>",
            type: "get",
            data: {
                package_id: package_id,
            },
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

    $(".shop_wish").click(function () {
        var t = $(this);
        var shop_id = $(this).data('id');
        $.ajax({
            url: "<?= yii\helpers\Url::to(['/ajax/wish-list-user']) ?>",
            type: "get",
            data: {
                user_id: shop_id,
                type: '<?= \frontend\models\User::TYPE_DOANH_NGHIEP ?>',
            },
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