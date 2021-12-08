<link rel="stylesheet" href="<?= yii::$app->homeUrl ?>css/chitietgoitho.css">

<?php

if (isset($data) && $data) {


    ?>
    <div class="site51_prodel_col12_chitiettimtho">
        <div class="container_fix">
            <?php
            echo \frontend\widgets\breadcrumbs\BreadcrumbsWidget::widget(['view' => 'view']);
            ?>
            <div class="pro_detail">
                <div class="detail_left wow fadeInLeft" data-wow-duration="2s"
                     style="visibility: visible; animation-duration: 3s;">
                    <div class="left_env">
                        <div class="slide_detail_on">
                            <?php
                            $avatar = \common\components\ClaHost::getImageHost() . '/imgs/default.png';
                            if (isset($data['user']['avatar_path']) && $data['user']['avatar_path']) {
                                $avatar = \common\components\ClaHost::getImageHost() . $data['user']['avatar_path'] . $data['user']['avatar_name'];
                            }
                            ?>
                            <div class="img_detail">
                                <a data-fancybox="gallery" href="<?= $avatar ?>">
                                    <img src="<?= $avatar ?>">
                                </a>
                            </div>
                            <?php
                            foreach ($data['images'] as $key) {
                                ?>
                                <div class="img_detail">
                                    <a data-fancybox="gallery"
                                       href="<?= \common\components\ClaHost::getImageHost() . $key['path'] . $key['name'] ?>">
                                        <img src="<?= \common\components\ClaHost::getImageHost() . $key['path'] . $key['name'] ?>"
                                             alt="<?= $key['name'] ?>">
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="slide_detail_in">
                            <div class="img_detail_1">
                                <a data-fancybox="gallery" href="<?= $avatar ?>">
                                    <img src="<?= $avatar ?>" alt="">
                                </a>
                            </div>
                            <?php
                            foreach ($data['images'] as $key) {
                                ?>
                                <div class="img_detail_1">
                                    <a data-fancybox="gallery"
                                       href="<?= \common\components\ClaHost::getImageHost() . $key['path'] . $key['name'] ?>">
                                        <img src="<?= \common\components\ClaHost::getImageHost() . $key['path'] . $key['name'] ?>"
                                             alt="<?= $key['name'] ?>">
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="detail_right wow fadeInRight" data-wow-duration="2s"
                     style="visibility: visible; animation-duration: 3s;">
                    <div class="content">
                        <div class="title title_28">
                            <?= isset($data['name']) && $data['name'] ? $data['name'] : 'Đang cập nhật' ?>
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
                                <span><?= isset($data['rate']) && $data['rate'] ? $data['rate'] : '' ?></span>
                            </div>
                            <div class="description">
                                <i class='fa fa-address-card'></i>
                                <span class="content_16">Kinh nghiệm <?= isset($data['kinh_nghiem']) && $data['kinh_nghiem'] ? \common\models\user\Tho::numberKn()[$data['kinh_nghiem']] : 'Đang cập nhật' ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="contact_info">
                        <div class="content_16_b">Thông tin liên lạc:</div>
                        <div class="contact_row">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-person-square" viewBox="0 0 16 16">
                                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                                <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1v-1c0-1-1-4-6-4s-6 3-6 4v1a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12z"/>
                            </svg>
                            <a href=""
                               class="content_16"><?= isset($data['name']) && $data['name'] ? $data['name'] : 'Đang cập nhật' ?></a>
                        </div>
                        <div class="contact_row">
                            <i class="far fa-map-marker-alt"></i>
                            <span class="content_16"><?= isset($data['province']['name']) && $data['province']['name'] ? $data['province']['name'] : 'Đang cập nhật' ?></span>
                        </div>
                        <div class="contact_row">
                            <div class="contact_flex">
                                <div class="flex">
                                    <i class="far fa-phone-alt"></i>
                                    <a href="tel:<?= $data['user']['phone'] ?>"
                                       class="content_16"><?= isset($data['user']['phone']) && $data['user']['phone'] ? $data['user']['phone'] : 'Đang cập nhật' ?></a>
                                </div>
                                <div class="flex">
                                    <i class="far fa-envelope"></i>
                                    <a href="mailto:<?= $data['user']['email'] ?>"
                                       class="content_16"><?= isset($data['user']['email']) && $data['user']['email'] ? $data['user']['email'] : 'Đang cập nhật' ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="detail_des">
                        <span class="content_16_b">Giới thiệu:</span>
                        <span class="content_16"> <?= isset($data['kinh_nghiem_description']) && $data['kinh_nghiem_description'] ? $data['kinh_nghiem_description'] : 'Đang cập nhật' ?></span>
                    </div>
                    <a id="chat-circle" class="detail_button btn-animation chatbox__button">
                        <img src="<?= yii::$app->homeUrl ?>images/chat_alt.png" alt=""><span class="content_16_b">Chat ngay</span>
                    </a>
                </div>
            </div>
            <div class="pro_main">
                <div class="pro_flex_left">
                    <nav class="nav_menu">
                        <a class="back"></a>
                        <blockquote id="scroll_load_1" href="#" class="nav_list active title_18">giới thiệu<a href=""
                                                                                                              title=""
                                                                                                              id="scroll_load_1"></a>
                        </blockquote>
                        <blockquote id="scroll_load_2" href="#" class="nav_list title_18">HỒ SƠ cá nhân<a href=""
                                                                                                          title=""
                                                                                                          id="scroll_load_2"></a>
                        </blockquote>
                        <blockquote id="scroll_load_3" href="#" class="nav_list title_18">Đánh giá<a href="" title=""
                                                                                                     id="scroll_load_3"></a>
                        </blockquote>
                        <a class="continue"></a>
                    </nav>
                    <div id="pro_desc_list" class="pro_description">
                        <?php echo isset($data['description']) && $data['description'] ? $data['description'] : 'Chưa có mô tả' ?>
                    </div>
                    <div id="pro_desc_list_1" class="pro_description_1">
                        <div class="pro_package">
                            <div class="pro_content">
                                <div class="content_text">
                                    <h3>hồ sơ cá nhân</h3>
                                </div>
                            </div>
                            <div class="pro_flex">
                                <table>
                                    <tr>
                                        <td>Họ và tên</td>
                                        <td><?= isset($data['name']) && $data['name'] ? $data['name'] : 'Đang cập nhật' ?></td>
                                    </tr>
                                    <tr>
                                        <td>Ngày sinh</td>
                                        <td><?= isset($data['user']['birthday']) && $data['user']['birthday'] ? date('d/m/Y', $data['user']['birthday']) : 'Đang cập nhật' ?></td>
                                    </tr>
                                    <tr>
                                        <td>Số điện thoại</td>
                                        <td><?= isset($data['user']['phone']) && $data['user']['phone'] ? $data['user']['phone'] : 'Đang cập nhật' ?></td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td><?= isset($data['user']['email']) && $data['user']['email'] ? $data['user']['email'] : 'Đang cập nhật' ?></td>
                                    </tr>
                                    <tr>
                                        <td>Tốt nghiệp trường</td>
                                        <td><?= isset($data['tot_nghiep']) && $data['tot_nghiep'] ? $data['tot_nghiep'] : 'Đang cập nhật' ?></td>
                                    </tr>
                                    <tr>
                                        <td>Chuyên ngành</td>
                                        <td><?= isset($data['chuyen_nganh']) && $data['chuyen_nganh'] ? $data['chuyen_nganh'] : 'Đang cập nhật' ?></td>
                                    </tr>
                                    <tr>
                                        <td>Nghề nghiệp</td>
                                        <td><?= isset($data['job']['name']) && $data['job']['name'] ? $data['job']['name'] : 'Đang cập nhật' ?></td>
                                    </tr>
                                    <tr>
                                        <td>Kinh nghiệm</td>
                                        <td><?= isset($data['kinh_nghiem']) && $data['kinh_nghiem'] ? \common\models\user\Tho::numberKn()[$data['kinh_nghiem']] : 'Đang cập nhật' ?></td>
                                    </tr>
                                    <tr>
                                        <td>Kinh nghiệm làm việc</td>
                                        <td>
                                            <?= isset($data['kinh_nghiem_description']) && $data['kinh_nghiem_description'] ? $data['kinh_nghiem_description'] : 'Đang cập nhật' ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pro_flex_right">
                    <div class="pro_package">
                        <div class="pro_content">
                            <div class="content_text">
                                <h3>nổi bật</h3>
                            </div>
                        </div>
                        <div class="pro_flex item-list-hot-deal">
                            <?php
                            echo frontend\widgets\shopview\ShopviewWidget::widget(
                                [
                                    'view' => 'view',
                                    'data' => $tho_hot,
                                    'us_wish' => $us_wish
                                ]);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <?=
            \frontend\widgets\rating\RatingWidget::widget([
                'view' => 'view',
                'type' => \common\models\rating\Rating::TYPE_THO,
                'object_id' => $data['user_id'],
                'title' => 'Đánh giá thợ',
                'rating' => [
                    'rate' => $data['rate'],
                    'rate_count' => $data['rate_count']
                ]
            ])
            ?>

            <div class="pro_slide">
                <div class="pro_package">
                    <div class="pro_content">
                        <div class="content_text">
                            <h3>tìm thợ khác</h3>
                        </div>
                    </div>
                    <div class="pro_flex slide_pro_active">
                        <?php
                        echo frontend\widgets\shopview\ShopviewWidget::widget(
                            [
                                'view' => 'view',
                                'data' => $tho_related,
                                'us_wish' => $us_wish
                            ]);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="chat-box">
        <div class="chat-box-header">
            <div class="title_chat-box">
                <div class="image">
                    <?php
                    $avatar = \common\components\ClaHost::getImageHost() . '/imgs/default.png';
                    if (isset($data['user']['avatar_path']) && $data['user']['avatar_path']) {
                        $avatar = \common\components\ClaHost::getImageHost() . $data['user']['avatar_path'] . $data['user']['avatar_name'];
                    }
                    ?>
                    <img src="<?= $avatar?>" alt="">
                </div>
                <h4 class="content_14"><?= isset($data['name']) && $data['name'] ? $data['name'] : 'Đang cập nhật' ?></h4>
            </div>
            <div class="click-box">
                <div class="zoom-box"></div>
                <span class="chat-box-toggle">
                    <i class="material-icons">×</i>
                </span>
            </div>
        </div>
        <div class="chat-box-body">
            <div class="tt-cty">
                <div class="image">
                    <img src="<?= yii::$app->homeUrl ?>images/avt2.png" alt="">
                </div>
                <div class="detaile">
                    <div class="chat_title">
                        <?= isset($data['name']) && $data['name'] ? $data['name'] : 'Đang cập nhật' ?>
                    </div>
                    <div class="contact_info">
                        <div class="contact_row">
                            <img src="<?= yii::$app->homeUrl ?>images/img_detail_home.png" alt="">
                            <a href="" title="">Công ty Cổ phần ABC</a>
                        </div>
                        <div class="contact_row">
                            <i class="far fa-map-marker-alt"></i>
                            <a href="" title="">60 Phố Lý Thái Tổ, Tràng Tiền, Hoàn Kiếm, Hà Nội</a>
                        </div>
                        <div class="contact_row">
                            <i class="far fa-phone-alt"></i>
                            <a href="" title="">0123.456.789</a>
                        </div>
                        <div class="contact_row">
                            <i class="far fa-envelope"></i>
                            <a href="" title="">nguyenhoanganh@gmail.com</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="chat-box-overlay">
            </div>
            <div class="chat-logs">
            </div><!--chat-log -->
        </div>
        <div class="chat-input">
            <form>
                <input type="text" id="chat-input" placeholder="Nhập nội dung tin nhắn..."/>
                <button type="submit" class="chat-submit" id="chat-submit">
                    <i class='fa fa-paper-plane'></i>
                </button>
            </form>
        </div>
    </div>
<?php } ?>

<script>
    $(".tho_like").click(function () {
        var t = $(this);
        var tho_id = $(this).data('id');
        $.ajax({
            url: "<?= yii\helpers\Url::to(['/user/user/add-like']) ?>",
            type: "get",
            data: {"tho_id": tho_id},
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
